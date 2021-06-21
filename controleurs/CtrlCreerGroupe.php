<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlCreerGroupe.php : traite la demande de création d'un groupe de documents sur le portail
// Crée le 08/06/2021 par Baptiste de Bailliencourt

// inclusion de la classe Outils
if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}
// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.portail.php');
$dao = new DAO();
$lesGroupes = $dao->getLesGroupesSansDocuments();
if ( ! isset ($_POST ["btnEnvoyer"]) ) {
    // si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
    $unNomDeGroupe = '';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $lienRetour = '#page_principale';	// pour le retour en version jQuery mobile
    $themeFooter = $themeNormal;
    include_once ($cheminDesVues . 'VueCreerGroupe.php');
}
else {
     // récupération des données postées
     // inclusion de la classe Groupe
     include_once ('modele/Groupe.class.php');
     // création d'un objet Groupe
     $id = 0; 	// le numéro sera affecté automatiquement par le SGBD
     $unNomDeGroupe = $_POST["txtNom"];
     $ok = true;
     foreach($lesGroupes as $unGroupe)
     {
         if ($unNomDeGroupe == $unGroupe->getNomGroupe())
         {
             $ok = false;
             // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
             $message = "Ce groupe existe déjà !";
             $typeMessage = 'avertissement';
             $lienRetour = '#page_principale';
             $themeFooter = $themeProbleme;
             include_once ($cheminDesVues . 'VueCreerGroupe.php');
         }
     }
     if($ok)
     {
         $unNouveauGroupe = new Groupe($id, $unNomDeGroupe);
         // enregistrement de l'élève dans la BDD
         $ok = $dao->ajouterGroupe($unNouveauGroupe);
         if ( ! $ok ) 
         {
             // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
             $message = "Problème lors de l'enregistrement !";
             $typeMessage = 'avertissement';
             $lienRetour = '#page_principale';
             $themeFooter = $themeProbleme;
             include_once ($cheminDesVues . 'VueCreerGroupe.php');
         }
         else {
             // tout a fonctionné
             $message = "Enregistrement effectué !";
             $typeMessage = 'information';
             $lienRetour = 'index.php?action=Menu#menu6';
             $themeFooter = $themeNormal;
             include_once ($cheminDesVues . 'VueCreerGroupe.php');
         }
     }
unset($dao);		// fermeture de la connexion à MySQL
}
