<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/TypeAbonnement.php';

class TypeAbonnementController extends BaseController
{
    private TypeAbonnement $typeAbonnement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->typeAbonnement = new TypeAbonnement($pdo);
    }

    public function index(?int $id = null): void
    {
        $this->render('types_abonnements/index', [
            'pageTitle' => 'Types d\'abonnements',
            'currentPage' => 'types_abonnements',
            'types' => $this->typeAbonnement->getAll(),
        ]);
    }

    public function create(?int $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($this->post('nom'));
            $duree = (int) $this->post('duree_jours');
            $prix = (float) $this->post('prix');

            if ($nom === '' || $duree <= 0 || $prix < 0) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->typeAbonnement->create($nom, $duree, $prix);
                $this->redirect('index.php?page=types_abonnements', 'Type d\'abonnement ajouté avec succès.');
            }
        }

        $this->render('types_abonnements/create', [
            'pageTitle' => 'Ajouter un type',
            'currentPage' => 'types_abonnements',
            'error' => $error ?? null,
        ]);
    }

    public function edit(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=types_abonnements', 'Type introuvable.', 'danger');
        }

        $type = $this->typeAbonnement->getById($id);
        if (!$type) {
            $this->redirect('index.php?page=types_abonnements', 'Type introuvable.', 'danger');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($this->post('nom'));
            $duree = (int) $this->post('duree_jours');
            $prix = (float) $this->post('prix');

            if ($nom === '' || $duree <= 0 || $prix < 0) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->typeAbonnement->update($id, $nom, $duree, $prix);
                $this->redirect('index.php?page=types_abonnements', 'Type d\'abonnement modifié avec succès.');
            }
        }

        $this->render('types_abonnements/edit', [
            'pageTitle' => 'Modifier un type',
            'currentPage' => 'types_abonnements',
            'type' => $type,
            'error' => $error ?? null,
        ]);
    }

    public function delete(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=types_abonnements', 'Type introuvable.', 'danger');
        }

        if ($this->typeAbonnement->hasAbonnements($id)) {
            $this->redirect('index.php?page=types_abonnements', 'Impossible de supprimer ce type car il est lié à des abonnements.', 'warning');
        }

        $this->typeAbonnement->delete($id);
        $this->redirect('index.php?page=types_abonnements', 'Type d\'abonnement supprimé avec succès.');
    }
}
