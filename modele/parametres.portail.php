<?php
// ce fichier est destiné à être inclus dans les pages PHP qui ont besoin de se connecter à la base mrbs de GRR
// 2 possibilités pour inclure ce fichier :
//     include_once ('include_parametres.php');
//     require_once ('include_parametres.php');

// paramètres de connexion en localhost ----------------------------------------------------------------
global $PARAM_HOTE, $PARAM_PORT, $PARAM_BDD, $PARAM_USER, $PARAM_PWD;
$PARAM_HOTE = "localhost";			// si le sgbd est sur la même machine que le serveur php
$PARAM_PORT = "3306";				// le port utilisé par le serveur MySql
$PARAM_BDD = "portail";	// nom de la base de données
$PARAM_USER = "log_portail";			// nom de l'utilisateur
$PARAM_PWD = "mdp_portail";				// son mot de passe


// paramètres de connexion chez OVH --------------------------------------------------------------------

// $PARAM_HOTE = "mysql51-46.perso";		// si le sgbd est sur la même machine que le serveur php
// $PARAM_PORT = "3306";					// le port utilisé par le serveur MySql
// $PARAM_BDD = "lyceedelasalle";			// nom de la base de données
// $PARAM_USER = "lyceedelasalle";			// nom de l'utilisateur
// $PARAM_PWD = "patwcg35";				// son mot de passe





// ---------------- version récupérée du site portefeuille ----------------------
// paramètres pour localhost
// $nomServeur="localhost";
// $loginAdminServeur="log_portail";
// $motPasseAdminServeur="mdp_portail";
// $nomBaseDonnee="portail";
// $prefixeTable="portail_";
// $crypte=false;
// $smtp=false;

// paramètres pour OVH
// $nomServeur="mysql51-46.perso";
// $loginAdminServeur="lyceedelasalle";
// $motPasseAdminServeur="patwcg35";
// $nomBaseDonnee="lyceedelasalle";
// $prefixeTable="portail_";
// $crypte=false;
// $smtp=false;
?>
