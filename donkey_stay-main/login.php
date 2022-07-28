<?php
session_start();
require_once('../../identifiants/connect.php');
$pdo = new \PDO(DSN, USER, PASS);

// Requête d'authentification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $user_password = trim($_POST['user_password']);

    $passwordQuery = "SELECT * FROM user WHERE username = :username AND user_password = :user_password";
    $statement = $pdo->prepare($passwordQuery);
    $statement->bindValue(':username', $username, \PDO::PARAM_STR);
    $statement->bindValue(':user_password', $user_password, \PDO::PARAM_STR);
    $statement->execute();
    $authentication = $statement->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Donkey Gîtes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="login.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light_profil" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Donkey Stay<span>Location de Gîtes d'exception</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Accueil</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->

    <div class="hero-wrap_profil js-fullheight">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h1 class="mb-4">Connexion</h1>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // SI TABLEAU $AUTHENTHATION VIDE, ALORS USERNAME OU PASSWORD INCORRECT SINON CONNEXION RÉUSSIE
                        if ($authentication === []) {
                    ?><div class="incorrect">
                                <?= "Identifiant ou mot de passe incorrect"; ?></div>
                    <?php
                        } else {
                            echo "connexion réussie";
                            $_SESSION['id'] = $authentication[0][0];
                            $_SESSION['login'] = trim($_POST['username']);
                            $_SESSION['password'] = trim($_POST['user_password']);
                            if (!empty($_GET)) {
                                header('location: gite_1.php?id=' . $_GET['id'] . '');
                            } else {
                                header('location: index.php');
                            }
                        }
                    }
                    ?>
                    <!-- Formulaire de connection -->
                    <form action="" method="POST">
                        <div class=connection_form>
                            <div class="label_input">
                                <label for="username" class="label">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required autofocus>
                            </div>
                            <div class="label_input">
                                <label for="user_password" class="label">Mot de passe</label>
                                <input type="password" id="user_password" name="user_password" placeholder="Mot de passe" required>
                            </div>
                            <div>
                                <button>Se connecter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url(images/bg_3.jpg);">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">À propos</h2>
                        <p>Loin de tous les tracas du quotidien, se trouve, sur les collines, les plaines, et les montagnes, un âne intrépide et plein de fougue, impatient de vous rencontrer pour partager un bout de route avec vous. Qu'allez-vous décider ?</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md pt-5 border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Informations</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Demandes en ligne</a></li>
                            <li><a href="#" class="py-2 d-block">Demandes générales</a></li>
                            <li><a href="#" class="py-2 d-block">Conditions de réservation</a></li>
                            <li><a href="#" class="py-2 d-block">Confidentialité et politique</a></li>
                            <li><a href="#" class="py-2 d-block">Politique de remboursement</a></li>
                            <li><a href="#" class="py-2 d-block">Appelez-nous</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md pt-5 border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Nous contacter?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon fa fa-map-marker"></span><span class="text">7 Rue Castéja, 92100 Boulogne-Billancourt</span></li>
                                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+1 234 567 890</span></a></li>
                                <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">info@yourdonkey.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--                <div class="row">
                    <div class="col-md-12 text-center">
                        <p> Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.</p>
                        </div>
                    </div>
                </div> -->
    </footer>


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

</body>

</html>