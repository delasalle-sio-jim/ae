<?php
	// Projet DLS - BTS Info - Anciens élèves
	// Fonction de la vue vues.html5/VueVoirPhotos.php : afficher la vue de la galerie
	// Ecrit le 15/06/2016 par Killian BOUTIN 
?>
<!doctype html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="screen" href="vues.html5/styleGalerie.css" />
	<link rel="stylesheet" type="text/css" href="fancybox.galerie/jquery.fancybox-1.3.4.css" media="screen" />
	
	<!-- Inclure jQuery -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	
	<!-- Inclure le script de la fancybox -->
	<script type="text/javascript" src="js.galerie/jquery.fancybox-1.3.4.pack.js"></script>
	
	<script type="text/javascript">
	
		/* on zoom sur l'élément sélectionné grâce à une "fancybox" */
		$(document).ready(function() {

			$("a#fancybox").fancybox({
				openEffect	: 'elastic',
				closeEffect	: 'elastic',

				helpers : {
					title : {
						type : 'inside'
					}
				}
			});

		});
	</script>
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

		function voirPhotos() {
			window.location.href="index.php?action=Menu";
		}
	</script>
	<script type="text/javascript">

		// Cette fonction permet de scroller la page vers l'ancre choisie par l'utilisateur
		function voirPhotos() {
			var id = document.getElementById('txtAnnee').value;
			window.location.href="#" + id;
		}
	</script>
</head>

<body>
	<div id="page">
		<div id="content">
			<h3 style= "margin-left:12px;" id="top"><i>Galerie photo des anciens étudiants :</i></h3>
			
			<h5 style= "margin: -12px 0px 2px 12px; ">Indiquez votre année d'arrivée :</h4>
			<!-- Quand on valide le formulaire avec le bouton ou si on clique sur "entrée" -->
			<input type="number" name = "txtAnnee" id= "txtAnnee" style = "margin-left: 12px; " onKeyPress="if (event.keyCode == 13) voirPhotos()">
			<input type="submit" value="Aller" onclick="voirPhotos()" ><br>
			
			<div id="works">
				<?php 

				/* Pour chaque image de la collection */
				foreach ($lesImages as $uneImage){
					
					$promo = $uneImage->getPromo() . "-" . ($uneImage->getPromo() + 1);
					
					/* On regarde si l'année est différente de celle de la photo d'avant */
					if($annee != $uneImage->getPromo()) {
						echo "<div style=\"width: 2000px; overflow:hidden;\"></div>";
					}
					
					if ($annee <= '2011'){
						$classe = "IG";
					}
					else{
						$classe = "SIO";
					}
					
					/* On change l'année */
					$annee = $uneImage->getPromo();
					
					if ($uneImage->getClasse() == 1)
						$classe .= "1";
					elseif ($uneImage->getClasse() == 2 )
						$classe .= "2";
					elseif ($uneImage->getClasse() == 3 )
						$classe = "Post-BTS";
					else $classe = "Année X"; ?>
					
					<a href = "#top" id="toTop" > Haut ↑ </a>
					<a title= "Photo de la classe <?php echo $classe . ", promotion " . $promo ?>" id="fancybox" href="photos.initiales/<?php echo $uneImage->getLien() ?>">
					<div class="work" id="<?php echo $uneImage->getPromo() ?>">
					 
						<img src="photos.700/<?php echo $uneImage->getLien() ?>" />
						<div class="triangle-gauche"></div><!-- .triangle-gauche -->
						<div class="triangle-droite"></div><!-- .triangle-droite -->
						<span><?php echo $promo . " " . $classe ?> </span>
					 
					</div><!-- .work -->
					</a>
				<?php } ?>
  			</div><!-- #works -->
		</div>
	</div>
	
</body>
</html>