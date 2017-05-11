<?php
session_start();
include '../config.php';

if(!isset($_SESSION['message'])) {
    header('Location: index.php');
} else {
    $heading = $_SESSION['message']['heading'];
    $text = $_SESSION['message']['message'];

    $_SESSION['message'] = null;
    unset($_SESSION['message']);
}

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

<?php echo $imports ?>

</body>

</html>