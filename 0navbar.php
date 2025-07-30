<nav class="navbar navbar-expand-lg fixed-top bg-secondary text-uppercase navbar-light" id="mainNav">
    <div class="container-fluid"><a class="navbar-brand" href="#page-top">Appointment</a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler text-white bg-primary navbar-toggler-right text-uppercase rounded" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1" <?php if ($_SESSION['Page_Active'] == 'index.php') {
                                                        echo 'style="background: #4e5b69;border-radius: 100px;"';
                                                    } ?>>
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="removecoki.php">Home</a>
                </li>
                <li hidden class="nav-item mx-0 mx-lg-1" <?php if ($_SESSION['Page_Active'] == 'SEARCH.php') {
                                                        echo 'style="background: #4e5b69;border-radius: 100px;"';
                                                    } ?>>
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="SEARCH.php">SEARCH</a>
                </li>
                <li hidden class="nav-item mx-0 mx-lg-1" <?php if ($_SESSION['Page_Active'] == 'EXPORT.php') {
                                                        echo 'style="background: #4e5b69;border-radius: 100px;"';
                                                    } ?>>
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="EXPORT.php">EXPORT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>