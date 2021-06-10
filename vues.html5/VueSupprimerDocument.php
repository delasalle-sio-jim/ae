<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueSupprimerDocument.php : visualiser la vue de suppression d'un document- par un administrateur
// Projet DLS - BTS Info - Anciens élèves
// Ecrit le 03/06/2021 par Baptiste de Bailliencourt

?>
<!doctype html>
<html lang="fr">
<head>	
	<?php include_once ('head.php');
	include_once ('modele/DAO.class.portail.php');
	$dao = new DAO();?>
	<script>
		window.onload = initialisations;	
		function initialisations() {
			<?php if ($typeMessage == 'avertissement') { ?>
				afficher_avertissement("<?php echo $message; ?>");
			<?php } ?>
			
			<?php if ($typeMessage == 'information') { ?>
				afficher_information("<?php echo $message; ?>");
			<?php } ?>
		}
		
	</script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	
	<style>
		 .ui-autocomplete {
			 max-height: 100px;
			 overflow-y: auto;
			 /* prevent horizontal scrollbar */
			 overflow-x: hidden;
		 }
		 /* IE 6 doesn't support max-height
		  * we use height instead, but this forces the menu to always be this tall
		  */
		 * html .ui-autocomplete {
			 height: 100px;
		 }
	</style>

		
	<script>
		function afficher_information(msg) {
			document.getElementById("titre_message").innerHTML = "Information...";
			document.getElementById("titre_message").className = "classe_information";
			document.getElementById("texte_message").innerHTML = msg;
			window.open ("#affichage_message", "_self");
		}
		function afficher_avertissement(msg) {
			document.getElementById("titre_message").innerHTML = "Avertissement...";
			document.getElementById("titre_message").className = "classe_avertissement";
			document.getElementById("texte_message").innerHTML = msg;
			window.open ("#affichage_message", "_self");
		}
	</script>
</head> 
<body>
	<div id="page">
	
		<div id="header">
			<div id=header-menu>
				<ul id="menu-horizontal">
					<li><a href="index.php?action=Menu#menu6">Retour menu</a></li>
					<?php include_once 'ReseauxSociaux.php';?>
				</ul>
			</div>
			<div id="header-logos">
				<img src="images/Logo_DLS.png" id="logo-gauche" alt="Lycée De La Salle (Rennes)" />
				<img src="images/Intitules_bts_ig_sio.png" id="logo-droite" alt="BTS Informatique" />
			</div>
		</div>
			
		<div id="content">
		<h2>Modifier un groupe</h2>
		<form name="form1" id="form1" action="index.php?action=SupprimerDocument" method="post">
				<p>
					<label for="listeDocuments">Le document à supprimer :</label>
					
					<select size="1" name="listeDocuments" id="listeDocuments">
					<option value="0" <?php if ($id == '') echo 'selected'; ?> >-- Indiquez le document --</option>

					<?php foreach ($lesDocuments as $unDocument) { ?>
							<option value="<?php echo $unDocument->getId(); ?>" <?php if ($id == $unDocument->getId()) echo 'selected="selected"'; ?>><?php echo $unDocument->getNomSurBouton(); ?></option>
					<?php } ?>				
					</select>
				</p>			
					<input type="submit" value="Supprimer" name="btnEnvoyer" id="btnEnvoyer" />
				
			</form>
		</div>
			
		<div id="footer">
			<p>Annuaire des anciens élèves du BTS Informatique - Lycée De La Salle (Rennes)</p>
		</div>	
			
	</div>
	
	<aside id="affichage_message" class="classe_message">
		<div>
			<h2 id="titre_message" class="classe_information">Message</h2>
			<p id="texte_message" class="classe_texte_message">Texte du message</p>
			<a href="<?php echo $lienRetour; ?>" title="Fermer">Fermer</a>
		</div>
	</aside>
	</body>
</html>						