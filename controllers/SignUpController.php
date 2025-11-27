<?php
class SignUpController {
    public function index() {
        global $bdd;
        if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (username, password_hash, email) VALUES ('".$username."',
                        '".$hashed_password."',
                        '".$email."')";

            $stmt = $bdd->prepare($sql);

            if ($stmt->execute()) {
                $_SESSION["username"] = $username;
                header('Location: account');
                exit;
            }
        }

        require_once 'views/account/signUp.php';
    }
}