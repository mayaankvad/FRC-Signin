<?php
session_start();

function authenticate() {
    // Get Password From File
    $file = fopen("../passwords/password.txt", "r") or nicedie('Could Not Fetch Password. ');
    $password = fgets($file);
    fclose($file);

    // authenticate user
    if ($_SESSION['password'] == null) {
        die();
    }
    if ($_SESSION['password'] != md5($password)) {
        die();
    }

}
