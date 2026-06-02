<div class="content-card">
  <div class="card-head">
    <h5><i class="bi bi-cash-coin me-2"></i>Liste des paiements</h5>
    <a href="index.php?page=paiements&action=create" class="btn-primary-custom"><i class="bi bi-plus-lg"></i> Enregistrer</a>
  </div>
  <div class="card-body-custom p-0">
    <?php if (empty($paiements)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Aucun paiement enregistré.</p>
        <a href="index.php?page=paiements&action=create" class="btn-primary-custom mt-3"><i class="bi bi-plus-lg"></i> Enregistrer un paiement</a>
      </div>
    <?php else: ?>
      <table class="custom-table">
        <thead><tr><th>#</th><th>Membre</th><th>Abonnement</th><th>Montant payé</th><th>Date paiement</th></tr></thead>
        <tbody>
          <?php foreach ($paiements as $paiement): ?>
            <tr>
              <td><?= h($paiement['id']) ?></td>
              <td><?= h($paiement['nom'] . ' ' . $paiement['prenom']) ?></td>
              <td><span class="badge-filiere"><?= h($paiement['type_abonnement']) ?></span></td>
              <td><?= h(format_money($paiement['montant_paye'])) ?></td>
              <td><?= h(format_date($paiement['date_paiement'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
