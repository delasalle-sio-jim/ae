<?php
// -------------------------------------------------------------------------------------------------------------------------
//                                         boite à outils de fonctions courantes
//                       Auteur : JM Cartron              	       Avant-dernière modification : 16/11/2015
//						 Modification : Killian BOUTIN		   	   Dernière modification : 25/05/2016
// -------------------------------------------------------------------------------------------------------------------------

// liste des méthodes statiques de cette classe (dans l'ordre d'apparition dans le fichier) :

// estUnEntierValide           : validation d'un nombre entier (il doit comporter 1 ou plusieurs chiffres chiffres)
// estUnCodePostalValide       : validation d'un code postal (il doit comporter 5 chiffres)
// estUneAdrMailValide         : validation d'une adresse mail
// estUnNumTelValide           : validation d'un numéro de téléphone (5 groupes de 2 chiffres EVENTUELLEMENT séparés)
// estUneDateValide            : validation d'une date (format jj/mm/aaaa ou bien jj-mm-aaaa)
// corrigerDate                : remplace les "/" par des "-"
// corrigerVille               : met la ville en majuscules et remplace les "SAINT" par "St"
// corrigerPrenom              : met en majuscules le premier caractère, et le caractère qui suit un éventuel tiret
// corrigerTelephone           : met le numéro sous la forme de 5 groupes de 2 chiffres séparés par des points
// convertirEnDateUS           : convertit une date française (j/m/a) au format US (a-m-j)
// convertirEnDateFR           : convertit une date US (a-m-j) au format Français (j/m/a)
// envoyerMail                 : envoyer un mail à un destinataire
// creerMdp                    : créer un mot de passe aléatoire de 8 caractères

// getImageByNomFichier        : fournit une image à partir d'un nom de fichier correspondant à une image jpeg, gif ou png
// enregistrerImageDansFichier : enregistre une image dans un fichier correspondant à une image jpeg, gif ou png
// getLargeurImage             : fournit la largeur d'une image en pixels
// getHauteurImage             : fournit la hauteur d'une image en pixels
// redimensionnerImage         : redimensionne une image source pour la réduire à la taille maximum indiquée, et la place dans le dossier de destination
	
// ce fichier est destiné à être inclus dans les pages PHP qui ont besoin des fonctions qu'il contient
// 2 possibilités pour inclure ce fichier :
//     include_once ('Class.Outils.php');
//     require_once ('Class.Outils.php');

// ces méthodes statiques sont appelées avec la notation suivante :
//     Outils::methode(parametres);

// début de la classe Outils
class Outils
{
	// fournit true si $entierAvalider est un nombre entier valide (1 ou plusieurs chiffres), false sinon
	public static function estUnEntierValide($entierAvalider)
	{	// utilisation d'une expression régulière pour vérifier un nombre entier :
		$EXPRESSION = "#^[0-9]+$#";
		// on retourne true si le nombre est valide :
		if ( preg_match ( $EXPRESSION , $entierAvalider ) == true ) return true; else return false;
	}	

	// fournit true si $codePostalAvalider est un code postal valide (5 chiffres), false sinon
	public static function estUnCodePostalValide($codePostalAvalider)
	{	// utilisation d'une expression régulière pour vérifier un code postal :
		$EXPRESSION = "#^[0-9]{5,5}$#";
		// on retourne true si le code est bon, mais aussi si le code est vide :
		if ( preg_match ( $EXPRESSION , $codePostalAvalider ) == true || $codePostalAvalider == "" ) return true; else return false;
	}	

	// fournit true si $adrMailAvalider est une adresse valide, false sinon
	public static function  estUneAdrMailValide ($adrMailAvalider)
	{	// utilisation d'une expression régulière pour vérifier une adresse mail :
		$EXPRESSION = "#^.+@.+\\..+$#";
		// on retourne true si l'adresse est bonne, mais aussi si l'adresse est vide :
		if ( preg_match ( $EXPRESSION , $adrMailAvalider) == true || $adrMailAvalider == "" ) return true; else return false;
	}
	
