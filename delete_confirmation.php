<?php
    require "config.php";

    // verify login and identity
    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"] || $_SESSION["user_type"] != 1)
    {
        header("Location: final_project_home.php");
    }
    else
    {
        $rec_id = $_GET["rec_id"];

        if(!isset($rec_id) || empty($rec_id))
        {
            $error = "Must specify a record to delete";
        }
        else
        {
            // establish DB connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno)
            {
                echo $mysqli->connect_error;
                exit();
            }
            $mysqli->set_charset('utf8');

            $delete_stmt = $mysqli->prepare("DELETE FROM recommendations WHERE id=?");
            $delete_stmt->bind_param("i", $rec_id);

            $can_delete = $delete_stmt->execute();
            if(!$can_delete)
            {
                echo $delete_stmt->error;
                exit();
            }


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
    <title>ANiREC Admin Delete</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center white-font">

                <?php if(!isset($error) || empty($error)) :?>
                    <h1>This recommendation has been deleted</h1>
                <?php else :?>
                    <h1><?php echo $error;?></h1>
                <?php endif; ?>

                <a class="btn btn-primary my-5" href="final_project_recommendations.php" role="button">Back to recommendations</a>
            </div>
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