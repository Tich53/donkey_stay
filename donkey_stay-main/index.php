<?php
session_start();
require_once('../../identifiants/connect.php');
$pdo = new \PDO(DSN, USER, PASS);

//PAGINATION => 2 étapes
// Etape 1: Faire la requête de sélection et définir le nombre de page
// Etape 2: Faire une boucle "FOR" sous la boucle "FOREACH" afin d'afficher le nombre de page dans des liens
$nbCottageQuery = "SELECT COUNT(idcottage) as nbCottage  FROM cottage";
$statement = $pdo->query($nbCottageQuery);
$nbCottageArray = $statement->fetchAll();
$nbCottage = $nbCottageArray[0]['nbCottage'];

$size = 6;
$nbPage = ceil($nbCottage / $size);

if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$offset = ($page - 1) * $size;

if (isset($_POST['search'])) {
	// récupération du mot clef pour trier la destination
	$keyword = trim($_POST['keyword']);



	//Requête de sélection des gîtes via keyword
	$cottageQuery = "SELECT * FROM cottage
	WHERE (cottage_city LIKE '%$keyword%' OR cottage_region LIKE '%$keyword%' OR cottage_country LIKE '%$keyword%') ";
	$statement = $pdo->query($cottageQuery);
	$cottages = $statement->fetchAll();
} else {
	//Requête de sélection des gîtes
	$cottageQuery = "SELECT * FROM cottage LIMIT $size OFFSET $offset";
	$statement = $pdo->query($cottageQuery);
	$cottages = $statement->fetchAll();
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

	<link rel="stylesheet" href="index.css">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.php">Donkey Stay<span>Location de Gîtes d'exception</span></a>
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

	<div class="hero-wrap js-fullheight" style="background-image: url('images/bg_6.webp');">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
				<div class="col-md-7 ftco-animate">
					<span class="subheading">Bienvenue chez Donkey Stay</span>
					<h1 class="mb-4">Découvrez notre sélection des plus beaux gîtes</h1>
					<p class="caps"></p>
				</div>
			</div>
		</div>
	</div>

	<section class="ftco-section ftco-no-pb ftco-no-pt">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ftco-search d-flex justify-content-center">
						<div class="row">
							<div class="col-md-12 nav-link-wrap">
								<div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link active mr-md-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Gîtes</a>
								</div>
							</div>
							<div class="col-md-12 tab-wrap">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
										<form action="#" method="POST" class="search-property-1">
											<div class="row no-gutters">
												<div class="col-md d-flex">
													<div class="form-group p-4 border-0">
														<label for="#">Destination</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-search"></span></div>
															<input type="text" class="form-control" placeholder="Lieu" name="keyword">
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="#">Arrivée</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-calendar"></span></div>
															<input type="text" class="form-control checkin_date" name="start_date" placeholder="Date d'arrivée">
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="#">Départ</label>
														<div class="form-field">
															<div class="icon"><span class="fa fa-calendar"></span></div>
															<input type="text" class="form-control checkout_date" name="end_date" placeholder="Date de départ">
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group d-flex w-100 border-0">
														<div class="form-field w-100 align-items-center d-flex">
															<input type="submit" value="Search" name="search" class="align-self-stretch form-control btn btn-primary">
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>

	<!-- 	<section class="ftco-section services-section">
		<div class="container">
			<div class="row d-flex">
				<di$pagev class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
					<div class="w-100">
						<span class="subheading">Welcome to Pacific</span>
						<h2 class="mb-4">It's time to start your adventure</h2>
						<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
							A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
						<p><a href="#" class="btn btn-primary py-3 px-4">Search Destination</a></p>
					</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
						<div class="services services-1 color-4 d-block img" style="background-image: url(images/parcours1.jpg);">
							<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-map"></span></div>
							<div class="media-body">
								<h3 class="heading mb-3">Location Manager</h3>
								<p>A small river named Duden flows by their place and supplies it with the necessary</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section> -->
	<section class="ftco-section container">
		<div class="container">
			<div class="row justify-content-center pb-4">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<span class="subheading">Destination</span>
					<h2 class="mb-4">Nos Gîtes</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<?php

			if (isset($_POST['search'])) {
				// récupération des champs dates sélectionnées dans le formulaire et transformation de ces dates dans le bon format
				$start_date = date_create(($_POST['start_date']));
				$start_date = date_format($start_date, "Y/m/d");

				$end_date = date_create(($_POST['end_date']));
				$end_date = date_format($end_date, "Y/m/d");

				if ($start_date !== $end_date) {

					// Pour chaque cottage, vérifier si il y a une location dans les dates sélectionnées
					// Si oui, cette location ne s'affiche pas
					foreach ($cottages as $cottage) {
						$idCottage = $cottage['idcottage'];

						$booked_dateQuery = "SELECT * FROM booking 
						WHERE (cottage_idcottage = '$idCottage')
						AND (`start_date` BETWEEN '$start_date' AND '$end_date'
						OR end_date BETWEEN '$start_date' AND '$end_date')";
						$statement = $pdo->query($booked_dateQuery);
						$booked_dateArray = $statement->fetchAll();

						if (empty($booked_dateArray)) {
			?>
							<div class="col-md-4 ftco-animate">
								<div class="project-wrap">
									<h3><a href="gite_1.php?id=<?= $cottage['idcottage'] ?>"><?= $cottage['cottage_city'] ?></a></h3>
									<div class="text p-4">
										<span class="days"><?= $cottage['cottage_name'] ?></span>
										<h3><a href="gite_1.php?id=<?= $cottage['idcottage'] ?>"><?= $cottage['cottage_city'] ?></a></h3>
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
					}
				} else {
					foreach ($cottages as $cottage) {
						?>
						<div class="col-md-4 ftco-animate">
							<div class="project-wrap">
								<a href="gite_1.php?id=<?= $cottage['idcottage'] ?>" class="img" style="background-image: url(<?= $cottage['cottage_photo1'] ?>);">
									<span class="price"><?= $cottage['cottage_price_per_night'] . "€ / nuit" ?></span>
								</a>
								<div class="text p-4">
									<span class="days"><?= $cottage['cottage_name'] ?></span>
									<h3><a href="gite_1.php?id=<?= $cottage['idcottage'] ?>"><?= $cottage['cottage_city'] ?></a></h3>
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
				}
				// Si pas d'utilisation du formulaire search, alors tous les gîtes apparaissent avec la pagination
			} else {
				foreach ($cottages as $cottage) {
					?>
					<div class="col-md-4 ftco-animate">
						<div class="project-wrap">
							<a href="gite_1.php?id=<?= $cottage['idcottage'] ?>" class="img" style="background-image: url(<?= $cottage['cottage_photo1'] ?>);">
								<span class="price"><?= $cottage['cottage_price_per_night'] . "€ / nuit" ?></span>
							</a>
							<div class="text p-4">
								<span class="days"><?= $cottage['cottage_name'] ?></span>
								<h3><a href="gite_1.php?id=<?= $cottage['idcottage'] ?>"><?= $cottage['cottage_city'] ?></a></h3>
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
			}
			if (!isset($_POST['search'])) {
				?><div class="pagination">
					<?php
					for ($i = 1; $i <= $nbPage; $i++) {
						if ($i == $page) {
					?>
							<?= "$i/"; ?>
						<?php
						} else {
						?>
							<?= "<a href = \"index.php?page=$i\">$i/</a>"; ?>
					<?php
						}
					}
					?>
				</div>
			<?php
			}
			?>
		</div>

	</section>
	<!-- 	<section class="ftco-section ftco-about img" style="background-image: url(images/parcours2.jpg);">
		<div class="overlay"></div>
		<div class="container py-md-5">
			<div class="row py-md-5">
				<div class="col-md d-flex align-items-center justify-content-center">
					<a href="https://vimeo.com/214535951" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
						<span class="fa fa-play"></span>
					</a>
				</div>
			</div>
		</div>
	</section> -->

	<!-- 	<section class="ftco-section ftco-about ftco-no-pt img">
		<div class="container">
			<div class="row d-flex">
				<div class="col-md-12 about-intro">
					<div class="row">
						<div class="col-md-6 d-flex align-items-stretch">
							<div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url(images/about-1.jpg);">
							</div>
						</div>
						<div class="col-md-6 pl-md-5 py-5">
							<div class="row justify-content-start pb-3">
								<div class="col-md-12 heading-section ftco-animate">
									<span class="subheading">About Us</span>
									<h2 class="mb-4">Make Your Tour Memorable and Safe With Us</h2>
									<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
									<p><a href="#" class="btn btn-primary">Book Your Destination</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->

	<section class="ftco-section testimony-section bg-bottom" style="background-image: url(images/gite1_2.webp);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center pb-4">
				<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
					<span class="subheading"></span>
					<h2 class="mb-4">Avis Clients</h2>
				</div>
			</div>
			<div class="row ftco-animate">
				<div class="col-md-12">
					<div class="carousel-testimony owl-carousel">
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="text">
									<p class="star">
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
									<p class="mb-4">Le top du top en terme de location saisonnière, en particulier la possibilité de faire une petite balade à dos d'âne.</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/CédricL.png)"></div>
										<div class="pl-3">
											<p class="name">CédricL</p>
											<span class="position"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="text">
									<p class="star">
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
									<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/SamiaB.jfif)"></div>
										<div class="pl-3">
											<p class="name">SamiaB</p>
											<span class="position"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="text">
									<p class="star">
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
									<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
										<div class="pl-3">
											<p class="name">Roger Scott3</p>
											<span class="position">Marketing Manager</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="text">
									<p class="star">
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										var_dump($cottages); <span class="fa fa-star"></span>
									</p>
									<p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
										<div class="pl-3">
											<p class="name">Roger Scott4</p>
											<span class="position">Marketing Manager</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="testimony-wrap py-4">
								<div class="text">
									<p class="star">
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</p>
									<p class="mb-4">Sans équivalent dans le domaine, un site esthétique et merveilleusement intuitif ainsi qu'une équipe remarquable.</p>
									<div class="d-flex align-items-center">
										<div class="user-img" style="background-image: url(images/AntoineD.jfif)"></div>
										<div class="pl-3">
											<p class="name">AntoineD</p>
											<span class="position"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url(images/bg_3.jpg);">
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
			<!-- 				<div class="row">
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