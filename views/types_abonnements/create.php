<div class="row">
  <div class="col-lg-7">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-plus-circle me-2"></i>Ajouter un type d'abonnement</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations du type</div>
        <form method="POST" action="index.php?page=types_abonnements&action=create">
          <div class="mb-3">
            <label class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" name="nom" class="form-control" placeholder="Ex : Mensuel" required>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Durée en jours <span class="text-danger">*</span></label>
              <input type="number" name="duree_jours" class="form-control" min="1" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prix <span class="text-danger">*</span></label>
              <input type="number" step="0.01" name="prix" class="form-control" min="0" required>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <a href="index.php?page=types_abonnements" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
