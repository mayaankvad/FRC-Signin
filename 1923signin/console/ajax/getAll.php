<?php
include '../../formatting.php';
include '../../databaseConfig.php';
include 'ajaxAuthenticate.php';

authenticate();



// connect to Database
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) nicedie('Database Connection Failed<br>Reason: ' . mysqli_connect_error());

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

if(!$result) die();

while($row = mysqli_fetch_array($result)) {
    $fullName = $row['fullName'];
    $subteam = $row['subteam'];
    $day = $row['robotDay'];
    $seconds =  $row['seconds'];
    $lastLogin = $row['lastLogin'];

    $time = formatSeconds($seconds);
    $seen = formatDate($lastLogin);

    echo "<tr class='info'><td>$fullName</td><td>$subteam</td><td>$day</td><td>$time</td><td>$seen</td></tr>";
}

