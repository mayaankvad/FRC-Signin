<?php

//include '../databaseConfig.php';

$title = 'The MidKnight Inventors';
$copyright = '<br><div class="copyright">Copyright &copy; 2017 Team 1923 The MidKnight Inventors, All Rights Reserved</div>';

$defaultDeathScreenHeading = "Team 1923 Sign In error";
$defaultDeathScreenMessage = "Something went wrong and we don't know what. Call me now";

$defaultMessageHeading = 'Message';
$defaultMessageText = 'This page did not receive a message';
$defaultMessageTime = '5';

$helpText = "<div class='text-muted' style='font-size: 15px !important;'>If you need help text me @ 732-567-4753</div>";



$imports = <<<"END"
<cdn>
    <!-- Links to resources -->
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
END;
