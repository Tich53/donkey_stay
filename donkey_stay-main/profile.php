<?php
// Démarrage ou restauration de la session
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

//Requête de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$iduser = trim($_POST['iduser']);
	$modifyUsername = trim($_POST['username']);
	$modifyUser_password = trim($_POST['user_password']);
	$modifyUser_firstname = trim($_POST['user_firstname']);
	$modifyUser_lastname = trim($_POST['user_lastname']);
	$modifyUser_phone = trim($_POST['user_phone']);
	$modifyUser_email = trim($_POST['user_email']);

	$updateUser = "UPDATE user 
	SET 
	username = :modifyUsername, 
	user_password = :modifyUser_password,
	user_firstname = :modifyUser_firstname,
	user_lastname = :modifyUser_lastname,
	user_phone = :modifyUser_phone,
	user_email = :modifyUser_email
	WHERE iduser = :iduser";

	$statement = $pdo->prepare($updateUser);
	$statement->bindValue(':modifyUsername', $modifyUsername, \PDO::PARAM_STR);
	$statement->bindValue(':modifyUser_password', $modifyUser_password, \PDO::PARAM_STR);
	$statement->bindValue(':modifyUser_firstname', $modifyUser_firstname, \PDO::PARAM_STR);
	$statement->bindValue(':modifyUser_lastname', $modifyUser_lastname, \PDO::PARAM_STR);
	$statement->bindValue(':modifyUser_phone', $modifyUser_phone, \PDO::PARAM_STR);
	$statement->bindValue(':modifyUser_email', $modifyUser_email, \PDO::PARAM_STR);
	$statement->bindValue(':iduser', $_POST['iduser'], \PDO::PARAM_INT);
	$statement->execute();

?>
	<div class="maj"><?php echo "Mise à jour effectuée !"; ?></div>
<?php
}

// Requête de sélection des infos utilisateurs
$id = $_SESSION['id'];
$userQuery = "SELECT * FROM user WHERE iduser = $id";
$statement = $pdo->query($userQuery);
$userInfo = $statement->fetchAll();

$iduser = $userInfo[0][0];
$username = $userInfo[0][1];
$user_password = $userInfo[0][2];
$user_firstname = $userInfo[0][3];
$user_lastname = $userInfo[0][4];
$user_phone = $userInfo[0][5];
$user_email = $userInfo[0][6];

