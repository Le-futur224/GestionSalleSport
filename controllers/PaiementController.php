<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Paiement.php';
require_once __DIR__ . '/../models/Abonnement.php';

class PaiementController extends BaseController
{
    private Paiement $paiement;
    private Abonnement $abonnement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->paiement = new Paiement($pdo);
        $this->abonnement = new Abonnement($pdo);
    }

    public function index(?int $id = null): void
    {
        $this->render('paiements/index', [
            'pageTitle' => 'Paiements',
            'currentPage' => 'paiements',
            'paiements' => $this->paiement->getAll(),
        ]);
    }

    public function create(?int $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $abonnementId = (int) $this->post('abonnement_id');
            $montant = (float) $this->post('montant_paye');
            $date = trim($this->post('date_paiement'));

            if ($abonnementId <= 0 || $montant <= 0 || $date === '') {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->paiement->create($abonnementId, $montant, $date);
                $this->redirect('index.php?page=paiements', 'Paiement enregistré avec succès.');
            }
        }

        $this->render('paiements/create', [
            'pageTitle' => 'Enregistrer un paiement',
            'currentPage' => 'paiements',
            'abonnements' => $this->abonnement->getAll(),
            'error' => $error ?? null,
        ]);
    }
}
