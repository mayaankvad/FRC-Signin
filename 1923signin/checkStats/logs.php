<?php

include '../databaseConfig.php';

$title = 'The MidKnight Inventors';

function formatSeconds($seconds) {
    return ($seconds == null)? 0: gmdate("H:i:s", intval($seconds));
}

function formatDate($date) {
    return ($date == null)? "Never": date("d/m/y", strtotime($date));
}

function formatTime($time) {
    return ($time== null)? 0: date("h:i:sa", strtotime($time));
}


function toNameID($name) {
    return strtolower(str_replace(' ', '', $name));
}

function getFormattedName($name) {
    global $conn;
    $nameID = toNameID($name);
    $query = "SELECT fullName from users WHERE nameID = '$nameID'";
    $result = mysqli_query($conn, $query);
    return (!$result || mysqli_num_rows($result) <= 0) ? null: mysqli_fetch_array($result)['fullName'];
}

$copyright = '<br><div class="copyright">Copyright &copy; 2017 Team 1923 The MidKnight Inventors, All Rights Reserved</div>';
$imports = <<<END
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
END;

////////
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) nicedie('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


$view = toNameID(urldecode($_GET['view']));

$query = <<<END
SELECT Date_Format(a.logTime, '%d/%m/%y') AS logDate, a.nameID, Date_Format(a.logtime, '%k:%i') AS signinTime,
    (SELECT Date_Format(b.logTime, '%k:%i') FROM logs b
     WHERE Date_Format(b.logTime, '%d/%m/%y') = Date_Format(a.logTime, '%d/%m/%y') AND
     b.nameID = a.nameID AND
     b.flag = 0) AS signoutTime
FROM logs a
WHERE a.flag = 1
END;

/*nameID, signinTime, signoutTime*/

$result = mysqli_query($conn, $query);

if(!$result)
    message('Database Error, Did you sign in a user more then once?. <br>' . mysqli_error($conn) .
        "<br> The logs still exist but we cant display them right now"
        , "Failed to render logs", 7);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="../console/style.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<body>

<div class="container">

    <div class="content-block">

        <h1>Attendance Logs <?php if($view != 'all') echo "For " . getFormattedName($view)?></h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table" id="log-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Full Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Time</th>

                </tr>
                </thead>
                <tbody>

                <?php

                while($row = mysqli_fetch_array($result)) {
                    $nameID = $row['nameID'];
                    $date = formatDate($row['logDate']);
                    $signin = formatTime($row['signinTime']);
                    $signout = formatTime($row['signoutTime']);

                    $fullName = getFormattedName($nameID);
                    $time = ($signout != null) ? formatSeconds(strtotime($signout) - strtotime($signin)) : null;

                    if($view == 'all' || $view == $nameID) echo <<<END
                    <tr class='success'>
                        <td align='left'>$date</td>
                        <td align='left'>$fullName</td>
                        <td align='left'>$signin</td>
                        <td align='left'>$signout</td>
                        <td align='left'>$time</td>
                    </tr>
END;
                }

                ?>

                </tbody>
            </table>
        </div>


        <?php echo $imports ?>
        <!-- Link for download as xls scripts -->
        <script type="text/javascript" src="../console/scripts/tableExport.js"></script>
        <script type="text/javascript" src="../console/scripts/jquery.base64.js"></script>

        <br><br>
        <button class="btn btn-primary" onClick ="$('#log-table').tableExport({type:'excel',escape:'false'});">
            <i class="fa fa-download" aria-hidden="true"></i> Save as .xls
        </button>

    </div>

    <?php echo $copyright ?>
</div>


</body>

</html>

<?php
mysqli_close($conn);
?>

