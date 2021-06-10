<?php
// Projet DLS - BTS Info - Anciens élèves
// Test de la classe DAO
// fichier : modele/DAO.test.ae.php
// Création : 16/11/2015 par JM CARTRON
// Mise à jour : 13/5/2016 par JM CARTRON

// ATTENTION : la position des tests dans ce fichier est identique à la position des méthodes testées dans la classe DAO

include_once ('Groupe.class.php');
include_once ('Document.class.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test de la classe DAO.class.portail</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
// connexion du serveur web à la base MySQL
include_once ('DAO.class.portail.php');  
$dao = new DAO();

// // test de la méthode getLesGroupesAvecDocuments -------------------------------------------------------------
// // modifié par Jim le 11/5/2016
// echo "<h3>Test de getLesGroupesAvecDocuments : </h3>";
// $lesGroupes = $dao->getLesGroupesAvecDocuments();
// $nbReponses = sizeof($lesGroupes);
// echo "<p>Nombre de groupes : " . $nbReponses . "</p>";
// // affichage des groupes
// foreach ($lesGroupes as $unGroupe)
// {	echo ($unGroupe->toString());
// 	echo ('<br>');
// }


// test de la méthode ajouterGroupe ------------------------------------------------------------
// modifié par Jim le 7/6/2021
echo "<h3>Test de ajouterGroupe : </h3>";
$unId = 0;
$unNomGroupe = "téèàstê";

$unGroupe = new Groupe($unId, $unNomGroupe);

$ok = $dao->ajouterGroupe($unGroupe);
if ($ok)
    echo "<p>Groupe bien enregistré !</p>";
else
    echo "<p>Echec lors de l'enregistrement du groupe !</p>";

// ferme la connexion à MySQL
unset($dao);
?>

</body>
</html>