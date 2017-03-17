<?php
include 'tools.php';
authenticate();

$action = $_GET['action'];

$heading = ($action == 'signoutall') ? "Sign Out All?": "Force Sign Out All?";
$message = ($action == 'signoutall') ?
    "This will Sign out all active users and award hours, and add a record to the logs":
    "This will Force Sign out all active users and will not award any hours. No record will be added to the logs.";

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

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../favicon.ico">
    
</head>

<body>

<div class="container">
    <div class="content-block">

        <h1 class="text-center"><?php echo $heading ?></h1><br><hr><br>

        <h4>
            <?php echo $message ?> <br><b>This action is irreversible!</b> Are you sure you want to continue?
        </h4>

        <br><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>

        <br><br>
        <button class="btn btn-danger" onclick="document.getElementById('authInput').style.visibility='visible'">
            Authenticate <?php echo ($action == 'signoutall')? " Sign Out": " Force Sign Out"?>
        </button>

        <br><br><br>
        <div id="authInput" style="visibility: hidden">
            <form action="" method="post">
                <input type="password" class="form-control" id="" placeholder="Password" name="password" required autocomplete="off"><br><br>
                <input type="submit" class="btn btn-danger" name="submit"
                       value="<?php echo ($action == 'signoutall')?"Sign Out All": "Force Sign Out All"?>"
                >
            </form>
        </div>


    </div>
    <?php echo $copyright ?>
</div>
<?php echo $imports ?>

</body>


</html>



