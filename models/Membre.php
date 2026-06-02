<?php

class Membre
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT m.*,
                   a.statut AS statut_abonnement,
                   a.date_fin,
                   t.nom AS type_abonnement
            FROM membres m
            OUTER APPLY (
                SELECT TOP 1 *
                FROM abonnements a
                WHERE a.membre_id = m.id
                ORDER BY a.date_debut DESC, a.id DESC
            ) a
            LEFT JOIN types_abonnements t ON t.id = a.type_abonnement_id
            ORDER BY m.nom, m.prenom
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function search(string $keyword): array
    {
        $sql = "
            SELECT m.*,
                   a.statut AS statut_abonnement,
                   a.date_fin,
                   t.nom AS type_abonnement
            FROM membres m
            OUTER APPLY (
                SELECT TOP 1 *
                FROM abonnements a
                WHERE a.membre_id = m.id
                ORDER BY a.date_debut DESC, a.id DESC
            ) a
            LEFT JOIN types_abonnements t ON t.id = a.type_abonnement_id
            WHERE m.nom LIKE :keyword OR m.prenom LIKE :keyword OR m.telephone LIKE :keyword
            ORDER BY m.nom, m.prenom
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM membres WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $membre = $stmt->fetch();
        return $membre ?: null;
    }

    public function create(string $nom, string $prenom, int $age, string $telephone): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO membres (nom, prenom, age, telephone) VALUES (:nom, :prenom, :age, :telephone)");
        return $stmt->execute(compact('nom', 'prenom', 'age', 'telephone'));
    }

    public function update(int $id, string $nom, string $prenom, int $age, string $telephone): bool
    {
        $stmt = $this->pdo->prepare("UPDATE membres SET nom = :nom, prenom = :prenom, age = :age, telephone = :telephone WHERE id = :id");
        return $stmt->execute(compact('id', 'nom', 'prenom', 'age', 'telephone'));
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM membres WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function hasAbonnements(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM abonnements WHERE membre_id = :id");
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function hasPresences(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM presences WHERE membre_id = :id");
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
