<?php
// is this app taken offline?
// delete killed.txt to restore app

$deathFile = 'killed.txt';

if(file_exists($deathFile)) {
    header('Location: death.php?error=kill');
}

if(isset($_GET['command']) && isset($_GET['auth'])) {
    $cmd = $_GET['command'] == 'kill';
    $_GET['auth'] = '000';

    fopen($deathFile, "w");

    header('Location: death.php?error=kill');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>MidKnight Inventors Sign In</title>
    
    <noscript>
        <meta http-equiv="refresh" content="0;URL='death.php?error=javascript_disabled'" />
    </noscript>

    <link rel="shortcut icon" href="favicon.ico">

    <cdn>
        <!-- Links to resources -->
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Enables Bootstrap compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Enables Bootstrap compatibility -->


        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Animation resources -->
        <!-- Animate css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

        <!-- WOW js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script>new WOW().init();</script>
    </cdn>

    <style>
        body {
            background-color: #000000 !important;
            color: white !important;
            align-content: center !important;
            text-align: center !important;
            align-items: center !important;

        }

        .container {
            margin-top: 5%;
        }

        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .mki-btn {
            color: white !important;
            background-color: black !important;
            border: 1px solid white !important;
            border-radius: 150px !important;
            font-size: 20px!important;
            padding: 10px !important;
            display: block !important;
            width: 200px;
        }

        .mki-btn:hover {
            background-color: #ff007d !important;
            border-color: #ff007d !important;
            /*color: black !important;background-color: #fffc00 !important;border-color: #fffc00 !important;*/
        }

    </style>

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

    <img src="images/logo.jpeg" alt="The MidKnight Inventors" width="250px" class="img img-responsive center-block wow fadeInDown" data-wow-delay="0.3s" data-wow-duration="2s">
    <h1 class="wow fadeIn" data-wow-delay="0.5s" data-wow-duration="2s">Team Sign In</h1><br>
    <button class="btn btn-default mki-btn center-block wow fadeInUp" data-wow-delay="1s" data-wow-duration="3s" onclick="window.location.href = 'checkStats/'">Check Your Stats</button><br>
    <button class="btn btn-default mki-btn center-block wow fadeInUp" data-wow-delay="1.3s" data-wow-duration="3s" onclick="window.location.href = 'register/'">Register</button> <br>
    <button class="btn btn-default mki-btn center-block wow fadeInUp" data-wow-delay="1.6s" data-wow-duration="3s" onclick="window.location.href = 'console/'">Console</button>

	<br><br><br><small class="text-muted wow bounceInUp" style="font-size: 10px; font-family: monospace" data-wow-delay="5s" data-wow-duration="10s"><i>-- By Mayaank</i></small>

</div>

</body>

</html>
