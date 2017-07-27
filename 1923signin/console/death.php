<?php

include 'tools.php';

$heading = (isset($_SESSION['death_message'])) ? $_SESSION['death_message']['heading'] : $defaultDeathScreenHeading;
$message = (isset($_SESSION['death_message'])) ? $_SESSION['death_message']['message'] : $defaultDeathScreenMessage;

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    
    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<body>

<main>

    <div class="container">

        <div class="card-panel">
            <h3><?php echo $heading; ?></h3> <br><br>


            <p class="flow-text"> <?php echo $message; ?> </p>

            <br><br><br>
            <p class="flow-text"> <?php echo $helpText; ?> </p>
        </div>

    </div>

</main>

<?php echo $copyright; ?>


<?php echo $imports ?>
</body>


</html>

<?php die(); ?>
