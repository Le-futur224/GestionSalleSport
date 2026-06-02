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
            <thead><tr><th>Membre</th><th>Nombre de présences</th></tr></thead>
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
        <h5><i class="bi bi-cash-stack me-2"></i>Recettes mensuelles</h5>
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

  <div class="col-12">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-check2-circle me-2"></i>Abonnements actifs</h5>
      </div>
      <div class="card-body-custom p-0">
        <?php if (empty($abonnementsActifs)): ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucun abonnement actif.</p></div>
        <?php else: ?>
          <table class="custom-table">
            <thead><tr><th>Membre</th><th>Type</th><th>Début</th><th>Fin</th></tr></thead>
            <tbody>
              <?php foreach ($abonnementsActifs as $abonnement): ?>
                <tr>
                  <td><?= h($abonnement['nom'] . ' ' . $abonnement['prenom']) ?></td>
                  <td><span class="badge-filiere"><?= h($abonnement['type_abonnement']) ?></span></td>
                  <td><?= h(format_date($abonnement['date_debut'])) ?></td>
                  <td><?= h(format_date($abonnement['date_fin'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
