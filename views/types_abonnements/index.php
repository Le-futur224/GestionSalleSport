<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-tags me-2"></i>Types d'abonnements</h5>
    <a href="index.php?page=types_abonnements&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Ajouter</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($types)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun type d'abonnement enregistré.</p>
        <a href="index.php?page=types_abonnements&action=create" class="btn-primary-custom mt-3"><i class="bi bi-plus-lg"></i> Ajouter un type</a>
      </div>
    <?php else: ?>
      <table class="custom-table">
        <thead>
          <tr><th>#</th><th>Nom</th><th>Durée</th><th>Prix</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach ($types as $type): ?>
            <tr>
              <td><?= h($type['id']) ?></td>
              <td><span class="badge-filiere"><?= h($type['nom']) ?></span></td>
              <td><?= h($type['duree_jours']) ?> jours</td>
              <td><?= h(format_money($type['prix'])) ?></td>
              <td>
                <div class="d-flex gap-2">
                  <a href="index.php?page=types_abonnements&action=edit&id=<?= h($type['id']) ?>" class="btn-icon edit" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                  <a href="index.php?page=types_abonnements&action=delete&id=<?= h($type['id']) ?>" class="btn-icon delete" title="Supprimer" onclick="return confirm('Supprimer ce type ?')"><i class="bi bi-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
