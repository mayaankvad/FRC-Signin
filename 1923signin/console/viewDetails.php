<?php
include 'tools.php';
authenticate();

if(isset($_SESSION['viewUser'])) {
    $nameID = toNameID($_SESSION['viewUser']);

    $query = "SELECT * FROM users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);

    if(!$result) nicedie("Database Error. Reason: <br>" . mysqli_error($conn));

    $row = mysqli_fetch_array($result);

    $fullName = $row['fullName'];
    $email = $row['email'];
    $subteam = $row['subteam'];
    $day = $row['robotDay'];
    $seconds =  $row['seconds'];
    $lastLogin = $row['lastLogin'];

    $time = formatSeconds($seconds);
    $seen = formatDate($lastLogin);
}
else {
    message("Error, Select a User");
    die();
}

if(isset($_POST['change-profile'])) {

    if(md5($_POST['password'] == md5($password))) {
        $time = ($_POST['hours'] != null) ? $seconds + ($_POST['hours'] * 3600) : $seconds; // sec
        $team = ($_POST['subteam'] != null) ? $_POST['subteam'] : $subteam; // subteam
        $robot = ($_POST['day'] != null) ? $_POST['day'] : $day; // day


        $query = "UPDATE users SET subteam = '$team', robotDay = '$robot', seconds = '$time' WHERE nameID = '$nameID'";

        $result = mysqli_query($conn, $query);

        if($result)
            message("$fullName was Updated", "Update Successful");
        else
            message("$fullName was not updated, reason: <br>" . mysqli_error($conn), "ERROR");
    }
    else {
        message("Profile not Changed", "Incorrect Password");
    }

    $_SESSION['viewUser'] = null;
    unset($_SESSION['viewUser']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<body>

<div class="container">

    <div class="content-block">

        <h1 class="text-center">Profile for <?php echo $fullName ?></h1><br><hr>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button><br>
        <br><br><br>

        <div class="table-responsive">
            <table class="table" id="table">
                <tbody>

                    <tr>
                        <td>Full Name</td>
                        <td><?php echo $fullName ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <td>Subteam</td>
                        <td><?php echo $subteam ?></td>
                    </tr>
                    <tr>
                        <td>Day</td>
                        <td><?php echo $day ?></td>
                    </tr>
                    <tr>
                        <td>Total Time</td>
                        <td><?php echo $time ?></td>
                    </tr>
                    <tr>
                        <td>Last Login</td>
                        <td><?php echo $seen ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <br><br><br>
        <button class="btn btn-primary" onclick="window.location.href='<?php echo "logs.php?view=$nameID"; ?>'">
            Logs for this user
        </button><br>

        <br><br>

        <button class="btn btn-success" onclick="document.getElementById('form').style.visibility='visible'">
            Edit Profile?
        </button> <br><br>
        
        <div id="form" style="visibility: hidden;">
            <form action="" method="post">
                <input type="number" class="form-control" id="number" name="hours" placeholder="Hours To Add" ><br>


                <div class="form-group">
                    <select class="form-control" id="subteam" name="subteam" >
                        <option value="" disabled selected>Select a Subteam...</option>
                        <option value="Mechanism">Mechanism</option>
                        <option value="Drive Train">Drive Train</option>
                        <option value="Programming">Programming</option>
                        <option value="Electrical">Electrical</option>
                        <option value="CAD">CAD</option>
                    </select>
                    <small id="" class="form-text text-muted">
                        Change Subteam
                    </small>
                </div>
                <br>

                <!-- Day -->
                <div class="form-group">
                    <select class="form-control" id="day" name="day" >
                        <option value="" disabled selected>Select a Robot...</option>
                        <option value="Tesla">Tesla (Tuesday + Thursday + Saturday)</option>
                        <option value="Edison">Edison (Wednesday + Friday + Sunday)</option>
                        <option value="Both">Both (For Co-Captains Only)</option>
                    </select>
                    <small id="" class="form-text text-muted">
                        Change Day
                    </small>
                </div>
                <br>

                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="off"> <br>
                <input type="submit" id="submit" class="btn btn-primary submit" name="change-profile" value="Update Profile"><br>
            </form>
        </div>

    </div>

    <?php echo $copyright ?>
</div>
<?php echo $imports ?>

</body>

</html>
