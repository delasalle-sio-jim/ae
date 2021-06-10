<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlSupprimerDocument.php : traiter la demande de suppression d'un groupe
// Ecrit le 07/06/2021 par Baptiste de Bailliencourt

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

$lesDocuments = $dao->getTousLesDocuments();

if ( ! isset ($_POST ["btnEnvoyer"]) ) {
    // si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
    $id = '';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $lienRetour = '#page_principale';	// pour le retour en version jQuery mobile
    $themeFooter = $themeNormal;
    include_once ($cheminDesVues . 'VueSupprimerDocument.php');
}
else {
    // récupération des données postées
    if ( $_POST ["listeDocuments"] == 0)  $id = 0;  else   $id = $_POST ["listeDocuments"];
    if ($id == 0){
        // si les données sont incorrectes ou incomplètes, réaffichage de la vue de suppression avec un message explicatif
        $message = 'Données incomplètes ou incorrectes !';
        $typeMessage = 'avertissement';
        $lienRetour = '#page_principale';
        $themeFooter = $themeProbleme;
        include_once ($cheminDesVues . 'VueSupprimerDocument.php');
    }
    else {
        // inclusion de la classe Groupe
        include_once ('modele/Groupe.class.php');
        // suppression du groupe dans la bdd
        $leDossierInitial = '../portail/documents/'; // Le dossier d'enregistrement pour les documents
        $unDocument = $dao->getLeDocument($id);
        $unNomFichier = $unDocument->getNomDuFichier();
        unlink($leDossierInitial . $unNomFichier);
        $ok = $dao->supprimerUnDocument($id);
        if ( ! $ok )
        {
            // si la suppression a échoué, réaffichage de la vue avec un message explicatif
            $message = "Problème lors de la suppression !";
            $typeMessage = 'avertissement';
            $lienRetour = '#page_principale';
            $themeFooter = $themeProbleme;
            include_once ($cheminDesVues . 'VueSupprimerDocument.php');
        }
        else {
            // tout a fonctionné
            $message = "Suppression effectuée !";
            $typeMessage = 'information';
            $lienRetour = 'index.php?action=Menu#menu6';
            $themeFooter = $themeNormal;
            include_once ($cheminDesVues . 'VueSupprimerDocument.php');
        }
    }
    
    unset($dao);		// fermeture de la connexion à MySQL
}
