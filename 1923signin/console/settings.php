<?php
include 'tools.php';
authenticate();

if(isset($_POST['deAuthenticate'])) {
    deAuthenticate();
}

if(isset($_POST['change-password'])) {
    if( md5($_POST['old-password']) != md5($password) ) {
		message("Password not changed", "Incorrect Password");
    }
    else {
		$file = fopen("passwords/password.txt", "w") or nicedie("Unable To Change Password due to a system error.", true);
        fwrite($file, $_POST['confirm-password']);
        fclose($file);
        message('Password Changed');
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

    <!-- Change the buttons -->
    <script>
        function keyUp() {
            var newPass = document.getElementById("new-password").value;
            var confirmPass = document.getElementById("confirm-password").value;

            var error = document.getElementById("error");

            var submit = document.getElementById("submit");

            if(newPass != confirmPass) {
                error.innerHTML = "<div class='alert alert-danger'>Passwords Do Not Match</div>";
                submit.disabled = true;
            }
            else if(newPass == "" || confirmPass == "" ) {
                error.innerHTML = "";
                submit.disabled = true;
            }
            else if(newPass == confirmPass){
                error.innerHTML = "";
                submit.disabled = false;
            }

        }
    </script>



</head>

<body>

<div class="container">

    <div class="content-block">

        <h1 class="text-center">Settings</h1><br><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br><br>

        <!-- deAuthenticate -->
        <form action="" method="post">
            <input type="submit" name="deAuthenticate" value="Deactivate" class="btn btn-danger"><br>
            <small class="form-text text-muted">
                Deactivate secures the console and stops anyone from using it without the password
            </small>
        </form>

        <br><br>
        <button class="btn btn-success" onclick="document.getElementById('change-pass').style.visibility='visible'">
            Change Password?
        </button>

        <!-- Change Password -->
        <div id="change-pass" style="visibility: hidden;">
            <br><h3 class="text-center">Change Password</h3><br><hr><br>
            <form action="" method="post">
                <input type="password" class="form-control" id="old-password" name="old-password" placeholder="Old Password" onkeyup="keyUp()" required autocomplete="off"> <br>
                <input type="password" class="form-control" id="new-password" name="new-password" placeholder="New Password" onkeyup="keyUp()" required autocomplete="off"> <br>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password" onkeyup="keyUp()" required autocomplete="off"> <br>

                <div id="error"></div>

                <input type="submit" id="submit" class="btn btn-primary submit" name="change-password" value="Change Password" disabled><br>
                <small id="" class="form-text text-muted">
                    Every device will be forced back to the login screen if password change is successful<br>
                    Use the new Password to get back in<br><br>
                </small>
            </form>
        </div>

    </div>

    <?php echo $copyright ?>
</div>

<?php echo $imports ?>

</body>

</html>
