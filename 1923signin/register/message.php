<?php
include '../config.php';
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

header('refresh:' . $time . '; url=index.php'); // redirect after time

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

                <a href="index.php">Didn't redirect automatically?</a><br>

                <?php echo $helpText ?>

            </div>

        </div>

    </div>

</main>

<?php echo $copyright ?>

<?php echo $imports ?>
</body>

</html>