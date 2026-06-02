<?php

class TypeAbonnement
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        return $this->pdo->query("SELECT * FROM types_abonnements ORDER BY nom")->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM types_abonnements WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $type = $stmt->fetch();
        return $type ?: null;
    }

    public function create(string $nom, int $dureeJours, float $prix): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO types_abonnements (nom, duree_jours, prix) VALUES (:nom, :duree_jours, :prix)");
        return $stmt->execute(['nom' => $nom, 'duree_jours' => $dureeJours, 'prix' => $prix]);
    }

    public function update(int $id, string $nom, int $dureeJours, float $prix): bool
    {
        $stmt = $this->pdo->prepare("UPDATE types_abonnements SET nom = :nom, duree_jours = :duree_jours, prix = :prix WHERE id = :id");
        return $stmt->execute(['id' => $id, 'nom' => $nom, 'duree_jours' => $dureeJours, 'prix' => $prix]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM types_abonnements WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function hasAbonnements(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM abonnements WHERE type_abonnement_id = :id");
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
