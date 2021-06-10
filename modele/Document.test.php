<?php
// Projet : DLS - BTS Info - Anciens élèves
// fichier : modele/Document.test.php
// Rôle : test de la classe Document
// Création : 02/06/2021 par Baptiste de Bailliencourt

// inclusion de la classe Soiree
include_once ('Document.class.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test de la classe Document</title>
	<style type="text/css">body {font-family: Arial, Helvetica, sans-serif; font-size: small;}</style>
</head>
<body>

<?php
$unId = 1;	
$unNomSurBouton = "Convention de stage";
$unNomDuFichier = "cvs.docx";					
$unIdGroupe = 3;				
			
$unDocument= new Document($unId, $unNomSurBouton, $unNomDuFichier, $unIdGroupe);

echo ($unDocument->toString());
echo ('<br>');

$unDocument->setId(2);
$unDocument->setNomSurBouton("Compte rendu de stage");
$unDocument->setNomDuFichier("cr_nom_prenom.pdf");
$unDocument->setIdGroupe(4);


echo ($unDocument->toString());
echo ('<br>');
?>

</body>
</html>