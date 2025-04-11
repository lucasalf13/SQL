<?php

require "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = getUserById($db, $id);
    if ($user) {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = updateUser($db, $id, $_POST['firstName'], $_POST['lastName'], $_POST['mail'], $_POST['zipCode']);
            if (empty($errors)) {
                header("Location: index.php");
                exit;
            }
        }
    } else {
        echo "Utilisateur non trouvé.";
        exit;
}
} else {
    echo "ID non fourni.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifier Utilisateur</title>
</head>
<body>
    <h1>Modifier l'utilisateur</h1>
    <form action="modifier.php?id=<?= $id; ?>" method="POST">
        <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']); ?>" required>
        <input type="text" name="lastName" value="<?= htmlspecialchars($user['lastName']); ?>" required>
        <input type="email" name="mail" value="<?= htmlspecialchars($user['mail']); ?>" required>
        <input type="text" name="zipCode" value="<?= htmlspecialchars($user['zipCode']); ?>" required>
        <button class="modif" type="submit">Modifier</button>
    </form>
    <?php if (!empty($errors)) : ?>
        <div style="color: red;">
            <?php foreach ($errors as $error) : ?>
                <p><?= htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <a href="index.php"><button class="back">Retour à l'accueil</button></a>
    <footer>
        <p>&copy; 2025 Lucas Alfred. Tous droits réservés.</p>
    </footer>
</body>
</html>
