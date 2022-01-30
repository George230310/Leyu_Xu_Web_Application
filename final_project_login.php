<?php
    require "config.php";

    // if not already logged in
    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
    {
        // if the form is submitted
        if ( isset($_POST["username"]) && isset($_POST["password"]) )
        {
            // if the form is not filled
            if ( empty($_POST["username"]) || empty($_POST["password"]) ) {

                $error = "Please enter username and password";
    
            }
            else
            {
                // establish DB connection
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if($mysqli->connect_errno) {
                    echo $mysqli->connect_error;
                    exit();
                }

                $mysqli->set_charset('utf8');

                // login
                $username = $_POST["username"];
                $password = $_POST["password"];
                $hashed_password = hash("sha256", $password);

                $login_stmt = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
                $login_stmt->bind_param("ss", $username, $hashed_password);

                $can_login = $login_stmt->execute();

                // check connection error
                if(!$can_login)
                {
                    echo $login_stmt->error;
                    exit();
                }
                
                // if can login
                $result = $login_stmt->get_result();
                if($result->num_rows > 0)
                {
                    // record session
                    $_SESSION["logged_in"] = true;
                    $_SESSION["username"] = $username;
                    $row = $result->fetch_assoc();
                    $_SESSION["user_type"] = $row["user_type"];
                    $_SESSION["user_id"] = $row["id"];
                    $login_stmt->close();
                    $mysqli->close();
                    header("Location: final_project_home.php");
                }
                else
                {
                    $error = "Invalid username or password";
                }
            }
        }
    }
    else
    {
        header("Location: final_project_home.php");
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
    <title>ANiREC Login</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #login-bk{
            background-image: url("media/images/fate_bk.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 3%;
        }

        #login-form{
            color: white;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 15%;
            text-shadow: 0px 0px 3px black;
        }

        #login-bk h1{
            color: white;
            text-align: center;
            text-shadow: 0px 0px 3px black;
        }

        #error-message{
            background-color: red;
            color: white;
            text-shadow: 0px 0px 3px black;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        /* responsive caption */
        @media(min-width: 768px)
        {
            #login-form{
                width: 80%;
            }
        }

        @media(min-width: 991px){
            #login-form{
                width: 60%;
            }
        }
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid" id="login-container">
        <div class="row mt-5 mb-5">
            <div class="col-1 col-md-2"></div>

            <!-- actual login content -->
            <div id="login-bk" class="col-10 col-md-8 pb-5">
                <h1 class="pt-5">Welcome back to ANiREC!</h1>

                <!-- submit to myself -->
                <form id="login-form" method="POST" action="final_project_login.php">

                    <!-- username -->
                    <div class="mb-3">
                        <label for="usern" class="form-label fs-2">Username</label>
                        <input type="text" class="form-control" id="usern" name="username">
                    </div>

                    <!-- password -->
                    <div class="mb-5">
                        <label for="pwd" class="form-label fs-2">Password</label>
                        <input type="password" class="form-control" id="pwd" name="password">
                    </div>

                    <!-- submit button -->
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary bt-custom">Login</button>
                        <button type="reset" class="btn btn-primary bt-custom">Reset</button>
                    </div>
                </form>

                <?php if(isset($error) && !empty($error)) :?>
                    <div id="error-message" class="normal-text text-center p-2"><?php echo $error;?></div>
                <?php endif; ?>
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

    <script>
        // highlight in navbar
        let children = document.querySelector("#all-navs").children;
        for(let i = 0; i < children.length; i++)
        {
            if(children[i].innerHTML == "Login")
            {
                children[i].classList.add("active");
            }
            else
            {
                children[i].classList.remove("active");
            }
        }

        // input verification
        document.querySelector("#login-form").onsubmit = function(){
            let username = document.querySelector("#usern").value.trim();
            let password = document.querySelector("#pwd").value.trim();

            if(username == "" || password == "")
            {
                event.preventDefault();
                alert("username and password cannot be empty");
            }
            else if(username.length > 45)
            {
                event.preventDefault();
                alert("username cannot exceed 45 characters");
            }
        }
        
    </script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>