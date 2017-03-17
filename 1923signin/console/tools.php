<?php
session_start();
include 'config.php';
include '../databaseConfig.php';
date_default_timezone_set('America/New_York');

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) nicedie('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


// Get Password From File
$file = fopen("passwords/password.txt", "r") or nicedie('Could Not Fetch Password. ');
$password = fgets($file);
fclose($file);

function formatSeconds($seconds) {
    return ($seconds == null)? 0: gmdate("H:i:s", intval($seconds));
}

function formatDate($date) {
    return ($date == null)? "Never": date("d/m/y", strtotime($date));
}

function formatTime($time) {
    return ($time== null)? 0: date("h:i:sa", strtotime($time));
}

/*
 * Returnes a nameID from an inputed name
 * nameID is always lowercase with no spaces
 */
function toNameID($name) {
    return strtolower(str_replace(' ', '', $name));
}

/*
 * Gets FormattedName from the database
 */
function getFormattedName($name) {
    global $conn;
    $nameID = toNameID($name);
    $query = "SELECT fullName from users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    return (!$result || mysqli_num_rows($result) <= 0) ? null: mysqli_fetch_array($result)['fullName'];
}



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

/*
 * Assumes that user is already signed out
 * (Does not check if user is already signed in)
 */
function signin($name) {
    global $conn;
    $nameID = toNameID($name);
    $fullName = getFormattedName($nameID);


    // Sign User In
    $query = "UPDATE users SET online = 1, lastLogin = UNIX_TIMESTAMP() WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not Sign In $fullName, Reason: <br>". mysqli_error($conn));

    // Add a record
    $query = "INSERT INTO logs (nameID, flag, logTime) VALUES ('$nameID', 1, NOW()) ";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not record $fullName's Sign In, Reason: <br>". mysqli_error($conn));

    // message the user
    message("$fullName was recorded arriving at " . date("h:i:sa"), "Sign In Successful", 3);

}

/*
 * Assumes that user is already signed in
 * (Does not check if user is already signed out)
 * (Force signout awards no hours)
 */
function signout($name, $force=false) {
    global $conn;
    $nameID = toNameID($name);
    $fullName = getFormattedName($nameID);


    // Get User Details
    $query = "SELECT * FROM users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not get $fullName's data, Reason: <br>". mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    // get last seen time
    $timeIn = strtotime($row['lastLogin']);

    // calculate time spent loged in
    $sessionTime = time() - $timeIn;

    // set New Total Time
    if(!$force)
        $totalTime = $sessionTime + $row['seconds'];
    else
        $totalTime = $row['seconds'];

    // Update logs
    $query = "INSERT INTO logs(nameID, flag, logTime) VALUES ('$nameID', 0, NOW()) ";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not record $fullName's Sign Out, Reason: <br>". mysqli_error($conn));

    // Update user data
    $query = "UPDATE users SET online = 0, seconds = '$totalTime' WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not Sign Out $fullName, Reason: <br>". mysqli_error($conn));

    // message user
    if(!$force) {
        message("$fullName was recorded leavening at " . date("h:i:sa"), "Sign Out Successful", 3);
    }

}

/*
 * Signs out everyone who is online
 * (Force signout awards no hours)
 */
function signoutall($force=false) {
    global $conn;
    $query = "SELECT * FROM users WHERE online = 1";

    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Database Error, Reason: <br>". mysqli_error($conn));

    $out = 0;
    while($row = mysqli_fetch_array($result)) {
        signout($row['nameID'], $force);
        $out++;
    }
    
    if(!$force)
        message("Successfully signed out $out users",'Signed Out ALl', 5);
    else
        message("Successfully force signed out $out users<br> No time was awarded",'Force Signed Out All', 5);

}