	// fournit true si $numTelAvalider est un numéro de téléphone valide, false sinon
	public static function  estUnNumTelValide ($numTelAvalider)
	{	// utilisation d'une expression régulière pour vérifier un numéro de téléphone :
		$EXPRESSION = "#^([0-9]{2,2}( |\\.|-|_|,|/)?){4,4}[0-9]{2,2}$#";
		// on retourne true si le numéro est bon, mais aussi si le numéro est vide :
		if ( preg_match ( $EXPRESSION , $numTelAvalider) == true || $numTelAvalider == "" ) return true; else return false;
	}
	
	// fournit true si $laDateAvalider est une date valide (format jj/mm/aaaa ou bien jj-mm-aaaa), false sinon
	public static function estUneDateValide ($laDateAvalider)
	{	// on retourne true si la date est vide :
		if ( $laDateAvalider == "" ) return true;
		
		// utilisation d'une expression régulière pour vérifier le format de la date :
		$EXPRESSION = "#^[0-9]{2,2}(/|-)[0-9]{2,2}(/|-)[0-9]{4,4}$#";
		if ( preg_match ( $EXPRESSION , $laDateAvalider) == false) return false;
		
		// jusque là, tout va bien ! on extrait les 3 sous-chaines et on les convertit en 3 entiers :
		$chaine1 = substr ($laDateAvalider, 0, 2);
		$chaine2 = substr ($laDateAvalider, 3, 2);
		$chaine3 = substr ($laDateAvalider, 6, 4);
		$jour = (int)($chaine1);
		$mois = (int)($chaine2);
		$an = (int)($chaine3);
	
		// test des valeurs
		if ( $mois < 0 || $mois > 12 || $jour < 0 || $jour > 31 )
			return false;
		else
		{   // cas des mois de 30 jours
			if ( ( $mois == 4 || $mois == 6 || $mois == 9 || $mois == 11 ) && ( $jour > 30 ) )
				return false;
			else
			{   // cas du mois de février
				// % est l'op�rateur modulo ; il permet de tester si $an est multiple de 4, de 100 ou de 400
				$bissextile = (($an % 4) == 0 && ($an % 100) != 0) || ($an % 400) == 0;
				if ( $mois == 2 && $bissextile == false && $jour > 28 )
					return false;
				else
				{   if ( $mois == 2 && $bissextile == false && $jour > 29 )
					{   return false;
					}
				}
			}
		}
		// si on arrive ici, c'est que la date est bonne :
		return true;
	}
	
	// remplace les "/" par des "-"
	public static function corrigerDate ($laDate)
	{
		$temporaire = str_replace ("-", "/", $laDate);
		return $temporaire;
	}
	
	// met la ville en majuscules et remplace les "SAINT" par "St"
	public static function corrigerVille ($laVille)
	{	$temporaire = $laVille;
		$temporaire = str_replace ("é", "e", $temporaire);
		$temporaire = str_replace ("è", "e", $temporaire);
		$temporaire = str_replace ("ê", "e", $temporaire);
		$temporaire = str_replace ("à", "a", $temporaire);
		$temporaire = str_replace ("ô", "o", $temporaire);
		$temporaire = str_replace ("î", "i", $temporaire);
		$temporaire = mb_strtoupper ($temporaire);
		$temporaire = str_replace ("SAINTE ", "Ste ", $temporaire);
		$temporaire = str_replace ("SAINTE-", "Ste ", $temporaire);
		$temporaire = str_replace ("SAINT ", "St ", $temporaire);
		$temporaire = str_replace ("SAINT-", "St ", $temporaire);
		return $temporaire;
	}
	
