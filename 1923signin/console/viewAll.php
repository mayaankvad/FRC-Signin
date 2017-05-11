<?php
include 'tools.php';
authenticate();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <script>
        function run() {
            getAll();
            setTimeout(run, 1000);
        }

        function getAll() {
            var data = document.getElementById('data');
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    data.innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "ajax/getAll.php", true);
            xmlhttp.send();
        }
    </script>

</head>

<body onload="run()">

<div class="container">

    <div class="content-block">

        <h1>All User Data</h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Subteam</th>
                    <th>Robot Day</th>
                    <th>Hours</th>
                    <th>Last Login</th>
                </tr>
                </thead>
                <tbody id="data">

                    <!-- Filled in through ajax call -->

                </tbody>
            </table>
        </div>

        <?php echo $imports ?>
        <!-- Link for download as xls scripts -->
        <script type="text/javascript" src="scripts/tableExport.js"></script>
        <script type="text/javascript" src="scripts/jquery.base64.js"></script>

        <br><br>
        <button class="btn btn-primary" onClick ="$('#table').tableExport({type:'excel',escape:'false'});">
            <i class="fa fa-download" aria-hidden="true"></i> Save as .xls
        </button>

    </div>

    <?php echo $copyright ?>
</div>

</body>

</html>
