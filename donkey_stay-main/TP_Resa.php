<?php
session_start();
require_once '../../identifiants/connect.php';
$pdo = new \PDO(DSN, USER, PASS);
//Etape 1
$idCottage = $_GET['id'];
//Etape 3 : FAIRE D'ABORD DES REQUETES D'INSERTION POUR VERIFIER LES RESULTATS
if (isset($_POST['add_reservation'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    var_dump($start_date);
    var_dump($end_date);
    var_dump($idCottage);
    $booked_dateQuery = "SELECT * FROM booking
    WHERE cottage_idcottage = $idCottage
    AND `start_date` BETWEEN '$start_date' AND '$end_date'
    OR end_date BETWEEN '$start_date' AND '$end_date'";
    $statement = $pdo -> query($booked_dateQuery);
    $booked_dateArray = $statement->fetchAll();
    var_dump($booked_dateArray);
}
/*     $booked_dateQuery = "SELECT cottage_idcottage, booked_date_idbooked_date FROM cottage_has_booked_date
    JOIN booked_date ON booked_date_idbooked_date
    JOIN cottage ON cottage_idcottage
    WHERE cottage_idcottage = '$idCottage'
    AND '$start_date' OR $end_date BETWEEN start_booked_date AND end_booked_date
    /* OR '$end_date' BETWEEN start_booked_date AND end_booked_date *//* ";
/*     $statement = $pdo -> query($booked_dateQuery);
    $booked_dateArray = $statement->fetchAll();
    var_dump($booked_dateArray);*/
// Requête d'insertion dans la table booking + booked date + has booked date
if (isset($_POST['add_reservation'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $userid = $_SESSION['id'];
    $cottage_idcottage = $_GET['id'];
    $optional_idoptional = $_POST['optional'];
    $newBooking = "INSERT INTO booking (start_date, end_date, user_iduser, cottage_idcottage, optional_idoptional)
    VALUES (:start_date, :end_date, :userid, :cottage_idcottage,:optional_idoptional);";
    $statement = $pdo->prepare($newBooking);
    $statement->bindValue(':start_date', $start_date, \PDO::PARAM_STR);
    $statement->bindValue(':end_date', $end_date, \PDO::PARAM_STR);
    $statement->bindValue(':userid', $userid, \PDO::PARAM_INT);
    $statement->bindValue(':cottage_idcottage', $cottage_idcottage, \PDO::PARAM_INT);
    $statement->bindValue(':optional_idoptional', $optional_idoptional, \PDO::PARAM_STR);
    $statement->execute();
    $newBookedDate = "INSERT INTO booked_date (start_booked_date, end_booked_date)
    VALUES (:start_date, :end_date);";
    $statement = $pdo->prepare($newBookedDate);
    $statement->bindValue(':start_date', $start_date, \PDO::PARAM_STR);
    $statement->bindValue(':end_date', $end_date, \PDO::PARAM_STR);
    $statement->execute();
    $idNewBookedDateQuery = "SELECT idbooked_date FROM booked_date WHERE idbooked_date = (SELECT MAX(idbooked_date) FROM booked_date)";
    $statement = $pdo->query($idNewBookedDateQuery);
    $idNewBookedDateArray = $statement -> fetchAll();
    $lastIdBookedDate = $idNewBookedDateArray[0]['idbooked_date'];
    $newCottageHasBookedDate = "INSERT INTO cottage_has_booked_date (cottage_idcottage, booked_date_idbooked_date)
    VALUES (:cottage_idcottage, :lastIdBookedDate);";
    $statement = $pdo->prepare($newCottageHasBookedDate);
    $statement->bindValue(':cottage_idcottage', $cottage_idcottage, \PDO::PARAM_INT);
    $statement->bindValue(':lastIdBookedDate', $lastIdBookedDate, \PDO::PARAM_INT);
    $statement->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!--
Etape 2
 -->
 <form action="" method="POST" value="new_reservation" name="action" class="form">
    <div>
        <label for="start_date" class="label">date de début :</label>
        <input type="date" id="start_date" name="start_date" class="label_input" />
    </div>
    <div>
        <label for="end_date" class="label">date de fin :</label>
        <input type="date" id="end_date" name="end_date" class="label_input" />
    </div>
    <div>
        <label for="optional" class="label">option :</label>
        <SELECT size="1" name="optional" class="label_input">
            <OPTION value="choisissez une option">choisissez une option</OPTION>
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
        <label for="nbr_adults" class="label">nombre d'adultes (<?php echo $row['optional_price_per_adult'] . "€ /pers" ?>) :</label>
        <input type="int" id="nbr_adults" name="nbr_adults" value=0 class="label_input" />
    </div>
    <div>
        <label for="nbr_children" class="label">nombre d'enfants (<?php echo $row['optional_price_per_child'] . "€ /pers" ?>) :</label>
        <input type="int" id="nbr_children" name="nbr_children" value=0 class="label_input" />
    </div>
<?php  } ?>
    <div>
        <button type="submit" name="add_reservation" value="Réserver" class="button">Réserver</button>
    </div>
</form>
<!-- Etape 2:
Etape 3:
Etape 4:
 -->
</body>
</html>