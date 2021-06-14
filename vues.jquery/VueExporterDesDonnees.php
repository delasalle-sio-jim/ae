<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de le vue la vue vues.jquery/VueExporterDesDonnees.php : traite la demande d'export des données présente dans la table au format .csv
// Ecrit le 02/06/2016 par Killian BOUTIN
// Modifié le 14/06/2021 par Baptiste DE BAILLIENCOURT

// pour obliger la page à se recharger
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
				<a href="index.php?action=Menu#menu2" data-ajax="false" data-transition="<?php echo $transition; ?>">Retour menu</a>
				<?php include_once 'ReseauxSociaux.php';?>
			</div>
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Exportation des données</h4>
				<form action="index.php?action=ExporterDesDonnees" method="post" data-ajax="false" >
													
					<input type="submit" name="btnPDF" id="btnPDF" value="Télécharger la liste d'inscription">
					<br></br>
					<input type="submit" name="btnCSV" id="btnCSV" value="Exporter les élèves">	
					
				</form>				
			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
				<h4>Annuaire des anciens du BTS Informatique<br>Lycée De La Salle (Rennes)</h4>
			</div>
		</div>
		
		<?php include_once ('vues.jquery/dialog_message.php'); ?>
	</body>
</html>