/* if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    //Réinitialisation du tableau de session
    //On le vide intégralement
     $_SESSION = array();
    // Destruction de la session
     session_destroy();
    // Destruction du tableau de session
    unset($_SESSION);
    header('location: index.php');
} */
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

	<link rel="stylesheet" href="profile.css">

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
					<!-- <li class="nav-item"><a href="contact.html" class="nav-link">Contactez-nous</a></li> -->
					<li class="nav-item nav-link"><a href="add_edit_cottage.php" class="nav-link">Créer / consulter ses gîtes</a></li>
					<!-- AJOUT DE LA LIGNE CONNECTE(E) EN TANT QUE SI $_SESSION ACTIF -->
					<li class="nav-item nav-link"><a href="logout.php" class="nav-link">
							<?php
							if (!empty($_SESSION['login'])) {
								echo "Se déconnecter";
							}
							?>
						</a></li>
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
					<h2 class="mb-4">Profil</h2>
					<!-- Formulaire de modification -->
					<form action="" method="POST">
						<div class=edit_form>
							<div class="label_input">
								<input type="hidden" id="iduser" name="iduser" value=<?= $iduser ?>>
							</div>
							<div class="label_input">
								<label for="username" class="label">Nom d'utilisateur</label>
								<input type="text" id="username" name="username" value=<?= $username ?> required autofocus>
							</div>
							<div class="label_input">
								<label for="user_password" class="label">Mot de passe</label>
								<input type="password" id="user_password" name="user_password" value=<?= $user_password ?> required>
							</div>
							<div class="label_input">
								<label for="user_firstname" class="label">Prénom</label>
								<input type="text" id="user_firstname" name="user_firstname" value=<?= $user_firstname ?> required>
							</div>
							<div class="label_input">
								<label for="user_lastname" class="label">Nom</label>
								<input type="text" id="user_lastname" name="user_lastname" value=<?= $user_lastname ?> required>
							</div>
							<div class="label_input">
								<label for="user_phone" class="label">Téléphone</label>
								<input type="text" id="user_phone" name="user_phone" value=<?= $user_phone ?> required>
							</div>
							<div class="label_input">
								<label for="user_email" class="label">Email</label>
								<input type="text" id="user_email" name="user_email" value=<?= $user_email ?> required>
							</div>
							<div>
								<button>Modifier</button>
							</div>
						</div>
					</form>
					<?php echo "<br>"; ?>
					<!-- historique de réservation -->
					<h2 class="mb-4">Historique de vos réservations</h2>
					<div>
						<?php

						$statement = $pdo->query("SELECT * 
						FROM booking INNER JOIN cottage on idcottage=cottage_idcottage WHERE user_iduser=$id ;");
						$past_reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

						echo "<h4><strong>Réservation(s) à venir:</strong></h4>";
						echo "<table>";
						echo "<tr><th>date de début</th><th>date de fin</th><th>nom du gîte</th></tr>";
						foreach ($past_reservations as $past_reservation) {
							$start_date = date_create($past_reservation['start_date']);
							$start_date = date_format($start_date, 'Y-m-d');
							$today = date("Y-m-d");
							if ($start_date > $today) {
								echo "<tr>";
								echo "<td>" . $past_reservation['start_date'] . "</td>";
								echo "<td>" . $past_reservation['end_date'] . "</td>";
								echo "<td>" . $past_reservation['cottage_name'] . "</td>";
								echo "<td>" . $past_reservation['cottage_region'] . "</td>";
								echo "<td>" . $past_reservation['cottage_city'] . "</td>";
								echo "<td>" . $past_reservation['cottage_country'] . "</td>";
								echo "<td>" . $past_reservation['cottage_nb_bed'] . "</td>";
								echo "<td>" . $past_reservation['cottage_nb_bathroom'] . "</td>";
								echo "<td>" . $past_reservation['cottage_photo1'] . "</td>";
								echo "</tr>";
							}
						}
						echo "</table>";
						echo "<br>";
						echo "<h4><strong>Réservation(s) passée(s):</strong></h4>";
						echo "<table>";
						echo "<tr><th>date de début</th><th>date de fin</th><th>nom du gîte</th></tr>";
						foreach ($past_reservations as $past_reservation) {
							$start_date = date_create($past_reservation['start_date']);
							$start_date = date_format($start_date, 'Y-m-d');
							$today = date("Y-m-d");
							if ($start_date <= $today) {
								echo "<tr>";
								echo "<td>" . $past_reservation['start_date'] . "</td>";
								echo "<td>" . $past_reservation['end_date'] . "</td>";
								echo "</tr>";
							}
						}
						echo "</table>";
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="ftco-section container">
		<div class="container">
			<div class="row justify-content-center pb-4">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<h2 class="mb-4">Réservations</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<?php
			$id = $_SESSION['id'];
			$sql = 'SELECT * FROM booking INNER JOIN cottage ON idcottage=cottage_idcottage' ;
			foreach ($pdo->query($sql) as $reservation) {
			?>
				<div class="col-md-4 ftco-animate">
					<div class="project-wrap">
						<div class="img" style="background-image: url(<?= $reservation['cottage_photo1'] ?>);">
							<span class="price"><?= "Prix du séjour " . 276 . "€" ?></span>
						</div>
						<div class="text p-4">
							<span class="days"><?= $reservation['cottage_name'] ?></span>
							<h3><?= $reservation['cottage_city'] ?></h3>
							<p class="location"><span class="fa fa-map-marker"></span> <?= $reservation['cottage_region'] . " " . $reservation['cottage_country'] ?></p>
							<p class="location"><span class="fa fa-map-marker"></span> <?= $reservation['cottage_region'] . " " . $reservation['cottage_country'] ?></p>
							<ul>
								<li><span class="flaticon-shower"></span><?= $reservation['cottage_nb_bathroom'] ?></li>
								<li><span class="flaticon-king-size"></span><?= $reservation['cottage_nb_bed'] ?></li>
							</ul>
						</div>
					</div>
				</div>
			<?php
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
							<?= "<a href = \"profile.php?page=$i\">$i/</a>"; ?>
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
							<li><a href="	var_dump($_SESSION);#" class="py-2 d-block">General Enquiries</a></li>
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