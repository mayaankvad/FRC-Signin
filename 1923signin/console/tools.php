<?php
session_start();
include '../config.php';
include '../databaseConfig.php';
include '../formatting.php';
include 'userActions.php';

// date_default_timezone_set('America/New_York');

// connect to Database
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) nicedie('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


// Get Password From File
$file = fopen("passwords/password.txt", "r") or nicedie('Could Not Fetch Password. ');
$password = fgets($file);
fclose($file);



/*
 * redirects user to a message page and redirects them back index
 */
function message($message=null, $heading=null, $time=null) {
    global $defaultMessageText, $defaultMessageHeading, $defaultMessageTime;
    $message = ($message == null) ? $defaultMessageText: $message;
    $heading = ($heading == null) ? $defaultMessageHeading: $heading;
    $time = ($time == null) ? $defaultMessageTime: $time;
    $_SESSION['message'] = [
        'heading' => $heading,
        'text' => $message,
        'time' => $time
    ];
    header('Location: message.php');
}

/*
 * Kills the app
 */
function nicedie($message=null, $heading=null) {
    global $defaultDeathScreenMessage, $defaultDeathScreenHeading;
    $message = ($message == null) ? $defaultDeathScreenMessage: $message;
    $heading = ($heading == null) ? $defaultDeathScreenHeading: $heading;
    $_SESSION['death_message'] = [
        'message' => $message,
        'heading' => $heading
    ];
    header('Location: death.php');
    die();
}

/*
 * Makes sure the app is authenticated
 */
function authenticate() {
    global $password;
    if($_SESSION['password'] == null) {
        header('Location: login.php');
        die();
    }
    if ($_SESSION['password'] != md5($password)) {
        header('Location: login.php?error=incorrect-password');
        die();
    }
}

/*
 * Secures the app against unauthorised use
 */
function deAuthenticate() {
    global $conn;
    mysqli_close($conn);
    unset($_SESSION['password']);
    session_destroy();
    header('Location: login.php?error=deactivate');
    die();
}
