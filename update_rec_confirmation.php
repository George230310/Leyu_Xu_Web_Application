<?php
    require "config.php";

    // verify login
    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
    {
        header("Location: final_project_login.php");
    }
    else
    {
        // server side validation
        $anime_title = $_POST["anime_title"];
        $brief_intro = $_POST["brief_intro"];
        $rec_title = $_POST["rec_title"];
        $content = $_POST["content"];
        $post_date = $_POST["post_date"];
        $rec_id = $_GET["rec_id"];
        $anime_id = $_GET["anime_id"];

        if(!isset($anime_title) || empty($anime_title) || !isset($rec_title) || empty($rec_title) || !isset($content) || empty($content))
        {
            $error = "Please fill out all required fields";
        }
        else if(strlen($anime_title) > 255 || strlen($rec_title) > 255)
        {
            $error = "Woops, watch out for the character limit";
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

            // update anime table
            $update_anime_stmt = $mysqli->prepare("UPDATE animes SET anime_title=?, brief_intro=? WHERE id=?");
            $update_anime_stmt->bind_param("ssi", $anime_title, $brief_intro, $anime_id);
            $can_update = $update_anime_stmt->execute();
            if(!$can_update)
            {
                echo $update_anime_stmt->error;
                exit();
            }

            // update rec table
            $update_rec_stmt = $mysqli->prepare("UPDATE recommendations SET rec_title=?, content=?, post_date=? WHERE id=?");
            $update_rec_stmt->bind_param("sssi", $rec_title, $content, $post_date, $rec_id);
            $can_update_rec = $update_rec_stmt->execute();
            if(!$can_update_rec)
            {
                echo $update_rec_stmt->error;
                exit();
            }

            $update_anime_stmt->close();
            $update_rec_stmt->close();

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
    <title>ANiREC Update Confirmation</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #confirmation-bk{
            background-image: url("media/images/letter_bk.jpg");
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
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>
    <div class="container-fluid">
        <div class="row mt-5 mb-5 justify-content-center">
            <div id="confirmation-bk" class="col-10 col-md-8 pb-5">
                <?php if(isset($error) && !empty($error)) : ?>
                    <h1><?php echo $error;?></h1>
                <?php else : ?>
                    <h1><?php echo "Your recommendation has been updated!";?></h1>
                <?php endif; ?>

                <div class="text-center mt-5 pt-5">
                    <a class="btn btn-primary" href="final_project_home.php" role="button">Back to home page</a>
                </div>

                <div class="text-center mt-2">
                    <a class="btn btn-secondary mt-2" href="final_project_recommendations.php" role="button">View all recommendations</a>
                </div>
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