	// met en majuscules le premier caractère, et le caractère qui suit un éventuel tiret (le reste en minuscules)
	public static function corrigerPrenom ($lePrenom)
	{	if ($lePrenom != "")
		{	$longueur = strlen($lePrenom);
			$position = strpos($lePrenom, "-");
			if ($position == "")
			{	$partie1 = substr ($lePrenom, 0 , 1);
				$partie2 = substr ($lePrenom, 1 , $longueur-1);
				$lePrenom = mb_strtoupper($partie1) . strtolower($partie2);
			}
			else
			{	$partie1 = substr ($lePrenom, 0 , 1);
				$partie2 = substr ($lePrenom, 1 , $position-1);
				$partie3 = substr ($lePrenom, $position + 1, 1);
				$partie4 = substr ($lePrenom, $position + 2, $longueur-$position-2);
				$lePrenom = mb_strtoupper($partie1) . strtolower($partie2) . "-" . mb_strtoupper($partie3) . strtolower($partie4);
			}
		}
		return $lePrenom;
	}
	
	// met le numéro sous la forme de 5 groupes de 2 chiffres séparés par des points
	public static function corrigerTelephone ($leNumero)
	{	$temporaire = $leNumero;
		$temporaire = str_replace (" ", "", $temporaire);	// supprime les espaces
		$temporaire = str_replace (".", "", $temporaire);	// supprime les points
		$temporaire = str_replace (",", "", $temporaire);	// supprime les virgules
		$temporaire = str_replace ("-", "", $temporaire);	// supprime les tirets
		$temporaire = str_replace ("_", "", $temporaire);	// supprime les underscore
		$temporaire = str_replace ("/", "", $temporaire);	// supprime les slash
		
		if (strlen($temporaire) == 10 )		// il ne doit rester que les 10 chiffres...
		{   $resultat =             substr ($temporaire, 0, 2) . ".";
			$resultat = $resultat . substr ($temporaire, 2, 2) . ".";
			$resultat = $resultat . substr ($temporaire, 4, 2) . ".";
			$resultat = $resultat . substr ($temporaire, 6, 2) . ".";
			$resultat = $resultat . substr ($temporaire, 8, 2);
			return $resultat;
		}
		else
		{   return $leNumero;
		}
	}
	
	
	// La fonction dateUS convertit une date française (j/m/a) au format US (a-m-j)
	// par exemple, le paramètre '16/05/2007' donnera '2007-05-16'
	public static function convertirEnDateUS ($laDate)
	{	$tableau = explode ("/", $laDate);		// on extrait les segments de la chaine $laDate séparés par des "/"
		$jour = $tableau[0];
		$mois = $tableau[1];
		$an = $tableau[2];
		return ($an . "-" . $mois . "-" . $jour);		// on les reconcatène dans un ordre différent
	}
		
	// La fonction dateFR convertit une date US (a-m-j) au format Français (j/m/a)
	// par exemple, le paramètre '2007-05-16' donnera '16/05/2007'
	public static function convertirEnDateFR ($laDate)
	{	$tableau = explode ("-", $laDate);		// on extrait les segments de la chaine $laDate séparés par des "/"
		$an = $tableau[0];
		$mois = $tableau[1];
		$jour = $tableau[2];
		return ($jour . "/" . $mois . "/" . $an);		// on les reconcatène dans un ordre différent
	}
		
// 	// envoie un mail à un destinataire
// 	// retourne true si envoi correct, false en cas de problème d'envoi
// 	public static function  envoyerMail ($adresseDestinataire, $sujet, $message, $adresseEmetteur)
// 	{	// utilisation d'une expression régulière pour vérifier si c'est une adresse Gmail :
// 		if ( preg_match ( "#^.+@gmail\.com$#" , $adresseDestinataire) == true)
// 		{	// on commence par enlever les points dans l'adresse gmail car ils ne sont pas pris en compte
// 			$adresseDestinataire = str_replace(".", "", $adresseDestinataire);
// 			// puis on remet le point de "@gmail.com"
// 			$adresseDestinataire = str_replace("@gmailcom", "@gmail.com", $adresseDestinataire);
// 		}
// 		// envoi du mail avec la fonction mail de PHP
// 		$ok = mail($adresseDestinataire , utf8_decode($sujet) , utf8_decode($message), "From: " . $adresseEmetteur);
// 		return $ok;
// 	}
	
