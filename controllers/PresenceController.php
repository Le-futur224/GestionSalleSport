<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Presence.php';
require_once __DIR__ . '/../models/Membre.php';

class PresenceController extends BaseController
{
    private Presence $presence;
    private Membre $membre;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->presence = new Presence($pdo);
        $this->membre = new Membre($pdo);
    }

    public function index(?int $id = null): void
    {
        $this->render('presences/index', [
            'pageTitle' => 'Présences',
            'currentPage' => 'presences',
            'presences' => $this->presence->getAll(),
        ]);
    }

    public function create(?int $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membreId = (int) $this->post('membre_id');
            $date = trim($this->post('date_presence'));

            if ($membreId <= 0 || $date === '') {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->presence->create($membreId, $date);
                $this->redirect('index.php?page=presences', 'Présence enregistrée avec succès.');
            }
        }

        $this->render('presences/create', [
            'pageTitle' => 'Enregistrer une présence',
            'currentPage' => 'presences',
            'membres' => $this->membre->getAll(),
            'error' => $error ?? null,
        ]);
    }
}
