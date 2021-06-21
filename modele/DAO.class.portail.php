<?php
// certaines méthodes nécessitent les fichiers suivants :
include_once ('Groupe.class.php');
include_once ('Document.class.php');

// inclusion des paramètres de l'application
//include_once ('parametres.free.php');
include_once ('parametres.portail.php');

class DAO
{
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Membres privés de la classe ---------------------------------------
	// ------------------------------------------------------------------------------------------------------
		
	private $cnx;				// la connexion à la base de données
	
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Constructeur et destructeur ---------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	// le constructeur crée la connexion $cnx à la base de données
	public function __construct() {
		global $PARAM_HOTE, $PARAM_PORT, $PARAM_BDD, $PARAM_USER, $PARAM_PWD;
		try
		{	$this->cnx = new PDO ("mysql:host=" . $PARAM_HOTE . ";port=" . $PARAM_PORT . ";dbname=" . $PARAM_BDD,
							$PARAM_USER,
							$PARAM_PWD);
			return true;
		}
		catch (Exception $ex)
		{	echo ("Echec de la connexion a la base de donnees <br>");
			echo ("Erreur numero : " . $ex->getCode() . "<br />" . "Description : " . $ex->getMessage() . "<br>");
			echo ("PARAM_HOTE = " . $PARAM_HOTE);
			return false;
		}
	}
	
	// le destructeur ferme la connexion $cnx à la base de données
	public function __destruct() {
		unset($this->cnx);
	}
	
	// ------------------------------------------------------------------------------------------------------
	// -------------------------------------- Méthodes d'instances ------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	// permet l'ajout d'un groupe dans lequel y placer des documents
	public function ajouterGroupe ($unGroupe)
	{	// préparation de la requête
	    $txt_req = "INSERT INTO portail_groupes_documents (nomGroupe)";  
	    $txt_req .= " VALUES (:nomGroupe)";
	    $req = $this->cnx->prepare($txt_req);
	    // liaison de la requête et de ses paramètres
	    $req->bindValue("nomGroupe",utf8_decode($unGroupe->getNomGroupe()), PDO::PARAM_STR);
	    // exécution de la requête
	    $ok = $req->execute();
	    
	    // sortir en cas d'échec
	    if ( ! $ok) { return false; }
	    
	    // recherche de l'identifiant (auto_increment) qui a été attribué à la trace
	    $unId = $this->cnx->lastInsertId();
	    $unGroupe->setId($unId);
	    return true;
	}	
	
	// permet la modification d'un grupe déjà existant
	public function modifierUnGroupe($unGroupe)
	{	// préparation de la requête
	    $txt_req = "UPDATE portail_groupes_documents SET";
	    $txt_req .= " nomGroupe = :nomGroupe";
	    $txt_req .= " WHERE id = :id";
	    $req = $this->cnx->prepare($txt_req);
	    
	    // liaison de la requête et de ses paramètres
	    $req->bindValue("id",  $unGroupe->getId() , PDO::PARAM_INT);
	    $req->bindValue("nomGroupe",  utf8_decode($unGroupe->getNomGroupe()), PDO::PARAM_STR);
	    
	    // exécution de la requête
	    $ok = $req->execute();
	    return $ok;
	}	
	
	// permet la suppression d'un groupe si celui ci est vide
	public function supprimerUnGroupe($unIdGroupe)
	{  
	    if (sizeof($this->getLesDocumentsDuGroupe($unIdGroupe)) != 0)
	    {
	        $ok = FALSE;
	    }
	    else 
	    {
	        $txt_req = "DELETE FROM portail_groupes_documents WHERE id = :id ";
	        $req = $this->cnx->prepare($txt_req);
	        
	        // liaison de la requête et de ses paramètres
	        $req->bindValue("id",  $unIdGroupe , PDO::PARAM_INT);
	        // exécution de la requête 
	        $ok = $req->execute();
	    }
	    return $ok;
	}	
	
