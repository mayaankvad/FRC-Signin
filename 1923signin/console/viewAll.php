<?php
include 'tools.php';
authenticate();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../favicon.ico">
    
</head>

<body>

<div class="container">

    <div class="content-block">

        <h1>All User Data</h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Subteam</th>
                        <th>Robot Day</th>
                        <th>Hours</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = "SELECT * FROM users";
                    $result = mysqli_query($conn, $query);

                    if(!$result) nicedie("Database error. Reason: <br>" . mysqli_error($conn));

                    while($row = mysqli_fetch_array($result)) {
                        $fullName = $row['fullName'];
                        $email = $row['email'];
                        $subteam = $row['subteam'];
                        $day = $row['robotDay'];
                        $seconds =  $row['seconds'];
                        $lastLogin = $row['lastLogin'];

                        $time = formatSeconds($seconds);
                        $seen = formatDate($lastLogin);

                        echo "<tr class='info'><td>$fullName</td><td>$email</td><td>$subteam</td><td>$day</td><td>$time</td><td>$seen</td></tr>";
                    }

                    ?>

                </tbody>
            </table>
        </div>

        <?php echo $imports ?>
        <!-- Link for download as xls scripts -->
        <script type="text/javascript" src="scripts/tableExport.js"></script>
        <script type="text/javascript" src="scripts/jquery.base64.js"></script>

        <br><br>
        <button class="btn btn-primary" onClick ="$('#table').tableExport({type:'excel',escape:'false'});">
            <i class="fa fa-download" aria-hidden="true"></i> Save as .xls
        </button>

    </div>

    <?php echo $copyright ?>
</div>

</body>

</html>
