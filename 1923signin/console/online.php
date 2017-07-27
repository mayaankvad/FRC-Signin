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

    <link rel="stylesheet" href="../styles/console.css">
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

<main>

    <div class="container">

        <div class="card-panel">

            <h3 class="center">Online<span class="count"><!-- filled through js --></span> </h3><hr><br>

            <?php echo $homeBtn ?>
            <br><br>

            <table class="centered" id="table">
                <thead>
                    <tr>
                        <th>Online <span class="count"><!-- filled through js --></span> </th>
                    </tr>
                </thead>
                <tbody id="data">

                    <!-- Filled in through ajax call -->

                </tbody>
            </table>

        </div>

    </div>

</main>

<?php echo $copyright ?>

</body>
<?php echo $imports ?>

</html>
