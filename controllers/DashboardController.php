<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Statistique.php';

class DashboardController extends BaseController
{
    public function index(?int $id = null): void
    {
        $statistique = new Statistique($this->pdo);
        $this->render('dashboard', [
            'pageTitle' => 'Tableau de bord',
            'currentPage' => 'dashboard',
            'stats' => $statistique->getDashboardStats(),
            'membresReguliers' => $statistique->getMembresReguliers(5),
            'recettesMensuelles' => $statistique->getRecettesMensuelles(5),
        ]);
    }
}
