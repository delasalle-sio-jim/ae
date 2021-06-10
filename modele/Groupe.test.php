<?php
// Projet : DLS - BTS Info - Anciens élèves
// fichier : modele/Fonction.test.php
// Rôle : test de la classe Fonction
// Création : 02/06/2021 par Baptiste de Bailliencourt

// inclusion de la classe Fonction
include_once ('Groupe.class.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test de la classe Groupe</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
$unId = 1;
$unNomGroupe = "Pour les stages";
$unGroupe = new Groupe($unId, $unNomGroupe);

echo ('$id : ' . $unGroupe->getId() . '<br>');
echo ('$libelle : ' . $unGroupe->getNomGroupe() . '<br>');
echo ('<br>');

echo ($unGroupe->toString());
echo ('<br>');

$unId = 2;
$unNomGroupe = "Pour les stagiaires";
$unGroupe->setId($unId);
$unGroupe->setNomGroupe($unNomGroupe);

echo ('$id : ' . $unGroupe->getId() . '<br>');
echo ('$libelle : ' . $unGroupe->getNomGroupe() . '<br>');
echo ('<br>');

echo ($unGroupe->toString());
echo ('<br>');

$unId = 1;
$unNomSurBouton = "Convention de stage";
$unNomDuFichier = "cvs.docx";
$unIdGroupe = 3;
$unDocument= new Document($unId, $unNomSurBouton, $unNomDuFichier, $unIdGroupe);
$unGroupe->ajouterDocument($unDocument);

$unId = 2;
$unNomSurBouton = "CR_nom_prenom";
$unNomDuFichier = "cvs.pdf";
$unIdGroupe = 3;
$unDocument= new Document($unId, $unNomSurBouton, $unNomDuFichier, $unIdGroupe);
$unGroupe->ajouterDocument($unDocument);

echo ($unGroupe->toString());
echo ('<br>');
?>

</body>
</html>