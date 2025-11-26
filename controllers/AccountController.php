<?php
class AccountController {
    public function index() {
        if (!isset($_SESSION["username"])) {
            require_once 'views/account/account.php';
        }
    }
}