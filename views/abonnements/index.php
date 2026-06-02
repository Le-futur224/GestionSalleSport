<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-card-checklist me-2"></i>Liste des abonnements</h5>
    <a href="index.php?page=abonnements&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Ajouter</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($abonnements)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun abonnement enregistré.</p>
        <a href="index.php?page=abonnements&action=create" class="btn-primary-custom mt-3"><i class="bi bi-plus-lg"></i> Ajouter un abonnement</a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="custom-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Membre</th>
              <th>Type</th>
              <th>Début</th>
              <th>Fin</th>
              <th>Prix</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($abonnements as $abonnement): ?>
              <tr>
                <td><?= h($abonnement['id']) ?></td>
                <td><?= h($abonnement['nom'] . ' ' . $abonnement['prenom']) ?></td>
                <td><span class="badge-filiere"><?= h($abonnement['type_abonnement']) ?></span></td>
                <td><?= h(format_date($abonnement['date_debut'])) ?></td>
                <td><?= h(format_date($abonnement['date_fin'])) ?></td>
                <td><?= h(format_money($abonnement['prix'])) ?></td>
                <td><span class="badge-status <?= h(strtolower($abonnement['statut'])) ?>"><?= h($abonnement['statut']) ?></span></td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="index.php?page=abonnements&action=edit&id=<?= h($abonnement['id']) ?>" class="btn-icon edit" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                    <a href="index.php?page=abonnements&action=delete&id=<?= h($abonnement['id']) ?>" class="btn-icon delete" title="Supprimer" onclick="return confirm('Supprimer cet abonnement ?')"><i class="bi bi-trash"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
