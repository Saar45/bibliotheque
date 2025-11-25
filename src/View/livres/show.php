<?php ob_start(); ?>

<div class="header">
    <h1>Détails du livre</h1>
    <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Retour</a>
</div>

<div class="book-details">
    <p><strong>ID :</strong> <?= htmlspecialchars($livre['id']) ?></p>
    <p><strong>Titre :</strong> <?= htmlspecialchars($livre['titre']) ?></p>
    <p><strong>Auteur :</strong> <?= htmlspecialchars($livre['auteur']) ?></p>
    <p><strong>Année de publication :</strong> <?= htmlspecialchars($livre['annee']) ?></p>
</div>

<div class="actions" style="margin-top: 20px;">
    <a href="<?= BASE_URL ?>/edit/<?= $livre['id'] ?>" class="btn">Modifier</a>
    <form method="POST" action="<?= BASE_URL ?>/delete/<?= $livre['id'] ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
