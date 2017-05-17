<?php
include '../../formatting.php';
include '../../databaseConfig.php';
include 'ajaxAuthenticate.php';

authenticate();


// connect to Database
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) die('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


//authenticate();

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
        'subteam' => $row['subteam'],
        'robotDay' => $row['robotDay'],
        'seconds' => $row['seconds'],
        'online' => $row['online'],
        'lastLogin' => $row['lastLogin']
    ];
    echo json_encode($arr);
}

