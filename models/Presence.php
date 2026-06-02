<?php

class Presence
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT p.*, m.nom, m.prenom, m.telephone
            FROM presences p
            INNER JOIN membres m ON m.id = p.membre_id
            ORDER BY p.date_presence DESC, p.id DESC
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(int $membreId, string $datePresence): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO presences (membre_id, date_presence) VALUES (:membre_id, :date_presence)");
        return $stmt->execute(['membre_id' => $membreId, 'date_presence' => $datePresence]);
    }
}
