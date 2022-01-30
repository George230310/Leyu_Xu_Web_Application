<?php
    require "config.php";

    // redirect if already logged in
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])
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
    <title>ANiREC Sign Up</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #sign-up-bk{
            background-image: url("media/images/violet_evergarden_bk.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 3%;
        }

        #sign-up-bk h1{
            color: white;
            text-align: center;
            text-shadow: 0px 0px 5px black;
        }

        #sign-up-form{
            color: white;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 15%;
            text-shadow: 0px 0px 3px black;
        }

        /* responsive caption */
        @media(min-width: 768px)
        {
            #sign-up-form{
                width: 80%;
            }
        }

        @media(min-width: 991px){
            #sign-up-form{
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
            <div id="sign-up-bk" class="col-10 col-md-8 pb-5">
                <h1 class="pt-5">Welcome to ANiREC!</h1>
                <form id="sign-up-form" method="POST" action="sign_up_confirmation.php">

                    <!-- username -->
                    <div class="mb-3">
                        <label for="usern" class="form-label fs-2">Create Username (45 characters MAX)</label>
                        <input type="text" class="form-control" id="usern" name="username">
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="pwd" class="form-label fs-2">Create Password</label>
                        <input type="password" class="form-control" id="pwd" name="password">
                    </div>

                    <!-- confirm password -->
                    <div class="mb-5">
                        <label for="pwd-re" class="form-label fs-2">Re-enter Password</label>
                        <input type="password" class="form-control" id="pwd-re" name="password-re">
                    </div>

                    <!-- submit button -->
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary bt-custom">Sign Up</button>
                        <button type="reset" class="btn btn-primary bt-custom">Reset</button>
                    </div>
                </form>
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
            if(children[i].innerHTML == "Sign Up")
            {
                children[i].classList.add("active");
            }
            else
            {
                children[i].classList.remove("active");
            }
        }

        // input validation
        document.querySelector("#sign-up-form").onsubmit = function(event){
            let username = document.querySelector("#usern").value.trim();
            let password = document.querySelector("#pwd").value.trim();
            let password_re = document.querySelector("#pwd-re").value.trim();

            if(username == "" || password == "" || password_re == "")
            {
                event.preventDefault();
                alert("username and two password entries cannot be empty");
            }
            else if(password != password_re)
            {
                event.preventDefault();
                alert("two password entries do not match");
            }
            else if(username.length > 45)
            {
                event.preventDefault();
                alert("username should not exceed 45 characters");
            }
        }
    </script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>