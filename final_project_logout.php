<?php
    require "config.php";
    // redirect if already logged out
    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
    {
        header("Location: final_project_home.php");
    }
    else
    {
        session_destroy();
        $_SESSION = [];
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
    <title>ANiREC Logout</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #logout-bk{
            background-image: url("media/images/fate_bk.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 3%;
        }

        #logout-bk h1{
            color: white;
            text-align: center;
            text-shadow: 0px 0px 3px black;
            padding-top: 30%;
        }
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid" id="confirmation-container">
        <div class="row mt-5 mb-5">
            <div class="col-1 col-md-2"></div>
            <div id="logout-bk" class="col-10 col-md-8 pb-5">
                <h1>You are now logged out</h1>

                <div class="text-center mt-5 pt-5">
                    <a class="btn btn-primary" href="final_project_home.php" role="button">Back to Home Page</a>
                </div>
                <div class="text-center mt-3">
                    <a class="btn btn-secondary" href="final_project_login.php" role="button">Login again</a>
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