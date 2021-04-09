
<link rel="stylesheet" href="showRevStyle.css" />

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

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] == 4)
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
	
	<?php
		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
        	?>
        		<div class="mainLinks">
					<p>
						<a href="../../acc/my">ACCUEIL</a> |
						<a href="../admin/powertool">GESTION</a> |
						<a href="../admin/showRev" id="current">REVENUS EMPLOYÉS</a> |
						<a href="../admin/vars">VARIABLES GLOBALES</a> |
						<a href="../util/params">PARAMÈTRES</a>				
					</p>
				</div>
        	<?php
        }

        else
        {
        	?>
        		<div class="mainLinks">
					<p>
						<a href="../../acc/my">HOME</a> |
						<a href="../admin/powertool">MANAGEMENT</a> |
						<a href="../admin/showRev" id="current">PAY EMPLOYEES</a> |
						<a href="../admin/vars">GLOBAL VARIABLES</a> |
						<a href="../util/params">SETTINGS</a>				
					</p>
				</div>
        	<?php
        }
	?>
	

	<div class="content">

		<div class="wrapper">
			<?php
				include '../../cur.php';

			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
        		?>
        			<p class="mainTitle">
						Historique des paies
					</p>
        		<?php
        	}

        	else
        	{
        		?>
        			<p class="mainTitle">
						Pays' Historic
					</p>
        		<?php
        	}

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
			if (isset($_POST['updatePay']) && $_POST['updatePay'])
			{
				//GRABING USER'S PAYCHECK
				//CHECKING MAXIMUM USER ID POSSIBLE	
				$req = $database->prepare('SELECT IDseller, IDworker FROM payescurr WHERE hide=:hide');
				$req->execute(array(
					'hide' => 0
				));

				while ($result = $req->fetch())
				{
					if ($result)
					{
						if ($result['IDseller'] > $maxID)
						{
							$maxID = $result['IDseller'];
						}

						if ($result['IDworker'] > $maxID)
						{
							$maxID = $result['IDworker'];
						}
					}
				}

				//RETRIEVE tStamp
				$day = date('j');

				if ($day == 1 || $day == 21 || $day == 31)
				{
					$print = 'st';
				}

				else if ($day == 2 || $day == 22)
				{
					$print = 'nd';
				}

				else if ($day == 3 || $day == 23)

				{
					$print = 'rd';
				}

				else
				{
					$print = 'th';
				}

				$tStamp = date('l, F j') . $print . ', ' . date('Y') . ' (' . date('d/m/y') . ')' . ' @ ' . date('G') . 'h, ' . date('i') . 'min, ' . date('s') . 's ' . date('T');

				for ($i = 0; $i < $maxID + 1; $i++) //$i fetching all IDempl possibilities
				{
					$total = 0;

					$req = $database->prepare('SELECT cut, cutWorker, bns, hide, IDseller, IDworker FROM payescurr WHERE IDseller=:IDseller OR IDworker=:IDworker');
					$req->execute(array(
						'IDseller' => $i,
						'IDworker' => $i
					));

					while ($result = $req->fetch())
					{
						if ($result['hide'] == 0)
						{
							if ($result['IDseller'] == $i)
							{
								$total = $total + $result['cut'];
							}

							if ($result['IDworker'] == $i)
							{
								$total = $total + $result['cutWorker'] + $result['bns'];
							}

							$impotF = $_SESSION['impotF'] * $total;
							$impotP = $_SESSION['impotF'] * $total;
							$RRQ = $_SESSION['RRQ'] * $total;
							$RQAPemploye = $_SESSION['RQAPemploye'] * $total;
							$RQAPemployeur = $_SESSION['RQAPemployeur'] * $total;
							$AEemploye = $_SESSION['AEemploye'] * $total;
							$AEemployeur = $_SESSION['AEemployeur'] * $total;
							$CST = $_SESSION['CST'] * $total;
							$CNESSTemployeur = $_SESSION['CNESSTemployeur'] * $total;
							$FSS = $_SESSION['FSS'] * $total;

							$req = $database->prepare('SELECT removeImpot FROM users WHERE ID=:ID');
							$req->execute(array(
								'ID' => $i
							));

							while ($result = $req->fetch())
							{
								if ($result['removeImpot'] == 0)
								{
									$brut = $total - $impotF - $impotP - $RRQ - $RQAPemploye - $AEemploye;
								}

								else if ($result['removeImpot'] == 1)
								{
									$brut = $total - $RRQ - $RQAPemploye - $AEemploye;
								}
							}

							$costEmployer = $RRQ + $RQAPemployeur + $AEemployeur + $CST + $CNESSTemployeur + $FSS;

							//NOW INSERT PAY HISTO
							$req = $database->prepare('INSERT INTO payeshisto(IDempl, datentime, rev, brut, impotF, impotP, RRQ, RQAPemploye, RQAPemployeur, AEemploye, AEemployeur, CNESSTemployeur, CST, FSS, costEmployer) VALUES(:IDempl, :datentime, :rev, :brut, :impotF, :impotP, :RRQ, :RQAPemploye, :RQAPemployeur, :AEemploye, :AEemployeur, :CNESSTemployeur, :CST, :FSS, :costEmployer)');
				
							$req->execute(array(
								'IDempl' => $i,
								'datentime' => $tStamp,
								'rev' => $total, //REV BRUT
								'brut' => $brut,
								'impotF' => $impotF,
								'impotP' => $impotP,
								'RRQ' => $RRQ,
								'RQAPemploye' => $RQAPemploye,
								'RQAPemployeur' => $RQAPemployeur,
								'AEemploye' => $AEemploye,
								'AEemployeur' => $AEemployeur,
								'CNESSTemployeur' => $CNESSTemployeur,
								'CST' => $CST,
								'FSS' => $FSS,
								'costEmployer' => $costEmployer
							));
						}
					}
				}

				$req = $database->prepare('UPDATE payescurr SET hide=:hide');

				$req->execute(array(
					'hide' => 1
				));

				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					$_SESSION['curSuc'] = 'Employés payés.';
					header('Location: showRev');
				}

				else
				{
					$_SESSION['curSuc'] = 'Employees paid.';
					header('Location: showRev');
				}
				
			}

			if (isset($_POST['numPaie']) && isset($_POST['completed']) && $_POST['completed'])
			{
				$num = test_input($_POST['numPaie']);
				
				if (is_numeric($num))
				{
					$req = $database->prepare('SELECT paid FROM payeshisto WHERE ID=:ID');
					
					$req->execute(array(
						'ID' => $num
					));

					while ($result = $req->fetch())
					{
						if ($result)
						{
							break;
						}
					}

					if ($result['paid'] == 0)
					{
						$req = $database->prepare('UPDATE payeshisto SET paid=:paid WHERE ID=:ID');
					
						$req->execute(array(
							'paid' => 1,
							'ID' => $num
						));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = 'Paie #' . $num . ' modifiée avec succès.';
							header('Location: showRev');
						}

						else
						{
							$_SESSION['curSuc'] = 'Pay #' . $num . ' successfully modified.';
							header('Location: showRev');
						}
					}

					else if ($result['paid'] == 1)
					{
						$req = $database->prepare('UPDATE payeshisto SET paid=:paid WHERE ID=:ID');
					
						$req->execute(array(
							'paid' => 0,
							'ID' => $num
						));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = 'Paie #' . $num . ' modifiée avec succès.';
							header('Location: showRev');
						}

						else
						{
							$_SESSION['curSuc'] = 'Pay #' . $num . ' successfully modified.';
							header('Location: showRev');
						}
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = '# de paie inconnu.';
							header('Location: showRev');
						}
						
						else
						{
							$_SESSION['curErr'] = 'Unknown pay #.';
							header('Location: showRev');
						}
					}
				}

				else
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = '# de paie invalide.';
						header('Location: showRev');
					}
						
					else
					{
						$_SESSION['curErr'] = 'Invalid pay #.';
						header('Location: showRev');
					}
				}
			}

			if (isset($_POST['numPaie']) && isset($_POST['sent']) && $_POST['sent'])
			{
				$num = test_input($_POST['numPaie']);
				
				if (is_numeric($num))
				{
					$req = $database->prepare('SELECT mailed FROM payeshisto WHERE ID=:ID');
					
					$req->execute(array(
						'ID' => $num
					));

					while ($result = $req->fetch())
					{
						if ($result)
						{
							break;
						}
					}

					if ($result['mailed'] == 0)
					{
						$req = $database->prepare('UPDATE payeshisto SET mailed=:mailed WHERE ID=:ID');
					
						$req->execute(array(
							'mailed' => 1,
							'ID' => $num
						));
						
						$_SESSION['sendReceipt'] = 1;

						$req = $database->prepare('SELECT IDempl, datentime, rev, brut, impotF, impotP, RRQ, RQAPemploye, AEemploye FROM payeshisto WHERE ID=:ID');
						
						$req->execute(array(
							'ID' => $num
						));

						while ($result = $req->fetch())
						{
							if ($result)
							{
								$_SESSION['AEemployeReceiver'] = $result['AEemploye'];
								$_SESSION['RQAPemployeReceiver'] = $result['RQAPemploye'];
								$_SESSION['RRQReceiver'] = $result['RRQ'];
								$_SESSION['impotPReceiver'] = $result['impotP'];
								$_SESSION['impotFReceiver'] = $result['impotF'];
								$_SESSION['brutReceiver'] = $result['brut'];
								$_SESSION['revReceiver'] = $result['rev'];
								$_SESSION['datentimeReceiver'] = $result['datentime'];
								$_SESSION['receiptReceiver'] = $result['IDempl'];

								$req = $database->prepare('SELECT name, email FROM users WHERE ID=:ID');
								
								$req->execute(array(
									'ID' => $_SESSION['receiptReceiver']
								));

								while ($result = $req->fetch())
								{
									if ($result)
									{
										$_SESSION['receiverName'] = $result['name'];
										$_SESSION['receiverEmail'] = $result['email'];
									}
								}

								break;
							}
						}
						
						header('Location: ../../sendReceipt.php');
					}

					else if ($result['mailed'] == 1)
					{
						$req = $database->prepare('UPDATE payeshisto SET mailed=:mailed WHERE ID=:ID');
					
						$req->execute(array(
							'mailed' => 0,
							'ID' => $num
						));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = 'Paie #' . $num . ' modifiée avec succès.';
							header('Location: showRev');
						}

						else
						{
							$_SESSION['curSuc'] = 'Pay #' . $num . ' successfully modified.';
							header('Location: showRev');
						}
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = '# de paie inconnu.';
						}
						
						else
						{
							$_SESSION['curErr'] = 'Unknown pay #.';
						}
					}
				}
			}
        }

		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
    	{
    		?>
    			<div>
					<form target="" method="post">
						<input type="submit" name="updatePay" value="Payer les employés">
					</form>
				</div>

				<div>
					<form id="paid" target="" method="post">
						<input type="text" name="numPaie" placeholder="#" value="" />
						<input type="submit" name="completed" value="Versé">
						<input type="submit" name="sent" value="Reçu">
					</form>
				</div>

				<div>

					<table>
						<tr>
							<th class="columnTitle">
								#
							</th>
							<th class="columnTitle">
								ID (T)
							</th>
							<th class="columnTitle">
								Date
							</th>
							<th class="columnTitle">
								Rev. brut (T)
							</th>
							<th class="columnTitle">
								Imp. F (T)
							</th>
							<th class="columnTitle">
								Imp. P (T)
							</th>
							<th class="columnTitle">
								RRQ (T)(E)
							</th>
							<th class="columnTitle">
								RQAP (T)
							</th>
							<th class="columnTitle">
								AE (T)
							</th>
							<th class="columnTitle">
								Rev. net (T)
							</th>
							<th class="columnTitle">
								AE (E)
							</th>
							<th class="columnTitle">
								RQAP (E)
							</th>
							<th class="columnTitle">
								CST (E)
							</th>
							<th class="columnTitle">
								CNESST (E)
							</th>
							<th class="columnTitle">
								FSS (E)
							</th>
							<th class="columnTitle">
								Coût (E)
							</th>
							<th class="columnTitle">
								Versé
							</th>
							<th class="columnTitle">
								Reçu
							</th>
						</tr>
    		<?php
    	}

    	else
    	{
    		?>
    			<div>
					<form target="" method="post">
						<input type="submit" name="updatePay" value="Pay employees">
					</form>
				</div>

				<div>
					<form id="paid" target="" method="post">
						<input type="text" name="numPaie" placeholder="#" value="" />
						<input type="submit" name="completed" value="Versed">
						<input type="submit" name="sent" value="Receipt">
					</form>
				</div>

				<div>

					<table>
						<tr>
							<th class="columnTitle">
								#
							</th>
							<th class="columnTitle">
								ID (W)
							</th>
							<th class="columnTitle">
								Date
							</th>
							<th class="columnTitle">
								Gross rev. (W)
							</th>
							<th class="columnTitle">
								F tax. (W)
							</th>
							<th class="columnTitle">
								P tax. (W)
							</th>
							<th class="columnTitle">
								RRQ (W)(E)
							</th>
							<th class="columnTitle">
								RQAP (W)
							</th>
							<th class="columnTitle">
								AE (W)
							</th>
							<th class="columnTitle">
								Net rev. (W)
							</th>
							<th class="columnTitle">
								AE (E)
							</th>
							<th class="columnTitle">
								RQAP (E)
							</th>
							<th class="columnTitle">
								CST (E)
							</th>
							<th class="columnTitle">
								CNESST (E)
							</th>
							<th class="columnTitle">
								FSS (E)
							</th>
							<th class="columnTitle">
								Cost (E)
							</th>
							<th class="columnTitle">
								Versed
							</th>
							<th class="columnTitle">
								Receipt
							</th>
						</tr>
    		<?php
    	}

					$req = $database->prepare('SELECT ID, IDempl, datentime, rev, brut, impotF, impotP, RRQ, RQAPemploye, RQAPemployeur, AEemploye, AEemployeur, CST, CNESSTemployeur, FSS, costEmployer, paid, mailed FROM payeshisto ORDER BY ID DESC');
			
					$req->execute();

					while ($result = $req->fetch())
					{
						if ($result)
						{
							?>
								<tr class="tableLine">

									<td style="padding: 16px; border-right: 2px dashed black;">
										<?php echo $result['ID']; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; background-color: lightgoldenrodyellow;">
										<?php echo $result['IDempl']; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black;">
										<?php echo $result['datentime']; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; color: magenta; background-color: lightgoldenrodyellow;">
										<?php echo round($result['rev'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;">
										<?php echo round($result['impotF'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;">
										<?php echo round($result['impotP'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;">
										<?php echo round($result['RRQ'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;">
										<?php echo round($result['RQAPemploye'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;">
										<?php echo round($result['AEemploye'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lightgoldenrodyellow;color: magenta;">
										<?php echo round($result['brut'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['AEemployeur'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['RQAPemployeur'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['CST'], 2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['CNESSTemployeur'], 2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['FSS'],2) . ' $'; ?>
									</td>

									<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background-color: lavender;">
										<?php echo round($result['costEmployer'],2) . ' $'; ?>
									</td>

									<?php
										if ($result['paid'] == 1)
										{
											?>
												<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background: lightgreen;">
													<?php echo '1 OUI/YES'; ?>
												</td>
											<?php
										}

										else
										{
											?>
												<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background: indianred;">
													<?php echo '0 NON/NO'; ?>
												</td>
											<?php
										}

										if ($result['mailed'] == 1)
										{
											?>
												<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background: lightgreen;">
													<?php echo '1 OUI/YES'; ?>
												</td>
											<?php
										}

										else
										{
											?>
												<td style="padding: 16px; border-right: 2px dashed black; font-size: 20px; background: indianred;">
													<?php echo '0 NON/NO'; ?>
												</td>
											<?php
										}
									?>

								</tr>
							<?php
						}
					}
					?>
				</table>
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
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="../acc/util/terms">Termes et conditions d'utilisation</a> et de notre <a href="../acc/util/privacy">Politique de confidentialité</a>. Tous les copyrights, marques déposées et marques de service appartiennent aux propriétaires respectifs.
							<br />
							Cette page a été générée en français. Pour modifier vos préférences linguistiques, veuillez vous référer aux <a href="../acc/util/params">paramètres</a> de votre compte.
							<br />
							Victime d'un bug ? N'attendez pas et <a href="../acc/util/help">faites-nous en part</a>.
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
							Use of this Web site constitutes acceptance of the <a href="../acc/util/terms">Terms and Conditions</a> and <a href="../acc/util/privacy">Privacy policy</a>. All copyrights, trade marks and service marks belong to the corresponding owners.
							<br />
							This page was generated in English. To change your language preferences, please refer to your account's <a href="../acc/util/params">parameters</a>.
							<br />
							Victim of a bug? Do not wait and <a href="../acc/util/help">get in touch with us</a>.	
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