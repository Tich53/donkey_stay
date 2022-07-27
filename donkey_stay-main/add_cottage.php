<?php
session_start();
require_once('../../identifiants/connect.php');
$pdo = new \PDO(DSN, USER, PASS);

$idUser = $_SESSION['id'];



//Requête d'ajout de gîte
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cottage_name = trim($_POST['cottage_name']);
    $cottage_region = trim($_POST['cottage_region']);
    $cottage_city= trim($_POST['cottage_city']);
    $cottage_country = trim($_POST['cottage_country']);
    $cottage_nb_bed = trim($_POST['cottage_nb_bed']);
    $cottage_nb_bathroom = trim($_POST['cottage_nb_bathroom']);
    $cottage_price_per_night = trim($_POST['cottage_price_per_night']);
    $cottage_description = trim($_POST['cottage_description']);
    $cottage_photo1 = trim($_POST['cottage_photo1']);
    $cottage_photo2 = trim($_POST['cottage_photo2']);
    $cottage_photo3 = trim($_POST['cottage_photo3']);
    $cottage_photo4 = trim($_POST['cottage_photo4']);
    $cottage_photo5 = trim($_POST['cottage_photo5']);
    $cottage_photo6 = trim($_POST['cottage_photo6']);


    $createCottage = "INSERT INTO cottage (cottage_name, cottage_region, cottage_city, cottage_country, cottage_nb_bed, cottage_nb_bathroom, cottage_price_per_night, cottage_description, cottage_photo1, cottage_photo2, cottage_photo3, cottage_photo4, cottage_photo5, cottage_photo6, cottage_user_iduser) VALUES (:cottage_name, :cottage_region, :cottage_city, :cottage_country, :cottage_nb_bed, :cottage_nb_bathroom, :cottage_price_per_night, :cottage_description, :cottage_photo1, :cottage_photo2, :cottage_photo3, :cottage_photo4, :cottage_photo5, :cottage_photo6, :idUser)"; 

    $statement = $pdo->prepare($createCottage);
    $statement->bindValue(':cottage_name', $cottage_name, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_region', $cottage_region, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_city', $cottage_city, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_country', $cottage_country, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_nb_bed', $cottage_nb_bed, \PDO::PARAM_INT);
    $statement->bindValue(':cottage_nb_bathroom', $cottage_nb_bathroom, \PDO::PARAM_INT);
    $statement->bindValue(':cottage_price_per_night', $cottage_price_per_night, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_description', $cottage_description, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo1', $cottage_photo1, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo2', $cottage_photo2, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo3', $cottage_photo3, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo4', $cottage_photo4, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo5', $cottage_photo5, \PDO::PARAM_STR);
    $statement->bindValue(':cottage_photo6', $cottage_photo6, \PDO::PARAM_STR);
    $statement->bindValue(':idUser', $idUser, \PDO::PARAM_INT);
    $statement->execute();

    header("Location: add_edit_cottage.php");

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

    <link rel="stylesheet" href="add_cottage.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light_profil" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.php">Donkey Stay<span>Location de Gîtes d'exception</span></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> 
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
					<li class="nav-item active"><a href="index.php" class="nav-link">Accueil</a></li>
					<!-- <li class="nav-item"><a href="contact.html" class="nav-link">Contactez-nous</a></li> -->
					<!-- Ajout de la ligne "Bonjour" si $_SESSION non vide sinon "login" -->
					<?php
					if (!empty($_SESSION['login'])) {
					?>
                        <li class="nav-item nav-link"><a href="add_edit_cottage.php" class="nav-link">Gérer mes gîtes</a></li>
						<li class="nav-item nav-link">
                            <a href="profile.php" class="nav-link">
							    <?= $_SESSION['login']; ?>
							</a>
                        </li>
					<?php
					} else {
					?>
						<li class="nav-item nav-link"><a href="login.php" class="nav-link">login</a></li>
					<?php
					}
					?>
					
				</ul>
			</div>
		</div>
	</nav>
	<!-- END nav -->
	

		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
				<div class="col-md-7 ftco-animate">
					<h1 class="mb-4" id="title">Ajouter un gîte</h1>
                    <form class=".cottage_form" action="" method="POST">

                        <div class="label_input">
                            <label class="label" for="cottage_name">Nom du gîte*</label>
                            <input type="text" id="cottage_name" name = "cottage_name" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_region">Région*</label>
                            <input type="text" id="cottage_region" name="cottage_region" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_city">Ville*</label>
                            <input type="text" id="cottage_city" name="cottage_city" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_country">Pays*</label>
                            <input type="text" id="cottage_country" name="cottage_country" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_nb_bed">Nombre de chambre(s)*</label>
                            <input type="text" id="cottage_nb_bed" name="cottage_nb_bed" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_nb_bathroom">Nombre de salle de bain(s)*</label>
                            <input type="text" id="cottage_nb_bathroom" name="cottage_nb_bathroom" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_price_per_night">Prix/nuit*</label>
                            <input type="text" id="cottage_price_per_night" name="cottage_price_per_night" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_description">Description*</label>
                            <textarea class ="textarea" type="text" id="cottage_description" name="cottage_description" rows="5" required></textarea>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo1">Photo principale*</label>
                            <input type="text" id="cottage_photo1" name="cottage_photo1" required>
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo2">Photo</label>
                            <input type="text" id="cottage_photo2" name="cottage_photo2">
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo3">Photo</label>
                            <input type="text" id="cottage_photo3" name="cottage_photo3">
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo4">Photo</label>
                            <input type="text" id="cottage_photo4" name="cottage_photo4">
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo5">Photo</label>
                            <input type="text" id="cottage_photo5" name="cottage_photo5">
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_photo6">Photo</label>
                            <input type="text" id="cottage_photo6" name="cottage_photo6">
                        </div>
                        <div class="label_input">
                            <label class="label" for="cottage_user_iduser"></label>
                            <input type="hidden" id="cottage_user_iduser" name="cottage_user_iduser" value="<?=$idUser?>">
                        </div>
                        <button>Valider</button>
                    </form>
                
				</div>
			</div>
		</div>
	</div>



<!-- 		<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url(images/bg_3.jpg);">
			<div class="container">
				<div class="row mb-5">
					<div class="col-md pt-5">
						<div class="ftco-footer-widget pt-md-5 mb-4">
							<h2 class="ftco-heading-2">About</h2>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							<ul class="ftco-footer-social list-unstyled float-md-left float-lft">
								<li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
								<li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
								<li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
							</ul>
						</div>
					</div>
					<div class="col-md pt-5 border-left">
						<div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
							<h2 class="ftco-heading-2">Information</h2>
							<ul class="list-unstyled">
								<li><a href="#" class="py-2 d-block">Online Enquiry</a></li>
								<li><a href="#" class="py-2 d-block">General Enquiries</a></li>
								<li><a href="#" class="py-2 d-block">Booking Conditions</a></li>
								<li><a href="#" class="py-2 d-block">Privacy and Policy</a></li>
								<li><a href="#" class="py-2 d-block">Refund Policy</a></li>
								<li><a href="#" class="py-2 d-block">Call Us</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md pt-5 border-left">
						<div class="ftco-footer-widget pt-md-5 mb-4">
							<h2 class="ftco-heading-2">Have a Questions?</h2>
							<div class="block-23 mb-3">
								<ul>
									<li><span class="icon fa fa-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
									<li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+2 392 3929 210</span></a></li>
									<li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">info@yourdomain.com</span></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

			</footer> --> 
			

			<!-- loader -->
			<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


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