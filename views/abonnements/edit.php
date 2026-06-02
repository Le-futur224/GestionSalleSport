<div class="row">
  <div class="col-lg-8">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-pencil-square me-2"></i>Modifier l'abonnement</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations à modifier</div>
        <form method="POST" action="index.php?page=abonnements&action=edit&id=<?= h($abonnement['id']) ?>">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Membre <span class="text-danger">*</span></label>
              <select name="membre_id" class="form-select" required>
                <?php foreach ($membres as $membre): ?>
                  <option value="<?= h($membre['id']) ?>" <?= (int) $abonnement['membre_id'] === (int) $membre['id'] ? 'selected' : '' ?>>
                    <?= h($membre['nom'] . ' ' . $membre['prenom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Type d'abonnement <span class="text-danger">*</span></label>
              <select name="type_abonnement_id" class="form-select" required>
                <?php foreach ($types as $type): ?>
                  <option value="<?= h($type['id']) ?>" <?= (int) $abonnement['type_abonnement_id'] === (int) $type['id'] ? 'selected' : '' ?>>
                    <?= h($type['nom']) ?> - <?= h(format_money($type['prix'])) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label class="form-label">Date début <span class="text-danger">*</span></label>
              <input type="date" name="date_debut" class="form-control" value="<?= h($abonnement['date_debut']) ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date fin <span class="text-danger">*</span></label>
              <input type="date" name="date_fin" class="form-control" value="<?= h($abonnement['date_fin']) ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Statut <span class="text-danger">*</span></label>
              <select name="statut" class="form-select" required>
                <?php foreach (['Actif', 'Expire', 'Annule'] as $statut): ?>
                  <option value="<?= h($statut) ?>" <?= $abonnement['statut'] === $statut ? 'selected' : '' ?>><?= h($statut) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Mettre à jour</button>
            <a href="index.php?page=abonnements" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
