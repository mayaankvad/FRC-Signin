<?php
include 'tools.php';
authenticate();

$toast = null;

if (isset($_POST['moreinfo'])) {
    $_SESSION['viewUser'] = $_POST['name'];
    header('Location: viewDetails.php');
}

if (isset($_POST['signin'])) {
    $toast = signin($_POST['name']);
}

if (isset($_POST['signout'])) {
    $toast = signout($_POST['name']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title><?php echo $title ?></title>

    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="../styles/console.css">

    <?php echo $imports ?>

    <script>
        // set autocomplete for names
        $(function () {
            $(function () {
                $('input.autocomplete').autocomplete({
                    data: {
                        <?php

                        $query = "SELECT fullName FROM users";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            echo '"' . $row['fullName'] . '":null,';
                        }

                        ?>
                    },
                    limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                    onAutocomplete: function (val) {
                        // Callback function when value is autcompleted.
                    },
                    minLength: 3, // The minimum length of the input for the autocomplete to start. Default: 1.
                });
            });

        });

        // initialize model (for menu buttons)
        $(document).ready(function () {
                $('.modal').modal({
                        dismissible: true, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        inDuration: 300, // Transition in duration
                        outDuration: 200, // Transition out duration
                        startingTop: '4%', // Starting top style attribute
                        endingTop: '10%', // Ending top style attribute
                        ready: function (modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.

                        },
                        complete: function () { // Callback for Modal close

                        }
                    }
                );
            }
        );


        function run() {
            getUser();
            setTimeout(run, 250);
        }

        function getUser() {
            var name = document.getElementById("name-input").value;
            var signInButton = document.getElementById("signin-btn");
            var signOutButton = document.getElementById("signout-btn");
            var moreInfoButton = document.getElementById("moreinfo-btn");

            if (name == "") {
                signInButton.disabled = true;
                signOutButton.disabled = true;
                moreInfoButton.disabled = true;
            }
            else {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        if (this.responseText == "{}") {
                            signInButton.disabled = true;
                            signOutButton.disabled = true;
                            moreInfoButton.disabled = true;
                        }
                        else {
                            moreInfoButton.disabled = false;
                            var user = JSON.parse(this.responseText);
                            if (user.online == 0) {
                                signInButton.disabled = false;
                                signOutButton.disabled = true;
                            }
                            else if (user.online == 1) {
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

</head>

<body onload="run()">

<?php

if($toast != null)
    echo <<<"END"
            <script>
                var msg ="$toast";
                var col = '';
                if(msg.indexOf('already') > -1) {
                    col = 'red-text';
                } else if(msg.indexOf('signed in') > -1) {
                    col = 'green lighten-1';
                } else if(msg.indexOf('signed out') > -1) {
                    col = 'red lighten-1';
                }

                Materialize.toast(msg, 3000, col);
            </script>
END;
$toast = null;

?>

<main>


    <div class="container">

        <div class="card-panel">

            <img src="../images/banner.png" class="responsive-img" alt="Sign In Below"><br>
            <h5 class="center">Hi!</h5><br>

            <form action="" method="post">
                <!-- Name Input -->
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input type="text" id="name-input" class="autocomplete" name="name" onkeyup="getUser()"
                           autocomplete="off" autofocus required>
                    <label for="name-input" class="center">Full Name</label>
                </div>


                <div class="input-field center">

                    <!-- Sign In -->
                    <button class="btn waves-effect waves-light btn-large green lighten-1 hoverable"
                            type="submit" name="signin" value="Sign In" id="signin-btn" disabled>
                        Sign In
                    </button>

                    <!-- Info -->
                    <button class="btn waves-effect waves-light btn-large pink lighten-1 hoverable"
                            type="submit" name="moreinfo" value="More Info" id="moreinfo-btn" disabled>
                        Info <i class="material-icons right">info_outline</i>
                    </button>

                    <!-- Sign Out -->
                    <button class="btn waves-effect waves-light btn-large red lighten-1 hoverable"
                            type="submit" name="signout" value="Sign Out" id="signout-btn" disabled>
                        Sign Out
                    </button>

                </div>

            </form>

            <br><br>

            <!-- Popup Trigger -->
            <a class="waves-effect waves-light btn pink lighten-1" href="#popup"><i class="material-icons">menu</i></a>

            <!-- Popup Structure -->
            <div id="popup" class="modal">
                <div class="modal-content">
                    <div class="center">
                        <a class="btn waves-effect waves-light green lighten-1 hoverable" href="online.php">Online</a>
                        <br><br>

                        <a class="btn waves-effect waves-light pink lighten-1 hoverable" href="viewAll.php">All Data</a>
                        <br><br>

                        <a class="btn waves-effect waves-light pink lighten-1 hoverable" href="newStudent.php">New Student</a>
                        <br><br>

                        <a class="btn waves-effect waves-light blue lighten-1 hoverable" href="logs.php">Logs</a>
                        <br><br>

                        <a class="btn waves-effect waves-light red lighten-1 hoverable" href="confirm.php?action=signoutall">Sign Out All</a>
                        <br><br>

                        <a class="btn waves-effect waves-light red darken-1 hoverable" href="confirm.php?action=forcesignoutall">Force Sign Out All</a>
                        <br><br>

                        <a class="btn waves-effect waves-light pink lighten-1 hoverable" href="settings.php"><i class="material-icons">settings</i></a>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
                </div>
            </div>

        </div> <!-- ./card-panel -->


    </div> <!-- ./container -->

</main>


<?php echo $copyright ?>


</body>

</html>
