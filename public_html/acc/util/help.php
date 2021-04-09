<link rel="stylesheet" href="helpStyle.css" />

<?php
    include '../../head.php';
	?>
    <title>
            <?php 
                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    {
                    echo 'ELECTRONET > Aide';
                }
        
                else
                {
                    echo 'ELECTRONET > Help';
                }
            ?>
    </title>
    <?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 0)
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['bug']) && isset($_POST['send']) && isset($_POST['prob']) && isset($_POST['misc']))
            {
				$bug = test_input($_POST['bug']);
				$prob = test_input($_POST['prob']);
				$misc = test_input($_POST['misc']);

				if (isset($_POST['receiveUpdates']))
				{
					$_SESSION['receiveUpdates'] = 1;
				}

				if (!empty($bug))
				{
					$_SESSION['bug'] = $bug;
				}

				if (!empty($prob))
				{
					$_SESSION['prob'] = $prob;
				}

				if (!empty($misc))
				{
					$_SESSION['misc'] = $misc;
				}

				$_SESSION['sendHelp'] = 1;

				if (empty($bug) && empty($prob) && empty($misc))
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    	{
    	    			$_SESSION['curErr'] = 'Vous devez &eacute;crire quelque chose avant de transmettre un appel d\'aide.';
        	    	}

        	    	else
        	    	{
        	    		$_SESSION['curErr'] = 'You need to write something before transmitting a help report.';
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
							<a href="../util/request">POSTULER</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;" id="current">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../my">HOME</a> |
							<a href="../util/estimate">ESTIMATE</a> |
							<a href="../util/request">APPLY</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;" id="current">HELP</a>
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
							<a href="../util/help" style="cursor: help;" id="current">AIDE</a>
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
							<a href="../util/help" style="cursor: help;" id="current">HELP</a>
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
							<a href="../util/help" style="cursor: help;" id="current">AIDE</a>
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
							<a href="../util/help" style="cursor: help;" id="current">HELP</a>
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
							<a href="../util/help" style="cursor: help;" id="current">AIDE</a>
					<?php
					}

					else
					{	
						?>
							<a href="../my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../util/params">SETTINGS</a> |
							<a href="../util/help" style="cursor: help;" id="current">HELP</a>
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
				    Aide
			    </p>

			    <textarea name="bug" form="helpForm" placeholder="Un bug rencontr&eacute; ?"></textarea><br /><br />
			    <textarea name="prob" form="helpForm" placeholder="Une id&eacute;e d'am&eacute;lioration ?"></textarea><br /><br />
			    <textarea name="misc" form="helpForm" placeholder="Autre (veuillez d&eacute;crire)"></textarea><br /><br /><br />

			    <form target="" method="post" id="helpForm">
				    <p>
					    <input type="checkbox" name="receiveUpdates" checked /> <span style="font-size: 16px;">Je souhaite recevoir une r&eacute;troaction administrative par courriel suite &agrave; cet appel d'aide.</input>
				    </p>
				    <input type="submit" name="send" value="Envoyer" />
			    </form>
            <?php
            }
            else
            {
            ?>
                <p class="mainTitle">
				    Help
			    </p>

			    <textarea name="bug" form="helpForm" placeholder="A bug encountered?"></textarea><br /><br />
			    <textarea name="prob" form="helpForm" placeholder="An idea for improvement?"></textarea><br /><br />
			    <textarea name="misc" form="helpForm" placeholder="Other (please describe)"></textarea><br /><br /><br />

			    <form target="" method="post" id="helpForm">
				    <p>
					    <input type="checkbox" name="receiveUpdates" checked /> <span style="font-size: 16px;">I would like to receive administrative feedback by email following this call for help.</input>
				    </p>
				    <input type="submit" name="send" value="Send" />
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