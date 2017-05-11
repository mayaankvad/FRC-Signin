<?php
session_start();

include '../databaseConfig.php';
include '../config.php';
include '../formatting.php';

// Database Connection
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);
if(!$conn) display('Database Connection Failed<br>Reason: ' . mysqli_connect_error());


// Add New User
if(isset($_POST['submit'])) {

    $fullName = $_POST['name'];
    $subteam = $_POST['subteam'];
    $day = $_POST['day'];
    $hours = 0;

    $nameID = toNameID($fullName);
    $seconds = $hours * 3600;

    $query = "INSERT INTO users(nameID, fullName, subteam, robotDay, seconds) VALUES ('$nameID', '$fullName', '$subteam', '$day', '$seconds');";

    $result = mysqli_query($conn, $query);

    if(!$result)
        display("Could not add $fullName, Reason: " . mysqli_error($conn), 'Error!');
    else
        display("Ok $fullName, you are now on team 1923 ", "New Member Added!");

}


function display($message, $heading=null) {
    $_SESSION['message'] = [
        'message' => $message,
        'heading' => $heading
    ];
    header('Location: message.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>The MidKnight Inventors</title>

    <link rel="stylesheet" href="../console/style.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <!-- Check Name Availability -->
    <script>
        function getUser() {
            var name = document.getElementById("name-input").value;
            name = encodeURI(name);

            var response = document.getElementById("response");
            var button = document.getElementById("submit");

            if(name.length < 4) {
                response.innerHTML = "";
                button.disabled = true;
            }
            else {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if(this.readyState == 4 && this.status == 200) {

                        if(this.responseText == "{}") {
                            response.innerHTML = "<div class='alert alert-success'>This name is available</div>";
                            button.disabled = false;
                        }
                        else {
                            response.innerHTML = "<div class='alert alert-danger'>This name is not available</div>";
                            button.disabled = true;
                        }

                    }
                };
                xmlhttp.open("GET", "../getUser.php?q=" + name , true);
                xmlhttp.send();
            }

        }
    </script>

</head>

<body>

<div class="container">

    <div class="content-block">


        <img src="../banner.png" alt="The MidKnight Inventors" width="" class="img img-responsive center-block" onclick="window.location.href='../'">
        <h1>Sign Up for Team 1923</h1><hr>

        <form action="" method="post">

            <!--  Full Name -->
            <div class="form-group">
                <input type="text" class="form-control" id="name-input" name="name" placeholder="Full Name" onkeyup="getUser()" required autocomplete="off">
                <small id="name-help" class="form-text text-muted">Please include proper capitalization and spacing</small>

            </div>
            <div id="response">
            </div>
            <br>


            <!-- Subteam -->
            <div class="form-group">
                <select class="form-control" id="subteam" name="subteam" required>
                    <option value="" disabled selected>Select a Subteam...</option>
                    <option value="Mechanism">Mechanism</option>
                    <option value="Drive Train">Drive Train</option>
                    <option value="Programming">Programming</option>
                    <option value="Electrical">Electrical</option>
                    <option value="CAD">CAD</option>
                </select>
                <small id="" class="form-text text-muted">
                    What Subteam are you on?
                </small>
            </div>
            <br>

            <!-- Day -->
            <div class="form-group">
                <select class="form-control" id="day" name="day" required>
                    <option value="" disabled selected>Select a Robot...</option>
                    <option value="Tesla">Tesla (Tuesday + Thursday + Saturday)</option>
                    <option value="Edison">Edison (Wednesday + Friday + Sunday)</option>
                    <option value="Both">Both (For Co-Captains Only)</option>
                </select>
                <small id="" class="form-text text-muted">
                    What Robot do you work with?
                </small>
            </div>
            <br>

            <input type="submit" id="submit" class="btn btn-primary big-btn" name="submit" value="Register" disabled>

        </form>

    </div>

    <br><div class="copyright">Copyright &copy; 2017 Team 1923 The MidKnight Inventors, All Rights Reserved</div>
    <br><br><br>

</div>

<?php echo $imports ?>

</body>

</html>

