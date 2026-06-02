<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Abonnement.php';
require_once __DIR__ . '/../models/Membre.php';
require_once __DIR__ . '/../models/TypeAbonnement.php';

class AbonnementController extends BaseController
{
    private Abonnement $abonnement;
    private Membre $membre;
    private TypeAbonnement $typeAbonnement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->abonnement = new Abonnement($pdo);
        $this->membre = new Membre($pdo);
        $this->typeAbonnement = new TypeAbonnement($pdo);
    }

    public function index(?int $id = null): void
    {
        $this->render('abonnements/index', [
            'pageTitle' => 'Abonnements',
            'currentPage' => 'abonnements',
            'abonnements' => $this->abonnement->getAll(),
            'mode' => 'all',
        ]);
    }

    public function actifs(): void
    {
        $this->render('abonnements_actifs', [
            'pageTitle' => 'Abonnements actifs',
            'currentPage' => 'abonnements_actifs',
            'abonnements' => $this->abonnement->getActifs(),
        ]);
    }

    public function expires(): void
    {
        $this->render('abonnements_expires', [
            'pageTitle' => 'Abonnements expirés',
            'currentPage' => 'abonnements_expires',
            'abonnements' => $this->abonnement->getExpires(),
        ]);
    }

    public function create(?int $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getFormData();
            $error = $this->validate($data);
            if ($error === null) {
                $this->abonnement->create($data['membre_id'], $data['type_abonnement_id'], $data['date_debut'], $data['date_fin'], $data['statut']);
                $this->redirect('index.php?page=abonnements', 'Abonnement enregistré avec succès.');
            }
        }

        $this->render('abonnements/create', [
            'pageTitle' => 'Ajouter un abonnement',
            'currentPage' => 'abonnements',
            'membres' => $this->membre->getAll(),
            'types' => $this->typeAbonnement->getAll(),
            'error' => $error ?? null,
        ]);
    }

    public function edit(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=abonnements', 'Abonnement introuvable.', 'danger');
        }

        $abonnement = $this->abonnement->getById($id);
        if (!$abonnement) {
            $this->redirect('index.php?page=abonnements', 'Abonnement introuvable.', 'danger');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getFormData();
            $error = $this->validate($data);
            if ($error === null) {
                $this->abonnement->update($id, $data['membre_id'], $data['type_abonnement_id'], $data['date_debut'], $data['date_fin'], $data['statut']);
                $this->redirect('index.php?page=abonnements', 'Abonnement modifié avec succès.');
            }
        }

        $this->render('abonnements/edit', [
            'pageTitle' => 'Modifier un abonnement',
            'currentPage' => 'abonnements',
            'abonnement' => $abonnement,
            'membres' => $this->membre->getAll(),
            'types' => $this->typeAbonnement->getAll(),
            'error' => $error ?? null,
        ]);
    }

    public function delete(?int $id = null): void
    {
        if (!$id) {
            $this->redirect('index.php?page=abonnements', 'Abonnement introuvable.', 'danger');
        }

        if ($this->abonnement->hasPaiements($id)) {
            $this->redirect('index.php?page=abonnements', 'Impossible de supprimer cet abonnement car il possède des paiements.', 'warning');
        }

        $this->abonnement->delete($id);
        $this->redirect('index.php?page=abonnements', 'Abonnement supprimé avec succès.');
    }

    private function getFormData(): array
    {
        return [
            'membre_id' => (int) $this->post('membre_id'),
            'type_abonnement_id' => (int) $this->post('type_abonnement_id'),
            'date_debut' => trim($this->post('date_debut')),
            'date_fin' => trim($this->post('date_fin')),
            'statut' => trim($this->post('statut', 'Actif')),
        ];
    }

    private function validate(array $data): ?string
    {
        if ($data['membre_id'] <= 0 || $data['type_abonnement_id'] <= 0 || $data['date_debut'] === '' || $data['date_fin'] === '' || $data['statut'] === '') {
            return 'Veuillez remplir tous les champs obligatoires.';
        }
        if ($data['date_fin'] < $data['date_debut']) {
            return 'La date de fin doit être supérieure ou égale à la date de début.';
        }
        return null;
    }
}
