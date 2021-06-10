<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.jquery/VueCreerGroupe.php : afficher la vue de création d'un groupe par un administrateur
// Ecrit le 03/06/2021 par Baptiste de Bailliencourt

header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Content-Tranfer-Encoding: none');
header('Expires: 0');
?>
<!doctype html>
<html>
	<head>	
		<?php include_once ('vues.jquery/head.php'); ?>
		
		<script>
			<?php if ($typeMessage != '') { ?>
				// associe une fonction à l'événement pageinit
				$(document).bind('pageinit', function() {
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				} );
			<?php } ?>

		</script>
	</head> 
	<body>
		<div data-role="page" id="page_principale">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4><?php echo $titreHeader ?></h4>
				<a href="index.php?action=Menu" data-ajax="false" data-transition="<?php echo $transition; ?>">Retour menu</a>
				<?php include_once 'ReseauxSociaux.php';?>
			</div>
			<div date-role="content">
		<h2>Supprimer un Document</h2>
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
					<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
						<h4>Annuaire des anciens du BTS Informatique<br>Lycée De La Salle (Rennes)</h4>
					</div>
			</div>
		
			<?php include_once ('vues.jquery/dialog_message.php'); ?>
		
	</body>
</html>
				