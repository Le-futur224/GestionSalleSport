<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-check2-circle me-2"></i>Abonnements actifs</h5>
    <a href="index.php?page=abonnements&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Ajouter</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($abonnements)): ?>
      <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucun abonnement actif.</p></div>
    <?php else: ?>
      <table class="custom-table">
        <thead><tr><th>Membre</th><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th></tr></thead>
        <tbody>
          <?php foreach ($abonnements as $abonnement): ?>
            <tr>
              <td><?= h($abonnement['nom'] . ' ' . $abonnement['prenom']) ?></td>
              <td><span class="badge-filiere"><?= h($abonnement['type_abonnement']) ?></span></td>
              <td><?= h(format_date($abonnement['date_debut'])) ?></td>
              <td><?= h(format_date($abonnement['date_fin'])) ?></td>
              <td><span class="badge-status actif"><?= h($abonnement['statut']) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
