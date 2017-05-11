<?php
include 'tools.php';
authenticate();

$view = toNameID(urldecode($_GET['view']));

$query = <<<END
SELECT Date_Format(a.logTime, '%m/%d/%y') AS logDate, a.nameID, Date_Format(a.logtime, '%k:%i') AS signinTime,
    (SELECT Date_Format(b.logTime, '%k:%i') FROM logs b
     WHERE Date_Format(b.logTime, '%m/%d/%y') = Date_Format(a.logTime, '%m/%d/%y') AND
     b.nameID = a.nameID AND
     b.flag = 0) AS signoutTime
FROM logs a
WHERE a.flag = 1
END;

/*nameID, signinTime, signoutTime*/

$result = mysqli_query($conn, $query);

if(!$result)
    message('Database Error, <u>Did you sign in a user more then once today?</u>. <br>' . mysqli_error($conn) .
        "<br> The logs still exist but we cant display them right now"
        , "Failed to render logs", 7);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="style.css">
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

                $previous = '';
                while($row = mysqli_fetch_array($result)) {
                    $nameID = $row['nameID'];
                    $date = $row['logDate'];

                    $signin = formatTime($row['signinTime']);
                    //$signout = formatTime($row['signoutTime']);
                    if($row['signoutTime'] == null )
                        $signout = "Did Not Sign Out";
                    else
                        $signout = formatTime($row['signoutTime']);

                    $fullName = getFormattedName($nameID);
                    $time = ($signout != null) ? formatSeconds(strtotime($signout) - strtotime($signin)) : null;

                    if($date != $previous) {
                        $d = date("l, F j, Y", strtotime( $date ));
                        echo "<tr class='success'><td align='left'>$d</td><td></td><td></td><td></td><td></td></tr>";
                        $previous = $date;
                    }

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
        <script type="text/javascript" src="scripts/tableExport.js"></script>
        <script type="text/javascript" src="scripts/jquery.base64.js"></script>

        <br><br>
        <button class="btn btn-primary" onClick ="$('#log-table').tableExport({type:'excel',escape:'false'});">
            <i class="fa fa-download" aria-hidden="true"></i> Save as .xls
        </button>

    </div>

    <?php echo $copyright ?>
</div>


</body>

</html>

