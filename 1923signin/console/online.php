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

        <h1>Active Now</h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Online Now</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = "SELECT fullName FROM users WHERE online = 1";
                    $result = mysqli_query($conn, $query);

                    if(!$result) nicedie("Database error. Reason: <br>" . mysqli_error($conn));

                    while($row = mysqli_fetch_array($result)) {
                        $fullName = $row['fullName'];
                        echo "<tr class='success'><td>$fullName</td></tr>";
                    }

                    ?>

                </tbody>
            </table>
        </div>

    </div>

    <?php echo $copyright ?>
</div>


</body>
<?php echo $imports ?>

</html>
