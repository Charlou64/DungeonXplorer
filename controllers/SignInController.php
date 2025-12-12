<?php
class SignInController {
    public function index() {
        global $bdd;
        if (isset($_POST["username"], $_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Récupération de l'utilisateur par username
            $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1";
            $stmt = $bdd->prepare($sql);

            $stmt->execute([
                ':username' => $username
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION["username"] = $user["username"];
                    header('Location: ' . $_SESSION["basepath"] . '/account');
                    exit;
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Utilisateur introuvable.";
            }
        }

        require_once 'views/account/signIn.php';
    }
}