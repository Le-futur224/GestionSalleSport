<?php

class Paiement
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT p.*,
                   m.nom,
                   m.prenom,
                   t.nom AS type_abonnement
            FROM paiements p
            INNER JOIN abonnements a ON a.id = p.abonnement_id
            INNER JOIN membres m ON m.id = a.membre_id
            INNER JOIN types_abonnements t ON t.id = a.type_abonnement_id
            ORDER BY p.date_paiement DESC, p.id DESC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(int $abonnementId, float $montantPaye, string $datePaiement): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO paiements (abonnement_id, montant_paye, date_paiement)
            VALUES (:abonnement_id, :montant_paye, :date_paiement)
        ");
        return $stmt->execute([
            'abonnement_id' => $abonnementId,
            'montant_paye' => $montantPaye,
            'date_paiement' => $datePaiement,
        ]);
    }
}
