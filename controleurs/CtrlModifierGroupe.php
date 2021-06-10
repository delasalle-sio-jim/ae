<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlModifierGroupe.php : traiter la demande de modification d'un groupe
// Ecrit le 03/06/2021 par Baptiste de Bailliencourt

// inclusion de la classe Outils
include_once ('modele/Outils.class.php');
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
    $id = '';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $lienRetour = '#page_principale';	// pour le retour en version jQuery mobile
    $themeFooter = $themeNormal;
    include_once ($cheminDesVues . 'VueModifierGroupe.php');
}
else {
    // récupération des données postées
    $unNomDeGroupe = $_POST ["txtNom"];
    if ( $_POST ["listeGroupes"] == 0)  $id = 0;  else   $id = $_POST ["listeGroupes"];
    if ($unNomDeGroupe == ''|| $id == 0){
        // si les données sont incorrectes ou incomplètes, réaffichage de la vue de modification avec un message explicatif
        $message = 'Veuillez choisir un groupe !';
        $typeMessage = 'avertissement';
        $lienRetour = '#page_principale';
        $themeFooter = $themeProbleme;
        include_once ($cheminDesVues . 'VueModifierGroupe.php');
    }
    else {
        // inclusion de la classe Groupe
        include_once ('modele/Groupe.class.php');
        // création d'un objet Groupe
    
        $unGroupe = new Groupe($id, $unNomDeGroupe);
        // enregistrement de l'élève dans la BDD
        $ok = $dao->modifierUnGroupe($unGroupe);
        if ( ! $ok )
        {
          // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
         $message = "Problème lors de la modification !";
          $typeMessage = 'avertissement';
            $lienRetour = '#page_principale';
         $themeFooter = $themeProbleme;
          include_once ($cheminDesVues . 'VueModifierGroupe.php');
        }
        else {
            // tout a fonctionné
            $message = "Modification effectuée !";
            $typeMessage = 'information';
            $lienRetour = 'index.php?action=Menu#menu6';
            $themeFooter = $themeNormal;
            include_once ($cheminDesVues . 'VueModifierGroupe.php');
        }
    }
    
    unset($dao);		// fermeture de la connexion à MySQL
}
