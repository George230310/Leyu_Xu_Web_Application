<?php
    require "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>ANiREC</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #main-container h1{
            color: white;
        }

        #video{
            position: relative;
        }

        #video-overlay{
            position: absolute;
            top: 0px;
            right: 0px;
            text-align: right;
            color: white;
            text-shadow: 0px 0px 3px black;
            padding-right: 3%;
            padding-top: 3%;
            font-size: 1em;
        }

        #clip{
            width: 100%;
        }

        .site-purpose{
            background-color: #1a1a2e;
            border-radius: 3%;
            text-align: center;
        }

        .function-buttons{
            border-radius: 3%;
            background-color: #16213e;
        }

        .site-purpose h2, .function-buttons h2{
            text-align: center;
            color: white;
        }

        /* responsive caption */
        @media(min-width: 768px)
        {
            #video-overlay{
                font-size: 1.2em;
            }
        }

        @media(min-width: 992px)
        {
            #video-overlay{
                font-size: 1.5em;
            }
        }
        
    </style>
</head>

<body>
    <?php include "final_project_navbar.php"; ?>
    <div class="container-fluid" id="main-container">

        <!-- clip section -->
        <div class="row">
            <div id="video" class="col-12 px-0">
                <video id="clip" autoplay controls loop><source id="clip-source" src="media/clips/86_clip.mp4"></video>

                <div id="video-overlay">
                    <div>
                        Trending Anime Trailer
                    </div>
                    
                    <div>
                        Now Playing: <span id="now-playing">86 Eighty-Six</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- switch video -->
        <div class="row">
            <div class="col-4 py-3 px-3 text-start">
                <button id="prev-clip" type="button" class="btn btn-secondary">Prev Clip</button>
            </div>

            <div class="col-4 py-3 px-3 text-center normal-text">
                Select a trending trailer!
            </div>

            <div class="col-4 py-3 px-3 text-end">
                <button id="next-clip" type="button" class="btn btn-secondary">Next Clip</button>
            </div>
        </div>

        <!-- site purpose and link to sign-up/search/view rec -->
        <div class="row">
            <div class="site-purpose col-12 col-md-7 py-3 px-3 my-3">
                <h1 class="fs-2">About ANiREC</h1>
                <p class="normal-text">
                    The purpose of ANiREC is to provide all anime enthusiasts a platform to recommend their favorite anime works to their comrades, as well as all newcommers of the anime world. While only registered members of ANiREC may post anime recommendations, all visitors of ANiREC may search for trending animes using our search tool and view all anime recommendations posted by ANiREC community members.
                </p>
            </div>

            <div class="function-buttons col-12 col-md-5 py-3 px-3 my-3">
                <h2>Get Started</h2>

                <div class="d-grid gap-2">
                    <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) : ?>
                        <a class="btn btn-primary" href="final_project_login.php" role="button">Login as ANiREC Member</a>
                    <?php else :?>
                        <a class="btn btn-primary" href="final_project_logout.php" role="button">Logout</a>
                        <a class="btn btn-primary" href="final_project_add_rec.php" role="button">Add a Recommendation</a>
                    <?php endif;?>
                    <a class="btn btn-primary" href="final_project_anime_search.php" role="button">Search for Animes</a>
                    <a class="btn btn-primary" href="final_project_recommendations.php" role="button">View Recommendations</a>
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

    <!-- video switcher -->
    <script>
        // fill the list of trailers
        let prefix = "media/clips/";
        let filenames = ["86_clip.mp4", "to_your_eternity_clip.mp4"];
        let titles = ["86 Eighty-Six", "To Your Eternity"];
        let idx = 0;

        // next clip
        document.querySelector("#next-clip").onclick = function(){
            // switch clip
            idx++;
            idx = idx % filenames.length;

            let fullFileName = prefix + filenames[idx];
            let clip = document.querySelector("#clip");
            let source = document.querySelector("#clip-source");

            clip.muted = true;
            clip.pause();
            source.src = fullFileName;
            clip.load();
            clip.muted = false;
            clip.play();

            // switch title
            document.querySelector("#now-playing").innerHTML = titles[idx];
        }

        // prev clip
        document.querySelector("#prev-clip").onclick = function(){
            // wrap
            if(idx > 0)
            {
                idx--;
            }
            else
            {
                idx = filenames.length - 1;
            }

            let fullFileName = prefix + filenames[idx];
            let clip = document.querySelector("#clip");
            let source = document.querySelector("#clip-source");

            clip.muted = true;
            clip.pause();
            source.src = fullFileName;
            clip.load();
            clip.muted = false;
            clip.play();

            // switch title
            document.querySelector("#now-playing").innerHTML = titles[idx];
        }


        // highlight in navbar
        let children = document.querySelector("#all-navs").children;
        for(let i = 0; i < children.length; i++)
        {
            if(children[i].innerHTML == "Home")
            {
                children[i].classList.add("active");
            }
            else
            {
                children[i].classList.remove("active");
            }
        }
    </script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>