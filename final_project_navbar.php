<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid">
        <!-- brand -->
        <a class="navbar-brand fs-1" href="final_project_home.php">
            <img src="media/images/flower.png" alt="icon">
            ANiREC
        </a>

        <!-- toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <!-- navbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div id="all-navs" class="navbar-nav fs-4">
                <a class="nav-link" aria-current="page" href="final_project_home.php">Home</a>
                <a class="nav-link" href="final_project_anime_search.php">Anime Search</a>
                <a class="nav-link" href="final_project_recommendations.php">View Recommendations</a>

                <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) : ?>
                    <a class="nav-link" href="final_project_login.php">Login</a>
                    <a class="nav-link" href="final_project_sign_up.php">Sign Up</a>
                <?php else : ?>
                    <a class="nav-link" href="final_project_home.php">Hello, <?php echo $_SESSION["username"]?></a>
                    <a class="nav-link" href="final_project_logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>