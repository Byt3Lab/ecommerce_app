<h3>Créer un produit</h3>
<form method="post" action="">
    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input class="form-control" name="nom" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Prix</label>
        <input class="form-control" name="prix" type="number" step="0.01" required>
    </div>
    <button class="btn btn-success" type="submit">Enregistrer</button>
    <a class="btn btn-secondary" href="?controller=Produit&action=index">Annuler</a>
</form>
