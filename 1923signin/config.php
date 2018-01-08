<?php

$title = 'The MidKnight Inventors';

$defaultDeathScreenHeading = "Team 1923 Sign In error";
$defaultDeathScreenMessage = "Something went wrong and we don't know what. Call me now";

$defaultMessageHeading = 'Message';
$defaultMessageText = 'This page did not receive a message';
$defaultMessageTime = '3';

$helpText = "If you need help text me!";


$homeBtn = <<<"END"
<button class="btn waves-effect waves-light pink lighten-1 z-depth-5" onclick="window.location='index.php'">
    <i class="material-icons">home</i>
</button>

END;



$copyright = <<<"END"
 <footer>
	<div class="footer-copyright black white-text">
		<div class="container" style="font-family: monospace;">
			Copyright © 2017 The MidKnight Inventors
		</div>
	</div>
</footer>

END;




$imports = <<<"END"
    <!-- Links to resources -->
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>


        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Animation resources -->
            <!-- Animate css-->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

            <!-- WOW js -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
            <script>new WOW().init();</script>

END;
