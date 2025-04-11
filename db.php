<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=yolo", "root", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
 catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

function getUsers($db) {
    return $db->query("SELECT * FROM user")->fetchAll();
}

function getUserById($db, $id) {
    $requete = $db->prepare("SELECT * FROM user WHERE id = :id");
    $requete->bindParam(':id', $id);
    $requete->execute();
    return $requete->fetch();
}

function addUser($db, $firstName, $lastName, $mail, $zipCode) {
    $errors = [];
    if (!preg_match("/^[a-zA-ZÀ-ÿ\-\' ]+$/", $firstName)) {
        $errors[] = "Prénom invalide";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ ]+$/", $lastName)) {
        $errors[] = "Nom invalide";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/", $mail)) {
        $errors[] = "Email invalide";
    }
    if (!preg_match("/^\d{5,6}$/", $zipCode)) {
        $errors[] = "Code postal invalide";
    }
    if (!empty($errors)) {
        return $errors;
    }
    $requete = $db->prepare("INSERT INTO user (firstName, lastName, mail, zipCode) VALUES (:firstName, :lastName, :mail, :zipCode)");
    $requete->bindParam(':firstName', $firstName);
    $requete->bindParam(':lastName', $lastName);
    $requete->bindParam(':mail', $mail);
    $requete->bindParam(':zipCode', $zipCode);
    $requete->execute();
    return null;
}

function deleteUser($db, $id) {
    $requete = $db->prepare("DELETE FROM user WHERE id = :id");
    $requete->bindParam(':id', $id);
    $requete->execute();
}

function updateUser($db, $id, $firstName, $lastName, $mail, $zipCode) {
    $errors = [];
    if (!preg_match("/^[a-zA-ZÀ-ÿ\-\' ]+$/", $firstName)) {
        $errors[] = "Prénom invalide";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ ]+$/", $lastName)) {
        $errors[] = "Nom invalide";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/", $mail)) {
        $errors[] = "Email invalide";
    }
    if (!preg_match("/^\d{5,6}$/", $zipCode)) {
        $errors[] = "Code postal invalide";
    }
    if (!empty($errors)) {
        return $errors;
    }
    $requete = $db->prepare("UPDATE user SET firstName = :firstName, lastName = :lastName, mail = :mail, zipCode = :zipCode WHERE id = :id");
    $requete->bindParam(':firstName', $firstName);
    $requete->bindParam(':lastName', $lastName);
    $requete->bindParam(':mail', $mail);
    $requete->bindParam(':zipCode', $zipCode);
    $requete->bindParam(':id', $id);
    $requete->execute();
    return null;
}

?>