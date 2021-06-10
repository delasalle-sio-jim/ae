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
			<div data-role="content">
		<h2>Modifier un document</h2>
		<form name="form1" id="form1" action="index.php?action=ModifierDocument" method="post">				
		
				<?php if($etape == 0){ ?>
				
				<div class="ui-widget">
				<p>
					 <label for="listeGroupes">Le document à modifier :</label>
					
					<select size="1" name="listeDocuments" id="listeDocuments">
					<option value="0" <?php if ($idDocument == '') echo 'selected'; ?> >-- Indiquez le document --</option>

					<?php foreach ($lesDocuments as $unDocument) { ?>
							<option value="<?php echo $unDocument->getId(); ?>" <?php if ($idDocument == $unDocument->getId()) echo 'selected="selected"'; ?>><?php echo $unDocument->getNomSurBouton(); ?></option>
					<?php } ?>				
					</select>
				</p>
					
				<p>
					<input type="submit" name="btnDetail" id="btnDetail" value="Obtenir les détails">
				</p>	
				</div>

				<?php } else
				{?>
				
				<p>
					<label for="txtBouton">Nom du bouton correspondant * :</label>
					<input type="text" name="txtBouton" id="txtBouton" maxlength="30" required value="<?php echo $unNom; ?>" />
				</p>
				<p>
				<label for="listeGroupes">Le groupe du document :</label>
					
					<select size="1" name="listeGroupes" id="listeGroupes">
					<option value="0" <?php if ($idGroupe == '') echo 'selected'; ?> >-- Indiquez le groupe --</option>

					<?php foreach ($lesGroupes as $unGroupe) { ?>
							<option value="<?php echo $unGroupe->getId(); ?>" <?php if ($idGroupe == $unGroupe->getId()) echo 'selected="selected"'; ?>><?php echo $unGroupe->getNomGroupe(); ?></option>
					<?php } ?>				
					</select>	
				</p>
				<p>
							<label for="fileDocument">Remplacer le fichier par :</label>
							<input type="file" name="fileDocument" id="fileDocument" required style="border: 0px; margin-left: 0px;">
				</p>															
				<p>
					<input type="submit" value="Envoyer les données" name="btnEnvoyer" id="btnEnvoyer" />
				</p>
				<?php }?>	
		</form>
		</div>
					<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
						<h4>Annuaire des anciens du BTS Informatique<br>Lycée De La Salle (Rennes)</h4>
					</div>
			</div>
		
			<?php include_once ('vues.jquery/dialog_message.php'); ?>
		
	</body>
</html>
				