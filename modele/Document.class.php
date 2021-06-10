<?php
// Projet : DLS - BTS Info - Anciens élèves
// fichier : modele/Document.class.php
// Rôle : la classe Document représente les documents mis à disposition pour les stagiaires et les maitres de stages.
// Création : 02/06/2021 par Baptiste de Bailliencourt

class Document
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    private $id;				// identifiant du Document
    private $nomSurBouton;		// Nom affiché sur le bouton du site
    private $nomDuFichier;		// nom du document téléchargé
    private $idGroupe;			// id du groupe auquel appartient le document
    
    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function __construct($unId, $unNomSurBouton, $unNomDuFichier, $unIdGroupe) {
        $this->id = $unId;
        $this->nomSurBouton = $unNomSurBouton;
        $this->nomDuFichier = $unNomDuFichier;
        $this->idGroupe = $unIdGroupe;
    }
    
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function getId()	{return $this->id;}
    public function setId($unId) {$this->id = $unId;}
    
    public function getNomSurBouton() {return $this->nomSurBouton;}
    public function setNomSurBouton($unNomSurBouton) {$this->nomSurBouton = $unNomSurBouton;}
    
    public function getNomDuFichier() {return $this->nomDuFichier;}
    public function setNomDuFichier($unNomDuFichier) {$this->nomDuFichier = $unNomDuFichier;}
    
    public function getIdGroupe() {return $this->idGroupe;}
    public function setIdGroupe($unIdGroupe) {$this->idGroupe = $unIdGroupe;}
    
    
    // ------------------------------------------------------------------------------------------------------
    // -------------------------------------- Méthodes d'instances ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function toString() {
        $msg  = 'Document : <br>';
        $msg .= 'id : ' . $this->getId() . '<br>';
        $msg .= 'nomSurBouton : ' . $this->getNomSurBouton() . '<br>';
        $msg .= 'nomDuFichier : ' . $this->getNomDuFichier() . '<br>';
        $msg .= 'idGroupe : ' . $this->getIdGroupe() . '<br>';

        return $msg;
    }
    
} // fin de la classe Document

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!