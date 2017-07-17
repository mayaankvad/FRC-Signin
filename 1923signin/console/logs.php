<?php
include 'tools.php';
authenticate();


if(!isset($_GET['view']))
    $view = 'all';
else
    $view = toNameID(urldecode($_GET['view']));

$query = <<<END
SELECT Date_Format(a.logTime, '%m/%d/%y') AS logDate, a.nameID, Date_Format(a.logtime, '%k:%i') AS signinTime,
    (SELECT Date_Format(b.logTime, '%k:%i') FROM logs b
     WHERE Date_Format(b.logTime, '%m/%d/%y') = Date_Format(a.logTime, '%m/%d/%y') AND
     b.nameID = a.nameID AND
     b.flag = 0) AS signoutTime
FROM logs a
WHERE a.flag = 1
ORDER BY id DESC;
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

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

</head>

<body>

<main>

    <div class="container">

        <div class="card-panel">

            <h3>Attendance Logs <?php if($view != 'all') echo "For " . getFormattedName($view)?></h3><hr><br>

            <?php echo $homeBtn ?>

            <br><br>


            <!-- Save btn -->
            <button id="save" class="btn waves-effect waves-light pink lighten-1 z-depth-5">
                <i class="fa fa-file-excel-o"></i> Save as Excel
            </button>
            <br><br><br>


            <table id="log-table">
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
                    $time = ($signout == null) ?  "N/A": formatSeconds(strtotime($signout) - strtotime($signin));

                    if($date != $previous) {
                        $d = date("l, F j, Y", strtotime( $date ));
                        echo "<tr><td>$d</td><td></td><td></td><td></td><td></td></tr>";
                        $previous = $date;
                    }

                    if($view == 'all' || $view == $nameID) echo <<<END
                    <tr>
                        <td>$date</td>
                        <td>$fullName</td>
                        <td>$signin</td>
                        <td>$signout</td>
                        <td>$time</td>
                    </tr>
END;
                }

                ?>

                </tbody>
            </table>



            <?php echo $imports ?>

            <!-- Link for download as xls scripts -->
            <script src="scripts/jquery.table2excel.js"></script>

            <script>
                $(function() {
                    $("#save").click(function(){
                        $("#log-table").table2excel({
                            exclude: ".noExl",
                            name: "mki-logs"
                        });
                    });
                });
            </script>



        </div>


    </div>

</main>

<?php echo $copyright ?>
</body>

</html>

