<?php

require "db.php";

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    deleteUser($db, $id);
    header("Location: index.php");
    exit;
}

?>
