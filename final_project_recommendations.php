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

    $view_rec_stmt = $mysqli->prepare("SELECT users.username, recommendations.post_date, recommendations.id AS rec_id, animes.anime_title
    FROM users JOIN recommendations ON users.id=recommendations.users_id JOIN animes ON recommendations.animes_id=animes.id ORDER BY recommendations.post_date DESC");

    $can_view = $view_rec_stmt->execute();
    if(!$can_view)
    {
        echo $view_rec_stmt->error;
        exit();
    }

    $results = $view_rec_stmt->get_result();

    $view_rec_stmt->close();
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
    <title>ANiREC Recommendations</title>
    <link rel="stylesheet" href="plugin/splide/splide.min.css">
    <link rel="stylesheet" href="plugin/pagination/paginate.css">
    <link rel="stylesheet" href="main.css">

    <style>
        #posters img{
            width: 100%;
        }

        #rec-list h1{
            color: white;
        }

        .white-br{
            background-color: white;
        }

        #entry-table, #entry-table a{
            font-size: 0.5em;
        }

        @media(min-width: 991px)
        {
            #entry-table, #entry-table a{
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <?php include "final_project_navbar.php"; ?>

    <div id="rec-main" class="container-fluid">
        <div class="row justify-content-center">
            <div id="posters" class="col-12 col-lg-5 py-3 mt-5">
                <div class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide"><img src="media/images/86_poster.jpg" alt="86 Poster"></li>
                            <li class="splide__slide"><img src="media/images/fate_poster.jpg" alt="Fate Poster"></li>
                            <li class="splide__slide"><img src="media/images/psycho_pass_poster.jpg" alt="Psycho Pass Poster"></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- table of content -->
            <div id="rec-list" class="col-12 col-lg-7 py-3">
                <h1 class="p-3 text-center">Recommendation Entries</h1>

                <input type="search" id="entry-search" class="form-control mb-3" placeholder="Filter by poster/date/anime title...">

                <table id="entry-table" class="table table-dark table-striped">
                    <tbody>
                        <tr class="header">
                            <th scope="col">Poster</th>
                            <th scope="col">Date</th>
                            <th scope="col">Anime</th>
                            <th scope="col">Operations</th>
                        </tr>

                        <!-- print results -->
                        <?php while($row = $results->fetch_assoc()) :?>
                            <tr>
                                <td><?php echo $row["username"]?></td>
                                <td><?php echo $row["post_date"]?></td>
                                <td><?php echo $row["anime_title"]?></td>
                                <td>
                                    <!-- everyone can view -->
                                    <div class="mb-2">
                                        <a class="btn btn-primary" href="final_project_view_rec.php?rec_id=<?php echo $row["rec_id"]; ?>" role="button">View Entry</a>
                                    </div>

                                    <!-- only logged in users can edit their own records-->
                                    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && ($_SESSION["username"] == $row["username"])) :?>
                                        <a class="btn btn-warning" href="final_project_update_rec.php?rec_id=<?php echo $row["rec_id"]; ?>" role="button">Update Entry</a>
                                    <?php endif;?>

                                    <!-- only admin can delete -->
                                    <?php if(isset($_SESSION["user_type"]) && !empty($_SESSION["user_type"]) && ($_SESSION["user_type"] == 1)): ?>
                                        <div class="mt-2">
                                            <a class="btn btn-danger" href="delete_confirmation.php?rec_id=<?php echo $row["rec_id"]; ?>" role="button" onclick="return confirm('You are about to delete a recommendation');">Delete Entry</a>
                                        </div>
                                    <?php endif;?>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    </tbody>
                </table>

                <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) :?>
                    <div class="d-grid gap-2 mt-3">
                        <a class="btn btn-primary btn-block" href="final_project_add_rec.php" role="button">Add My Recommendation</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- footer -->
        <div class="row">
            <div class="footer normal-text col-12 py-2">
                Copyright &copy; 2021 ANiREC
            </div>
        </div>
    </div>

    
    <script src="plugin/splide/splide.min.js"></script>
    <script src="plugin/pagination/paginate.min.js"></script>

    <script>
        // splide
        document.addEventListener( 'DOMContentLoaded', function () {
		    new Splide( '.splide' ).mount();
	    } );

        // highlight in navbar
        let children = document.querySelector("#all-navs").children;
        for(let i = 0; i < children.length; i++)
        {
            if(children[i].innerHTML == "View Recommendations")
            {
                children[i].classList.add("active");
            }
            else
            {
                children[i].classList.remove("active");
            }
        }

        // pagination
        let options = {
            numberPerPage:10,
            constNumberPerPage:10,
            numberOfPages:0,
            goBar:false,
            pageCounter:true,
            hasPagination:true,
        };

        let filterOptions = {
            el:'#entry-search'
        };

        paginate.init('#entry-table',options,filterOptions);
    </script>

    
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>