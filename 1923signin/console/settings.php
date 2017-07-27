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

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <!-- Change the buttons -->
    <script>
        function keyUp() {
            var newPass = document.getElementById("new-password").value;
            var confirmPass = document.getElementById("confirm-password").value;
            var oldPass = document.getElementById("old-password").value;

            var error = document.getElementById("error");

            var submit = document.getElementById("submit");

            if(newPass !== confirmPass) {
                error.innerHTML = "<span class='red-text'> <i class='material-icons'>error_outline</i> Passwords Do Not Match</span>";
                submit.disabled = true;
            }
            else if(newPass === "" || confirmPass === "" || oldPass === "") {
                error.innerHTML = "";
                submit.disabled = true;
            }
            else if(newPass === confirmPass){
                error.innerHTML = "";
                submit.disabled = false;
            }

        }
    </script>



</head>

<body>


<main>

    <div class="container">

        <div class="card-panel">

            <h1 class="center">Settings</h1><br><br>

            <?php echo $homeBtn ?>
            <br><br><br>


            <!-- Deactivate -->
            <form action="" method="post">
                <div class="input-field center">
                    <button class="btn waves-effect waves-light btn-large z-depth-5 tooltipped deep-orange lighten-1"
                            type="submit" name="deAuthenticate" value="Deactivate" data-position="top" data-delay="25"
                            data-tooltip="Deactivation prevents anyone else from using this device">
                        Deactivate
                    </button>
                </div>
            </form>



            <br><br>
            <a onclick="document.getElementById('change-pass').style.visibility='visible'">Change Password?</a>



            <!-- Change Password -->
            <div id="change-pass" style="visibility: hidden;">

                <br><h5 class="center">Change Password</h5><br><br>

                <form action="" method="post">

                    <!-- Old -->
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" id="old-password" name="old-password" onkeyup="keyUp()"
                               autocomplete="off" required>
                        <label for="old-password" class="center">Old Password</label>
                    </div>

                    <!-- New -->
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" id="new-password" name="new-password" onkeyup="keyUp()"
                               autocomplete="off" required>
                        <label for="new-password" class="center">New Password</label>
                    </div>

                    <!-- Confirm -->
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" id="confirm-password" name="confirm-password" onkeyup="keyUp()"
                               autocomplete="off" required>
                        <label for="confirm-password" class="center">Confirm Password</label>
                    </div>

                    <div id="error"></div> <br><br><br>


                    <!-- Authenticate -->
                    <div class="input-field center">
                        <button class="btn waves-effect waves-light btn-large teal darken-1 hoverable tooltipped"
                                data-position="top" data-delay="25"
                                data-tooltip="If successful, every active device will be sent back to the authenticate screen."
                                type="submit" id="submit" name="change-password" value="Change Password" disabled>
                            Change Password
                        </button>
                    </div>


                </form>
            </div>

        </div>


    </div>

</main>

<?php echo $copyright ?>

<?php echo $imports ?>

</body>

</html>
