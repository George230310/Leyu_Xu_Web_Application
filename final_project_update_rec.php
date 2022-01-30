<?php
    require "config.php";

     // verify login
     if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
     {
         header("Location: final_project_login.php");
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

        $rec_id = $_GET["rec_id"];

        // query for details
        $rec_detail_stmt = $mysqli->prepare("SELECT recommendations.rec_title, recommendations.content, animes.anime_title, animes.brief_intro, animes.id AS anime_id FROM recommendations JOIN animes ON recommendations.animes_id = animes.id WHERE recommendations.id=?");

        $rec_detail_stmt->bind_param("i", $rec_id);

        $can_detail = $rec_detail_stmt->execute();

        // check for error
        if(!$can_detail)
        {
            echo $rec_detail_stmt->error;
            exit();
        }

        $result = $rec_detail_stmt->get_result();
        $row = $result->fetch_assoc();
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
    <title>ANiREC Update</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid" id="update-container">

        <form id="update-form" action="update_rec_confirmation.php?rec_id=<?php echo $rec_id;?>&anime_id=<?php echo $row['anime_id'];?>" method="POST">
            <div class="row justify-content-center">
                <div id="update-rec" class="col-12 col-lg-8 white-font mt-5 p-4">
                    <h1 class="text-center">Update an Entry</h1>

                    <label for="anime_title" class="form-label normal-text">*Anime Title (Cannot modify this)</label>
                    <input type="text" class="form-control" id="anime_title" name="anime_title" value="<?php echo $row['anime_title']?>" readonly>

                    <label for="brief_intro" class="form-label normal-text">Anime Synopsis</label>
                    <textarea id="brief_intro" class="form-control" name="brief_intro"><?php echo $row['brief_intro']?></textarea>

                    <label for="rec_title" class="form-label normal-text">*Title of Recommendation (255 characters MAX)</label>
                    <input type="text" class="form-control" id="rec_title" name="rec_title" value="<?php echo $row['rec_title']?>">

                    <label for="content" class="form-label normal-text">*Recommendation Content</label>
                    <textarea id="content" class="form-control" name="content"><?php echo $row['content']?></textarea>

                    <input type="hidden" name="post_date" value="<?php echo date('Y-m-d');?>">
                </div>

                <div class="col-12 col-lg-8 mb-5 mt-3">
                    <p class="normal-text">* Required</p>
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- footer -->
        <div class="row">
            <div class="footer normal-text col-12 py-2">
                Copyright &copy; 2021 ANiREC
            </div>
        </div>
    </div>

    <!-- input validation -->
    <script>
        document.querySelector("#update-form").onsubmit = function(event){
            let anime_title = document.querySelector("#anime_title").value;
            let rec_title = document.querySelector("#rec_title").value;
            let rec_content = document.querySelector("#content").value;

            if(anime_title == "" || rec_title == "" || rec_content == "")
            {
                event.preventDefault();
                alert("Please fill out all required fields");
            }
            else if(anime_title.length > 255 || rec_title.length > 255)
            {
                event.preventDefault();
                alert("Woops, watch out for the character limit");
            }
        }
    </script>
    
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>