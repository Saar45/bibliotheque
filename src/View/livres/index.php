<?php ob_start(); ?>

<div class="header">
    <h1>Gestion des Livres</h1>
    <a href="<?= BASE_URL ?>/create" class="btn">Ajouter un livre</a>
</div>

<!-- <div class="search-form">
    <form method="GET" action="<?= BASE_URL ?>/search">
        <input type="text" name="q" placeholder="Rechercher par titre ou auteur..." value="<?= htmlspecialchars($search ?? '') ?>">
        <button type="submit" class="btn">Rechercher</button>
        <?php if (!empty($search)): ?>
            <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Réinitialiser</a>
        <?php endif; ?>
    </form>
</div> -->

<?php if (empty($livres)): ?>
    <div class="empty-state">
        <h2>Aucun livre trouvé</h2>
        <p>Commencez par ajouter votre premier livre à la bibliothèque.</p>
    </div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $livre): ?>
                <tr>
                    <td><?= htmlspecialchars($livre['id']) ?></td>
                    <td><?= htmlspecialchars($livre['titre']) ?></td>
                    <td><?= htmlspecialchars($livre['auteur']) ?></td>
                    <td><?= htmlspecialchars($livre['annee']) ?></td>
                    <td>
                        <div class="actions">
                            <a href="<?= BASE_URL ?>/show/<?= $livre['id'] ?>" class="btn btn-secondary">Voir</a>
                            <a href="<?= BASE_URL ?>/edit/<?= $livre['id'] ?>" class="btn">Modifier</a>
                            <form method="POST" action="<?= BASE_URL ?>/delete/<?= $livre['id'] ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
