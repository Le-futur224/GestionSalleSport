<div class="row">
  <div class="col-lg-8">
    <div class="content-card">
      <div class="card-head">
        <h5><i class="bi bi-plus-circle me-2"></i>Ajouter un abonnement</h5>
      </div>
      <div class="card-body-custom">
        <div class="form-section-title">Informations de l'abonnement</div>
        <form method="POST" action="index.php?page=abonnements&action=create">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Membre <span class="text-danger">*</span></label>
              <select name="membre_id" class="form-select" required>
                <option value="">-- Choisir un membre --</option>
                <?php foreach ($membres as $membre): ?>
                  <option value="<?= h($membre['id']) ?>"><?= h($membre['nom'] . ' ' . $membre['prenom']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Type d'abonnement <span class="text-danger">*</span></label>
              <select name="type_abonnement_id" id="type_abonnement_id" class="form-select" required>
                <option value="">-- Choisir un type --</option>
                <?php foreach ($types as $type): ?>
                  <option value="<?= h($type['id']) ?>" data-duree="<?= h($type['duree_jours']) ?>"><?= h($type['nom']) ?> - <?= h(format_money($type['prix'])) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label">Date début <span class="text-danger">*</span></label>
              <input type="date" name="date_debut" id="date_debut" class="form-control" value="<?= h(date('Y-m-d')) ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date fin <span class="text-danger">*</span></label>
              <input type="date" name="date_fin" id="date_fin" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Statut <span class="text-danger">*</span></label>
              <select name="statut" class="form-select" required>
                <option value="Actif" selected>Actif</option>
                <option value="Expire">Expire</option>
                <option value="Annule">Annule</option>
              </select>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-floppy"></i> Enregistrer</button>
            <a href="index.php?page=abonnements" class="btn-secondary-custom"><i class="bi bi-x-lg"></i> Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function calculerDateFin() {
    const select = document.getElementById('type_abonnement_id');
    const debut = document.getElementById('date_debut');
    const fin = document.getElementById('date_fin');
    const duree = parseInt(select.options[select.selectedIndex]?.dataset.duree || '0', 10);
    if (!debut.value || duree <= 0) return;
    const date = new Date(debut.value + 'T00:00:00');
    date.setDate(date.getDate() + duree);
    fin.value = date.toISOString().slice(0, 10);
  }
  document.getElementById('type_abonnement_id').addEventListener('change', calculerDateFin);
  document.getElementById('date_debut').addEventListener('change', calculerDateFin);
</script>
