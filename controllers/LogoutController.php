<?php

class LogoutController {
    public function index() {
        unset($_SESSION['username']);
        header('Location: ' . $_SESSION["basepath"]);
    }
}
