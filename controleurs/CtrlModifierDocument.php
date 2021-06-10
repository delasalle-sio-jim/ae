<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlModifierDocument.php : traiter la modification d'un document
// Ecrit le 08/06/2021 par Baptiste de Bailliencourt


if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}
// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.portail.php');
// inclusion de la classe Outils
include_once ('modele/Outils.class.php');
$dao = new DAO();

$lesGroupes = $dao->getLesGroupesSansDocuments();
$lesDocuments = $dao->getTousLesDocuments();
$idDocument = "";
/* Premier passage sur la page */
if( (! isset ($_POST ["listeDocuments"]) == true) && ( ! isset ($_POST ["btnEnvoyer"]) == true)){
    // redirection vers la vue si aucune données n'est recu par le controleur
    $idDocument = "";
    $message = "";
    $typeMessage = "";
    $lienRetour = '#page_principale';
    $etape=0;
    
    //mise a zéro des variables de modifications de l'eleve
    $nomSurBouton = '';
    $nomFichier = '';
    $idGroupe = '';
    $themeFooter = $themeNormal;
    include_once ($cheminDesVues . 'VueModifierDocument.php');
}

/* Si on appuie sur le bouton "Obtenir des détails" */
elseif( isset ($_POST ["btnDetail"]) == true && (isset($_POST['btnEnvoyer']) == false )){
    
    if ( $_POST ["listeDocuments"] == 0)  $idDocument = 0;  else   $idDocument = $_POST ["listeDocuments"];
    if ($idDocument == 0){
        // si les données sont incorrectes ou incomplètes, réaffichage de la vue de modification avec un message explicatif
        $message = 'Donnée incorrecte ! (Veuillez choisir un document)';
        $typeMessage = 'avertissement';
        $lienRetour = '#page_principale';
        $themeFooter = $themeProbleme;
        $etape=0;
        include_once ($cheminDesVues . 'VueModifierDocument.php');
    }
    else{
        $etape = 1;
        $unDocumentInitial = $dao->getLeDocument($idDocument);
        
        $unNomSurBouton = $unDocumentInitial->getNomSurBouton();
        $unNomFichier = $unDocumentInitial->getNomDuFichier();
        $idGroupe = $unDocumentInitial->getIdGroupe();
        $_SESSION['id'] = $idDocument;
        
        
        $themeFooter = $themeNormal;
        include_once ($cheminDesVues . 'VueModifierDocument.php');
        
    }
}

elseif (isset($_POST['btnEnvoyer']) == true )
{      
        $etape=0;
        $unDocumentInitial = $dao->getLeDocument($_SESSION['id']);
        // récupération des données du formulaire + assemblage avec les données qui ne changerons pas
        $unId = $unDocumentInitial->getId();
        if ( empty ($_POST ["txtBouton"]) == true)  $unNomSurBouton = $unDocumentInitial->getNomSurBouton();  else   $unNomSurBouton = $_POST ["txtBouton"];
        
        if ( $_POST ["listeGroupes"] == 0)  $idGroupe = $unDocumentInitial->getIdGroupe(); else   $idGroupe = $_POST ["listeGroupes"];        
        $unNomFichierInitial = iconv("UTF-8", "CP1252", $unDocumentInitial->getNomDuFichier());
        if (($_FILES['fileDocument']["name"]) == "") $unNomFichier = $unNomFichierInitial; else $unNomFichier = $_FILES['fileDocument']['name'];
        $leDossierInitial = '../portail/documents/';
                        
        unlink($leDossierInitial . $unNomFichierInitial);
        move_uploaded_file($_FILES['fileDocument']['tmp_name'], $leDossierInitial . $unNomFichier);    
        $unDocument = new Document($unId, $unNomSurBouton, $unNomFichier, $idGroupe);
        
        $ok = $dao->modifierUnDocument($unDocument);
        
        if ($ok) {

            $message = 'Modification réussie.';
            $typeMessage = 'information';
            $lienRetour = 'index.php?action=Menu#menu6';
            $themeFooter = $themeNormal;
            include_once ($cheminDesVues . 'VueModifierDocument.php');
            
        }
        else
        {
            $message = "La modification a échouée.";
            $typeMessage = 'avertissement';
            $lienRetour = '#page_principale';
            $themeFooter = $themeProbleme;
            include_once ($cheminDesVues . 'VueModifierDocument.php');
        }
        
        unset($DAO);
}
