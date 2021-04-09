<link rel="stylesheet" href="helpStyle.css" />
<link rel="stylesheet" href="paramsStyle.css" />

<?php
    include '../../head.php';
	?>
    <title>
            <?php 
                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    {
                    echo 'ELECTRONET > Devenir employé';
                }
        
                else
                {
                    echo 'ELECTRONET > Become an employee';
                }
            ?>
    </title>
    <?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] == 0 || $_SESSION['perms'] == 3 || $_SESSION['perms'] == 4)
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
        	if (isset($_POST['send']))
			{
	        	$desc = test_input($_POST['desc']);
				$_SESSION['desc'] = $desc;

	        	if (isset($_FILES['curric']) && $_FILES['curric']['error'] == 0)
				{
					if ($_FILES['curric']['size'] <= 5000000)
					{
						$fileName = pathinfo($_FILES['curric']['name']);
						$fileExtension = $fileName['extension'];
						$authExtensions = array('pdf', 'doc', 'docx');

						if (in_array($fileExtension, $authExtensions))
						{
							$cvPath = 'uploads/' . $_SESSION['ID'] . '.' . $fileExtension;

							move_uploaded_file($_FILES['curric']['tmp_name'], $cvPath);

							if (isset($_SESSION['cvPath']) || !isset($_SESSION['cvPath']))
							{
								$_SESSION['cvPath'] = $cvPath;
							}
						}

						else
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Extension invalide.';
							}

							else
							{
								$_SESSION['curErr'] = 'Invalid extension.';
							}
						}
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'CV trop massif (> 5 Mo).';
						}

						else
						{
							$_SESSION['curErr'] = 'CV too big (> 5 Mb).';
						}
					}
				}
					$_SESSION['apply'] = true;

					/* DEBUG echo $desc . $cvPath; */

					if ($desc == '' && $cvPath == '')
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'CV invalide (voir formats accept&eacute;s).';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid CV (see accepted formats).';
						}
					}

					else
					{
						header('Location: ../../mail');
					}		
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
				if ($_SESSION['perms'] == 0)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="../my">ACCUEIL</a> |
							<a href="../util/estimate">ESTIMATION</a> |
							<a href="../util/request" id="current">POSTULER</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../my">HOME</a> |
							<a href="../util/estimate">ESTIMATE</a> |
							<a href="../util/request" id="current">APPLY</a> |
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
							<a href="../my">ACCUEIL</a> |
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
							<a href="../my">HOME</a> |
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
							<a href="../my">ACCUEIL</a> |
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
							<a href="../my">HOME</a> |
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
							<a href="../my">ACCUEIL</a> |
							<a href="../admin/powertool">GESTION</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
					<?php
					}

					else
					{	
						?>
							<a href="../my">HOME</a> |
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
							<a href="../my">ACCUEIL</a> |
							<a href="../admin/powertool">GESTION</a> |
							<a href="../admin/showRev">REVENUS EMPLOYÉS</a> |
							<a href="../admin/vars">VARIABLES GLOBALES</a> |
							<a href="../util/params">PARAMÈTRES</a>
						<?php
					}

					else
					{
						?>
							<a href="../my">HOME</a> |
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
				    Devenir employé
				    </p>

				    <p>Veuillez nous faire parvenir votre CV dans la case ci-dessous OU le téléverser (formats acceptés: pdf, doc, docx).</p>

				    <br/>

				    <textarea name="desc" form="sendCurric" placeholder="Copiez votre CV dans cette case..."></textarea><br /><br /><br />

				    <form target="" method="post" enctype="multipart/form-data" id="sendCurric">

						<input type="file" id="file" class="inputfile" name="curric" />

						<label id="label" for="file">T&eacute;l&eacute;verser votre CV</label> <br />

						<br />
		                <input type="submit" name="send" value="Appliquer" />

					</form>
        		<?php
        	}

        	else
        	{
        		?>
        			<p class="mainTitle">
				    Become Employee
				    </p>

				    <p>Please send us your CV in the box below OR upload it (accepted formats: pdf, doc, docx).</p>

				    <br/>

				    <textarea name="desc" form="sendCurric" placeholder="Copy your CV in this box..."></textarea><br /><br /><br />

				    <form target="" method="post" enctype="multipart/form-data" id="sendCurric">

						<input type="file" id="file" class="inputfile" name="curric" />

						<label id="label" for="file">Upload your CV</label> <br />

						<br />
		                <input type="submit" name="send" value="Apply" />

					</form>
        		<?php
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
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="terms">Termes et conditions d'utilisation</a> et de notre <a href="privacy">Politique de confidentialit&eacute;</a>. Tous les copyrights, marques d&eacute;pos&eacute;es et marques de service appartiennent aux propri&eacute;taires respectifs.
							<br />
							Cette page a &eacute;t&eacute; g&eacute;n&eacute;r&eacute;e en français. Pour modifier vos pr&eacute;f&eacute;rences linguistiques, veuillez vous r&eacute;f&eacute;rer aux <a href="params">param&egrave;tres</a> de votre compte.
							<br />
							Victime d'un bug ? N'attendez pas et <a href="">faites-nous en part</a>.
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
							Victim of a bug? Do not wait and <a href="">get in touch with us</a>.	
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
			$_SESSION['error'] = 'Vous n\'avez pas la permission d\'acc&eacute;der &agrave; ce fichier.';
		}

		else
		{
			$_SESSION['error'] = 'You do not have permission to access this file.';
		}

		header('Location: ../../error');
    }

?>