<div class="row">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-pencil-square me-2"></i>Modifier le membre</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations à modifier</div>
        <form method="POST" action="index.php?page=membres&action=edit&id=<?= h($membre['id']) ?>">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control" value="<?= h($membre['nom']) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control" value="<?= h($membre['prenom']) ?>" required>
            </div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label class="form-label">Âge <span class="text-danger">*</span></label>
              <input type="number" name="age" class="form-control" min="1" max="120" value="<?= h($membre['age']) ?>" required>
            </div>
            <div class="col-md-8">
              <label class="form-label">Téléphone <span class="text-danger">*</span></label>
              <input type="text" name="telephone" class="form-control" value="<?= h($membre['telephone']) ?>" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Mettre à jour</button>
            <a href="index.php?page=membres" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
