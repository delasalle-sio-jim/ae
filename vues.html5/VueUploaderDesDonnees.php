<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueUploaderDesDonnées : afficher le formulaire de modification des infos sur la soirée
// Ecrit le 01/06/2016 par Killian BOUTIN
// Modifié le 04/10/2016 par Killian BOUTIN
?>
<!doctype html>
<html>
<head>	
	<?php include_once ('head.php'); ?>
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
					<li><a href="index.php?action=Menu#menu2" data-ajax="false">Retour menu</a></li>
					<?php include_once 'ReseauxSociaux.php';?>
				</ul>
			</div>
			<div id="header-logos">
				<img src="images/Logo_DLS.png" id="logo-gauche" alt="Lycée De La Salle (Rennes)" />
				<img src="images/Intitules_bts_ig_sio.png" id="logo-droite" alt="BTS Informatique" />
			</div>
		</div>
			
		<div id="content">
			<h2>Uploader les données au format .docx</h2>
			
			<h3>Sélectionnez les données à uploader :</h3>
			
			<form name="form1" id="form1" action="index.php?action=UploaderDesDonnees" method="post">
			
					<h2>Documents destinés aux stagiaires SIO1</h2>
			<div id="pages">
				<p><a href="documents/consignes_etudiants_stage_SIO1.docx" class="petit-bouton-menu">Consignes aux étudiants pour le stage SIO1 (format Word)</a></p>
				<p><a href="documents/infos_tuteur_stage_SIO1.docx" class="petit-bouton-menu">Informations pour le maître de stage SIO1 (format Word)</a></p>
				<p><a href="documents/CR_SIO1_Prenom_Nom_semaine_X.docx" class="petit-bouton-menu">Compte rendu hebdomadaire du stagiaire (format Word)</a></p>
				<p><a href="documents/AttestationDeStage2021_SIO1.docx" class="petit-bouton-menu">Attestation de stage SIO1 pour <?php echo date('Y') ?> (format Word)</a></p>
			</div>

			<h2>Documents destinés aux stagiaires SIO2</h2>
			<div id="pages">
				<p><a href="documents/consignes_etudiants_stage_SIO2.docx" class="petit-bouton-menu">Consignes aux étudiants pour le stage SIO2 (format Word)</a></p>
				<p><a href="documents/infos_tuteur_stage_SIO2.docx" class="petit-bouton-menu">Informations pour le maître de stage SIO2 (format Word)</a></p>
				<p><a href="documents/CR_SIO2_Prenom_Nom_semaine_X.docx" class="petit-bouton-menu">Compte rendu hebdomadaire du stagiaire (format Word)</a></p>
				<p><a href="documents/AttestationDeStage2021_SIO2.docx" class="petit-bouton-menu">Attestation de stage SIO2 pour <?php echo date('Y') ?> (format Word)</a></p>
			</div>
					
					<input type="submit" name="btnUploader" id="btnUploader" value="Téléverser">
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