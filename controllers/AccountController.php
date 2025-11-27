<?php
class AccountController {
    public function index() {
        global $bdd;
        if (isset($_SESSION["username"])) {
            // Récupération des infos utilisateur
            $stmt = $bdd->prepare("SELECT username, email, created_at FROM Users WHERE username = :username");
            $stmt->execute([':username' => $_SESSION["username"]]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            require_once 'views/account/account.php';
        }
    }
}