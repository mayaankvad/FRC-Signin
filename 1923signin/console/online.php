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
            setCount();
            setTimeout(run, 1000);
        }

        function setCount() {
            var table = document.getElementById('table');
            var text = '(' + (table.rows.length-1) + ')'; // -1 cause one row is used for 'Online Now'
            $('.count').text(text);
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

        <h1>Active Now <span class="count"><!-- filled through js --></span> </h1><hr><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>
        <br><br>

        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Online Now <span class="count"><!-- filled through js --></span> </th>
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
