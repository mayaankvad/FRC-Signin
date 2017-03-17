<?php

if(isset($_GET['error'])) {
    if($_GET['error'] == 'javascript_disabled') {
        $heading = 'JavaScript is Disabled!';
        $message = <<<END
        Your browser has disabled JavaScript! <br>
        We depend on JavaScript for the functionality of this web app. <br>
        Please enable JavaScript and <a href='index.php'>Try Again</a>. <br>
END;
    }
    if($_GET['error'] == 'clientIE') {
        $heading = 'Browser Not Supported!';
        $message = <<<END
        We do not support any version of Internet Explorer. <br>
        Please use another browser.<br>
        (Yes, we do support MS Edge!)<br>
END;
    }
}
else
    header('Location: index.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>The MidKnight Inventors</title>

    <link rel="stylesheet" href="console/style.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<body>

<div class="container">

    <div class="content-block">
        <h2><?php echo $heading; ?></h2>
        <hr>
        <?php echo $message; ?>
        <br><br><br>
    </div>

    <br><div class="copyright">Copyright &copy; 2017 Team 1923 The MidKnight Inventors, All Rights Reserved</div>
</div>


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

</body>

</html>

<?php die(); ?>
