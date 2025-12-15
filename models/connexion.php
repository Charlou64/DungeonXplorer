<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dungeonXplorer;charset=utf8', 'root', '');
    // Pour afficher les erreurs PDO en cas de problème :
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>