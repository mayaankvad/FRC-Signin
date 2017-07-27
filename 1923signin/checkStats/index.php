<?php

include '../config.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>The MidKnight Inventors</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="../styles/stats.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

    <script>
        // TODO formatting data & correcting errors
        function getUser() {
            var str = document.getElementById("name-input").value;

            if (str == "") {
                document.getElementById("user-info").innerHTML = "";
            }

            else if(str == "") {
                document.getElementById("user-info").innerHTML = "No Users Found";
            } else {
                xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        if(this.responseText == "{}" ) {
                            document.getElementById("user-info").innerHTML = (str.length >= 6) ? "No Users Found": "";
                        }
                        else {
                            var data = JSON.parse(this.responseText);

                            var msg = '<div class="table-responsive"> <table class="table " id="table"> <tbody>';
                            msg += '<tr class=""><td>Full Name</td><td>'+data.fullName+'</td></tr>';
                            msg += '<tr class=""><td>Subteam</td><td>'+data.subteam+'</td></tr>';
                            msg += '<tr class=""><td>Day</td><td>'+data.robotDay+'</td></tr>';
                            msg += '<tr class=""><td>Time</td><td>'+convertSeconds(data.seconds)+'</td></tr>';
                            msg += '<tr class=""><td>last login</td><td>'+data.lastLogin+'</td></tr>';
                            msg += '</tbody></table></div>';

                            var url = 'logs.php?view=' + encodeURI(data.fullName);
                            msg += '<button class="btn waves-effect waves-light btn-large pink lighten-1" onclick="window.location.href=\''+url+'\'">View Logs</button>';
                            document.getElementById("user-info").innerHTML = msg;
                        }
                    }
                };
                xmlhttp.open("GET","../getUser.php?q="+encodeURI(str),true);
                xmlhttp.send();
            }
        }

        function convertSeconds(sec) {
            return Math.trunc(sec / 3600) + " h : " + Math.trunc((sec % 3600) / 60) + ' m';
        }

    </script>


</head>

<body>

<main>


    <div class="container">

        <img src="../images/banner.png" class="responsive-img" alt="The MidKnight Inventors" onclick="window.location='../'"><br>
        <h5 class="center">Your Data</h5><br>


        <nav>
            <div class="nav-wrapper">
                <form>
                    <div class="input-field">
                        <input id="name-input" type="search" onkeyup="getUser()" class="white" autofocus required>
                        <label class="label-icon" for="name-input"><i class="material-icons">person</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>


        <br>
        <div class="center" id="user-info">
            <!-- Filled in through ajax call -->
        </div>

        <br><br><br><br>

    </div>

</main>

</body>

</html>

