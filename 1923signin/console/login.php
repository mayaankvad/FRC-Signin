<?php
include 'tools.php';

if(isset($_POST['submit'])) {
    $_SESSION['password'] = md5(trim(strip_tags($_POST['password'])));
    header('Location: index.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>

    <noscript>
        <meta http-equiv="refresh" content="0;URL='death.php?error=javascript_disabled'" />
    </noscript>

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <!-- Authenticate Button enabler -->
    <script>
        PASSWORD_MIN_LENGTH = 4;
        function disableButton(){
            document.getElementById('submit').disabled = !(document.getElementById('password-input').value.length >= PASSWORD_MIN_LENGTH);
        }
    </script>

    <!-- If browser is IE then kill the app -->
    <script>
        function clientUsesIE() {
            var client = window.navigator.userAgent;
            var ie = client.indexOf("MSIE ");
            if (ie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                window.location.href = 'death.php?error=clientIE';
            }
        }
    </script>


</head>

<body onload="clientUsesIE()">

<main>

    <div class="container">

        <div <?php echo (!isset($_GET['error'])) ? 'class="card-panel wow fadeIn" data-wow-delay="0.5s" data-wow-duration="2s"' : 'class="card-panel"' ?>>

            <div>


                <img src="../images/banner.png" class="responsive-img" alt="The MidKnight Inventors" onclick="window.location='../'"><br>
                <h5 class="center">Authentication Required!</h5><br>

                <form action="" method="post">


                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" id="password-input" name="password" onkeyup="disableButton()"
                               autocomplete="off" required>
                        <label for="password-input" class="center">Password</label>
                    </div>


                    <?php

                    if(isset($_GET['error']) && $_GET['error'] == 'incorrect-password'){
                        echo '<h5 class="center red-text wow shake" data-wow-duration="1s" data-wow-delay="0.3s">Incorrect Password</h5>';
                    }
                    if(isset($_GET['error']) && $_GET['error'] == 'deactivate'){
                        echo '<h5 class="center green-text">Deactivated</h5>';
                    }

                    /* a way to break in
                    if((isset($_GET['admin']) && $_GET['admin'] == 'root') && (isset($_GET['password']) && $_GET['password'] == 'admin')) {
                        nicedie("Password: $password <br>", 'System Administrator - Emergency Override');
                    } */

                    ?>

                    <noscript>
                        <h5 class="center red-text">Error: JavaScript Required</h5>
                    </noscript>
                    <br>

                    <!-- Authenticate -->
                    <div class="input-field center">
                        <button class="btn waves-effect waves-light btn-large pink lighten-1 hoverable"
                                type="submit" name="submit" value="Authenticate" id="submit" disabled>
                            Authenticate
                        </button>
                    </div>

                </form>

                <span class="grey-text darken-3">
                    &copy; 2017 Me!
                </span>

            </div>


        </div>


    </div>

</main>

<?php echo $copyright ?>

<?php echo $imports ?>

</body>

</html>
