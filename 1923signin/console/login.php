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

    <link rel="stylesheet" href="style.css">
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

<div class="container">

    <div <?php echo (!isset($_GET['error'])) ? 'class="content-block wow fadeIn" data-wow-delay="0.5s" data-wow-duration="2s"' : 'class="content-block"' ?>>

        <img src="../banner.png" alt="<h1>FRC 1923: The MidKnight Inventors Sign In</h1>" class="img img-responsive">
        <h4 class="text-center">Authentication Required</h4><br><hr>

        <form action="" method="post">

            <input type="password" class="form-control" id="password-input" placeholder="Password" name="password" required autocomplete="off" onkeyup="disableButton()"><br><br>
            
			<?php
            if(isset($_GET['error']) && $_GET['error'] == 'incorrect-password'){
                echo '<div style="font-size: 20px; color: red;" class="wow shake" data-wow-duration="1s" data-wow-delay="0.3s">Incorrect Password</div>';
            }
            if(isset($_GET['error']) && $_GET['error'] == 'deactivate'){
                echo '<div style="font-size: 20px; color: green;" >Deactivate Successful</div>';
            }

            // a way to break in
            if((isset($_GET['admin']) && $_GET['admin'] == 'manks') && (isset($_GET['password']) && $_GET['password'] == 'vad')) {
                nicedie("Password: $password <br>", 'System Administrator - Emergency Override');
            }

            ?>

            <noscript>
                <div style="font-size: 20px; color: red;">Error: Please Enable JavaScript!</div>
            </noscript>

            <br>
            <input type="submit" name="submit" value="Authenticate" id="submit" class="btn btn-primary big-btn" disabled>

        </form>

        <br><small class="text-muted" style="font-size: 15px">by Mayaank 😎</small>

    </div>

    <?php echo $imports ?>
</div>

</body>

</html>
