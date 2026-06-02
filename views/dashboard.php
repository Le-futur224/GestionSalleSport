<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="bi bi-people"></i></div>
      <div>
        <div class="stat-label">Total membres</div>
        <div class="stat-value"><?= h($stats['total_membres']) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card green">
      <div class="stat-icon green"><i class="bi bi-check2-circle"></i></div>
      <div>
        <div class="stat-label">Abonnements actifs</div>
        <div class="stat-value"><?= h($stats['abonnements_actifs']) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card red">
      <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
      <div>
        <div class="stat-label">Abonnements expirés</div>
        <div class="stat-value"><?= h($stats['abonnements_expires']) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card gold">
      <div class="stat-icon gold"><i class="bi bi-card-checklist"></i></div>
      <div>
        <div class="stat-label">Nouveaux abonnements</div>
        <div class="stat-value"><?= h($stats['nouveaux_abonnements']) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="bi bi-cash-coin"></i></div>
      <div>
        <div class="stat-label">Recettes du mois</div>
        <div class="stat-value"><?= h(format_money($stats['recettes_mois'])) ?></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="stat-card green">
      <div class="stat-icon green"><i class="bi bi-calendar-check"></i></div>
      <div>
        <div class="stat-label">Présences du jour</div>
        <div class="stat-value"><?= h($stats['presences_jour']) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-trophy me-2"></i>Membres les plus réguliers</h5>
      </div>
      <div class="card-body-custom p-0">
        <?php if (empty($membresReguliers)): ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucune présence enregistrée.</p></div>
        <?php else: ?>
          <table class="custom-table">
            <thead><tr><th>Membre</th><th>Présences</th></tr></thead>
            <tbody>
              <?php foreach ($membresReguliers as $membre): ?>
                <tr>
                  <td><?= h($membre['nom'] . ' ' . $membre['prenom']) ?></td>
                  <td><?= h($membre['total_presences']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-bar-chart me-2"></i>Recettes mensuelles</h5>
      </div>
      <div class="card-body-custom p-0">
        <?php if (empty($recettesMensuelles)): ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucun paiement enregistré.</p></div>
        <?php else: ?>
          <table class="custom-table">
            <thead><tr><th>Mois</th><th>Recettes</th></tr></thead>
            <tbody>
              <?php foreach ($recettesMensuelles as $recette): ?>
                <tr>
                  <td><?= h($recette['mois'] . '/' . $recette['annee']) ?></td>
                  <td><?= h(format_money($recette['total_recettes'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
