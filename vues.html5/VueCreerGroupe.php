<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueCreerGroupe.php : afficher la vue de création d'un groupe de documents sur le portail
// Ecrit le 08/06/2021 par Baptiste de Bailliencourt
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
			 		
			<h2>Création d'un groupe de documents</h2>
			
			<h3>Entrez le nom de votre groupe :</h3>
			
			<form name="form1" id="form1" action="index.php?action=CreerGroupe" method="post">

				<p>
					<label for="txtNom">Nom du groupe * :</label>
					<input type="text" name="txtNom" id="txtNom" maxlength="100" required=true/>

				</p>						
				<p>
					<input type="submit" value="Créer le groupe" name="btnEnvoyer" id="btnEnvoyer" />
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