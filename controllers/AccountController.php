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


    public function logout() {
        unset($_SESSION['username']);
        header('Location: ' . $_SESSION["basepath"]);
    }
    
    public function signIn() {
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

    public function signUp() {
        global $bdd;
        if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "SELECT COUNT(*) FROM Users WHERE username = '".$username."'";
            $stmt = $bdd->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                // Username already exists — affichage en overlay centré au-dessus (fixe, z-index élevé)
                echo '<div id="signup-alert" class="alert alert-danger" role="alert" style="position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:2050;margin:0;padding:0.75rem 1rem;transition:opacity .4s;">Nom d\'utilisateur déjà pris. Veuillez en choisir un autre.</div>'
                    . '<script>(function(){const d=4000;setTimeout(function(){const e=document.getElementById("signup-alert");if(!e) return;e.style.opacity=0;setTimeout(function(){if(e.parentNode) e.parentNode.removeChild(e);},400);},d);})();</script>';
            }else {
                $sql = "INSERT INTO Users (username, password_hash, email) VALUES ('".$username."',
                            '".$hashed_password."',
                            '".$email."')";

                $stmt = $bdd->prepare($sql);

                if ($stmt->execute()) {
                    $_SESSION["username"] = $username;
                    header('Location: ' . $_SESSION["basepath"] . '/account');
                    exit;
                }
            }
        }

        require_once 'views/account/signUp.php';
    }
}