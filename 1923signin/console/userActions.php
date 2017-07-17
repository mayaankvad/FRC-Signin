<?php

// depends on functions not in this file.
// make sure you include other files before this one in tools.php


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
 * 0 -> offline
 * 1 -> online
 */
function getOnlineStatus($nameID) {
    global $conn;
    $query = "SELECT online FROM users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result)['online'];
}


/*
 * Signs user in and adds record to logs
 */
function signin($name) {
    global $conn;
    $nameID = toNameID($name);
    $fullName = getFormattedName($nameID);

    // is the user already signed in?
    if(getOnlineStatus($nameID) == 1) {
        return "$fullName is already signed in";
    }

    // Sign User In
    $query = "UPDATE users SET online = 1, lastLogin = NOW() WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not Sign In $fullName, Reason: <br>". mysqli_error($conn));

    // Add a record
    $query = "INSERT INTO logs (nameID, flag, logTime) VALUES ('$nameID', 1, NOW()) ";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not record $fullName's Sign In, Reason: <br>". mysqli_error($conn));

    // message the user
    // message("$fullName was recorded arriving at " . date("h:i:sa"), "Sign In Successful", 3);

    return "$fullName is signed in";
}



/*
 * Signs out user and adds record to logs.
 * Calculates time spent in.
 * (Force signout awards no hours)
 */
function signout($name, $force=false) {
    global $conn;
    $nameID = toNameID($name);
    $fullName = getFormattedName($nameID);


    // is the user already signed out?
    if(getOnlineStatus($nameID) == 0) {
        return "$fullName is already signed out";
    }


    // Get User Details
    $query = "SELECT * FROM users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    if(!$result) nicedie("Could not get $fullName's data, Reason: <br>". mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    // get last seen time
    $timeIn = intval(strtotime($row['lastLogin']));

    // calculate time spent logged in
    $sessionTime = time() - $timeIn;

    // set New Total Time
    if(!$force)
        $totalTime = $sessionTime + intval($row['seconds']);
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
        // message("$fullName was recorded leavening at " . date("h:i:sa"), "Sign Out Successful", 3);
        return "$fullName is signed out";
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
        message("Successfully signed out $out users",'Signed Out All', 5);
    else
        message("Successfully force signed out $out users<br> No time was awarded",'Force Signed Out All', 5);

}


