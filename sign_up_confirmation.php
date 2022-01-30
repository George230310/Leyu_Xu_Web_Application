<?php
    require "config.php";

    // redirect if already logged in
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])
    {
        header("Location: final_project_home.php");
    }
    else
    {
        // do the sign up

        // server side validation
        if(!isset($_POST["username"]) || empty($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["password-re"]) || empty($_POST["password-re"]))
        {
            $error = "Please fill out all necessary information";
        }
        else if(strlen($_POST["username"]) > 45)
        {
            $error = "Username should not exceed 45 characters";
        }
        else
        {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // establish DB connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno)
            {
                echo $mysqli->connect_error;
                exit();
            }

            $mysqli->set_charset('utf8');

            // check for duplicate username
            $verify_duplicate_stmt = $mysqli->prepare("SELECT * FROM users WHERE username=?");
            $verify_duplicate_stmt->bind_param("s", $username);
            $can_verify = $verify_duplicate_stmt->execute();

            // check for connection errors
            if(!$can_verify)
            {
                echo $verify_duplicate_stmt->error;
                exit();
            }

            // verify duplicate username
            if($verify_duplicate_stmt->get_result()->num_rows > 0)
            {
                $error = "Username already exists";
            }
            else
            {
                $hashed_password = hash("sha256", $password);
                $user_type = 0;
                $registration_stmt = $mysqli->prepare("INSERT INTO users(username, password, user_type) VALUES(?,?,?)");
                $registration_stmt->bind_param("ssi", $username, $hashed_password, $user_type);

                $can_register = $registration_stmt->execute();
                if(!$can_register)
                {
                    echo $registration_stmt->error;
                    exit();
                }
                // automatic login
                else
                {
                    $_SESSION["logged_in"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["user_type"] = $user_type;
                    $_SESSION["user_id"] = $mysqli->insert_id;
                }

                $registration_stmt->close();
            }

            $verify_duplicate_stmt->close();
            $mysqli->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>ANiREC Confirmation</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #confirmation-bk{
            background-image: url("media/images/violet_evergarden_bk.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 3%;
        }

        #confirmation-bk h1{
            color: white;
            text-align: center;
            text-shadow: 0px 0px 5px black;
            padding-top: 30%;
        }

        #confirmation-bk p{
            text-shadow: 0px 0px 5px black;
        }
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid" id="confirmation-container">
        <div class="row mt-5 mb-5">
            <div class="col-1 col-md-2"></div>
                <div id="confirmation-bk" class="col-10 col-md-8 pb-5">
                    <?php if(isset($error) && !empty($error)) : ?>
                        <h1><?php echo $error;?></h1>
                    <?php else : ?>
                        <h1><?php echo "Registration successful! Welcome on board $username";?></h1>
                        <p class="text-center white-font">You're logged in automatically</p>
                    <?php endif; ?>

                    <div class="text-center mt-5 pt-5">
                        <a class="btn btn-primary" href="final_project_home.php" role="button">Back to home page</a>
                    </div>
                </div>
            <div class="col-1 col-md-2"></div>
        </div>

        <!-- footer -->
        <div class="row">
            <div class="footer normal-text col-12 py-2">
                Copyright &copy; 2021 ANiREC
            </div>
        </div>
    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>