	// permet d'ajouter un document dans un group déjà existant
	public function ajouterDocument ($unDocument)
	{	// préparation de la requête
	    $txt_req = "INSERT INTO portail_documents (nomSurBouton, nomDuFichier, idGroupe)";
	    $txt_req .= " VALUES (:nomSurBouton, :nomDuFichier, :idGroupe)";
	    $req = $this->cnx->prepare($txt_req);
	    // liaison de la requête et de ses paramètres
	    $req->bindValue("nomSurBouton", (utf8_decode($unDocument->getNomSurBouton())), PDO::PARAM_STR);
	    $req->bindValue("idGroupe", (utf8_decode($unDocument->getIdGroupe())), PDO::PARAM_INT);
	    $req->bindValue("nomDuFichier", (utf8_decode($unDocument->getNomDuFichier())), PDO::PARAM_STR);
	    // exécution de la requête
	    $ok = $req->execute();

	    // sortir en cas d'échec
	    if ( ! $ok) { return false; }
	    
	    // recherche de l'identifiant (auto_increment) qui a été attribué à la trace
	    $unId = $this->cnx->lastInsertId();
	    $unDocument->setId($unId);
	    return true;
	}	
	
	// permet la modification d'un document déjà existant
	public function modifierUnDocument($unDocument)
	{	// préparation de la requête
	    $txt_req = "UPDATE portail_documents SET";
	    $txt_req .= " nomSurBouton = :nomSurBouton,";
	    $txt_req .= " nomDuFichier = :nomDuFichier,";
	    $txt_req .= " idGroupe = :idGroupe";	    
	    $txt_req .= " WHERE id = :id;";
	    $req = $this->cnx->prepare($txt_req);
	    
	    // liaison de la requête et de ses paramètres
	    $req->bindValue("id", (utf8_decode($unDocument->getId())), PDO::PARAM_INT);
	    $req->bindValue("nomSurBouton", (utf8_decode($unDocument->getNomSurBouton())), PDO::PARAM_STR);
	    $req->bindValue("idGroupe", (utf8_decode($unDocument->getIdGroupe())), PDO::PARAM_INT);
	    $req->bindValue("nomDuFichier", (utf8_decode($unDocument->getNomDuFichier())), PDO::PARAM_STR);
	    // exécution de la requête
	    $ok = $req->execute();
	    return $ok;
	}	
	
	// permet la suppression d'un document déjà existant
	public function supprimerUnDocument($unIdDocument)
	{	
    	// préparation de la requete de suppression des inscriptions de l'élève à supprimer
    	$txt_req = "DELETE FROM portail_documents WHERE id = :id";
    	$req = $this->cnx->prepare($txt_req);
    	// liaison de la requête et de son paramètre
    	$req->bindValue("id", $unIdDocument, PDO::PARAM_INT);
    	// exécution de la requete
    	$ok = $req->execute();
    	return $ok;
	}
	
	public function getLeDocument($unIdDocument)
	{
	    //préparation de la requête 
	    $txt_req="Select id, nomSurBouton, nomDuFichier, idGroupe";
	    $txt_req .=" FROM portail_documents";
	    $txt_req .=" WHERE id = :id;";
	    $req = $this->cnx->prepare($txt_req);
	    //liaison de la requête et de son paramètre
	    $req->bindValue("id",($unIdDocument), PDO::PARAM_INT);
	    //execution de la requête
	    $ok = $req->execute();
	    $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    $id = utf8_decode($uneLigne->id);
	    $nomSurBouton = utf8_encode($uneLigne->nomSurBouton);
	    $nomDuFichier = utf8_decode($uneLigne->nomDuFichier);
	    $idGroupe = utf8_decode($uneLigne->idGroupe);
	    
	    $unDocument = new Document($id, $nomSurBouton, $nomDuFichier, $idGroupe);	    
	    return $unDocument;
	}
	
	public function getLesDocumentsDuGroupe($unIdGroupe)
	{
	    // préparation de la requete
	    $txt_req= "SELECT id, nomSurBouton, nomDuFichier, idGroupe";
	    $txt_req .=" FROM portail_documents";
	    $txt_req .=" WHERE idGroupe = :idGroupe;";
	    $req = $this->cnx->prepare($txt_req);
	    // liaison de la requête et de son paramètre
	    $req->bindValue("idGroupe",($unIdGroupe), PDO::PARAM_INT);
	    // exécution de la requete
	    $ok = $req->execute();
	    $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    
	    // construction d'une collection d'objets Groupes
	    $lesDocumentsDuGroupe = array();
	    // tant qu'une ligne est trouvée :
	    while ($uneLigne)
	    {
	        // création d'un objet Groupe
	        $id =$uneLigne->id;
	        $nomSurBouton = $uneLigne->nomSurBouton;
	        $nomDuFichier = $uneLigne->nomDuFichier;
	        $idGroupe =$uneLigne->idGroupe;
	        
	        $unDocument = new Document($id, $nomSurBouton, $nomDuFichier, $idGroupe);
	        
	        // ajout de l'élève à la collection
	        $lesDocumentsDuGroupe[] = $unDocument;
	        // extrait la ligne suivante
	        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    }
	    // libère les ressources du jeu de données
	    $req->closeCursor();
	    // fourniture de la collection
	    return $lesDocumentsDuGroupe;
	}

