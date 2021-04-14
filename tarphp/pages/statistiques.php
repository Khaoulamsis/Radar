<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user'])) {
    ?>

    <div class="container-fluid" style="margin-top: 5%;">
        <div class="">
            <p class="h2 text-center text-dark text-uppercase font-weight-bold">Statistiques</p>
            <hr class="line-seprate">
            <section class="statistic statistic2">
                <div class="container">
                    <div class="row">
                        <a href="./index.php?p=filiere" class="col-lg-6">
                            <div class="statistic__item statistic__item--green">
                                <h2 class="number">...</h2>
                                <span class="desc">Filières</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-accounts"></i>
                                </div>
                            </div>
                        </a>
                        <a href="./index.php?p=classe" class="col-lg-6">
                            <div class="statistic__item statistic__item--orange">
                                <h2 class="number">...</h2>
                                <span class="desc">Classes</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-group-work"></i>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </section>
        </div>
        <canvas id="myChart" width="1100" height="400"></canvas>
    </div>
    <script src="script/statistique.js" type="text/javascript"></script>
<?php
} else {
    header("Location: ../index.php");
}
?>
