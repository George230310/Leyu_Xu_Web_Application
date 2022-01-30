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
        $user_id = $_SESSION["user_id"];

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

            // check for existence of anime title
            $check_stmt = $mysqli->prepare("SELECT * FROM animes WHERE anime_title LIKE ?");
            $check_stmt->bind_param("s", $anime_title);

            $can_check = $check_stmt->execute();
            if(!$can_check)
            {
                echo $check_stmt->error;
                exit();
            }
            $result = $check_stmt->get_result();

            $anime_id = -1;

            // if anime title already exists, capture the id
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $anime_id = $row["id"];

                // if the current user has a longer synopsis replace synopsis
                $previous_intro = $row["brief_intro"];
                if(strlen($brief_intro) > strlen($previous_intro))
                {
                    $intro_insert_stmt = $mysqli->prepare("UPDATE animes SET brief_intro=? WHERE id=?");
                    $intro_insert_stmt->bind_param("si", $brief_intro, $anime_id);
                    $can_update = $intro_insert_stmt->execute();
                    if(!$can_update)
                    {
                        echo $intro_insert_stmt->error;
                        exit();
                    }

                    $intro_insert_stmt->close();
                }
            }
            // else insert the new anime
            else
            {
                $insert_stmt = $mysqli->prepare("INSERT INTO animes(anime_title, brief_intro) VALUES(?,?)");
                $insert_stmt->bind_param("ss", $anime_title, $brief_intro);
                $can_insert = $insert_stmt->execute();
                if(!$can_insert)
                {
                    echo $insert_stmt->error;
                    exit();
                }

                $anime_id = $mysqli->insert_id;
                $insert_stmt->close();
            }

            // insert recommendation
            $rec_insert_stmt = $mysqli->prepare("INSERT INTO recommendations(rec_title, content, post_date, animes_id, users_id) VALUES(?,?,?,?,?)");
            $rec_insert_stmt->bind_param("sssii", $rec_title, $content, $post_date, $anime_id, $user_id);
            $can_rec = $rec_insert_stmt->execute();
            if(!$can_rec)
            {
                echo $rec_insert_stmt->error;
                exit();
            }


            $rec_insert_stmt->close();
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
    <title>ANiREC Addition Confirmation</title>
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

    <div class="container-fluid" id="confirmation-container">
        <div class="row mt-5 mb-5 justify-content-center">
            <div id="confirmation-bk" class="col-10 col-md-8 pb-5">
                <?php if(isset($error) && !empty($error)) : ?>
                    <h1><?php echo $error;?></h1>
                <?php else : ?>
                    <h1><?php echo "Your recommendation has been recorded!";?></h1>
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