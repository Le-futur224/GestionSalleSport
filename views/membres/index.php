<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-people me-2"></i>Liste des membres</h5>
    <a href="index.php?page=membres&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Ajouter</a>
  </div>
  <div class="card-body-custom">
    <form method="GET" class="row g-2 mb-3">
      <input type="hidden" name="page" value="membres">
      <div class="col-md-10">
        <input type="search" name="q" value="<?= h($keyword) ?>" class="form-control" placeholder="Rechercher par nom, prénom ou téléphone">
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button class="btn-primary-custom w-100" type="submit"><i class="bi bi-search"></i></button>
        <?php if ($keyword !== ''): ?>
          <a href="index.php?page=membres" class="btn-secondary-custom"><i class="bi bi-x-lg"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($membres)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun membre enregistré pour le moment.</p>
        <a href="index.php?page=membres&action=create" class="btn-primary-custom mt-3"><i class="bi bi-plus-lg"></i> Ajouter un membre</a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="custom-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Âge</th>
              <th>Téléphone</th>
              <th>Abonnement actuel</th>
              <th>Statut</th>
              <th>Date fin</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($membres as $membre): ?>
              <tr>
                <td><?= h($membre['id']) ?></td>
                <td><?= h($membre['nom']) ?></td>
                <td><?= h($membre['prenom']) ?></td>
                <td><?= h($membre['age']) ?></td>
                <td><?= h($membre['telephone']) ?></td>
                <td><?= h($membre['type_abonnement'] ?? '-') ?></td>
                <td>
                  <?php if (!empty($membre['statut_abonnement'])): ?>
                    <span class="badge-status <?= h(strtolower($membre['statut_abonnement'])) ?>"><?= h($membre['statut_abonnement']) ?></span>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
                <td><?= h(format_date($membre['date_fin'] ?? null)) ?></td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="index.php?page=membres&action=edit&id=<?= h($membre['id']) ?>" class="btn-icon edit" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                    <a href="index.php?page=membres&action=delete&id=<?= h($membre['id']) ?>" class="btn-icon delete" title="Supprimer" onclick="return confirm('Supprimer ce membre ?')"><i class="bi bi-trash"></i></a>
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
