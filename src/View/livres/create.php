<?php ob_start(); ?>

<div class="header">
    <h1>Ajouter un nouveau livre</h1>
    <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Retour</a>
</div>

<form method="POST" action="<?= BASE_URL ?>/store">
    <div class="form-group">
        <label for="titre">Titre *</label>
        <input type="text" id="titre" name="titre" required value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="auteur">Auteur *</label>
        <input type="text" id="auteur" name="auteur" required value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="annee">Année de publication *</label>
        <input type="number" id="annee" name="annee" required min="0" max="<?= date('Y') ?>" value="<?= htmlspecialchars($_POST['annee'] ?? '') ?>">
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Annuler</a>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
