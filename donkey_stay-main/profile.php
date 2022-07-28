<?php
// Démarrage ou restauration de la session
session_start();
require_once('../../identifiants/connect.php');
$pdo = new \PDO(DSN, USER, PASS);

//PAGINATION => 2 étapes
// Etape 1: Faire la requête de sélection et définir le nombre de page
// Etape 2: Faire une boucle "FOR" sous la boucle "FOREACH" afin d'afficher le nombre de page dans des liens
$idUser = $_SESSION['id'];
$nbBookingQuery = "SELECT COUNT(idbooking) as nbBooking  FROM booking WHERE user_iduser = $idUser";
$statement = $pdo->query($nbBookingQuery);
$nbBookingArray = $statement->fetchAll();
$nbBooking = $nbBookingArray[0]['nbBooking'];

$size = 6;
$nbPage = ceil($nbBooking / $size);

if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$offset = ($page - 1) * $size;

//Requête de modification
if (isset($_POST['edit'])) {
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

// Requête d'annulation

if (isset($_POST['annulation'])) {
	try {
		$idbooking = $_POST['idbooking'];
		$sth = $pdo->prepare("DELETE FROM `booking` WHERE idbooking = :idbooking");
		$sth->execute(array(':idbooking' => $idbooking));
		/* echo "Réservation annulée"; */
	} catch (PDOException $e) {
		echo "Erreur:" . $e->getMessage();
	}
}

// Requête de sélection des infos utilisateurs
$userQuery = "SELECT * FROM user WHERE iduser = $idUser";
$statement = $pdo->query($userQuery);
$userInfo = $statement->fetchAll();

$iduser = $userInfo[0][0];
$username = $userInfo[0][1];
$user_password = $userInfo[0][2];
$user_firstname = $userInfo[0][3];
$user_lastname = $userInfo[0][4];
$user_phone = $userInfo[0][5];
$user_email = $userInfo[0][6];

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
				<span class="oi oi-menu"></span>
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active"><a href="index.php" class="nav-link">Accueil</a></li>

					<!-- AJOUT DE LA LIGNE CONNECTE(E) EN TANT QUE SI $_SESSION ACTIF -->
					<?php
					if (!empty($_SESSION['login'])) {
					?>
						<li class="nav-item nav-link"><a href="add_edit_cottage.php" class="nav-link">Gérer mes gîtes</a></li>
						<li class="nav-item nav-link"><a href="logout.php" class="nav-link">
								<?= "Se déconnecter"; ?>
							</a></li>
					<?php
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
					<h2 class="mb-4" id="title">Profil</h2>
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
								<button type="submit" name="edit"> Modifier </button>
							</div>
						</div>
					</form>
					<!-- historique de réservation -->
				</div>
			</div>
		</div>
	</div>
	<section class="ftco-section container">
		<div class="container">
			<div class="row justify-content-center pb-4">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<h2 class="mb-4">Mes réservations</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			$sql = "SELECT * FROM booking INNER JOIN cottage ON idcottage=cottage_idcottage WHERE user_iduser = '$idUser' ORDER BY start_date DESC LIMIT $size OFFSET $offset";
			foreach ($pdo->query($sql) as $reservation) {
				$start_date = date_create($reservation['start_date']);
				$start_date = date_format($start_date, 'Y-m-d');
				$today = date("Y-m-d");
			?>
				<div class="col-md-4 ftco-animate">
					<div class="project-wrap">
						<?php if ($start_date > $today) { ?>
							<span class="price"><?= "Prix du séjour : " . $reservation['total_price'] . "€" ?></span>
							<div class="img" style="background-image: url(<?= $reservation['cottage_photo1'] ?>);"></div>
						<?php } else { ?>
							<span class="price"><?= "Prix du séjour : " . $reservation['total_price'] . "€" ?></span>
							<div class="img old" style="background-image: url(<?= $reservation['cottage_photo1'] ?>);"></div>
						<?php } ?>
						<div class="text p-4">
							<span class="days"><?= $reservation['cottage_name'] ?></span>
							<h3><?= $reservation['cottage_city'] ?></h3>
							<p class="location"><span class="fa fa-map-marker"></span> <?= $reservation['cottage_region'] . " " . $reservation['cottage_country'] ?></p>
							<p class="location_period"> Début de séjour: <?= $reservation['start_date'] ?></p>
							<p class="location_period"> Fin de séjour: <?= $reservation['end_date'] ?></p>
							<ul class="list">
								<li><span class="flaticon-shower"></span><?= $reservation['cottage_nb_bathroom'] ?></li>
								<li><span class="flaticon-king-size"></span><?= $reservation['cottage_nb_bed'] ?></li>
								<?php if ($start_date > $today) { ?>
									<li class="button">
										<form action="profile.php" method="POST">
											<div class=edit_form>
												<input type="hidden" id="idbooking" name="idbooking" value=<?= $reservation['idbooking'] ?>>
											</div>
											<div class="button">
												<button type="submit" name="annulation"> Annuler </button>
											</div>
										</form>
									</li>
								<?php } ?>
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