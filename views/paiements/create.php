<div class="row">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-cash-coin me-2"></i>Enregistrer un paiement</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations du paiement</div>
        <form method="POST" action="index.php?page=paiements&action=create">
          <div class="mb-3">
            <label class="form-label">Abonnement <span class="text-danger">*</span></label>
            <select name="abonnement_id" class="form-select" required>
              <option value="">-- Choisir un abonnement --</option>
              <?php foreach ($abonnements as $abonnement): ?>
                <option value="<?= h($abonnement['id']) ?>">
                  #<?= h($abonnement['id']) ?> - <?= h($abonnement['nom'] . ' ' . $abonnement['prenom']) ?> - <?= h($abonnement['type_abonnement']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Montant payé <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="montant_paye" class="form-control" min="0.01" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date paiement <span class="text-danger">*</span></label>
              <input type="date" name="date_paiement" class="form-control" value="<?= h(date('Y-m-d')) ?>" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <a href="index.php?page=paiements" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
