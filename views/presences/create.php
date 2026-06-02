<div class="row">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-calendar-plus me-2"></i>Enregistrer une présence</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations de présence</div>
        <form method="POST" action="index.php?page=presences&action=create">
          <div class="mb-3">
            <label class="form-label">Membre <span class="text-danger">*</span></label>
            <select name="membre_id" class="form-select" required>
              <option value="">-- Choisir un membre --</option>
              <?php foreach ($membres as $membre): ?>
                <option value="<?= h($membre['id']) ?>"><?= h($membre['nom'] . ' ' . $membre['prenom']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="form-label">Date présence <span class="text-danger">*</span></label>
            <input type="date" name="date_presence" class="form-control" value="<?= h(date('Y-m-d')) ?>" required>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <a href="index.php?page=presences" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
