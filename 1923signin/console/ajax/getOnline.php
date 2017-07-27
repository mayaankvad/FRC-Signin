<?php
include '../../formatting.php';
include '../../databaseConfig.php';
include 'ajaxAuthenticate.php';

authenticate();


// connect to Database
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) die('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


//authenticate();


$query = "SELECT fullName FROM users WHERE online = 1";
$result = mysqli_query($conn, $query);

if(!$result) die();

while($row = mysqli_fetch_array($result)) {
    $fullName = $row['fullName'];
    echo "<tr><td>$fullName</td></tr>\n" ;
}

