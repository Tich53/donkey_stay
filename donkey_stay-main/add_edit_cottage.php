<?php
session_start();
require_once('../../identifiants/connect.php');
$pdo = new \PDO(DSN, USER, PASS);


$userId = $_SESSION['id'];

$cottageQuery = "SELECT * FROM cottage WHERE cottage_user_iduser = '$userId'";
$statement = $pdo -> query($cottageQuery);
$cottages = $statement->fetchAll();

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

</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.html">Donkey Stay<span>Location de Gîtes d'exception</span></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
					<li class="nav-item active"><a href="index.php" class="nav-link">Accueil</a></li>
					<!-- <li class="nav-item"><a href="contact.html" class="nav-link">Contactez-nous</a></li> -->
					<!-- Ajout de la ligne "Bonjour" si $_SESSION non vide sinon "login" -->
					<li class="nav-item nav-link"><a href="add_edit_cottage.php" class="nav-link">Créer / consulter ses gîtes</a></li>
					<?php
					if (!empty($_SESSION['login'])) {
					?>
						<li class="nav-item nav-link"><a href="profile.php" class="nav-link">
								<?= "Bonjour " . $_SESSION['login']; ?>
							</a></li>
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

		
	<section class="ftco-section container">
		<div class="container">
			<div class="row justify-content-center pb-4">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<h2 class="mb-4">Mes Gîtes</h2>
				</div>
			</div>
		</div>
		<h1>Mes gîtes</h1>
		<div class="row">
			<?php
			foreach ($cottages as $cottage) {
			?>
				<div class="col-md-4 ftco-animate">
					<div class="project-wrap">
						<a href="edit_cottage.php?id=<?= $cottage['idcottage'] ?>" class="img" style="background-image: url(<?= $cottage['cottage_photo1'] ?>);">
							<span class="price"><?= $cottage['cottage_price_per_night'] . "€ / nuit" ?></span>
						</a>
						<div class="text p-4">
							<span class="days"><?= $cottage['cottage_name'] ?></span>
							<h3><a href="edit_cottage.php?id=<?= $cottage['idcottage'] ?>"><?= $cottage['cottage_city'] ?></a></h3>
							<p class="location"><span class="fa fa-map-marker"></span> <?= $cottage['cottage_region'] . " " . $cottage['cottage_country'] ?></p>
							<ul>
								<li><span class="flaticon-shower"></span><?= $cottage['cottage_nb_bathroom'] ?></li>
								<li><span class="flaticon-king-size"></span><?= $cottage['cottage_nb_bed'] ?></li>
								<!-- <li><span class="flaticon-route"></span>Near Mountain</li> -->
							</ul>
						</div>
					</div>
				</div>

			<?php
			}
			?>
		</div>


	</section>





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