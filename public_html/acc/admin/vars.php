
<link rel="stylesheet" href="varsStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Variables globales';
        }

        else
        {
            echo 'ELECTRONET > Global variables';
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
						<a href="../admin/showRev">REVENUS EMPLOYÉS</a> |
						<a href="../admin/vars" id="current">VARIABLES GLOBALES</a> |
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
						<a href="../admin/showRev">PAY EMPLOYEES</a> |
						<a href="../admin/vars" id="current">GLOBAL VARIABLES</a> |
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
								Variables globales
							</p>
        				<?php
        			}

        			else
        			{
        				?>
        					<p class="mainTitle">
								Global Variables
							</p>
        				<?php
        			}

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
			//ADMIN MOD VARS
			if (isset($_POST['modVars']))
			{
				if (isset($_POST['cleanInP']) && isset($_POST['cleanOutP']) && isset($_POST['screen0']) && isset($_POST['screen32']) && isset($_POST['screen60']) && isset($_POST['taxes']) && isset($_POST['onlBoost']) && isset($_POST['cut']) && isset($_POST['cut2']) && isset($_POST['cut3']) && isset($_POST['cutWorker']) && isset($_POST['cutWorker2']) && isset($_POST['cutWorker3']) && isset($_POST['depot']) && isset($_POST['impotP']) && isset($_POST['impotF']) && isset($_POST['RRQ']) && isset($_POST['RQAPemploye']) && isset($_POST['RQAPemployeur']) && isset($_POST['AEemploye']) && isset($_POST['AEemployeur']) && isset($_POST['CST']) && isset($_POST['CNESSTemployeur']) && isset($_POST['FSS']))
				{
					$cleanInP = test_input($_POST['cleanInP']);
					$cleanOutP = test_input($_POST['cleanOutP']);
					$screen0 = test_input($_POST['screen0']);
					$screen32 = test_input($_POST['screen32']);
					$screen60 = test_input($_POST['screen60']);
					$taxes = test_input($_POST['taxes']);
					$onlBoost = test_input($_POST['onlBoost']);
					$cut = test_input($_POST['cut']);
					$cut2 = test_input($_POST['cut2']);
					$cut3 = test_input($_POST['cut3']);
					$cutWorker = test_input($_POST['cutWorker']);
					$cutWorker2 = test_input($_POST['cutWorker2']);
					$cutWorker3 = test_input($_POST['cutWorker3']);
					$depot = test_input($_POST['depot']);
					$impotP = test_input($_POST['impotP']);
					$impotF = test_input($_POST['impotF']);
					$RRQ = test_input($_POST['RRQ']);
					$RQAPemploye = test_input($_POST['RQAPemploye']);
					$RQAPemployeur = test_input($_POST['RQAPemployeur']);
					$AEemploye = test_input($_POST['AEemploye']);
					$AEemployeur = test_input($_POST['AEemployeur']);
					$CST = test_input($_POST['CST']);
					$CNESSTemployeur = test_input($_POST['CNESSTemployeur']);
					$FSS = test_input($_POST['FSS']);

					$req = $database->prepare('UPDATE vars SET cleanInP=:cleanInP, cleanOutP=:cleanOutP, screen0=:screen0, screen32=:screen32, screen60=:screen60, taxes=:taxes, onlBoost=:onlBoost, cut=:cut, cut2=:cut2, cut3=:cut3, cutWorker=:cutWorker, cutWorker2=:cutWorker2, cutWorker3=:cutWorker3, depot=:depot, impotP=:impotP, impotF=:impotF, RRQ=:RRQ, RQAPemploye=:RQAPemploye, RQAPemployeur=:RQAPemployeur, AEemploye=:AEemploye, AEemployeur=:AEemployeur, CST=:CST, CNESSTemployeur=:CNESSTemployeur, FSS=:FSS');

					$req->execute(array(
						'cleanInP' => $cleanInP,
						'cleanOutP' => $cleanOutP,
						'screen0' => $screen0,
						'screen32' => $screen32,
						'screen60' => $screen60,
						'taxes' => $taxes,
						'onlBoost' => $onlBoost,
						'cut' => $cut,
						'cut2' => $cut2,
						'cut3' => $cut3,
						'cutWorker' => $cutWorker,
						'cutWorker2' => $cutWorker2,
						'cutWorker3' => $cutWorker3,
						'depot' => $depot,
						'impotP' => $impotP,
						'impotF' => $impotF,
						'RRQ' => $RRQ,
						'RQAPemploye' => $RQAPemploye,
						'RQAPemployeur' => $RQAPemployeur,
						'AEemploye' => $AEemploye,
						'AEemployeur' => $AEemployeur,
						'CST' => $CST,
						'CNESSTemployeur' => $CNESSTemployeur,
						'FSS' => $FSS
					));

					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
   					{
   						$_SESSION['curSuc'] = 'Modification enregistrée.';
						header('Location: vars');
   					}

   					else
   					{
   						$_SESSION['curSuc'] = 'Changes were recorded.';
						header('Location: vars');
   					}
				}
			}
        }

		$req = $database->prepare('SELECT cleanInP, cleanOutP, screen0, screen32, screen60, taxes, onlBoost, cut, cut2, cut3, cutWorker, cutWorker2, cutWorker3, depot, impotP, impotF, RRQ, RQAPemploye, RQAPemployeur, AEemploye, AEemployeur, CST, CNESSTemployeur, FSS FROM vars');
		$req->execute();

		while ($result = $req->fetch())
		{
			if ($result)
			{
				break;
			}
		}

		if ($result)
		{
			$cleanInP = $result['cleanInP'];
			$cleanOutP = $result['cleanOutP'];
			$screen0 = $result['screen0'];
			$screen32 = $result['screen32'];
			$screen60 = $result['screen60'];
			$taxes = $result['taxes'];
			$onlBoost = $result['onlBoost'];
			$cut = $result['cut'];
			$cut2 = $result['cut2'];
			$cut3 = $result['cut3'];
			$cutWorker = $result['cutWorker'];
			$cutWorker2 = $result['cutWorker2'];
			$cutWorker3 = $result['cutWorker3'];
			$depot = $result['depot'];
			$impotP = $result['impotP'];
			$impotF = $result['impotF'];
			$RRQ = $result['RRQ'];
			$RQAPemploye = $result['RQAPemploye'];
			$RQAPemployeur = $result['RQAPemployeur'];
			$AEemploye = $result['AEemploye'];
			$AEemployeur = $result['AEemployeur'];
			$CST = $result['CST'];
			$CNESSTemployeur = $result['CNESSTemployeur'];
			$FSS = $result['FSS'];
		}
		
		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{
			?>
				<div class="variables">
					<form target="" method="post">

						<p>Nettoyage intérieur des ordinateurs</p>
						<input type="text" name="cleanInP" placeholder="$" value="<?php echo $cleanInP; ?>">

						<p>Nettoyage extérieur des ordinateurs</p>
						<input type="text" name="cleanOutP" placeholder="$" value="<?php echo $cleanOutP; ?>">

						<p>Écrans inférieurs à 32 pouces</p>
						<input type="text" name="screen0" placeholder="$" value="<?php echo $screen0; ?>">

						<p>Écrans se situant entre 32 pouces et 60 pouces</p>
						<input type="text" name="screen32" placeholder="$" value="<?php echo $screen32; ?>">

						<p>Écrans supérieurs à 60 pouces</p>
						<input type="text" name="screen60" placeholder="$" value="<?php echo $screen60; ?>">

						<p>Taxes</p>
						<input type="text" name="taxes" placeholder="%" value="<?php echo $taxes; ?>">

						<p>Supplément en-ligne</p>
						<input type="text" name="onlBoost" placeholder="%" value="<?php echo $onlBoost; ?>">

						<p>Ristourne des vendeurs [TIER I]</p>
						<input type="text" name="cut" placeholder="%" value="<?php echo $cut; ?>">

						<p>Ristourne des vendeurs [TIER II]</p>
						<input type="text" name="cut2" placeholder="%" value="<?php echo $cut2; ?>">

						<p>Ristourne des vendeurs [TIER III]</p>
						<input type="text" name="cut3" placeholder="%" value="<?php echo $cut3; ?>">

						<p>Ristourne des travailleurs [TIER I]</p>
						<input type="text" name="cutWorker" placeholder="%" value="<?php echo $cutWorker; ?>">

						<p>Ristourne des travailleurs [TIER II]</p>
						<input type="text" name="cutWorker2" placeholder="%" value="<?php echo $cutWorker2; ?>">

						<p>Ristourne des travailleurs [TIER III]</p>
						<input type="text" name="cutWorker3" placeholder="%" value="<?php echo $cutWorker3; ?>">

						<p>Dépôt à la première signature</p>
						<input type="text" name="depot" placeholder="%" value="<?php echo $depot; ?>">

						<p>Impôt provincial</p>
						<input type="text" name="impotP" placeholder="%" value="<?php echo $impotP; ?>">

						<p>Impôt fédéral</p>
						<input type="text" name="impotF" placeholder="%" value="<?php echo $impotF; ?>">

						<p>RRQ</p>
						<input type="text" name="RRQ" placeholder="%" value="<?php echo $RRQ; ?>">

						<p>RQAP Employés</p>
						<input type="text" name="RQAPemploye" placeholder="%" value="<?php echo $RQAPemploye; ?>">

						<p>RQAP Employeur</p>
						<input type="text" name="RQAPemployeur" placeholder="%" value="<?php echo $RQAPemployeur; ?>">

						<p>AE Employés</p>
						<input type="text" name="AEemploye" placeholder="%" value="<?php echo $AEemploye; ?>">

						<p>AE Employeur</p>
						<input type="text" name="AEemployeur" placeholder="%" value="<?php echo $AEemployeur; ?>">

						<p>CST</p>
						<input type="text" name="CST" placeholder="%" value="<?php echo $CST; ?>">

						<p>CNESST Employeur</p>
						<input type="text" name="CNESSTemployeur" placeholder="%" value="<?php echo $CNESSTemployeur; ?>">

						<p>FSS</p>
						<input type="text" name="FSS" placeholder="%" value="<?php echo $FSS; ?>">
						
						<br /><br />
						
						<input type="submit" name="modVars" value="Modifier">

					</form>
				</div>
			<?php
		}

		else
		{	
			?>
				<div class="variables">
					<form target="" method="post">

						<p>Interior computer cleaning</p>
						<input type="text" name="cleanInP" placeholder="$" value="<?php echo $cleanInP; ?>">

						<p>Exterior computer cleaning</p>
						<input type="text" name="cleanOutP" placeholder="$" value="<?php echo $cleanOutP; ?>">

						<p>Screens below 32 inches</p>
						<input type="text" name="screen0" placeholder="$" value="<?php echo $screen0; ?>">

						<p>Screens between 32 inches and 60 inches</p>
						<input type="text" name="screen32" placeholder="$" value="<?php echo $screen32; ?>">

						<p>Screens above 60 inches</p>
						<input type="text" name="screen60" placeholder="$" value="<?php echo $screen60; ?>">

						<p>Taxes</p>
						<input type="text" name="taxes" placeholder="%" value="<?php echo $taxes; ?>">

						<p>Online boost</p>
						<input type="text" name="onlBoost" placeholder="%" value="<?php echo $onlBoost; ?>">

						<p>Cut sellers [TIER I]</p>
						<input type="text" name="cut" placeholder="%" value="<?php echo $cut; ?>">

						<p>Cut sellers [TIER II]</p>
						<input type="text" name="cut2" placeholder="%" value="<?php echo $cut2; ?>">

						<p>Cut sellers [TIER III]</p>
						<input type="text" name="cut3" placeholder="%" value="<?php echo $cut3; ?>">

						<p>Cut workers [TIER I]</p>
						<input type="text" name="cutWorker" placeholder="%" value="<?php echo $cutWorker; ?>">

						<p>Cut workers [TIER II]</p>
						<input type="text" name="cutWorker2" placeholder="%" value="<?php echo $cutWorker2; ?>">

						<p>Cut workers [TIER III]</p>
						<input type="text" name="cutWorker3" placeholder="$" value="<?php echo $cutWorker3; ?>">

						<p>Deposit on first signature</p>
						<input type="text" name="depot" placeholder="%" value="<?php echo $depot; ?>">
						
						<p>Provincial imposition</p>
						<input type="text" name="impotP" placeholder="%" value="<?php echo $impotP; ?>">

						<p>Federal imposition</p>
						<input type="text" name="impotF" placeholder="%" value="<?php echo $impotF; ?>">

						<p>RRQ</p>
						<input type="text" name="RRQ" placeholder="%" value="<?php echo $RRQ; ?>">

						<p>RQAP Employees</p>
						<input type="text" name="RQAPemploye" placeholder="%" value="<?php echo $RQAPemploye; ?>">

						<p>RQAP Employer</p>
						<input type="text" name="RQAPemployeur" placeholder="%" value="<?php echo $RQAPemployeur; ?>">

						<p>AE Employees</p>
						<input type="text" name="AEemploye" placeholder="%" value="<?php echo $AEemploye; ?>">

						<p>AE Employer</p>
						<input type="text" name="AEemployeur" placeholder="%" value="<?php echo $AEemployeur; ?>">

						<p>CST</p>
						<input type="text" name="CST" placeholder="%" value="<?php echo $CST; ?>">

						<p>CNESST Employer</p>
						<input type="text" name="CNESSTemployeur" placeholder="%" value="<?php echo $CNESSTemployeur; ?>">

						<p>FSS</p>
						<input type="text" name="FSS" placeholder="%" value="<?php echo $FSS; ?>">

						<br /><br />
						
						<input type="submit" name="modVars" value="Modify">

					</form>
				</div>
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
        $_SESSION['error'] = 'You do not have permission to access this file.';
        header('Location: ../../error');
    }
?>