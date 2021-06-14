<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlVoirListeInscritsAdmin.php : traiter la demande de consultation des informations sur les inscriptions des anciens élèves à la soirée des anciens par un admin
// Ecrit le 27/05/2015 par Killian BOUTIN
// Modifié le 01/06/2021 par DE BAILLIENCOURT Baptiste

// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.ae.php');
if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}
$dao = new DAO();

if (! isset ($_POST ["btnMaj"])) {
    
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $lienRetour = '#page_principale';
    $themeFooter = $themeNormal;
    // récupère les détails des inscriptions pour les afficher
    $lesInscriptions = $dao->getLesInscriptionsSansAnnulations();
    
    /* récupération du nombre d'inscriptions */
    
    $nombreInscrits = 0;
    
    foreach ($lesInscriptions as $uneInscription)
    {
        $nombreInscrits += $uneInscription->getNbrePersonnes();
        
    }
    $themeFooter = $themeNormal;
    
    /* déclaration du nombre total d'inscriptions */
    $nombreInscritsTotal = 0;
    
    /* déclaration du montant total réglé */
    $montantTotalRegle = 0.00;
    
    /* déclaration du montant total remboursé */
    $montantTotalRembourse = 0.00;
    
    /* déclaration du montant total */
    $montantTotalFinal = 0.00;
    
    
    if ($nombreInscrits == 0 )
    {
        $titre = "Aucun élève n'est inscrit à ce jour";
    }
    
    elseif ($nombreInscrits == 1) {
        $titre = $nombreInscrits . " inscrit à la prochaine soirée des anciens :";
    }
    
    else{
        $titre = $nombreInscrits . " inscrits à la prochaine soirée des anciens :";
    }
    
    include_once ($cheminDesVues.'VueVoirListeInscritsAdmin.php');
}
else {
    
    
    // récupère les détails des inscriptions pour les afficher
    $lesInscriptions = $dao->getLesInscriptionsSansAnnulations();
    
    /* récupération du nombre d'inscriptions */
    
    $nombreInscrits = 0;
    
    foreach ($lesInscriptions as $uneInscription)
    {
        $nombreInscrits += $uneInscription->getNbrePersonnes();
    }
    $themeFooter = $themeNormal;
    
    /* déclaration du nombre total d'inscriptions */
    $nombreInscritsTotal = 0;
    
    /* déclaration du montant total réglé */
    $montantTotalRegle = 0.00;
    
    /* déclaration du montant total remboursé */
    $montantTotalRembourse = 0.00;
    
    /* déclaration du montant total */
    $montantTotalFinal = 0.00;
    
    
    if ($nombreInscrits == 0 )
    {
        $titre = "Aucun élève n'est inscrit à ce jour";
    }
    
    elseif ($nombreInscrits == 1) {
        $titre = $nombreInscrits . " inscrit à la prochaine soirée des anciens :";
    }
    
    else{
        $titre = $nombreInscrits . " inscrits à la prochaine soirée des anciens :";
    }
    
    $ok = $dao->PurgerLesInscriptions();
    if ($ok)
    {
        $message = "Suppression effectuée.";
        $typeMessage = 'information';
        $lienRetour = 'index.php?action=VoirListeInscritsAdmin';
        $themeFooter = $themeNormal;
        include_once ($cheminDesVues . 'VueVoirListeInscritsAdmin.php');
    }
    else
    {
        $message = "L'application a rencontré un problème.";
        $typeMessage = 'avertissement';
        $lienRetour = '#page_principale';
        $themeFooter = $themeProbleme;
        include_once ($cheminDesVues . 'VueVoirListeInscritsAdmin.php');
    }
}