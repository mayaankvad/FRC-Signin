<?php
include 'tools.php';
authenticate();

if(!isset($_SESSION['message'])) {
    $heading = $defaultMessageHeading;
    $text = $defaultMessageText;
    $time = $defaultMessageTime;
} else {
    $heading = $_SESSION['message']['heading'];
    $text = $_SESSION['message']['text'];
    $time = $_SESSION['message']['time'];

    $_SESSION['message'] = null;
    unset($_SESSION['message']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="style.css">
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

        <?php header('refresh:' . $time . '; url=index.php'); ?>
        <br><br><br>
        <button class="btn btn-link" onclick="window.location.href='index.php'">Didn't Redirect Automatically?</button><br>
        <?php echo $helpText ?>
    </div>

</div>

<?php echo $imports ?>
</body>

</html>