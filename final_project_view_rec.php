<?php
    require "config.php";

    // establish DB connection
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if($mysqli->connect_errno)
    {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');

    $rec_id = $_GET["rec_id"];

    // query for details
    $rec_detail_stmt = $mysqli->prepare("SELECT recommendations.rec_title, recommendations.content, recommendations.post_date, animes.anime_title, animes.brief_intro, users.username FROM recommendations JOIN animes ON recommendations.animes_id = animes.id JOIN users ON recommendations.users_id = users.id WHERE recommendations.id=?");

    $rec_detail_stmt->bind_param("i", $rec_id);

    $can_detail = $rec_detail_stmt->execute();

    // check for connection error
    if(!$can_detail)
    {
        echo $rec_detail_stmt->error;
        exit();
    }

    $result = $rec_detail_stmt->get_result();

    $row = $result->fetch_assoc();

    $rec_detail_stmt->close();
    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>ANiREC View Recommendation</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #main-detail{
            background-color: black;
            border-radius: 5%;
        }
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>


    <div id="view-rec-container" class="container-fluid">
        <!-- print details -->
        <div class="row justify-content-center">
            <div id="main-detail" class="col-12 col-lg-8 white-font mt-5 p-4">
                <h1 class="text-center">Recommendation for <?php echo $row["anime_title"] ;?></h1>
                <h3>Author</h3>
                <p class="normal-text"><em><?php echo $row["username"];?></em></p>
                <h3>Post Date</h3>
                <p class="normal-text"><em><?php echo $row["post_date"];?></em></p>
                <h3>Anime Synopsis</h3>
                <p class="normal-text"><em><?php echo $row["brief_intro"];?></em></p>
                <h3>Title of this Recommendation</h3>
                <p class="normal-text"><em><?php echo $row["rec_title"];?></em></p>
                <h3>Detailed Comments</h3>
                <p class="normal-text"><em><?php echo $row["content"];?></em></p>
            </div>

            <div class="col-12 col-lg-8 mb-5 mt-3">
                <div class="d-grid gap-2 mt-3">
                    <a class="btn btn-primary btn-block" href="final_project_recommendations.php" role="button">Go Back to All Recommendations</a>
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