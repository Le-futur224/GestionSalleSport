<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Membre.php';

class MembreController extends BaseController
{
    private Membre $membre;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->membre = new Membre($pdo);
    }

    public function index(?int $id = null): void
    {
        $keyword = trim($_GET['q'] ?? '');
        $membres = $keyword !== '' ? $this->membre->search($keyword) : $this->membre->getAll();
        $this->render('membres/index', [
            'pageTitle' => 'Membres',
            'currentPage' => 'membres',
            'membres' => $membres,
            'keyword' => $keyword,
        ]);
    }

    public function create(?int $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($this->post('nom'));
            $prenom = trim($this->post('prenom'));
            $age = (int) $this->post('age');
            $telephone = trim($this->post('telephone'));

            if ($nom === '' || $prenom === '' || $age <= 0 || $telephone === '') {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->membre->create($nom, $prenom, $age, $telephone);
                $this->redirect('index.php?page=membres', 'Membre ajouté avec succès.');
            }
        }

        $this->render('membres/create', [
            'pageTitle' => 'Ajouter un membre',
            'currentPage' => 'membres',
            'error' => $error ?? null,
        ]);
    }

    public function edit(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=membres', 'Membre introuvable.', 'danger');
        }

        $membre = $this->membre->getById($id);
        if (!$membre) {
            $this->redirect('index.php?page=membres', 'Membre introuvable.', 'danger');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($this->post('nom'));
            $prenom = trim($this->post('prenom'));
            $age = (int) $this->post('age');
            $telephone = trim($this->post('telephone'));

            if ($nom === '' || $prenom === '' || $age <= 0 || $telephone === '') {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $this->membre->update($id, $nom, $prenom, $age, $telephone);
                $this->redirect('index.php?page=membres', 'Membre modifié avec succès.');
            }
        }

        $this->render('membres/edit', [
            'pageTitle' => 'Modifier un membre',
            'currentPage' => 'membres',
            'membre' => $membre,
            'error' => $error ?? null,
        ]);
    }

    public function delete(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=membres', 'Membre introuvable.', 'danger');
        }

        if ($this->membre->hasAbonnements($id) || $this->membre->hasPresences($id)) {
            $this->redirect('index.php?page=membres', 'Impossible de supprimer ce membre car il possède des abonnements ou des présences.', 'warning');
        }

        $this->membre->delete($id);
        $this->redirect('index.php?page=membres', 'Membre supprimé avec succès.');
    }
}
