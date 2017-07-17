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

    <?php echo $imports ?>
    <script src="scripts/scroll.js"></script>

    <link rel="stylesheet" href="../styles/console.css">
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

<main>

    <div class="container">

        <div class="card-panel">

            <h3 class="center" id="top">All Team Data</h3><hr><br>

            <a class="center btn waves-effect waves-light pink lighten-1 z-depth-5" href="index.php">
                <i class="material-icons">home</i>
            </a>

            <br><br><br>
            <a href="#save">save</a>

            <br><br>


            <table id="table">
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


            <!-- Save btn -->
            <button id="save" class="btn waves-effect waves-light pink lighten-1 z-depth-5">
                <i class="fa fa-file-excel-o"></i> Save as Excel
            </button>

            <!-- Link for download as xls scripts -->
            <script src="scripts/jquery.table2excel.js"></script>

            <script>
                $(function() {
                    $("#save").click(function(){
                        $("#table").table2excel({
                            exclude: ".noExl",
                            name: "mki-team-data"
                        });
                    });
                });
            </script>


            <br><br>
            <a href="#top">Top</a>


        </div>


    </div>

</main>

    <?php echo $copyright ?>
</body>

</html>
