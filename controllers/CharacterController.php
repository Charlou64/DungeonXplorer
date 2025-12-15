<?php
class CharacterController {
    public function index() {
        global $bdd;
        if (isset($_SESSION["username"])) {
            // Récupération des infos des personnages
            require_once 'views/character/character.php';
        }
    }
}