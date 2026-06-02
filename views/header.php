<?php
if (!function_exists('h')) {
    function h($value): string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->format('Y-m-d');
        }
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('format_date')) {
    function format_date($value): string
    {
        if (!$value) {
            return '-';
        }
        if ($value instanceof DateTimeInterface) {
            return $value->format('d/m/Y');
        }
        return date('d/m/Y', strtotime((string) $value));
    }
}

if (!function_exists('format_money')) {
    function format_money($value): string
    {
        return number_format((float) $value, 2, ',', ' ') . ' GNF';
    }
}

$pageTitle = $pageTitle ?? 'Tableau de bord';
$currentPage = $currentPage ?? 'dashboard';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$menu = [
    ['page' => 'dashboard', 'icon' => 'bi-grid-1x2', 'label' => 'Tableau de bord'],
    ['page' => 'membres', 'icon' => 'bi-people', 'label' => 'Membres'],
    ['page' => 'types_abonnements', 'icon' => 'bi-tags', 'label' => 'Types abonnements'],
    ['page' => 'abonnements', 'icon' => 'bi-card-checklist', 'label' => 'Abonnements'],
    ['page' => 'paiements', 'icon' => 'bi-cash-coin', 'label' => 'Paiements'],
    ['page' => 'presences', 'icon' => 'bi-calendar-check', 'label' => 'Présences'],
    ['page' => 'abonnements_actifs', 'icon' => 'bi-check2-circle', 'label' => 'Abonnements actifs'],
    ['page' => 'abonnements_expires', 'icon' => 'bi-x-circle', 'label' => 'Abonnements expirés'],
    ['page' => 'statistiques', 'icon' => 'bi-bar-chart', 'label' => 'Statistiques'],
];
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= h($pageTitle) ?> - Gestion Salle Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <style>
      :root {
        --sidebar-width: 240px;
        --topbar-height: 60px;
        --primary: #1a3a6b;
        --primary-light: #2450a0;
        --accent: #e8af30;
        --bg-sidebar: #12285a;
        --bg-page: #f0f2f7;
      }
      body {
        background-color: var(--bg-page);
        font-family: "Segoe UI", sans-serif;
        margin: 0;
      }
      .topbar {
        height: var(--topbar-height);
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        padding: 0 1.5rem;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      }
      .topbar .brand {
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        color: white;
        text-decoration: none;
      }
      .topbar .brand span { color: var(--accent); }
      .topbar-right {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 1rem;
      }
      .topbar-right .user-name { font-size: 0.9rem; opacity: 0.85; }
      .topbar-right .avatar {
        width: 36px;
        height: 36px;
        background: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--primary);
      }
      .sidebar {
        width: var(--sidebar-width);
        background: var(--bg-sidebar);
        position: fixed;
        top: var(--topbar-height);
        left: 0;
        bottom: 0;
        overflow-y: auto;
        padding: 1.5rem 0;
        z-index: 999;
      }
      .sidebar-section-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.35);
        padding: 0.75rem 1.25rem 0.25rem;
        margin-top: 0.5rem;
      }
      .sidebar a {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        font-size: 0.9rem;
        padding: 0.6rem 1.25rem;
        border-left: 3px solid transparent;
        transition: all 0.15s;
      }
      .sidebar a:hover { background: rgba(255, 255, 255, 0.07); color: white; }
      .sidebar a.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: var(--accent);
        font-weight: 600;
      }
      .sidebar a i { font-size: 1.05rem; }
      .main-content {
        margin-left: var(--sidebar-width);
        margin-top: var(--topbar-height);
        padding: 2rem;
        min-height: calc(100vh - var(--topbar-height));
      }
      .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
      }
      .page-header h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
      }
      .breadcrumb { font-size: 0.8rem; margin: 0; }
      .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
        border-bottom: 3px solid transparent;
        min-height: 96px;
      }
      .stat-card.blue { border-bottom-color: #2450a0; }
      .stat-card.gold { border-bottom-color: var(--accent); }
      .stat-card.green { border-bottom-color: #1a7a4a; }
      .stat-card.red { border-bottom-color: #c0392b; }
      .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex: 0 0 auto;
      }
      .stat-icon.blue { background: #e8f0fb; color: #2450a0; }
      .stat-icon.gold { background: #fdf3d8; color: #b8860b; }
      .stat-icon.green { background: #e0f5e9; color: #1a7a4a; }
      .stat-icon.red { background: #fde8e6; color: #c0392b; }
      .stat-label { font-size: 0.78rem; color: #888; margin-bottom: 2px; }
      .stat-value { font-size: 1.6rem; font-weight: 700; color: var(--primary); line-height: 1.1; }
      .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
        overflow: hidden;
      }
      .content-card .card-head {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #eef0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
      }
      .content-card .card-head h5 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary);
      }
      .content-card .card-body-custom { padding: 1.25rem; }
      .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
      }
      .custom-table thead th {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
      }
      .custom-table tbody tr { border-bottom: 1px solid #f0f2f7; transition: background 0.1s; }
      .custom-table tbody tr:hover { background: #f8f9ff; }
      .custom-table tbody td { padding: 0.75rem 1rem; color: #444; vertical-align: middle; }
      .badge-filiere {
        background: #e8f0fb;
        color: #2450a0;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
      }
      .badge-status {
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
      }
      .badge-status.actif { background: #e0f5e9; color: #1a7a4a; }
      .badge-status.expire { background: #fde8e6; color: #c0392b; }
      .badge-status.annule { background: #f0f2f7; color: #666; }
      .form-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #999;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eef0f5;
      }
      .form-label { font-size: 0.82rem; font-weight: 600; color: #555; margin-bottom: 4px; }
      .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dde0ea;
        font-size: 0.875rem;
        padding: 0.5rem 0.85rem;
        color: #333;
      }
      .form-control:focus, .form-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(36, 80, 160, 0.12);
      }
      .btn-primary-custom, .btn-secondary-custom {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
        transition: background 0.15s;
      }
      .btn-primary-custom { background: var(--primary); color: white; border: none; }
      .btn-primary-custom:hover { background: var(--primary-light); color: white; }
      .btn-secondary-custom { background: white; color: #555; border: 1px solid #dde0ea; }
      .btn-secondary-custom:hover { background: #f5f6fa; color: #333; }
      .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: background 0.12s;
      }
      .btn-icon.edit { background: #fff4e0; color: #b8860b; }
      .btn-icon.edit:hover { background: #ffe9b3; }
      .btn-icon.delete { background: #fde8e6; color: #c0392b; }
      .btn-icon.delete:hover { background: #fac9c5; }
      .alert-custom {
        border-radius: 10px;
        padding: 0.85rem 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        margin-bottom: 1.25rem;
      }
      .alert-success-custom { background: #e0f5e9; color: #1a7a4a; }
      .alert-danger-custom { background: #fde8e6; color: #c0392b; }
      .alert-warning-custom { background: #fdf3d8; color: #8a6400; }
      .empty-state { text-align: center; padding: 3rem 1rem; color: #aaa; }
      .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; }
      .empty-state p { font-size: 0.9rem; margin: 0; }
      @media (max-width: 900px) {
        :root { --sidebar-width: 210px; }
        .main-content { padding: 1.25rem; }
      }
      @media (max-width: 720px) {
        .sidebar {
          width: 100%;
          height: auto;
          position: static;
          margin-top: var(--topbar-height);
          padding: 0.5rem 0;
        }
        .main-content {
          margin-left: 0;
          margin-top: 0;
        }
        .topbar { padding: 0 1rem; }
        .page-header { align-items: flex-start; flex-direction: column; }
      }
    </style>
  </head>
  <body>
    <div class="topbar">
      <a href="index.php?page=dashboard" class="brand">Gestion <span>Salle Sport</span></a>
      <div class="topbar-right">
        <span class="user-name">Admin</span>
        <div class="avatar">AD</div>
      </div>
    </div>

    <div class="sidebar">
      <div class="sidebar-section-title">Navigation</div>
      <?php foreach ($menu as $item): ?>
        <a href="index.php?page=<?= h($item['page']) ?>" class="<?= $currentPage === $item['page'] ? 'active' : '' ?>">
          <i class="bi <?= h($item['icon']) ?>"></i> <?= h($item['label']) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="main-content">
      <div class="page-header">
        <div>
          <h1><?= h($pageTitle) ?></h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php?page=dashboard">Accueil</a></li>
              <li class="breadcrumb-item active"><?= h($pageTitle) ?></li>
            </ol>
          </nav>
        </div>
      </div>

      <?php if ($flash): ?>
        <div class="alert-custom alert-<?= h($flash['type']) ?>-custom">
          <i class="bi <?= $flash['type'] === 'success' ? 'bi-check-circle-fill' : ($flash['type'] === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-x-circle-fill') ?>"></i>
          <?= h($flash['message']) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert-custom alert-danger-custom">
          <i class="bi bi-x-circle-fill"></i>
          <?= h($error) ?>
        </div>
      <?php endif; ?>
