<?php
session_start();
require_once '../../identifiants/connect.php';

$pdo = new \PDO(DSN, USER, PASS);

//getting id from url
/* $idCottage = $_GET['id']; */
/* $userid = $_SESSION['id']; */
$cottage_idcottage = $_GET['id'];

/******************** ADD NEW RESERVATION ******************/

if (isset($_POST['add_reservation'])) {
	if (empty($_SESSION['login'])) {
		header("location: /login.php?id=$cottage_idcottage");
	} else {

		// get the data from a form

		$userid = $_SESSION['id'];
		$start_date = trim($_POST['start_date']);
		$end_date = trim($_POST['end_date']);
		$nb_adult = $_POST['nb_adult'];
		$nb_child = $_POST['nb_child'];
		$total_price = $_POST['total_price']; //modifier ça avec la valeur calculer en js

		$optional = trim($_POST['optional']);

		$booked_dateQuery = "SELECT * FROM booking 
		WHERE (cottage_idcottage = '$cottage_idcottage')
		AND (`start_date` BETWEEN '$start_date' AND '$end_date'
		OR end_date BETWEEN '$start_date' AND '$end_date')";
		$statement = $pdo->query($booked_dateQuery);
		$booked_dateArray = $statement->fetchAll();

		if (!empty($booked_dateArray)){
			$unavailable = "Malheureusement, ces dates ne sont plus disponibles. Merci de sélectionner d'autres dates.";
		} else {
			$newBooking = "INSERT INTO booking (start_date, end_date, nb_adult, nb_child, total_price, user_iduser, cottage_idcottage, optional_idoptional) 
			VALUES (:start_date, :end_date, :nb_adult, :nb_child, :total_price, :userid, :cottage_idcottage, :optional);";
			$statement = $pdo->prepare($newBooking);
			$statement->bindValue(':start_date', $start_date, \PDO::PARAM_STR);
			$statement->bindValue(':end_date', $end_date, \PDO::PARAM_STR);
			$statement->bindValue(':nb_adult', $nb_adult, \PDO::PARAM_STR);
			$statement->bindValue(':nb_child', $nb_child, \PDO::PARAM_STR);
			$statement->bindValue(':total_price', $total_price, \PDO::PARAM_STR);
			$statement->bindValue(':userid', $userid, \PDO::PARAM_STR);
			$statement->bindValue(':cottage_idcottage', $cottage_idcottage, \PDO::PARAM_STR);
			$statement->bindValue(':optional', $optional, \PDO::PARAM_STR);
			$statement->execute();

			$newBookedDate = "INSERT INTO booked_date (start_booked_date, end_booked_date) 
				VALUES (:start_date, :end_date);";
			$statement = $pdo->prepare($newBookedDate);
			$statement->bindValue(':start_date', $start_date, \PDO::PARAM_STR);
			$statement->bindValue(':end_date', $end_date, \PDO::PARAM_STR);
			$statement->execute();
		}
	}
}



// date actuelle echo date("Y-m-d"); 
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


	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<!-- Bootstrap Datepicker CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="reservation.css">

