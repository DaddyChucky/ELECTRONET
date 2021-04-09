<link rel="stylesheet" href="tab.css">

<?php
	include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
	    {
            echo 'ELECTRONET > Journal de sécurité';
        }

        else
        {
            echo 'ELECTRONET > Security Journal';
        }
    ?>
</title>

<?php
	if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 0)
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
				if ($_SESSION['perms'] == 0)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../util/estimate">ESTIMATION</a> |
							<a href="../util/request">POSTULER</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../util/estimate">ESTIMATE</a> |
							<a href="../util/request">APPLY</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 1)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../util/work">TRAVAUX</a> |
							<a href="../util/pay">REVENU</a> |
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
							<a href="../util/pay">PAY</a> |
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
							<a href="../util/pay">REVENU</a> |
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
							<a href="../util/pay">PAY</a> |
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
				
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p class="mainTitle">
								Journal de sécurité*
							</p>
						<?php
					}

					else
					{
						?>
							<p class="mainTitle">
								Security Journal*
							</p>
						<?php
					}

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if (isset($_POST['clearLogs']) && $_POST['clearLogs'])
			{
				$req = $database->prepare('UPDATE logs SET hide=:hide WHERE userID=:userID');

				$req->execute(array(

					'hide' => 1,
					'userID' => $_SESSION['ID']
				));

				while ($result = $req->fetch())
				{
					if ($result)
					{
						break;
					}
				}
			}
		}

		$req = $database->prepare('SELECT IP, tStamp, browser, hide FROM logs WHERE userID=:userID ORDER BY ID DESC');

		$req->execute(array(

			'userID' => $_SESSION['ID']
		));

		while ($result = $req->fetch())
		{
			if ($result['hide'] == 0)
			{
				$count++;
			}
		}

	//IF THERE IS AT LEAST ONE (1) JOURNAL ENTRY
	if ($count > 0)
	{
		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{
			?>
				<form target="" method="post">
					<input type="submit" name="clearLogs" value="Effacer le journal">
				</form>
			<?php
		}

		else
		{
			?>
				<form target="" method="post">
					<input type="submit" name="clearLogs" value="Erase all entries">
				</form>
			<?php
		}
	?>

	<table>
		<tr>
			<?php
			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				?>
					<th class="columnTitle">DATE</th>
	            	<th class="columnTitle">ADRESSE IP</th>
	            	<th class="columnTitle">NAVIGATEUR</th>
				<?php
			}

			else
			{
				?>
					<th class="columnTitle">DATE</th>
	            	<th class="columnTitle">IP ADDRESS</th>
	            	<th class="columnTitle">BROWSER</th>
				<?php
			}
			?>
		</tr>

		<?php

		$req = $database->prepare('SELECT IP, tStamp, browser, hide FROM logs WHERE userID=:userID ORDER BY ID DESC');

		$req->execute(array(

			'userID' => $_SESSION['ID']
		));

		while ($result = $req->fetch())
		{
			if ($result['hide'] == 0)
			{

        ?>
				<tr class="tableLine">
                    <td style="padding: 16px; border-right: 2px dashed black;">
                        <?php
							echo $result['tStamp'];
                        ?>
                    </td>

                    <td style="padding: 16px; border-right: 2px dashed black;">
                        <a href="https://www.whois.com/whois/<?php echo $result['IP']; ?>" target="_blank">
                            <?php echo $result['IP']; ?>
                        </a>
                    </td>

                    <td style="padding: 16px; border-right: 2px dashed black;">
                        <?php
							echo $result['browser'];
                        ?>
                    </td>
				</tr>
				<?php
			}
		}
	?>
	</table>
	
	<?php
		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{
			?>
				<p style="margin-right: 8%; margin-left: 8%; margin-bottom: 4%;">
				    *Ce journal de sécurité vous procure toutes les tentatives de connection à votre compte ELECTRONET.<br/>S'il y a présence d'anormalités, n'hésitez pas à <a href="mailto:admin@electronet.ca">communiquer avec nous</a>.
				</p>
			<?php
		}

		else
		{
			?>
				<p style="margin-right: 8%; margin-left: 8%; margin-bottom: 4%;">
				    *This security log provides you with all attempts to connect to your ELECTRONET account.<br/>If there are abnormalities, do not hesitate to <a href="mailto:admin@electronet.ca">communicate with us</a>.
				</p>
			<?php
		}
	?>

	
	
	<?php
	}

	else
	{
		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{
			?>
				<p id="erasedEntries">Toutes les entrées du journal ont été <b>effacées</b>.</p>
			
				<p style="margin-right: 8%; margin-left: 8%; margin-bottom: 4%;">
			   		*Ce journal de sécurité vous procure toutes les tentatives de connection à votre compte ELECTRONET.<br/>S'il y a présence d'anormalités, n'hésitez pas à <a href="mailto:admin@electronet.ca">communiquer avec nous</a>.
		        </p>
	       	<?php
		}

		else
		{
			?>
				<p id="erasedEntries">All journal entries have been <b>erased</b>.</p>
			
				<p style="margin-right: 8%; margin-left: 8%; margin-bottom: 4%;">
			    	*This security log provides you with all attempts to connect to your ELECTRONET account.<br/>If there are abnormalities, do not hesitate to <a href="mailto:admin@electronet.ca">communicate with us</a>.
		        </p>
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
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="../util/terms">Termes et conditions d'utilisation</a> et de notre <a href="../util/privacy">Politique de confidentialité</a>. Tous les copyrights, marques déposées et marques de service appartiennent aux propriétaires respectifs.
							<br />
							Cette page a été générée en français. Pour modifier vos préférences linguistiques, veuillez vous référer aux <a href="../util/params">paramètres</a> de votre compte.
							<br />
							Victime d'un bug ? N'attendez pas et <a href="../util/help">faites-nous en part</a>.
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
							Use of this Web site constitutes acceptance of the <a href="../util/terms">Terms and Conditions</a> and <a href="..util/privacy">Privacy policy</a>. All copyrights, trade marks and service marks belong to the corresponding owners.
							<br />
							This page was generated in English. To change your language preferences, please refer to your account's <a href="../util/params">parameters</a>.
							<br />
							Victim of a bug? Do not wait and <a href="../util/help">get in touch with us</a>.	
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
