<?php
include 'tools.php';
authenticate();

// Add New User
if(isset($_POST['submit'])) {

    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $subteam = $_POST['subteam'];
    $day = $_POST['day'];
    $hours = $_POST['hours'];

    $nameID = toNameID($fullName);
    $seconds = $hours * 3600;

    $query = "INSERT INTO users(nameID, fullName, email, subteam, robotDay, seconds) VALUES ('$nameID', '$fullName', '$email', '$subteam', '$day', '$seconds');";

    $result = mysqli_query($conn, $query);

    if(!$result)
        nicedie("Could not add $fullName, Reason: " . mysqli_error($conn), 'Error!');
    else
        message("$fullName is now part of the team!", "New Member Added!");
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    
    <link rel="stylesheet" href="style.css">
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
                            response.innerHTML = "<div class='alert alert-success'>This name is available</div>";
                            button.disabled = false;
                        }
                        else {
                            response.innerHTML = "<div class='alert alert-danger'>This name is not available</div>";
                            button.disabled = true;
                        }

                    }
                };
                xmlhttp.open("GET", "getUser.php?q=" + name , true);
                xmlhttp.send();
            }

        }
    </script>

</head>

<body>

<div class="container">

    <div class="content-block">

        <h1>Register New Team Member</h1><hr>

        <form action="" method="post">

            <!--  Full Name -->
            <div class="form-group">
                <input type="text" class="form-control" id="name-input" name="name" placeholder="Full Name" onkeyup="getUser()" required autocomplete="off">
                <small id="name-help" class="form-text text-muted">Please include proper capitalization and spacing</small>

            </div>
            <div id="response">
            </div>
            <br>

            <!-- Email -->
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autocomplete="off">
                <small id="email-help" class="form-text text-muted">
                    We must be able to contact you through this email. Make sure its one you actually check<br>
                </small>
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

            <!-- Hours -->
            <div class="form-group">
                <input type="number" class="form-control" id="hours" name="hours" placeholder="Hours" required autocomplete="off">
                <small id="" class="form-text text-muted">
                    How many hours does this student already have?
                </small>
            </div>
            <br>
            
            <input type="submit" id="submit" class="btn btn-primary submit" name="submit" value="Add New Student" disabled>

        </form>

        <br><br>
        <button class="btn btn-primary home-btn fa fa-home fa-1x" onclick="window.location.href='index.php'"></button>

    </div>


    <?php echo $copyright; ?>

</div>
<?php echo $imports ?>

</body>

</html>

