<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The MidKnight Inventors</title>

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

    <script>
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
                            msg += '<tr class=""><td>Email</td><td>'+data.email+'</td></tr>';
                            msg += '<tr class=""><td>Subteam</td><td>'+data.subteam+'</td></tr>';
                            msg += '<tr class=""><td>Day</td><td>'+data.robotDay+'</td></tr>';
                            msg += '<tr class=""><td>Time</td><td>'+data.seconds+'(convert sec later)</td></tr>';
                            msg += '<tr class=""><td>last login</td><td>'+data.lastLogin+'</td></tr>';
                            msg += '</tbody></table></div>';

                            var url = 'logs.php?view=' + encodeURI(data.fullName);
                            msg += '<button class="btn btn-primary" onclick="window.location.href=\''+url+'\'">View Logs</button>';

                            document.getElementById("user-info").innerHTML = msg;
                        }
                    }
                };
                xmlhttp.open("GET","../getUser.php?q="+encodeURI(str),true);
                xmlhttp.send();
            }
        }
    </script>

    <style>
        body {
            background-color: #000000 !important;
            color: #ffffff !important;
            align-items: center;
            align-content: center;
        }
        #form{
            margin-top: 30px;
            align-items: center !important;
        }
        #heading {
            margin-top: 20px;
            text-align: center;
        }
        #name-input {
            text-align: center !important;
            font-size: 15px;

            margin-right: 50%;
        }

        #user-info {
            text-align: center;
        }

    </style>

</head>
<body>


<div class="container">

    <div id="heading" class="wow fadeIn" data-wow-delay="0.3s" data-wow-duration="2s">
        <img src="../banner.png" alt="The MidKnight Inventors" width="" class="img img-responsive center-block">

        <h4>Use this page to see your stats</h4>
        <h4>If you need help contact us</h4>
		<h5>Case Insensitive ;)</h5>
    </div>

    <div id="form" class="wow fadeIn" data-wow-delay="0.3s" data-wow-duration="2s">
        <form action="" method="post">
            <input type="text" class="form-control" id="name-input" placeholder="Full Name" name="name" autocomplete="on" onkeyup="getUser()" required>
        </form>
    </div>

    <br>
    <div id="user-info">

    </div>
    <br><br><br><br>

</div>

</body>
</html>