</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.php" id="title">Donkey Stay<span>Location de Gîtes d'exception</span></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item nav-link"><a href="index.php" class="nav-link">Accueil</a></li>
					<!-- <li class="nav-item"><a href="contact.html" class="nav-link">Contactez-nous</a></li> -->
					<!-- Ajout de la ligne "Bonjour" si $_SESSION non vide sinon "login" -->
					<?php
					if (!empty($_SESSION['login'])) {
					?>
						<li class="nav-item nav-link"><a href="add_edit_cottage.php" class="nav-link">Gérer mes gîtes</a></li>
						<li class="nav-item nav-link"><a href="profile.php" class="nav-link">
							<?= $_SESSION['login']; ?>
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

	<?php
	$cottage_info = 'SELECT * FROM cottage WHERE idcottage ="' . $_GET['id'] . '"';
	foreach ($pdo->query($cottage_info) as $cottage) {
	?>
		<div class="hero-wrap js-fullheight" style="background-image: url('<?= $cottage['cottage_photo1']; ?>');">
			<div class="overlay"></div>
			<div class="container">
				<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
					<div class="col-md-7 ftco-animate">
						<span class="subheading"></span>
						<h1 class="mb-4"><?= $cottage['cottage_name']; ?></h1>
						<p class="location"><span class="fa fa-map-marker"></span> <?= $cottage['cottage_city']; ?>, <?= $cottage['cottage_region']; ?>, <?= $cottage['cottage_country']; ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<section class="ftco-section">
		<div class="container">
			<div class="row">
				<div class="col-md-4 ftco-animate">
					<div class="project-wrap">
						<a href="#" class="img" style="background-image: url('<?= $cottage['cottage_photo1']; ?>');">
							<span class="price"><?= $cottage['cottage_price_per_night']; ?>€ / nuit</span>
						</a>
						<div class="text p-4">
							<span class="days"><?= $cottage['cottage_name']; ?></span>
							<h3><a href="#"><?= $cottage['cottage_city']; ?></a></h3>
							<p class="location"><span class="fa fa-map-marker"></span> <?= $cottage['cottage_region']; ?>, <?= $cottage['cottage_country']; ?></p>
							<ul>
								<li><span class="flaticon-shower"></span>2</li>
								<li><span class="flaticon-king-size"></span>3</li>
							</ul>
						</div>
					</div>
					<div class="ftco-grid">
						<div class="four">
							<form action="gite_1.php?id=<?= $cottage['idcottage'] ?>">
								<input type="submit" value="Reserver" />
							</form>
						</div>
						<div class="three">
							<p><?= $cottage['cottage_description'] ?></p>
						</div>
						<div class="five"><img src=<?= $cottage['cottage_photo2']; ?>></div>
						<div class="six"><img src=<?= $cottage['cottage_photo3']; ?>></div>
						<div class="seven"><img src=<?= $cottage['cottage_photo4']; ?>></div>
					</div>
				</div>
			</div>
	</section>

	<section class="formulaire">
		<h2>Réservation :</h2>
		<?php if (isset($_POST['add_reservation'])) {
				if (!empty($booked_dateArray)) {
					echo $unavailable;
				} elseif (!empty($_SESSION['login'])){
		?>
					<div class="alert alert-success">
						<?php echo "réservation est confirmée"; ?>
					</div>
		<?php
			} else {
				header("Location: /login.php?id=<?= $cottage_idcottage ?>");
				exit;
			}
		} ?>

		<form action="" method="post" value="new_reservation" name="action" class="form">
			<div>
				<input type="hidden" id="price_per_night" value=<?=$cottage['cottage_price_per_night'];?> onChange="computeTotalPrice();">
				<label for="start_date" class="label">date de début :</label>
				<input id="start_date" name="start_date" class="label_input" onChange="computeTotalPrice();"/>
			</div>
			<div>
				<label for="end_date" class="label">date de fin :</label>
				<input id="end_date" name="end_date" class="label_input" onChange="computeTotalPrice();"/>
			</div>
			<div>
				<label for="optional" class="label">option :</label>
				<SELECT size="1" name="optional" class="label_input">
					<?php
					$statement = $pdo->query('SELECT * FROM optional');
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) { ?>
						<OPTION value="<?php echo $row['idoptional']; ?> " selected>
							<?php
							echo $row['optional_name'];
							?>
						</OPTION>

				</SELECT>
			</div>
			<div>
			    <input type="hidden" id="price_for_adult" value=<?= $row['optional_price_per_adult']; ?> onChange="computeTotalPrice();">
				<label for="nb_adult" class="label">nombre d'adultes (<?php echo $row['optional_price_per_adult'] . "€ /pers" ?>) :</label>
				<input type="int" id="nb_adult" name="nb_adult" value=0 class="label_input" onChange="computeTotalPrice();"/>
			</div>
			<div>
				<input type="hidden" id="price_for_child" value=<?= $row['optional_price_per_child']; ?> onChange="computeTotalPrice();">
				<label for="nb_child" class="label">nombre d'enfants (<?php echo $row['optional_price_per_child'] . "€ /pers" ?>) :</label>
				<input type="int" id="nb_child" name="nb_child" value=0 class="label_input" onChange="computeTotalPrice();"/>
			</div>
		<?php  } ?>
		<div>
		<label for="total_price" class="label"> Prix Total en € : </label>
		<input type="int" id="total_price" name="total_price" readonly class="label_input"></input>
		</div>				
		<div>
			<input type="submit" name="add_reservation" id="add_reservation" value="Réserver" class="button" />
		</div>
		</form>
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

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<!-- Bootstrap 4 JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Bootstrap Datepicker JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">
		//remplir le tableau des date de début et de fin des réservations
		let tab = new Array(
			<?php
			$dateBooking = $pdo->query("SELECT start_date, end_date FROM booking WHERE cottage_idcottage='$cottage_idcottage'");
			$arrayBooking = array();
			while ($donnees = $dateBooking->fetch()) {
				$entree  = "['" . $donnees['start_date'] . "' , '" . $donnees['end_date'] . "']";
				$arrayBooking[] = $entree;
			}
			echo implode(',', $arrayBooking);
			$dateBooking->closeCursor();
			?>
		);
		console.log(tab);

		// let tab = [["2022-07-24", "2022-07-29"],["2022-08-10", "2022-08-15"],];
		let datesForDisable = [];

		function convertDate(date) {
			let yyyy = date.getFullYear().toString();
			let mm = (date.getMonth() + 1).toString();
			let dd = date.getDate().toString();

			let mmChars = mm.split("");
			let ddChars = dd.split("");

			return (
				yyyy +
				"-" +
				(mmChars[1] ? mm : "0" + mmChars[0]) +
				"-" +
				(ddChars[1] ? dd : "0" + ddChars[0])
			);
		}

		for (let i = 0; i < tab.length; i++) {
			let start_date = new Date(tab[i][0]);
			console.log(convertDate(start_date));

			let end_date = new Date(tab[i][1]);
			let nb_days = 1;
			console.log(convertDate(end_date));
			end_date.setDate(end_date.getDate() - 1);

			datesForDisable.push(convertDate(start_date));
			while (start_date < end_date) {
				start_date.setDate(start_date.getDate() + 1);
				//start_date.toString()
				datesForDisable.push(convertDate(start_date));
				console.log(start_date);
				nb_days = nb_days + 1;
			}
			console.log(start_date);
			console.log(nb_days);
		}

		for (let i = 0; i < datesForDisable.length; i++) {
			console.log(datesForDisable[i]);
		}

		(function($) {
			$.fn.datepicker.dates["fr"] = {
				days: [
					"dimanche",
					"lundi",
					"mardi",
					"mercredi",
					"jeudi",
					"vendredi",
					"samedi",
				],
				daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
				daysMin: ["d", "l", "ma", "me", "j", "v", "s"],
				months: [
					"janvier",
					"février",
					"mars",
					"avril",
					"mai",
					"juin",
					"juillet",
					"août",
					"septembre",
					"octobre",
					"novembre",
					"décembre",
				],
				monthsShort: [
					"janv.",
					"févr.",
					"mars",
					"avril",
					"mai",
					"juin",
					"juil.",
					"août",
					"sept.",
					"oct.",
					"nov.",
					"déc.",
				],
				today: "Aujourd'hui",
				monthsTitle: "Mois",
				clear: "Effacer",
				weekStart: 1,
				format: "yyyy-mm-dd",
			};
		})(jQuery);

		$("#start_date").datepicker({
			format: "yyyy-mm-dd",
			language: "fr",
			autoclose: true,
			todayHighlight: true,
			startDate: new Date(),
			datesDisabled: datesForDisable,
		});

		$("#end_date").datepicker({
			format: "yyyy-mm-dd",
			language: "fr",
			autoclose: true,
			todayHighlight: true,
			startDate: new Date(),
			datesDisabled: datesForDisable,
		});


	</script>
	<script type="text/javascript">
	
		function computeTotalPrice() {
			
			let total_price = document.getElementById('total_price');
			
		 	// get start_date and end_date from datepicker
			let start_date = $('#start_date').val();
			console.log(start_date);
			let end_date = $('#end_date').val();
			console.log(end_date);
			// convert start_date and end_date to Date format
			start_date = new Date(start_date);
			end_date = new Date(end_date);
			let nb_days = 0;

			while (start_date <= end_date) {
				start_date.setDate(start_date.getDate() + 1);
				nb_days = nb_days + 1;
			}
			console.log(nb_days);
		
			let price_per_night = document.getElementById('price_per_night').value;
			console.log(price_per_night);
			let price_for_adult = document.getElementById('price_for_adult').value;
			console.log(price_for_adult);
			let nb_adult = document.getElementById('nb_adult').value;
			console.log(nb_adult);
			let price_for_child = document.getElementById('price_for_child').value;
			console.log(price_for_child);
			let nb_child = document.getElementById('nb_child').value;
			console.log(nb_child);

			//let title= document.querySelector("#title");
			//title.textContent="MAXIME";
			//title.innerHTML="<strong>MAX</strong>";      parseInt(nb_days)

			//total_price.innerHTML="<strong>MAX</strong>";

			total_price.value = (parseInt(price_per_night)*parseInt(nb_days)) + (parseInt(price_for_adult) * parseInt(nb_adult)) + ( parseInt(price_for_child) * parseInt(nb_child));
			return total_price;
			console.log(total_price);

			var formInfo = document.forms['total_price'];

			formInfo.total_price.value = total_price;

		}

		console.log(computeTotalPrice());

 	</script>
</body>

</html>