	public function getTousLesDocuments()
	{	// préparation de la requete de recherche
	    $txt_req= "SELECT id, nomSurBouton, nomDuFichier, idGroupe";
	    $txt_req .=" FROM portail_documents";
	    
	    $req = $this->cnx->prepare($txt_req);
	    // extraction des données
	    $req->execute();
	    $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    
	    // construction d'une collection d'objets Document
	    $lesDocuments = array();
	    // tant qu'une ligne est trouvée :
	    while ($uneLigne)
	    {
	        // création d'un objet Document
	        $id = utf8_encode($uneLigne->id);
	        $nomSurBouton = utf8_encode($uneLigne->nomSurBouton);
	        $nomDuFichier = utf8_encode($uneLigne->nomDuFichier);
	        $idGroupe = utf8_encode($uneLigne->idGroupe);
	        
	        $unDocument = new Document($id, $nomSurBouton, $nomDuFichier, $idGroupe);
	        
	        // ajout du document à la collection
	        $lesDocuments[] = $unDocument;
	        // extrait la ligne suivante
	        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    }
	    // libère les ressources du jeu de données
	    $req->closeCursor();
	    // fourniture de la collection
	    return $lesDocuments;
	}
	
	public function getLesGroupesSansDocuments()
	{	// préparation de la requete de recherche
	    $txt_req = "SELECT id, nomGroupe FROM portail_groupes_documents ORDER BY id";
	    
	    $req = $this->cnx->prepare($txt_req);
	    // extraction des données
	    $req->execute();
	    $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    
	    // construction d'une collection d'objets Groupes
	    $lesGroupes = array();
	    // tant qu'une ligne est trouvée :
	    while ($uneLigne)
	    {
	        // création d'un objet Groupe
	        $id = $uneLigne->id;
	        $nomGroupe = utf8_encode($uneLigne->nomGroupe);
	        
	        $unGroupe = new Groupe($id, $nomGroupe);
	        
	        // ajout du groupe à la collection
	        $lesGroupes[] = $unGroupe;
	        // extrait la ligne suivante
	        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    }
	    // libère les ressources du jeu de données
	    $req->closeCursor();
	    // fourniture de la collection
	    return $lesGroupes;
	}

	public function getLesGroupesAvecDocuments()
	{	// préparation de la requete de recherche
	    $txt_req = "SELECT idDocument, nomSurBouton, nomDuFichier, idGroupe, nomGroupe";
	    $txt_req .= " FROM portail_vue_documents ORDER BY idGroupe, idDocument";
	    
	    $req = $this->cnx->prepare($txt_req);
	    // extraction des données
	    $req->execute();
	    $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    // construction d'une collection d'objets Groupes
	    $lesGroupes = array();
	    
	    $unGroupe = null;
	    // tant qu'une ligne est trouvée :
	    while ($uneLigne)
	    {	
	        $unId = utf8_encode($uneLigne->idDocument);
	        $unNomSurBouton = utf8_encode($uneLigne->nomSurBouton);
	        $unNomDuFichier = utf8_encode($uneLigne->nomDuFichier);
	        $unIdGroupe = utf8_encode($uneLigne->idGroupe);
	        $unNomGroupe = utf8_encode($uneLigne->nomGroupe);
	        
	        if($unGroupe == null || $unDocument->getIdGroupe() != $unIdGroupe)
	        {
	            $unGroupe = new Groupe($unIdGroupe, $unNomGroupe);
	            // ajout du groupe à la collection
	            $lesGroupes[] = $unGroupe;
	        }
	        $unDocument = new Document($unId, $unNomSurBouton, $unNomDuFichier, $unIdGroupe);
	        $unGroupe->ajouterDocument($unDocument);
	        
	        // extrait la ligne suivante
	        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
	    }
	    // libère les ressources du jeu de données
	    $req->closeCursor();
	    // fourniture de la collection
	    return $lesGroupes;
	}

}
?>