<?php
session_start();
require_once '../connexion.php';

// Vérifier que l'utilisateur est connecté et a un héros sélectionné
if (!isset($_SESSION['hero_id'])) {
    echo '<p>Vous devez être connecté pour voir votre inventaire.</p>';
    exit;
}
$hero_id = $_SESSION['hero_id'];

// Récupérer l'inventaire du héros
$sql = 'SELECT Items.name, Items.description, Inventory.quantity
        FROM Inventory
        JOIN Items ON Inventory.item_id = Items.id
        WHERE Inventory.hero_id = :hero_id';
$stmt = $bdd->prepare($sql);
$stmt->execute(['hero_id' => $hero_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaire</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <h1>Votre Équipement :</h1>
    <?php if (empty($items)) : ?>
        <p>Votre inventaire est vide.</p>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= (int)$item['quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>