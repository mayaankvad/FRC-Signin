<?php
include 'tools.php';

if(!isset($_GET['q'])) {
    echo '{}';
    die();
}

$q = toNameID(urldecode($_GET['q']));

$query = "SELECT * FROM users WHERE nameID='$q'";

$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) != 1) {
    echo '{}';
}
else {
    $row = mysqli_fetch_array($result);
    $arr = [
        'fullName' => $row['fullName'],
        'email' => $row['email'],
        'subteam' => $row['subteam'],
        'robotDay' => $row['robotDay'],
        'seconds' => $row['seconds'],
        'online' => $row['online'],
        'lastLogin' => $row['lastLogin']
    ];
    echo json_encode($arr);
}

