<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Statistique.php';

class StatistiqueController extends BaseController
{
    public function index(?int $id = null): void
    {
        $statistique = new Statistique($this->pdo);
        $this->render('statistiques', [
            'pageTitle' => 'Statistiques',
            'currentPage' => 'statistiques',
            'membresReguliers' => $statistique->getMembresReguliers(),
            'recettesMensuelles' => $statistique->getRecettesMensuelles(),
            'abonnementsActifs' => $statistique->getAbonnementsActifs(),
        ]);
    }
}
