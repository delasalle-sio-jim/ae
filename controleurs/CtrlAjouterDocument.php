<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlAjouterDocument.php : traiter la demande d'ajout de document dans le portail
// Ecrit le 03/06/2021 par Baptiste de Bailliencourt

// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.portail.php');
include_once ('modele/Outils.class.php');


$dao = new DAO();
$lesGroupes = $dao->getLesGroupesSansDocuments();

if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}

else{ 
    /* Si on n'a pas encore cliqué sur le bouton d'envoi */
    if ( ! isset ($_POST['btnEnvoi'])){
        $unNomSurBouton = '';
        $idGroupeChoisi = 0;
        $message = '';
        $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
        $lienRetour = 'index.php?action=Menu#menu6';
        $themeFooter = $themeNormal;
        include_once ($cheminDesVues . 'VueAjouterDocument.php');
    }
    
    /* Si on a cliqué sur le bouton d'envoi */
    else{
        /* Initialisation des variables d'upload du document */
        $leDossierInitial = '../portail/documents/'; // Le dossier d'enregistrement pour les documents
        $unNomFichier = $_FILES['fileDocument']['name'];  // Le fichier récupéré
        $unNomSurBouton = $_POST['txtBouton'];
        if ( $_POST ["listeGroupes"] == 0)  $idGroupeChoisi = 0;  else   $idGroupeChoisi = $_POST ["listeGroupes"];
        
        if ($unNomSurBouton == '' || $idGroupeChoisi == 0 ){
            // si les données sont incorrectes ou incomplètes, réaffichage de la vue de modification avec un message explicatif
            $message = 'Données incomplètes ou incorrectes !';
            $typeMessage = 'avertissement';
            $lienRetour = '#page_principale';
            $themeFooter = $themeProbleme;
            include_once ($cheminDesVues . 'VueAjouterDocument.php');
        }
        else{
            if ((file_exists($leDossierInitial . $unNomFichier)) ){
                // si les données sont incorrectes ou incomplètes, réaffichage de la vue de modification avec un message explicatif
                $message = 'Le document que vous essayez d\'ajouter existe déjà !';
                $typeMessage = 'avertissement';
                $lienRetour = '#page_principale';
                $themeFooter = $themeProbleme;
                include_once ($cheminDesVues . 'VueAjouterDocument.php');
            }
               else{
                /* Deplacement du document dans le dossier => ../portail/documents/ */
                move_uploaded_file($_FILES['fileDocument']['tmp_name'], $leDossierInitial . $unNomFichier);
                $unId = 0;  /* Il ne sera pas ajouté puisque c'est un auto incremente qui donnera son id */
                $unDocument = new Document ($unId, $unNomSurBouton, $unNomFichier, $idGroupeChoisi);
                
                $ok = $dao->ajouterDocument($unDocument);
                
                if ($ok){
                    $message = 'L\'ajout s\'est correctement effectué.';
                    $typeMessage = 'information';			// 2 valeurs possibles : 'information' ou 'avertissement'
                    $lienRetour = 'index.php?action=Menu#menu6';
                    $themeFooter = $themeNormal;
                    include_once ($cheminDesVues . 'VueAjouterDocument.php');
                }
                else{
                    $message ="L\'ajout est un échec !";
                    $typeMessage = 'avertissement';
                    $lienRetour = '#page_principale';
                    $themeFooter = $themeProbleme;
                    include_once ($cheminDesVues . 'VueAjouterDocument.php');
                }
            }
         }      
     }
}