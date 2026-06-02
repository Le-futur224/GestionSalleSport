<?php

class Statistique
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDashboardStats(): array
    {
        return [
            'total_membres' => $this->count("SELECT COUNT(*) FROM membres"),
            'abonnements_actifs' => $this->count("SELECT COUNT(*) FROM abonnements WHERE statut = N'Actif' AND date_fin >= CAST(GETDATE() AS date)"),
            'abonnements_expires' => $this->count("SELECT COUNT(*) FROM abonnements WHERE statut = N'Expire' OR date_fin < CAST(GETDATE() AS date)"),
            'nouveaux_abonnements' => $this->count("SELECT COUNT(*) FROM abonnements WHERE date_debut >= DATEADD(day, -30, CAST(GETDATE() AS date))"),
            'recettes_mois' => $this->sum("SELECT COALESCE(SUM(montant_paye), 0) FROM paiements WHERE YEAR(date_paiement) = YEAR(GETDATE()) AND MONTH(date_paiement) = MONTH(GETDATE())"),
            'presences_jour' => $this->count("SELECT COUNT(*) FROM presences WHERE date_presence = CAST(GETDATE() AS date)"),
        ];
    }

    public function getMembresReguliers(int $limit = 10): array
    {
        $sql = "
            SELECT TOP $limit m.id,
                   m.nom,
                   m.prenom,
                   COUNT(p.id) AS total_presences
            FROM membres m
            INNER JOIN presences p ON p.membre_id = m.id
            GROUP BY m.id, m.nom, m.prenom
            ORDER BY total_presences DESC, m.nom ASC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getRecettesMensuelles(int $limit = 12): array
    {
        $sql = "
            SELECT TOP $limit
                   YEAR(date_paiement) AS annee,
                   MONTH(date_paiement) AS mois,
                   SUM(montant_paye) AS total_recettes
            FROM paiements
            GROUP BY YEAR(date_paiement), MONTH(date_paiement)
            ORDER BY annee DESC, mois DESC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getAbonnementsActifs(): array
    {
        $sql = "
            SELECT a.*, m.nom, m.prenom, t.nom AS type_abonnement
            FROM abonnements a
            INNER JOIN membres m ON m.id = a.membre_id
            INNER JOIN types_abonnements t ON t.id = a.type_abonnement_id
            WHERE a.statut = N'Actif' AND a.date_fin >= CAST(GETDATE() AS date)
            ORDER BY a.date_fin ASC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    private function count(string $sql): int
    {
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    private function sum(string $sql): float
    {
        return (float) $this->pdo->query($sql)->fetchColumn();
    }
}
