<link rel="stylesheet" href="histoStyle.css" />

<?php
    include '../../head.php';
?>
<title>
            <?php 
                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    {
                    echo 'ELECTRONET > Historique des paies';
                }
        
                else
                {
                    echo 'ELECTRONET > Pays\' historic';
                }
            ?>
    </title>
<?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 1)
    {
	?>
		<div class="header">

		<p class="logo">
			<a href="../../acc/my" style="text-decoration: none;">
				<img src="../../img/logo.png" alt="Error loading logo.png" />
			</a>

			<span class="cred">
				<a href="../util/params">
					<?php 
						echo $_SESSION['name']; 
					?>
				</a>

				<?php
					//GET AVATAR
					$req = $database->prepare('SELECT avatar FROM users WHERE ID=:ID');

					$req->execute(array(
						'ID' => $_SESSION['ID']
					));

					while ($result = $req->fetch())
					{
						if ($result['avatar'])
						{
							$avatarName = $result['avatar'];
						}
					}
				?>
				<a href="../util/params">
					<img src="<?php echo '../../acc/util/' . $avatarName; ?>" alt="Error loading avatar" class="avatar" />
				</a>
			</span>
		</p>
	
	</div>
	
	<div class="mainLinks">
		<p>
			<?php
				if ($_SESSION['perms'] == 1)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../util/work">TRAVAUX</a> |
							<a href="../util/pay">REVENU</a> |
							<a href="../util/histo" id="current">HISTORIQUE</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}
					
					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../util/work">WORKS</a> |
							<a href="../util/pay">PAY</a> |
							<a href="../util/histo" id="current">HISTORIC</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 2)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../util/estimate">ESTIMATION</a> |
							<a href="../util/work">TRAVAUX</a> |
							<a href="../util/seller">VENTES</a> |
							<a href="../util/pay">REVENU</a> |
							<a href="../util/histo" id="current">HISTORIQUE</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../util/estimate">ESTIMATE</a> |
							<a href="../util/work">WORKS</a> |
							<a href="../util/seller">SELLS</a> |
							<a href="../util/pay">PAY</a> |
							<a href="../util/histo" id="current">HISTORIC</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 3)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../admin/powertool">GESTION</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 4)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../admin/powertool">GESTION</a> |
							<a href="../admin/showRev">REVENUS EMPLOYÉS</a> |
							<a href="../admin/vars">VARIABLES GLOBALES</a> |
							<a href="../util/params">PARAMÈTRES</a>
							
						<?php
					}

					else
					{
						?>

							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../admin/showRev">PAY EMPLOYEES</a> |
							<a href="../admin/vars">GLOBAL VARIABLES</a> |
							<a href="../util/params">SETTINGS</a>

						<?php
					}
				}
			?>
			
		</p>
	</div>

	<div class="content">

		<div class="wrapper">

			
		<?php
			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				?>
					<p class="mainTitle">Historique des paies</p>
				<?php
			}

			else
			{
				?>
					<p class="mainTitle">Pays' Historic</p>
				<?php
			}
		?>

			<div>
				<table>
					<tr>
						<?php
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<th class="columnTitle">
										#
									</th>
									<th class="columnTitle">
										Date
									</th>
									<th class="columnTitle">
										Revenu brut
									</th>
									<th class="columnTitle">
										Impôt fédéral
									</th>
									<th class="columnTitle">
										Impôt provincial
									</th>
									<th class="columnTitle">
										RRQ
									</th>
									<th class="columnTitle">
										RQAP
									</th>
									<th class="columnTitle">
										AE
									</th>
									<th class="columnTitle">
										Revenu net
									</th>
								<?php
							}

							else
							{
								?>
									<th class="columnTitle">
										#
									</th>
									<th class="columnTitle">
										Date
									</th>
									<th class="columnTitle">
										Gross revenue
									</th>
									<th class="columnTitle">
										Federal taxes
									</th>
									<th class="columnTitle">
										Provincial taxes
									</th>
									<th class="columnTitle">
										RRQ
									</th>
									<th class="columnTitle">
										RQAP
									</th>
									<th class="columnTitle">
										AE
									</th>
									<th class="columnTitle">
										Net revenue
									</th>
								<?php
							}
						?>
					</tr>
				<?php
					$req = $database->prepare('SELECT ID, datentime, rev, brut, impotF, impotP, RRQ, RQAPemploye, AEemploye, paid, mailed FROM payeshisto WHERE IDempl=:IDempl ORDER BY ID DESC');
			
					$req->execute(array(
						'IDempl' => $_SESSION['ID']
					));

					$i = 0;
					$total = 0;

					while ($result = $req->fetch())
					{
						if ($result)
						{
						$i++;
						$total = $total + $result['brut'];
							?>
								<tr class="tableLine" style="
									<?php
										if ($result['paid'] == 1)
										{
										?>
											background: lightgreen;
										<?php
										}
									?>
									">

									<td style="padding: 16px; border-right: 2px dashed black;">
										<?php echo $result['ID']; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black;">
										<?php echo $result['datentime']; ?>
									</td>					

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background: lavender;">
										<?php echo round($result['rev'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; background: lightgoldenrodyellow;">
										<?php echo round($result['impotF'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; background: lightgoldenrodyellow;">
										<?php echo round($result['impotP'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; background: lightgoldenrodyellow;">
										<?php echo round($result['RRQ'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; background: lightgoldenrodyellow;">
										<?php echo round($result['RQAPemploye'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; background: lightgoldenrodyellow;">
										<?php echo round($result['AEemploye'],2) . ' $'; ?>
									</td>
									<td style="padding: 16px; border-right: 2px dashed black; color: magenta; background: lavender;">
										<?php echo round($result['brut'],2) . ' $';
											if ($result['paid'] == 1)
											{
												if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													?>
														<span style="color: mediumspringgreen;"><br/>[paie versée]</span>
													<?php
												}

												else
												{
													?>
														<span style="color: mediumspringgreen;"><br/>[pay paid]</span>
													<?php
												}
											}
											
											else
											{
												if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													?>
														<span style="color: indianred;"><br/>[paie en cours de versement]</span>
													<?php
												}

												else
												{
													?>
														<span style="color: indianred;"><br/>[payment being paid]</span>
													<?php
												}
											}

											if ($result['mailed'] == 1)
											{
												if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													?>
														<span style="color: mediumspringgreen;"><br/>[reçu envoyé par courriel]</span>
													<?php
												}

												else
												{
													?>
														<span style="color: mediumspringgreen;"><br/>[receipt sent by email]</span>
													<?php
												}
											}

											else
											{
												if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													?>
														<span style="color: indianred;"><br/>[reçu en cours de création]</span>
													<?php
												}

												else
												{
													?>
														<span style="color: indianred;"><br/>[receipt in creation]</span>
													<?php
												}
											}
										?>
									</td>
								</tr>
							<?php
						}
					}
					?>
				</table>
					<?php
						if ($i == 0)
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<p style="font-weight: bold; margin-bottom: 2%; font-size: 22px;">Aucune paie à relever.</p>
								<?php
							}

							else
							{
								?>
									<p style="font-weight: bold; margin-bottom: 2%; font-size: 22px;">No pay to raise.</p>
								<?php
							}
							
						}

						else
						{	
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<p style="font-weight: bold; font-size: 22px; margin-bottom: 3%;">Total des paies:
										<span style="font-size: 24px; color: darkred;">
											<?php
												echo round($total,2) . ' $';
											?>
										</span>
									</p>

									<p>
										Une question ou un problème concernant votre/vos paie/s ? <a href="../util/help">Faites-nous en part.</a>
									</p>
								<?php
							}

							else
							{
								?>
									<p style="font-weight: bold; font-size: 22px; margin-bottom: 3%;">Total pay:
										<span style="font-size: 24px; color: darkred;">
											<?php
												echo round($total,2) . ' $';
											?>
										</span>
									</p>

									<p>
										A question or a problem concerning your pay(s)? <a href="../util/help">Let us know.</a>
									</p>
								<?php
							}
							
						}
					?>
					
			</div>
		</div>
	</div>

	<footer>
		<div>
			<p>
				<?php 
					if ($_SESSION['lang'] == 'fr')
					{
				?>
						<p class="footContent">
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="terms">Termes et conditions d'utilisation</a> et de notre <a href="privacy">Politique de confidentialité</a>. Tous les copyrights, marques déposées et marques de service appartiennent aux propriétaires respectifs.
							<br />
							Cette page a été générée en français. Pour modifier vos préférences linguistiques, veuillez vous référer aux <a href="params">paramètres</a> de votre compte.
							<br />
							Victime d'un bug ? N'attendez pas et <a href="help">faites-nous en part</a>.
						</p>
						<p class="copyright">
							© <?php echo date('y/m/d'); ?>, DE LAFONTAINE, Charles. ❤️
						</p>


						<?php
					}

					else
					{
						?>

						<p class="footContent">
							Use of this Web site constitutes acceptance of the <a href="terms">Terms and Conditions</a> and <a href="privacy">Privacy policy</a>. All copyrights, trade marks and service marks belong to the corresponding owners.
							<br />
							This page was generated in English. To change your language preferences, please refer to your account's <a href="params">parameters</a>.
							<br />
							Victim of a bug? Do not wait and <a href="help">get in touch with us</a>.	
						</p>
						<p class="copyright">
							© <?php echo date('y/d/m'); ?>, DE LAFONTAINE, Charles. ❤️
						</p>

						<?php
					}
				?>
			</p>
		</div>
	</footer>
	<?php

    }

    else
    {
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{
			$_SESSION['error'] = 'Vous n\'avez pas la permission d\'accéder à ce fichier.';
		}

		else
		{
			$_SESSION['error'] = 'You do not have permission to access this file.';
		}

		header('Location: ../../error');
    }

?>