<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction du contrôleur CtrlExporterDesDonnees.php : Permet d'obtenir divers documents à télécharger
// Ecrit le 08/06/2021 par Baptiste de Bailliencourt

// inclusion de la classe Outils
include_once ('modele/Outils.class.php');
if ( $_SESSION['typeUtilisateur'] != 'administrateur') {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Deconnecter");
}
// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.ae.php');
$inscription = new Inscription("","","","","","","","","","","","");
$dao = new DAO();
$relire = true;
$soiree = $dao->getSoiree($relire);
$lesInscriptions = $dao->getLaListeInscriptions();
$x = 173;
$y = 61;
$lesEleves = $dao->getLesEleves();
if(!isset ($_POST ["btnPDF"]) && !isset($_POST ["btnCSV"]))
{
    include_once ($cheminDesVues . 'VueExporterDesDonnees.php');
}
if ( isset ($_POST["btnCSV"]))
{
        function ExporterLesEleves($lesEleves){
            $excel =  "Nom;Prénom;Année de début de BTS;Mail;\n";
            foreach($lesEleves as $unEleve) {
                $unMail = 
                $excel .= $unEleve->getNom().";".$unEleve->getPrenom().";".$unEleve->getAnneeDebutBTS().";".$unEleve->getAdrMail()."; \n";
            }
            header('Content-Encoding: UTF-8');
            header("Content-type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-disposition: attachment; filename=ListeDesEleves.csv");
            echo pack('H*','EFBBBF');
            print $excel;
            exit;
        
        }
    ExporterLesEleves($lesEleves);
    include_once ($cheminDesVues . 'VueExporterDesDonnees.php');
}
if ( isset ($_POST ["btnPDF"]) ) {
    require('fpdf/fpdf.php');
    class PDF extends FPDF
    {
        // En-tête
        function Header()
        {
            // Logo
            $this->Image('images/Logo_DLS.png',10,6,30);
            // Police Arial gras 15
            $this->SetFont('Arial','B',15);
            // Décalage à droite
            $this->Cell(80);
            // Titre
            $this->Cell(30,10,'GESTION DES PAYEMENTS DE LA SOIREE',0,0,'C');
            // Saut de ligne
            $this->Ln(30);
        }
        
        // Pied de page
        function Footer()
        {
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial','I',8);
            // Numéro de page
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    $t=time(); 
    $pdf=new PDF();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetTitle('GESTION DES PAYEMENTS DE LA SOIREE', true);
	$pdf->SetFont('Arial','',16);
	$pdf->Cell(55,10,iconv("UTF-8", "CP1252", "Liste du ".date("d/m/Y",$t)." à ".date("H:i",$t)),0,1);
	$pdf->SetFont('Arial','B',16);
    $pdf->Cell(55,10,iconv("UTF-8", "CP1252", "Nom"),1,0);
    $pdf->Cell(55,10,iconv("UTF-8", "CP1252", "Prenom"),1,0);
    $pdf->Cell(10,10,iconv("UTF-8", "CP1252", "Nb"),1,0);
    $pdf->Cell(30,10,iconv("UTF-8", "CP1252", "  Montant"),1,0);
    $pdf->Cell(35,10,iconv("UTF-8", "CP1252", "     Payé ?"),1,1);
    foreach($lesInscriptions AS $uneInscription)
    {   $unNom = $uneInscription->nom;
        $unPrenom = $uneInscription->prenom;
        $unNbrePersonnes = $uneInscription->nbrePersonnes;
        $unMontant = $uneInscription->montant;
        if (strlen($unNom)<=15)
        {
            $pdf->SetFont('Arial','',16);
        }
        elseif (strlen($unNom)>15 && strlen($unNom)<18 )
        {
            $pdf->SetFont('Arial','',14);
        }
        elseif (strlen($unNom)>18)
        {
            $pdf->SetFont('Arial','',8.5);
        }
        
        $pdf->Cell(55,10,iconv("UTF-8", "CP1252", $unNom),1,0);
        
        if (strlen($unPrenom)<=15)
        {
            $pdf->SetFont('Arial','',16);
        }
        elseif (strlen($unPrenom)>15 && strlen($unPrenom)<18 )
        {
            $pdf->SetFont('Arial','',14);
        }
        elseif (strlen($unPrenom)>18)
        {
            $pdf->SetFont('Arial','',11.5);
        }
        $pdf->Cell(55,10,iconv("UTF-8", "CP1252", $unPrenom),1,0);
        $pdf->SetFont('Arial','',16);
        $pdf->Cell(10,10,$unNbrePersonnes,1,0);
        $pdf->Cell(30,10,$unMontant.iconv("UTF-8", "CP1252", " €"),1,0);
        $pdf->Cell(35,10, $pdf->Rect($x,$y,8,8),1,1);
        $y=$y+10;
        if ($y >= 270)
            $y=41;
    }
    $pdf->Output("Liste payements ".substr($soiree->getDateSoiree(),0,4).".pdf","I");
}

unset($dao);		// fermeture de la connexion à MySQL

