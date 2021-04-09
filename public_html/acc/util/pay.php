
<link rel="stylesheet" href="payStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
	    {
            echo 'ELECTRONET > Paie';
        }

        else
        {
            echo 'ELECTRONET > Pay';
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
							<a href="../util/pay" id="current">REVENU</a> |
							<a href="../util/histo">HISTORIQUE</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../util/work">WORKS</a> |
							<a href="../util/pay" id="current">PAY</a> |
							<a href="../util/histo">HISTORIC</a> |
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
							<a href="../util/pay" id="current">REVENU</a> |
							<a href="../util/histo">HISTORIQUE</a> |
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
							<a href="../util/pay" id="current">PAY</a> |
							<a href="../util/histo">HISTORIC</a> |
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
				include '../../cur.php';

        //IF USER IS A WORKER
        if ($_SESSION['perms'] > 0)
        {
			$req = $database->prepare('SELECT contractNum, cutWorker, bns, datentime FROM payescurr WHERE IDworker=:IDworker AND payWorker=:payWorker AND hide=:hide ORDER BY contractNum DESC');
			
			$req->execute(array(
				'IDworker' => $_SESSION['ID'],
				'payWorker' => true,
				'hide' => false
			));
		?>
			<span>
				<?php
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p style="margin-top: 0;">
								Mes travaux
							</p>

							</span>

							<table>
								<tr>
									<th class="columnTitle">
										Contrat
									</th>

									<th class="columnTitle">
										Revenu
									</th>

									<th class="columnTitle">
										Bonus
									</th>

									<th class="columnTitle">
										Derni&#xE8;re v&#233;rification
									</th>
								</tr>
						<?php
					}

					else
					{
						?>
							<p style="margin-top: 0;">
								My Works
							</p>

							</span>

							<table>
								<tr>
									<th class="columnTitle">
										Contract
									</th>

									<th class="columnTitle">
										Revenue
									</th>

									<th class="columnTitle">
										Bonus
									</th>

									<th class="columnTitle">
										Last verification
									</th>
								</tr>
						<?php
					}
				?>

			<?php
				while ($result = $req->fetch())
				{
					$count++;
					$total = $total + $result['cutWorker'] + $result['bns'];
					$total = round($total, 2);

			?>
    
				<tr class="tableLine">
					<td style="padding: 8px;">
						<?php echo '#' . $result['contractNum']; ?>
					</td>
					<td style="padding: 8px;">
						<?php echo round($result['cutWorker'], 2) . ' $'; ?>
					</td>
					<td style="padding: 8px;">
						<?php echo round($result['bns'], 2) . ' $'; ?>
					</td>
					<td style="padding: 8px;">
						<?php
							$nb = (time() - $result['datentime']) / 86400;
							$nb = round($nb, 0);

							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								if ($nb > 1)
								{
									echo $nb . ' jours';
								}

								else
								{
									echo $nb . ' jour';
								}
							}

							else
							{
								if ($nb > 1)
								{
									echo $nb . ' days';
								}

								else
								{
									echo $nb . ' day';
								}
							}
						?>
					</td>
				</tr>
                    <?php
                }
            ?>
            </table>

			<table style="margin-top: -4%; border-left:2px dashed black; border-bottom: 2px dashed black; border-right: 2px dashed black;">
                <tr>

					<?php
						if ($count >= 2)
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
										Travaux r&#233;alis&#233;s
									</th>
								<?php
							}

							else
							{
								?>
									<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
										Finished works
									</th>
								<?php
							}
						}
						
						else
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
										Travail r&#233;alis&#233;
									</th>
								<?php
							}

							else
							{
								?>
									<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
										Finished work
									</th>
								<?php
							}
							
						}
					
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
		                        Revenu total
		                    </th>

		                    </tr>

			                <tr>
			                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
			                        <?php echo $count; ?>
			                    </td>
			                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
			                        <?php echo $total . ' $'; ?>
			                    </td>
			                </tr>
						<?php
					}

					else
					{
						?>
							<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
		                        Total revenue
		                    </th>

		                    </tr>

			                <tr>
			                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
			                        <?php echo $count; ?>
			                    </td>
			                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
			                        <?php echo '$ ' . $total; ?>
			                    </td>
			                </tr>
						<?php
					}
				?>

                    
                
            </table>
		<?php

		//IF NO CONTRACT HAS BEEN VALIDATED
            if ($count == 0)
            {
            	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					?>
	                <p style="font-family: 'Blinker', sans-serif; font-size: 20px; text-align: center; margin-top: 2%; margin-bottom: 1%; margin-right: 20%; margin-left: 20%;">Aucune paie &#xE0; afficher, car aucun travail accompli. Il se peut qu'une ou plusieurs production/s est/sont en cours de confirmation.</p>
	            <?php
				}

				else
				{
					?>
	                <p style="font-family: 'Blinker', sans-serif; font-size: 20px; text-align: center; margin-top: 2%; margin-bottom: 1%; margin-right: 20%; margin-left: 20%;">No pay to display, because no work done. It is possible that one or more production(s) is/are being confirmed.</p>
	            <?php
				}
            
            }
        }


        //IF USER IS A SELLER
        if ($_SESSION['perms'] > 1)
        {
		?>
			<div style="margin-top: 2%; margin-bottom: -3%;">
				<p style="border: 1px solid black;"></p>
			</div>
		<?php
            $seek = $database->prepare('SELECT contractNum, cut, datentime FROM payescurr WHERE IDseller=:IDseller AND paySeller=:paySeller AND hide=:hide ORDER BY contractNum DESC');

            $seek->execute(array(
                'IDseller' => $_SESSION['ID'],
				'paySeller' => true,
				'hide' => false
                ));
?>
            <span>
            	<?php
            		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p>
			                    Mes ventes
			                </p>
						<?php
					}

					else
					{
						?>
							<p>
			                    My Sells
			                </p>
						<?php
					}
            	?>
                
            </span>

            <table>
            	<?php
            		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<tr>
			                    <th class="columnTitle">
			                        Contrat
			                    </th>

			                    <th class="columnTitle">
			                        Revenu
			                    </th>

			                    <th class="columnTitle">
			                        Derni&#xE8;re v&#233;rification
			                    </th>
			                </tr>
						<?php
					}

					else
					{
						?>
							<tr>
			                    <th class="columnTitle">
			                        Contract
			                    </th>

			                    <th class="columnTitle">
			                        Revenue
			                    </th>

			                    <th class="columnTitle">
			                        Last verification
			                    </th>
			                </tr>
						<?php
					}

                while ($res = $seek->fetch())
                {
                    $increment++;
                    $tot = $tot + $res['cut'];
					$tot = round($tot, 2);

                    ?>
                    
                        <tr class="tableLine">
                            <td style="padding: 8px;">
                                <?php echo '#' . $res['contractNum']; ?>
                            </td>
                            <td style="padding: 8px;">
                                <?php echo round($res['cut'], 2) . ' $'; ?>
                            </td>

                            <td style="padding: 8px;">
                                <?php
                                    $nb = (time() - $res['datentime']) / 86400;
                                    $nb = round($nb, 0);

                                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										if ($nb > 1)
	                                    {
	                                        echo $nb . ' jours';
	                                    }

	                                    else
	                                    {
	                                        echo $nb . ' jour';
	                                    }
									}

									else
									{
										if ($nb > 1)
	                                    {
	                                        echo $nb . ' days';
	                                    }

	                                    else
	                                    {
	                                        echo $nb . ' day';
	                                    }
									}
                                    
                                ?>
                            </td>
                        </tr>
                    <?php
                }
                    ?>
            </table>

            <table style="margin-top: -4%; border-left:2px dashed black; border-bottom: 2px dashed black; border-right: 2px dashed black;">
                <tr>

					<?php
						if ($increment >= 2)
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
								<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
									Ventes r&#233;alis&#233;es
								</th>
							<?php
							}

							else
							{
								?>
								<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
									Finished sells
								</th>
							<?php
							}
							
						}
						
						else
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
								<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
									Vente r&#233;alis&#233;e
								</th>
							<?php
							}

							else
							{
								?>
								<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
									Finished sell
								</th>
							<?php
							}
							
						}
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
                        Revenu total
                    </th>
						<?php
					}

					else
					{
						?>
							<th style="text-decoration: underline; font-size: 18px; padding: 10px; text-align: center; font-weight: initial; font-family: 'Blinker', sans-serif;">
                        Total revenue
                    </th>
						<?php
					}
               	?>

                </tr>

                <tr>
                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
                        <?php echo $increment; ?>
                    </td>
                    <td style="font-size: 20px; padding-bottom: 20px; color: mediumseagreen;">
                        <?php echo $tot . ' $'; ?>
                    </td>
                </tr>
            </table>
            <?php

            //IF NO CONTRACT HAS BEEN VALIDATED
            if ($increment == 0)
            {
            	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					?>
	                <p style="font-family: 'Blinker', sans-serif; font-size: 20px; text-align: center; margin-top: 2%; margin-bottom: 1%; margin-right: 20%; margin-left: 20%;">Aucune paie &#xE0; afficher, car aucune vente acquittée. Il se peut qu'une ou plusieurs vente/s est/sont en cours de v&#233;rification.</p>
	            <?php
				}

				else
				{
					?>
                <p style="font-family: 'Blinker', sans-serif; font-size: 20px; text-align: center; margin-top: 2%; margin-bottom: 1%; margin-right: 20%; margin-left: 20%;">No pay to display, because no sell done. It is possible that one or more sell(s) is/are being verified.</p>
            <?php
				}
            }
        }

		if ($_SESSION['perms'] > 0)
		{	
			//INITIATING VAR
			$total = 0;

			//GRAB WORKER STATS
			$req = $database->prepare('SELECT cutWorker, bns FROM payescurr WHERE IDworker=:IDworker AND payWorker=:payWorker AND hide=:hide');

			$req->execute(array(
				'IDworker' => $_SESSION['ID'],
				'payWorker' => true,
				'hide' => false
			));

			while ($result = $req->fetch())
			{
				if ($result)
				{
					$total = $total + $result['cutWorker'] + $result['bns'];
				}
			}

			//GRAB SELLER STATS
			$req = $database->prepare('SELECT cut FROM payescurr WHERE IDseller=:IDseller AND paySeller=:paySeller AND hide=:hide');

			$req->execute(array(
				'IDseller' => $_SESSION['ID'],
				'paySeller' => true,
				'hide' => false
			));

			while ($result = $req->fetch())
			{
				if ($result)
				{
					$total = $total + $result['cut'];
					$total = round($total, 2);
				}
			}

			if ($total != 0)
			{
				?>
					<div style="margin-top: -2%; margin-bottom: 4%;">
						<p>
							<?php
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<span style="text-decoration: underline;">Prochaine paie:</span>
									<br />
									<span style="color: magenta; font-size: 24px;"><?php echo $total . ' $'; ?></span>
								<?php
							}

							else
							{
								?>
									<span style="text-decoration: underline;">Next pay:</span>
									<br />
									<span style="color: magenta; font-size: 24px;"><?php echo '$ ' . $total; ?></span>
								<?php
							}
							?>
							
						</p>
					</div>
				<?php
			}
		}
		?>
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