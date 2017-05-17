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
            getOnline();
            setTimeout(run, 1000);
        }

        function getOnline() {
            var data = document.getElementById('data');
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                        data.innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "ajax/getOnline.php", true);
            xmlhttp.send();
        }
    </script>

</head>

<body onload="run()">

<div class="container">

    <div class="content-block">

        <h1>Active Now  </h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Online Now</th>
                    </tr>
                </thead>
                <tbody id="data">

                    <!-- Filled in through ajax call -->

                </tbody>
            </table>
        </div>

    </div>

    <?php echo $copyright ?>
</div>


</body>
<?php echo $imports ?>

</html>
