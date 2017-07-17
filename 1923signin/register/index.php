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
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="../styles/console.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <!-- Check Name Availability -->
    <script>
        function getUser() {
            var name = document.getElementById("name-input").value;
            name = encodeURI(name);

            var response = document.getElementById("response");
            var button = document.getElementById("submit");

            if(name == "") {
                response.innerHTML = "";
                button.disabled = true;
            }
            else {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if(this.readyState == 4 && this.status == 200) {

                        if(this.responseText == "{}") {
                            response.innerHTML = "<span class='green-text'> <i class='material-icons'>done_all</i> Name Available</span>";
                            button.disabled = false;
                        }
                        else {
                            response.innerHTML = "<span class='red-text'> <i class='material-icons'>error_outline</i> Name Not Available</span>";
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

<main>

    <div class="container">

        <div class="card-panel">


            <img src="../images/banner.png" class="responsive-img" alt="Register" onclick="window.location='../'"><br>
            <h5 class="center">Register</h5><br>


            <form action="" method="post">


                <!-- Name Input -->
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input type="text" id="name-input" class="autocomplete" name="name" onkeyup="getUser()" autocomplete="off" required>
                    <label for="name-input" class="center">Full Name</label>
                </div>


                <div id="response">
                    <!-- ajax -->
                </div>
                <br>

                <!-- subteam -->
                <div class="input-field">
                    <i class="material-icons prefix fa fa-gear"></i>
                    <select id="subteam" name="subteam" required>
                        <option value="" disabled selected>Select Subteam</option>
                        <option value="Mechanism">Mechanism</option>
                        <option value="Drive Train">Drive Train</option>
                        <option value="Programming">Programming</option>
                        <option value="Electrical">Electrical</option>
                        <option value="CAD">CAD</option>
                    </select>
                    <label>Subteam</label>
                </div>
                <br>

                <!-- Day -->
                <div class="input-field">
                    <i class="material-icons prefix fa fa-clock-o"></i>
                    <select id="day" name="day" required>
                        <option value="" disabled selected>Select Day</option>
                        <option value="Tesla">Tesla (Tuesday + Thursday + Saturday)</option>
                        <option value="Edison">Edison (Wednesday + Friday + Sunday)</option>
                        <option value="Both">Both (For Captains Only)</option>
                    </select>
                    <label>Day</label>
                </div>
                <br>


                <button class="btn waves-effect waves-light btn-large green lighten-1 z-depth-5"
                        type="submit" name="submit" value="submit" id="submit" disabled>
                    <i class="material-icons prefix">add</i> Team Member
                </button>
                <br><br><br>



            </form>


        </div>




    </div>

</main>

<?php echo $copyright; ?>


<?php echo $imports ?>

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>

</body>

</html>
