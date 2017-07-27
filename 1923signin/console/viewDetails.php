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

    if(md5($_POST['password']) == md5($password)) {
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

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <?php echo $imports ?>


    <script>
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>

</head>

<body>

<main>

    <div class="container">

        <div class="card-panel">

            <h3 class="center">Profile for <?php echo $fullName ?></h3><br><hr>

            <a class="center btn waves-effect waves-light pink lighten-1 z-depth-5" href="index.php">
                <i class="material-icons">home</i>
            </a>
            <br><br>

            <table id="table">
                <tbody>

                    <tr>
                        <td>Full Name</td>
                        <td><?php echo $fullName ?></td>
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

            <br><br>
            <a class=" btn waves-effect waves-light pink lighten-1 z-depth-5" href="<?php echo "logs.php?view=$nameID"; ?>">
                Logs for <?php echo $fullName ?>
            </a>

            <br><br>

            <a onclick="document.getElementById('form').style.visibility='visible'">Edit Profile?</a> <br><br>

            <!-- edit profile -->
            <div id="form" style="visibility: hidden;">

                <form action="" method="post">

                    <!-- hours -->
                    <div class="input-field">
                        <i class="material-icons prefix fa fa-hourglass"></i>
                        <input type="number" id="number" name="hours">
                        <label for="number" class="center">Hours to Add</label>
                    </div>

                    <!-- subteam -->
                    <div class="input-field">
                        <i class="material-icons prefix fa fa-gear"></i>
                        <select id="subteam" name="subteam" >
                            <option value="" disabled selected>Choose Subteam</option>
                            <option value="Mechanism">Mechanism</option>
                            <option value="Drive Train">Drive Train</option>
                            <option value="Programming">Programming</option>
                            <option value="Electrical">Electrical</option>
                            <option value="CAD">CAD</option>
                        </select>
                        <label>Subteam</label>
                    </div>
                    <br>

                    <!-- Day -->
                    <div class="input-field">
                        <i class="material-icons prefix fa fa-clock-o"></i>
                        <select id="day" name="day" >
                            <option value="" disabled selected>Select Day</option>
                            <option value="Tesla">Tesla (Tuesday + Thursday + Saturday)</option>
                            <option value="Edison">Edison (Wednesday + Friday + Sunday)</option>
                            <option value="Both">Both (For Captains Only)</option>
                        </select>
                        <label>Day</label>
                    </div>
                    <br>


                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" id="password" name="password" autocomplete="off" required>
                        <label for="password" class="center">Password</label>
                    </div>


                    <button class="btn waves-effect waves-light btn-large pink lighten-1 hoverable"
                            type="submit" name="change-profile" value="Update Profile" id="submit">
                        Update Profile
                    </button>

                </form>
            </div>

        </div>


    </div>

</main>

<?php echo $copyright ?>

</body>

</html>
