<?php
$sessionPath = __DIR__ . '/storage/sessions';
if (is_dir($sessionPath) && is_writable($sessionPath)) {
    session_save_path($sessionPath);
}
session_start();

require_once __DIR__ . '/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
} catch (RuntimeException $exception) {
    $pageTitle = 'Erreur de connexion';
    $currentPage = 'dashboard';
    $errorMessage = $exception->getMessage();
    require __DIR__ . '/views/header.php';
    echo '<div class="alert-custom alert-danger-custom"><i class="bi bi-x-circle-fill"></i>' . htmlspecialchars($errorMessage) . '</div>';
    require __DIR__ . '/views/footer.php';
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$routes = [
    'dashboard' => 'DashboardController',
    'membres' => 'MembreController',
    'types_abonnements' => 'TypeAbonnementController',
    'abonnements' => 'AbonnementController',
    'paiements' => 'PaiementController',
    'presences' => 'PresenceController',
    'abonnements_expires' => 'AbonnementController',
    'abonnements_actifs' => 'AbonnementController',
    'statistiques' => 'StatistiqueController',
];

if (!isset($routes[$page])) {
    $page = 'dashboard';
}

$controllerName = $routes[$page];
require_once __DIR__ . '/controllers/' . $controllerName . '.php';

$controller = new $controllerName($pdo);

try {
    if ($page === 'abonnements_expires') {
        $controller->expires();
        exit;
    }

    if ($page === 'abonnements_actifs') {
        $controller->actifs();
        exit;
    }

    if (!method_exists($controller, $action)) {
        $action = 'index';
    }

    $controller->$action($id);
} catch (Throwable $exception) {
    $pageTitle = 'Erreur';
    $currentPage = $page;
    $error = 'Une erreur est survenue. Vérifiez les informations saisies puis réessayez.';
    require __DIR__ . '/views/header.php';
    require __DIR__ . '/views/footer.php';
}
