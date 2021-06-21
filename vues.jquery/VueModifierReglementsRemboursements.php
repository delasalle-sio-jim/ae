<?php
// Projet DLS - BTS Info - Anciens élèves
// Fonction de la vue vues.jquery/VueModifierReglementsRemboursements.php : visualiser la vue de remboursement
// Ecrit le 31/05/2016 par Killian BOUTIN
// Modifié le 14/06/2021 par Baptiste DE BAILLIENCOURT

/* MESSAGE D'ERREUR QUI NE S'AFFICHE PAS, LOGO DE RELOAD EN BOUCLE */
?>
<!doctype html>
<html>
	<head>	
		<?php include_once ('head.php'); ?>
		
		<script>
			<?php if ($typeMessage != '') { ?>
				// associe une fonction à l'événement pageinit
				$(document).bind('pageinit', function() {
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				} );
			<?php } ?>
		</script>
		
	<!-- 
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
																			 $(function() {
																				    var listeEleves  = [ 
																				     <?php /*
																			     	$eleveMails='"';
																					foreach($lesMails as $unMail){ 
																						$eleveMails .= $unMail.'","';
																					 } 
																					 $eleveMails = substr($eleveMails ,0,-2);
																					 echo $eleveMails; */?>	         			    
																					];
																				    $( "#listeEleves" ).autocomplete({
																				      source: listeEleves
																				    });
																				  });
																			</script>		
		 -->
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
		<div data-role="page" id="page_principale">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4><?php echo $titreHeader ?></h4>
				<a href="index.php?action=Menu#menu2" data-ajax="false" data-transition="<?php echo $transition; ?>">Retour menu</a>
				<?php include_once 'ReseauxSociaux.php';?>
			</div>
			<div data-role="content">
				<h4 style="text-align: center;">Mise à jour des réglements et remboursements d'un élève</h4>
				<form action="index.php?action=ModifierReglementsRemboursements" method="post" data-ajax="false">
								
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
								<th>Payé </th>
								<th>Annulé </th>
								<th>Remboursé </th>
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

			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
				<h4>Annuaire des anciens du BTS Informatique<br>Lycée De La Salle (Rennes)</h4>
			</div>
		</div>
		<?php include_once ('vues.jquery/dialog_message.php'); ?>
	</body>
</html>