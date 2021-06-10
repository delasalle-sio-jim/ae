<?php
// Projet : DLS - BTS Info - Anciens élèves
// fichier : modele/Groupe.class.php
// Rôle : la classe Groupe représente les groupes de documents
// Création le 01/06/2021 par Baptiste DE BAILLIENCOURT
include_once ('Document.class.php');

class Groupe
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    private $id;				// identifiant de la fonction
    private $nomGroupe;			// libelle du groupe
    private $lesDocs;           // La collection des documents du groupe
    
    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function __construct($unId, $unNomGroupe) {
        $this->id = $unId;
        $this->nomGroupe = $unNomGroupe;
        $this->lesDocs = array();  
    }
    
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function getId()	{return $this->id;}
    public function setId($unId) {$this->id = $unId;}
    
    public function getNomGroupe()	{return $this->nomGroupe;}
    public function setNomGroupe($unNomGroupe) {$this->nomGroupe = $unNomGroupe;}
    
    public function getLesDocs()	{return $this->lesDocs;}
   
    
    // ------------------------------------------------------------------------------------------------------
    // -------------------------------------- Méthodes d'instances ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function toString() {
        $msg  = 'Groupe : <br>';
        $msg .= 'id : ' . $this->getId() . '<br>';
        $msg .= 'libelle : ' . $this->getNomGroupe() . '<br>';
        foreach ($this->lesDocs as $unDoc)
        {
            $msg .= $unDoc->toString() .'<br>';
        }
        return $msg;
    }
    
    public function ajouterDocument($unDocument)
    {
        $this->lesDocs[]= $unDocument;
    }
} // fin de la classe Fonction

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!