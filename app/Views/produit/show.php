<?php if ($produit): ?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
    <p class="card-text">Prix: <?= number_format($produit['prix'],2) ?></p>
    <a href="?controller=Produit&action=index" class="btn btn-primary">Retour</a>
  </div>
</div>
<?php else: ?>
<p>Produit introuvable.</p>
<?php endif; ?>