	// La fonction envoyerMail ($adresseDestinataire, $sujet, $message, $adresseEmetteur) envoie un mail à un destinataire
	// elle utilise le serveur le serveur OVH (sio.lyceedelassale.fr) pour envoyer le mail, en passant par un service web
	// retourne true si envoi correct, false en cas de problème d'envoi
	// Dernière mise à jour : 6/11/2018 par JM CARTRON
	public static function  envoyerMail ($adresseDestinataire, $sujet, $message, $adresseEmetteur)
	{
	    // transformation du message s'il contient des "&"
	    $message = str_replace("&", "$$", $message);
	    
	    // préparation de l'URL du service web avec ses paramètres
	    $urlService = "http://sio.lyceedelasalle.fr/tracegps/services/ServiceEnvoyerMail.php";
	    $urlService .= "?adresseDestinataire=" . $adresseDestinataire;
	    $urlService .= "&sujet=" . $sujet;
	    $urlService .= "&message=" . $message;
	    $urlService .= "&adresseEmetteur=" . $adresseEmetteur;
	    
	    // création d'un objet DOMDocument pour traiter un flux de données XML
	    $dom = new DOMDocument();
	    // chargement des données à partir de l'url du service web
	    if ( ! $dom->load($urlService )) return false;
	    // récupération du noeud XML correspondant à la balise <reponse>
	    $lesNoeuds = $dom->getElementsByTagName("reponse");
	    foreach ($lesNoeuds as $unNoeud)
	    {
	        if ($unNoeud->nodeValue == "true") return true;
	        else return false;
	    }
	}
	
	// crée un mot de passe aléatoire de 8 caractères (4 syllabes avec 1 consonne et 1 voyelle)
	public static function creerMdp ()
	{   $consonnes = "bcdfghjklmnpqrstvwxz";
		$voyelles = "aeiouy";
		$mdp = "";
		// on construit 4 syllabes de 2 caractères
		for ($i = 1 ; $i <= 4 ; $i++)
		{   // on tire d'abord une consonne (position aléatoire entre 0 et le nombre de consonnes - 1)
			$position = rand (0, strlen($consonnes)-1);
			// on récupère la consonne correspondant à la position dans $consonnes
			$unCaract = substr ($consonnes, $position, 1);
			// on ajoute cette consonne au mot de passe
			$mdp = $mdp . $unCaract;
			// puis on tire une voyelle (position aléatoire entre 0 et le nombre de voyelles - 1)
			$position = rand (0, strlen($voyelles)-1);
			// on récupère la voyelle correspondant à la position dans $voyelles
			$unCaract = substr ($voyelles, $position, 1);
			// on ajoute cette voyelle au mot de passe
			$mdp = $mdp . $unCaract;
		}
		return $mdp;
	}
	
	// fournit une image à partir d'un nom de fichier correspondant à une image jpeg, gif ou png
	// fournit null dans les autres cas
	// créé par Jim le 18/6/2016
	public static function getImageByNomFichier ($nomFichierSource) {
		$extensionFichier = mb_strtoupper(strrchr($nomFichierSource, '.'));	
		switch ($extensionFichier) {
			case '.JPG'  : { return imagecreatefromjpeg($nomFichierSource); break; }
			case '.JPEG' : { return imagecreatefromjpeg($nomFichierSource); break; }
			case '.GIF'  : { return imagecreatefromgif($nomFichierSource); break; }
			case '.PNG'  : { return imagecreatefrompng($nomFichierSource); break; }
			default      : { return null; break; }
		}	
	}

	// enregistre une image dans un fichier correspondant à une image jpeg, gif ou png
	// fournit true si l'enregistrement s'est bien passé, false autrement
	// créé par Jim le 18/6/2016
	public static function enregistrerImageDansFichier ($uneImage, $nomFichierDestination) {
		$extensionFichier = mb_strtoupper(strrchr($nomFichierDestination, '.'));
		switch ($extensionFichier) {
			case '.JPG'  : { imagejpeg ($uneImage, $nomFichierDestination); return true; break; }
			case '.JPEG' : { imagejpeg ($uneImage, $nomFichierDestination); return true; break; }
			case '.GIF'  : { imagegif ($uneImage, $nomFichierDestination); return true; break; }
			case '.PNG'  : { imagepng ($uneImage, $nomFichierDestination); return true; break; }
			default      : { return false; break; }
		}
	}
	
