<?php
include 'tools.php';
authenticate();

$action = $_GET['action'];

$heading = ($action == 'signoutall') ? "Sign Out All?": "Force Sign Out All?";
$message = ($action == 'signoutall') ?
    "This will Sign out all active users and award hours, and add a record to the logs":
    "This will Force Sign out all active users and <b>will not award any hours</b>. <br>No record will be added to the logs.";

if(isset($_POST['submit'])) {
    if (md5($_POST['password']) != md5($password)) {
        message("Incorrect Password, no action was taken");
        die();
    }
    else {
        if($action == 'signoutall')
            signoutall();
        else if($action == 'forcesignoutall')
            signoutall($force=true);
        else
            message("This action is invalid", 'Error');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <script>
        PASSWORD_MIN_LENGTH = 4;
        function disableButton(){
            document.getElementById('submit').disabled = !(document.getElementById('password-input').value.length >= PASSWORD_MIN_LENGTH);
        }
    </script>
    
</head>

<body>

<main>

    <div class="container">

        <div class="card-panel">

            <div class="center">

                <h3><?php echo $heading ?></h3><br><br>

                <h4>
                    <?php echo $message ?> <br>
                    <b>This action is irreversible!</b> Are you sure you want to continue?
                </h4>

                <br><br>
                <?php echo $homeBtn ?>

                <br><br>
                <a onclick="document.getElementById('authInput').style.visibility='visible'">
                    Authenticate <?php echo ($action == 'signoutall')? " Sign Out": " Force Sign Out"?>
                </a>

                <br><br><br>


                <div id="authInput" style="visibility: hidden">

                    <form action="" method="post">

                        <div class="input-field">
                            <i class="material-icons prefix">vpn_key</i>
                            <input type="password" id="password-input" name="password" onkeyup="disableButton()"
                                   autocomplete="off" required>
                            <label for="password-input" class="center">Password</label>
                        </div>

                        <div class="input-field center">
                            <button class="btn waves-effect waves-light btn-large red lighten-1 hoverable"
                                    type="submit" name="submit" value="submit" id="submit" disabled>
                                <?php echo ($action == 'signoutall')?"Sign Out All": "Force Sign Out All"?>
                            </button>
                        </div>

                    </form>

                </div>



            </div>


        </div>
    </div>

</main>

<?php echo $copyright ?>


<?php echo $imports ?>

</body>


</html>



