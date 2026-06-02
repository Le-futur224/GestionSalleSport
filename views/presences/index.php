<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-calendar-check me-2"></i>Liste des présences</h5>
    <a href="index.php?page=presences&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Enregistrer</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($presences)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucune présence enregistrée.</p>
        <a href="index.php?page=presences&action=create" class="btn-primary-custom mt-3"><i class="bi bi-plus-lg"></i> Enregistrer une présence</a>
      </div>
    <?php else: ?>
      <table class="custom-table">
        <thead><tr><th>#</th><th>Membre</th><th>Téléphone</th><th>Date présence</th></tr></thead>
        <tbody>
          <?php foreach ($presences as $presence): ?>
            <tr>
              <td><?= h($presence['id']) ?></td>
              <td><?= h($presence['nom'] . ' ' . $presence['prenom']) ?></td>
              <td><?= h($presence['telephone']) ?></td>
              <td><?= h(format_date($presence['date_presence'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
