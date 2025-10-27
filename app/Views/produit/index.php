<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Produits</h2>
    <a class="btn btn-primary" href="?controller=Produit&action=create">Nouveau produit</a>
</div>

<table class="table table-striped">
    <thead><tr><th>ID</th><th>Nom</th><th>Prix</th><th>Actions</th></tr></thead>
    <tbody>
    <?php if (!empty($produits)): foreach ($produits as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['nom']) ?></td>
            <td><?= number_format($p['prix'], 2) ?></td>
            <td>
                <a href="?controller=Produit&action=show&id=<?= $p['id'] ?>" class="btn btn-sm btn-info">Voir</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="4">Aucun produit.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