	// fournit la largeur d'une image en pixels
	// l'image peut être fournie par la méthode getImageByNomFichier
	// créé par Jim le 18/06/2016
	public static function getLargeurImage ($uneImage)
	{	return imagesx ($uneImage);
	}

	// fournit la hauteur d'une image en pixels
	// l'image peut être fournie par la méthode getImageByNomFichier
	// créé par Jim le 18/06/2016
	public static function getHauteurImage ($uneImage)
	{	return imagesy ($uneImage);
	}

	// redimensionne une image source pour la réduire à la taille maximum indiquée, et la place dans le dossier de destination
	// retourne true si la le redimensionnement s'est bien déroulé
	// retourne false sinon
	// créé par Jim le 17/06/2016
	public static function redimensionnerImage($nomFichierPhoto, $nomDossierSource, $nomDossierDestination, $tailleMax) {
		// tester si les noms de dossiers finissent par "/" et l'ajouter si besoin
		$dernierCaractere = $nomDossierSource[strlen($nomDossierSource)-1];
		if ($dernierCaractere != "/") $nomDossierSource .= "/";
		$dernierCaractere = $nomDossierDestination[strlen($nomDossierDestination)-1];
		if ($dernierCaractere != "/") $nomDossierDestination .= "/";
	
		// mémoriser les noms complets des fichiers et l'extension
		$nomFichierSource = $nomDossierSource . $nomFichierPhoto;
		$nomFichierDestination = $nomDossierDestination . $nomFichierPhoto;
		$extensionFichier = mb_strtoupper(strrchr($nomFichierPhoto, '.'));
	
		$imageSource = Outils::getImageByNomFichier($nomFichierSource);
		if ( ! $imageSource) return false;
	
		// Largeur de la source
		$largeurImageSource = imagesx ($imageSource);		// largeur en pixels
		// Hauteur de la source
		$hauteurImageSource = imagesy ($imageSource);		// hauteur en pixels
	
		// Largeur provisoire de la destination
		$largeurImageDestination = $largeurImageSource;
		// Hauteur provisoire de la destination
		$hauteurImageDestination = $hauteurImageSource;
	
		// Si l'image est trop large
		if ($largeurImageDestination > $tailleMax){
			// Taux de réduction
			$tauxReduction = $largeurImageDestination / $tailleMax;
			// Largeur de la destination
			$largeurImageDestination = $largeurImageSource / $tauxReduction;
			// Hauteur de la destination
			$hauteurImageDestination = $hauteurImageSource / $tauxReduction;
		}
	
		// Si l'image est trop haute
		if ($hauteurImageDestination > $tailleMax){
			// Taux de réduction
			$tauxReduction = $hauteurImageDestination / $tailleMax;
			// Largeur de la destination
			$largeurImageDestination = $largeurImageDestination / $tauxReduction;
			// Hauteur de la destination
			$hauteurImageDestination = $hauteurImageDestination / $tauxReduction;
		}
	
		// On donne à l'image ses dimensions finales
		$imageDestination = imagecreatetruecolor($largeurImageDestination, $hauteurImageDestination);
		if ( ! $imageDestination) return false;
	
		// On crée l'image, les 0 correspondent aux coordononnées
		$ok = imagecopyresampled($imageDestination, $imageSource, 0, 0, 0, 0,
				$largeurImageDestination, $hauteurImageDestination, $largeurImageSource, $hauteurImageSource);
		if ( ! $ok) return false;
	
		// On enregistrem la photo réduite dans un fichier
		$ok = Outils::enregistrerImageDansFichier ($imageDestination, $nomFichierDestination);

		return $ok;
	}
	
} // fin de la classe Outils

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!
