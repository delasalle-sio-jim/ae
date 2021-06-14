<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueModifierReglementsRemboursements.php : voir la liste des inscrits afin de mettre à jour ceux qui ont payés ou ceux qu'il f
// Ecrit le 6/1/2016 par Nicolas Esteve
// Modifié le 31/05/2016 par Killian BOUTIN
// Modifié le 10/06/2016 par Baptiste de Bailliencourt


// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.ae.php');
if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}
$dao = new DAO();
$lesInscriptions = $dao->getLesInscriptionsAvecAnnulations();
$relire = true;
$uneSoiree = $dao->getSoiree($relire);
$unTarif = $uneSoiree->getTarif();
$lesInscriptionsPayees = array();
$lesInscriptionsAnnulees = array();
$lesInscriptionsRemboursees = array();
$lesInscriptionsInpayees = array();
$lesInscriptionsConfirmees = array();
$lesInscriptionsNonRemboursees = array();
if (! isset ($_POST ["btnMaj"])) {
    
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $lienRetour = '#page_principale';
    $themeFooter = $themeNormal;
    $inscriptionPayee = "";
    // récupère les détails des inscriptions pour les afficher
    
    
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
    
    include_once ($cheminDesVues.'VueModifierReglementsRemboursements.php');
}
else {
    
    
    // récupère les détails des inscriptions pour les afficher
    $lesInscriptions = $dao->getLesInscriptionsAvecAnnulations();
    
    /* récupération du nombre d'inscriptions */
    
    $nombreInscrits = 0;
    if(!empty ($_POST["Paye"]))
    {
        foreach($_POST['Paye'] as $Payement) {
            $lesInscriptionsPayees[] = $Payement;
        }
        
    }
    if(!empty ($_POST["Annule"]))
    {
        foreach($_POST['Annule'] as $Annulement) {
            $lesInscriptionsAnnulees[] = $Annulement;
        }
        
    }
    if(!empty ($_POST["Rembourse"]))
    {
        foreach($_POST['Rembourse'] as $Remboursement) {
            $lesInscriptionsRemboursees[] = $Remboursement;
        }
        
    }
    
    foreach($lesInscriptions AS $uneInscription)
    {
        if (!in_array($uneInscription->getId(), $lesInscriptionsPayees))
        {
            $lesInscriptionsInpayees[] = $uneInscription->getId();
        }
        if (!in_array($uneInscription->getId(), $lesInscriptionsAnnulees))
        {
            $lesInscriptionsConfirmees[] = $uneInscription->getId();
        }
        if (!in_array($uneInscription->getId(), $lesInscriptionsRemboursees))
        {
            $lesInscriptionsNonRemboursees[] = $uneInscription->getId();
        }
    }
    
    
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
    
    $ok = $dao->actualiserLesInscriptions($lesInscriptionsPayees, $lesInscriptionsAnnulees, $lesInscriptionsRemboursees , $lesInscriptionsInpayees, $lesInscriptionsConfirmees, $lesInscriptionsNonRemboursees );
    if ($ok)
    {
        $message = "Mise à jour effectuée.";
        $typeMessage = 'information';
        $lienRetour = 'index.php?action=ModifierReglementsRemboursements';
        $themeFooter = $themeNormal;
        include_once ($cheminDesVues . 'VueModifierReglementsRemboursements.php');
    }
    else
    {
        $message = "L'application a rencontré un problème.";
        $typeMessage = 'avertissement';
        $lienRetour = '#page_principale';
        $themeFooter = $themeProbleme;
        include_once ($cheminDesVues . 'VueModifierReglementsRemboursements.php');
    }
}