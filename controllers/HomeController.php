<?php
class HomeController {
    public function index() {
        require_once 'connexion.php';
        require_once 'views/home.php';
    }
}