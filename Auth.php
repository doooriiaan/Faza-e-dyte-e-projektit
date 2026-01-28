<?php
class Auth {
    public static function check() {
        return isset($_SESSION['user']);
    }

    public static function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
