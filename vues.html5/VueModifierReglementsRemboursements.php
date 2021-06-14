<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.html5/VueModifierReglementsRemboursements.php : voir la liste des inscrits afin de mettre à jour ceux qui ont payés ou ceux qu'il f
// Ecrit le 6/1/2016 par Nicolas Esteve
// Modifié le 31/05/2016 par Killian BOUTIN
// Modifié le 10/06/2016 par Baptiste de Bailliencourt

?>
<!doctype html>
<html>
<head>	
	<?php include_once ('head.php');?>
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
			<h2>Liste des inscrits à la prochaine soirée des anciens</h2>
			
			<form name="form1" id="form1" action="index.php?action=ModifierReglementsRemboursements" method="post">
			
			<h3 class="titre_inscription"><?php echo $titre ?></h3>
			

				<?php
				
				/* si le nombre d'inscrit n'est pas égal à 0 */
				if ($nombreInscrits != 0 ){
					/* création de la première ligne dans le tableau */
					?>
					
					<table class="tableau inscription inscriptionAdmin">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Nb pers.</th>
								<th>Promotion</th>
								<th>Mt réglé</th>
								<th>Mt remboursé</th>
								<th>Reste dû</th>
								<th>Payé ?</th>
								<th>Annulé ?</th>
								<th>Remboursé ?</th>
							</tr>
						</thead>
						
					<?php
				
					/* pour chaque $uneInscription de la collection $lesInscriptions */
					foreach ($lesInscriptions as $uneInscription)
					{
						/*obtention du montant à régler puis du montant total à regler */
						$montantRegle = $uneInscription->getMontantRegle();
						$montantTotalRegle += $montantRegle;
						
						/* obtention du montant remboursé puis du montant total remboursé */
						$montantRembourse = $uneInscription->getMontantRembourse();
						$montantTotalRembourse += $montantRembourse;
						
						/* obtention du coût total à payer puis du montant final */
						$coutTotal = $uneInscription->getTarif() * $uneInscription->getNbrePersonnes() - ($montantRegle + $montantRembourse);
						if ($coutTotal <=0)
						    $coutTotal =0;
						$montantTotalFinal += $coutTotal;

						/* on formate les nombres au format français */
						$montantRegle = number_format($uneInscription->getMontantRegle(), 2, ',', ' ');
						$montantRembourse = number_format($uneInscription->getMontantRembourse(), 2, ',', ' ');
						$coutTotal = number_format($coutTotal, 2, ',', ' ');
						
						/* création d'une ligne du tableau */
						?>
						
						<tr>
							
							<td><?php echo $uneInscription->getNom() . " " . $uneInscription->getPrenom() ?></td>
							<td><?php echo $uneInscription->getNbrePersonnes() ?></td>
							<td><?php echo $uneInscription->getAnneeDebutBTS() ?></td>
							<td><?php echo $montantRegle ?> €</td>
							<td><?php echo $montantRembourse ?> €</td>
							<td><?php echo $coutTotal ?> €</td>
							<?php if(($uneInscription->getMontantRegle() ) == ( $unTarif * $uneInscription->getNbrePersonnes()))
                                    {
                                   
                                        $inscriptionPayee = 'on';
                            
                                    }
                                    else           
                                        $inscriptionPayee = 'off';
                                    if($uneInscription->getInscriptionAnnulee() == 1)
                                    {
                                        $inscriptionAnnulee = 'on';
                                    }
                                    else 
                                        $inscriptionAnnulee = 'off';
                                    if($uneInscription->getMontantRembourse() == ( $unTarif * $uneInscription->getNbrePersonnes()))
                                    {
                                        $inscriptionRemboursee = 'on';
                                    }
                                    else 
                                        $inscriptionRemboursee = 'off';
                                    ?>
							<td><input type="checkbox" name="Paye[]" value=<?php echo $uneInscription->getId()?> <?php if ($inscriptionPayee == 'on') echo 'checked'; ?>></td>
							<td><input type="checkbox" name="Annule[]" value=<?php echo $uneInscription->getId()?> <?php if ($inscriptionAnnulee == 'on') echo 'checked'; ?>></td>
							<td><input type="checkbox" name="Rembourse[]" value=<?php echo $uneInscription->getId()?> <?php if ($inscriptionRemboursee == 'on') echo 'checked'; ?>></td>
						</tr>
						
						<?php
						/* ajout du nombre d'inscrits de cet enregistrement au nombre total d'inscrits */
						$nombreInscritsTotal += $uneInscription->getNbrePersonnes();
	
					} 
					
						/* on formate les nombres au format français */
						$montantTotalRegle = number_format($montantTotalRegle, 2, ',', ' ');
						$montantTotalRembourse = number_format($montantTotalRembourse, 2, ',', ' ');
						$montantTotalFinal = number_format($montantTotalFinal, 2, ',', ' ');
						
						?>
						<tr>
							<td>Total</td>
							<td><?php echo $nombreInscritsTotal ?> pers.</td>
							<td>-</td>
							<td><?php echo $montantTotalRegle ?> €</td>
							<td><?php echo $montantTotalRembourse ?> €</td>
							<td><?php echo $montantTotalFinal ?> €</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
					</table>
					<p>
			<input type="submit" name="btnMaj" id="btnMaj" value="Mettre à jour les informations">
			</p>
				<?php 
				}
				?>
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
