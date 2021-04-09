
<link rel="stylesheet" href="powertoolStyle.css" />

<?php
 include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Outils de gestion';
        }

        else
        {
            echo 'ELECTRONET > Manager\'s tools';
        }
    ?>
</title>
<?php
    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 3)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['clearLogs']))
            {
                $req = $database->prepare('DELETE FROM logs');
                $req->execute();
            }
        }
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
				if ($_SESSION['perms'] == 3)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        			{
        				?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../admin/powertool" id="current">GESTION</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
        			}

        			else
        			{
        				?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool" id="current">MANAGEMENT</a> |
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
							<a href="../admin/powertool" id="current">GESTION</a> |
							<a href="../admin/showRev">REVENUS EMPLOYÉS</a> |
							<a href="../admin/vars">VARIABLES GLOBALES</a> |
							<a href="../util/params">PARAMÈTRES</a>
						<?php
        			}

        			else
        			{
        				?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool" id="current">MANAGEMENT</a> |
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
						Outils de gestion
					</p>

					<div id="links">
						<table class="functionalities">
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="employee">Liste des employ&#233;s</a></td>
							</tr>
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="contract">Liste des contrats</a></td>
							</tr>
						</table>
					</div>
				<?php
			}

			else
			{
				?>
					<p class="mainTitle">
						Manager's Tools
					</p>

					<div id="links">
						<table class="functionalities">
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="employee">Employees' list</a></td>
							</tr>
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="contract">Contracts' list</a></td>
							</tr>
						</table>
					</div>
				<?php
			}

				//CALCULATING IF LOGS TAKE TOO MUCH SPACE IN THE DATABASE
				$req = $database->prepare('SELECT ID FROM logs WHERE hide=:hide');

				$req->execute(array(
					'hide' => 1
					));

				$count = 0;

				while ($result = $req->fetch())
				{
					if ($result)
					{
						$count++;
					}
				}
			?>
        
			<div id="entries">
			<?php
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					?>
						<p>
							Espace globale inutilisée des journaux de s&#233;curit&#233;: 
							<?php

								if ($count <= 1)
								{
									?>
										<span style="color: red; text-decoration: underline;"><?php echo $count . ' ';?> </span>entr&#233;e.
									<?php
								}

								else
								{
									?>
										<span style="color: red; text-decoration: underline;"><?php echo $count . ' ';?> </span>entr&#233;es.
									<?php
								}
							?>
							<p>
								<form target="" method="POST">
									<input type="submit" name="clearLogs" value="Tout effacer*" />
								</form>
							</p>
						</p>
					<?php
				}

				else
				{
					?>
						<p>
							Unused security log space: 
							<?php

								if ($count <= 1)
								{
									?>
										<span style="color: red; text-decoration: underline;"><?php echo $count . ' ';?> </span>entry.
									<?php
								}

								else
								{
									?>
										<span style="color: red; text-decoration: underline;"><?php echo $count . ' ';?> </span>entries.
									<?php
								}
							?>
							<p>
								<form target="" method="POST">
									<input type="submit" name="clearLogs" value="Erase all*" />
								</form>
							</p>
						</p>
					<?php
				}
			?>

				<p>
					<?php
					if ($count >= 0 && $count <= 200)
					{
					?>
						<i class="material-icons" style="color: mediumseagreen;">
							thumb_up
						</i>
					<?php
					}

					else if ($count > 200 && $count <= 1000)
					{
					?>
						<i class="material-icons" style="color: yellow;">
							thumbs_up_down
						</i>
					<?php
					}

					else
					{
					?>
						<i class="material-icons" style="color: darkred;">
							thumb_down
						</i>
					<?php
					}
					?>
				</p>

				<?php
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p id="disclaimer">
								*Les usagers ne seront pas avertis de cet effacement.
							</p>
						<?php
					}

					else
					{
						?>
							<p id="disclaimer">
								*Users will not be notified of this deletion.
							</p>
						<?php
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

