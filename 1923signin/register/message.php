<?php
session_start();
include '../config.php';

if(!isset($_SESSION['message'])) {
    $heading = $defaultMessageHeading;
    $text = $defaultMessageText;
} else {
    $heading = $_SESSION['message']['heading'];
    $text = $_SESSION['message']['text'];

    $_SESSION['message'] = null;
    unset($_SESSION['message']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>


<body>

<main>

    <div class="container">

        <div class="card-panel">

            <div class="center">

                <h3><?php echo $heading; ?></h3>
                <br><br>

                <p class="flow-text">
                    <?php echo $text; ?>
                </p>

                <br><br><br>

                <a href="index.php">Back</a><br>

                <?php echo $helpText ?>

            </div>

        </div>

    </div>

</main>

<?php echo $copyright ?>

<?php echo $imports ?>
</body>

</html>