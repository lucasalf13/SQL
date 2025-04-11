<?php 

require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstName'])) {
    $errors = addUser($db, $_POST['firstName'], $_POST['lastName'], $_POST['mail'], $_POST['zipCode']);
    if (empty($errors)) {
        header("Location: index.php");
        exit;
    }
}
$users = getUsers($db);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <main>
        <h1>Liste Utilisateurs</h1>
        <table>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mail</th>
                <th>Code postal</th>
            </tr>
            <?php foreach ($users as $entry) { ?>
                <tr>
                    <td><?= htmlspecialchars($entry['firstName']); ?></td>
                    <td><?= htmlspecialchars($entry['lastName']); ?></td>
                    <td><?= htmlspecialchars($entry['mail']); ?></td>
                    <td><?= htmlspecialchars($entry['zipCode']); ?></td>
                    <td>
                    <a href="modifier.php?id=<?= $entry['id']; ?>"><button>Modifier</button></a>
                    </td>
                    <td>
                        <form action="supprimer.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $entry['id']; ?>">
                            <button type="submit" name="delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Ajouter Utilisateur</h2>
        <form action="index.php" method="POST">
            <input type="text" name="firstName" placeholder="Prénom" required>
            <input type="text" name="lastName" placeholder="Nom" required>
            <input type="email" name="mail" placeholder="Email" required>
            <input type="text" name="zipCode" placeholder="Code postal" required>
            <?php if (!empty($errors)) : ?>
            <div style="color: red;">
                <?php foreach ($errors as $error) : ?>
                    <p><?= htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
            <button class="add" type="submit">Ajouter</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 Lucas Alfred. Tous droits réservés.</p>
    </footer>
</body>

</html>