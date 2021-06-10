<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueAjouterDocument.php : permet d'ajouter un document au site portail
// Ecrit le 03/06/2021 par Baptiste de Bailliencourt
?>
<!doctype html>

<head>	
	<?php include_once ('head.php');
	include_once ('modele/DAO.class.portail.php');?>
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
			<div id="header-menu">
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
			<h2>Ajouter un document</h2>
			<form name="form1" id="form1" enctype="multipart/form-data" action="index.php?action=AjouterDocument" method="post">		
						<p>
							<label for="fileDocument">Document * :</label>
							<input type="file" name="fileDocument" id="fileDocument" required style="border: 0px; margin-left: 0px;">
						</p>
						<p>
							<label for="txtBouton">Nom * :</label>
							<input type="text" name="txtBouton" id="txtBouton" maxlength="100" placeholder="Entrez le nom qui apparaitra sur le bouton correspondant au document" required value="<?php echo $unNomSurBouton; ?>">
						</p>
						<p>
						<label for="listeGroupes">Nom du groupe * :</label>
						<select size="1" name="listeGroupes" id="listeGroupes">
					
					<option value="0" <?php if ($idGroupeChoisi == 0) echo 'selected'; ?> >-- Indiquez le groupe auquel appartiendra ce document --</option>

					<?php foreach ($lesGroupes as $unGroupe) { ?>
							<option value="<?php echo $unGroupe->getId(); ?>" <?php if ($idGroupeChoisi == $unGroupe->getId()) echo 'selected="selected"'; ?>><?php echo $unGroupe->getNomGroupe(); ?></option>
					<?php } ?>				
					</select>
					</p>
					<p>
				<input type="submit" value="Ajouter le document" name="btnEnvoi" id="btnEnvoi" />
					</p>
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