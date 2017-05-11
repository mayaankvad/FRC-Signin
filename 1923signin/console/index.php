<?php
include 'tools.php';
authenticate();

if(isset($_POST['moreinfo'])) {
    $_SESSION['viewUser'] = $_POST['name'];
    header('Location: viewDetails.php');
}

if(isset($_POST['signin'])) {
    signin($_POST['name']);
}

if(isset($_POST['signout'])) {
    signout($_POST['name']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../favicon.ico">

    <?php echo $imports ?>
    <!-- additional JQuery resources for autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <!-- Change the buttons -->
    <script>
        function getUser() {
            var name = document.getElementById("name-input").value;
            var signInButton = document.getElementById("signin-btn");
            var signOutButton = document.getElementById("signout-btn");
            var moreInfoButton = document.getElementById("moreinfo-btn");

            if(name == "") {
                signInButton.disabled = true;
                signOutButton.disabled = true;
                moreInfoButton.disabled = true;
            }
            else {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        if(this.responseText == "{}") {
                            signInButton.disabled = true;
                            signOutButton.disabled = true;
                            moreInfoButton.disabled = true;
                        }
                        else {
                            moreInfoButton.disabled = false;
                            var user = JSON.parse(this.responseText);
                            if(user.online == 0) {
                                signInButton.disabled = false;
                                signOutButton.disabled = true;
                            }
                            else if(user.online == 1) {
                                signInButton.disabled = true;
                                signOutButton.disabled = false;
                            }
                        }

                    }
                };
                xmlhttp.open("GET", "ajax/getUser.php?q=" + encodeURI(name), true);
                xmlhttp.send();
            }
        }
    </script>

    <!-- set autocomplete for names -->
    <script>
        $( function() {
            var availableNames = [
                <?php
                $query = "SELECT fullName FROM users";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)) {
                    echo '"' . $row['fullName'] . '", ';
                }
                ?>
            ];
            $("#name-input").autocomplete({
                source: availableNames
            });
        });
    </script>

</head>

<body>

<div class="container">

    <div class="content-block">

        <h1 class="text-center">Team 1923 Sign In Below</h1><br><hr><br>

        <form action="" method="post">
            <input type="text" class="form-control" id="name-input" placeholder="Full Name" name="name" autocomplete="on" onkeyup="getUser()" required><br>
            <br><br>
            <input type="submit" name="signin" value="Sign In" id="signin-btn" class="btn btn-primary big-btn" disabled>
            <input type="submit" name="moreinfo" value="More Info" id="moreinfo-btn" class="btn btn-primary big-btn" disabled>
            <input type="submit" name="signout" value="Sign Out" id="signout-btn" class="btn btn-primary big-btn" disabled>
        </form>
        <br><br>

        <!-- -->
        <br>
        <button class="btn btn-primary submit" onclick="window.location.href = 'online.php'">Currently Online</button>
        <button class="btn btn-primary submit" onclick="window.location.href = 'confirm.php?action=signoutall'">Sign Out All</button>
        <button class="btn btn-primary submit" onclick="window.location.href = 'confirm.php?action=forcesignoutall'">Force Sign Out All</button>
        <!-- -->

        <br><br>
        <button class="btn btn-primary submit" onclick="window.location.href = 'viewAll.php'">View All Data</button>
        <button class="btn btn-primary submit" onclick="window.location.href = 'logs.php?view=all'">View Logs</button>
        <button class="btn btn-primary submit" onclick="window.location.href = 'newStudent.php'">New Student?</button>
        <!-- -->

        <br>
        <button class="btn btn-primary submit" onclick="window.location.href = 'settings.php'">Settings</button>
        
    </div>

    <?php echo $copyright ?>
</div>

</body>

</html>
