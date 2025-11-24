<?php

$host = "https://dev-dx04.users.info.unicaen.fr/phpmyadmin/index.php?route=/&route=%2F";
$nom_BDD = "dx04_bd";

try {
    $bdd = new PDO('mysql:host=localhost,dbname=dx04_db;charset=utf8', 'dx04', 'zohxoothega9eiS2');
    // Pour afficher les erreurs PDO en cas de problème :
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>