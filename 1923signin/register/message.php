<?php
session_start();

$helpText = "<div class='text-muted' style='font-size: 15px !important;'>If you need help text me now at 732-567-4753</div>";

if(!isset($_SESSION['message'])) {
    header('Location: index.php');
} else {
    $heading = $_SESSION['message']['heading'];
    $text = $_SESSION['message']['message'];

    $_SESSION['message'] = null;
    unset($_SESSION['message']);
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>The MidKnight Inventors</title>

    <link rel="stylesheet" href="../console/style.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<style>
    body {
        font-size: 20px !important;
    }
</style>

<body>

<div class="container">

    <div class="content-block">
        <h2><?php echo $heading; ?></h2>
        <hr>
        <?php echo $text; ?>
        
        <br><br><br>

        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='../'"></button>
        
        <?php echo $helpText ?>
    </div>

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