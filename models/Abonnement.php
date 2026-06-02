<?php

class Abonnement
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        return $this->fetchList("ORDER BY a.date_debut DESC, a.id DESC");
    }

    public function getActifs(): array
    {
        return $this->fetchList("WHERE a.statut = N'Actif' AND a.date_fin >= CAST(GETDATE() AS date) ORDER BY a.date_fin ASC");
    }

    public function getExpires(): array
    {
        return $this->fetchList("WHERE a.statut = N'Expire' OR a.date_fin < CAST(GETDATE() AS date) ORDER BY a.date_fin DESC");
    }

    public function getNouveaux(): array
    {
        return $this->fetchList("WHERE a.date_debut >= DATEADD(day, -30, CAST(GETDATE() AS date)) ORDER BY a.date_debut DESC");
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM abonnements WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $abonnement = $stmt->fetch();
        return $abonnement ?: null;
    }

    public function create(int $membreId, int $typeAbonnementId, string $dateDebut, string $dateFin, string $statut): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO abonnements (membre_id, type_abonnement_id, date_debut, date_fin, statut)
            VALUES (:membre_id, :type_abonnement_id, :date_debut, :date_fin, :statut)
        ");
        return $stmt->execute([
            'membre_id' => $membreId,
            'type_abonnement_id' => $typeAbonnementId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'statut' => $statut,
        ]);
    }

    public function update(int $id, int $membreId, int $typeAbonnementId, string $dateDebut, string $dateFin, string $statut): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE abonnements
            SET membre_id = :membre_id,
                type_abonnement_id = :type_abonnement_id,
                date_debut = :date_debut,
                date_fin = :date_fin,
                statut = :statut
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'membre_id' => $membreId,
            'type_abonnement_id' => $typeAbonnementId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'statut' => $statut,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM abonnements WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function hasPaiements(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM paiements WHERE abonnement_id = :id");
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function fetchList(string $clause): array
    {
        $sql = "
            SELECT a.*,
                   m.nom,
                   m.prenom,
                   t.nom AS type_abonnement,
                   t.prix,
                   t.duree_jours
            FROM abonnements a
            INNER JOIN membres m ON m.id = a.membre_id
            INNER JOIN types_abonnements t ON t.id = a.type_abonnement_id
            $clause
        ";
        return $this->pdo->query($sql)->fetchAll();
    }
}
