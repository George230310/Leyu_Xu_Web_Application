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
    <title>ANiREC Discover</title>
    <link rel="stylesheet" href="main.css">

    <style>
        #header-img{
            background-image: url("media/images/angel_beats_bk.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 60vh;
        }

        #header-img h1{
            text-shadow: 0px 0px 3px black;
            padding-top: 10%;
        }
    </style>
</head>

<body>
    <?php include "final_project_navbar.php"; ?>

    <div class="container-fluid" id="search-container">
        <div class="row">
            <div id="header-img" class="col-12">
                <h1 class="white-font text-center mx-0 px-0">Discover Animes</h1>
            </div>
        </div>

        <div class="row my-5 mx-0">
            <form id="search-form" action="#">
                 <!-- keyword -->
                 <div class="mb-3 white-font">
                    <label for="keyword" class="form-label fs-2">Keywords</label>
                    <input type="text" class="form-control px-0" id="keyword" name="keyword">
                    <div class="mt-1">Input at least 3 characters</div>
                </div>


                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-primary" type="reset">Clear</button>

                <div class="mt-4 white-font">Displaying <span id="num"></span> result(s)</div>
            </form>
        </div>

        <div id="results-display" class="row">

        </div>

        <!-- footer -->
        <div class="row px-0 mx-0">
            <div class="footer normal-text col-12 py-2">
                Copyright &copy; 2021 ANiREC
            </div>
        </div>
    </div>

    <!-- navbar highlight -->
    <script>
        // highlight in navbar
        let children = document.querySelector("#all-navs").children;
        for(let i = 0; i < children.length; i++)
        {
            if(children[i].innerHTML == "Anime Search")
            {
                children[i].classList.add("active");
            }
            else
            {
                children[i].classList.remove("active");
            }
        }
    </script>

    <!-- ajax -->
    <script src="scripts/ajax.js"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>