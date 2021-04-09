
<link rel="stylesheet" href="estimateStyl.css" />

<?php
    include '../../head.php';
    ?>
    <title>
            <?php 
                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    {
                    echo 'ELECTRONET > Estimation';
                }
        
                else
                {
                    echo 'ELECTRONET > Estimate';
                }
            ?>
    </title>
    <?php
    $perms = 0; //4 = AUTO REJECT, FOR UPDATES

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= $perms)
	{

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['estimate']))
            {
                if (isset($_POST['cleanOutP']) && isset($_POST['cleanInP']) && isset($_POST['screen0']) && isset($_POST['screen32']) && isset($_POST['screen60']) && isset($_POST['gutters']) && isset($_POST['windows']))
                {
                    $cleanOutP = test_input($_POST['cleanOutP']);
                    $cleanInP = test_input($_POST['cleanInP']);
                    $screen0 = test_input($_POST['screen0']);
                    $screen32 = test_input($_POST['screen32']);
                    $screen60 = test_input($_POST['screen60']);
                    $windows = test_input($_POST['windows']);
                    $gutters = test_input($_POST['gutters']);

                    if (empty($windows))
                    {
                        $windows = 0;
                    }

                    if (empty($gutters))
                    {
                        $gutters = 0;
                    }

                    if (empty($cleanOutP))
                    {
                        $cleanOutP = 0;
                    }

                    if (empty($cleanInP))
                    {
                        $cleanInP = 0;
                    }

                    if (empty($screen0))
                    {
                        $screen0 = 0;
                    }

                    if (empty($screen32))
                    {
                        $screen32 = 0;
                    }

                    if (empty($screen60))
                    {
                        $screen60 = 0;
                    }

                    if (empty($cleanOutP) && empty($cleanInP) && empty($screen0) && empty($screen32) && empty($screen60) && empty($windows) && empty($gutters))
                    {
                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Certaines saisies sont invalides pour calculer l\'estimation.';
						}

						else
						{
							$_SESSION['curErr'] = 'Some entries were invalid in order to compute a proper estimate.';
						}

                    }

                    else if (!isset($_POST['checkTOS']))
                    {
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Vous devez lire et accepter nos Termes et Conditions d\'Utilisation pour utiliser cet outil.';
						}

						else
						{
							$_SESSION['curErr'] = 'You need to read and accept our Terms of Service in order to use this tool.';
						}

                    }

                    else if (preg_match('/^[0-9][1-9]{0,15}$/', $cleanOutP) && preg_match('/^[0-9][1-9]{0,15}$/', $cleanInP) && preg_match('/^[0-9][1-9]{0,15}$/', $screen0) && preg_match('/^[0-9][1-9]{0,15}$/', $screen32) && preg_match('/^[0-9][1-9]{0,15}$/', $screen60))
                    {
                        if ($cleanOutP >= 0 && $cleanOutP <= 10 && $cleanInP >= 0 && $cleanInP <= 10 && $screen0 >= 0 && $screen0 <= 10 && $screen32 >= 0 && $screen32 <= 10 && $screen60 >= 0 && $screen60 <= 10)
                        {
                        	$_SESSION['cleanOutP'] = $cleanOutP;
                            $_SESSION['cleanInP'] = $cleanInP;
                            $_SESSION['screen0'] = $screen0;
                            $_SESSION['screen32'] = $screen32;
                            $_SESSION['screen60'] = $screen60;
                            
                            $req = $database->prepare('SELECT cleanInP, cleanOutP, screen0, screen32, screen60, taxes, onlBoost FROM vars');
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
								//MULTIPLE SCREENS, LOWEST PRICE
								$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $screen0 * $result['screen0'];

								if ($screen32 >= 2)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $screen32 * $result['screen0'];
								}

								else
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $screen32 * $result['screen32'];
								}

								if ($screen60 >= 2)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $screen60 * $result['screen0'];
								}

								else
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $screen60 * $result['screen60'];
								}

								//REDUCTION IF INTERIOR+EXT
								$const = 0.1;
								$i = 0;
								$i = $cleanInP + $cleanOutP;

								if ($cleanInP >= 2 && $cleanOutP == 0)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanInP * $result['cleanInP'] - $const * ($cleanInP * $result['cleanInP']);
								}

								else if ($cleanInP == 1 && $cleanOutP == 0)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanInP * $result['cleanInP'];
								}

								else if ($cleanOutP >= 2 && $cleanInP == 0)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanOutP * $result['cleanOutP'] - $const * ($cleanOutP * $result['cleanOutP']);
								}

								else if ($cleanOutP == 1 && $cleanInP == 0)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanOutP * $result['cleanOutP'];
								}

								else if ($i >= 2)
								{
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanInP * $result['cleanInP'] - $const * ($cleanInP * $result['cleanInP']);;
									$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $cleanOutP * $result['cleanOutP'] - $const * ($cleanOutP * $result['cleanOutP']);
								}

								$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $_SESSION['windows'] * $windows + $_SESSION['gutters'] * $gutters;

								$_SESSION['estimateVal'] = $_SESSION['estimateVal'] + $result['taxes'] * $_SESSION['estimateVal'] + $result['onlBoost'] * $_SESSION['estimateVal'];

                                $_SESSION['estimateVal'] = round($_SESSION['estimateVal'], 2);

                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curInf'] = 'La valeur de votre estimation est de ' . $_SESSION['estimateVal'] . ' $ (taxes incluses).<br/><br/>Souhaitez-vous soumettre cette estimation à ELECTRONET ?<br/><br/>Si tel est le cas, veuillez entrer vos disponibilités ci-bas et cliquez sur le bouton « Envoyer » lorsque vous avez terminé:<br/><br/>';
								}

								else
								{
									$_SESSION['curInf'] = 'The value of your estimate is $' . $_SESSION['estimateVal'] . ' (taxes included).<br/><br/>Do you wish to submit this estimate to ELECTRONET?<br/><br/>If so, please enter your availability below and click the "Send" button when you are finished:<br/><br/>';
								}
                            }
                        }

                        else
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Certaines saisies sont invalides pour calculer l\'estimation.';
							}

							else
							{
								$_SESSION['curErr'] = 'Some entries were invalid in order to compute a proper estimate.';
							}

                        }
                    }

                    else
                    {
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Certaines saisies sont invalides pour calculer l\'estimation.';
						}

						else
						{
							$_SESSION['curErr'] = 'Some entries were invalid in order to compute a proper estimate.';
						}

                    }
                }
            }

            if (isset($_POST['send']))
            {
            	$_SESSION['estimateAdd'] = test_input($_POST['dispo']);
            	$_SESSION['sendEstimate'] = true;

            	header('location: ../../mail');
            	
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
							<a href="../util/estimate" id="current">ESTIMATION</a> |
							<a href="../util/request">POSTULER</a> |
							<a href="../util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../my">HOME</a> |
							<a href="../util/estimate" id="current">ESTIMATE</a> |
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
							<a href="../util/estimate" id="current">ESTIMATION</a> |
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
							<a href="../util/estimate" id="current">ESTIMATE</a> |
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
			
	<style>

	    .notifs
	    {
	        text-align: center;
	        padding-top: 4%;
	        padding-bottom: 4%;
	        border: 2px groove black;
	        background: white;
	        border-radius: 8px;
	        margin: 2% 20% 5% 20%;
	    }

	    .notifs:hover
	    {
	        background: #FFEEEE;
	        transition: ease-in-out 0.5s;
	    }

	</style>

	<?php
	    //IF ERROR, SHOW
	    if (isset($_SESSION['curErr']) && $_SESSION['curErr'] != '')
	    { 
	    ?>
	    <h3 class="notifs">
	        <i class="material-icons" style="font-size: 44px; color: crimson;" >
	            error
	        </i>
	        <br />
	        <span style="font-family: 'Blinker', sans-serif;
	        font-size: 20px;
	        text-align: center;
	        color: darkred;
	        margin-right: 2%;
	        margin-left: 2%;">
	            <?php
	                echo $_SESSION['curErr'];
	                $_SESSION['curErr'] = '';
	            ?>
	        </span>
	    </h3>
	    <?php
	    }

	    else if (isset($_SESSION['curInf']) && $_SESSION['curInf'] != '')
	    { 
	    ?>
	    <h3 class="notifs">
	        <i class="material-icons" style="font-size: 44px; color: cornflowerblue;">
	            info
	        </i>
	        <br />
	        <span style="font-family: 'Blinker', sans-serif;
	        font-size: 20px;
	        text-align: center;
	        color: darkblue;
	        margin-right: 2%;
	        margin-left: 2%;">
	            <?php
	                echo $_SESSION['curInf'];
	                $_SESSION['curInf'] = '';

		            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<textarea name="dispo" form="sendEstimate" placeholder="Le nom de votre vendeur, disponibilité(s), numéro(s) de téléphone, information(s) additionnelle(s)..."></textarea><br />

				            <form target="" method="post" id="sendEstimate">
				            	<input type="submit" name="send" value="Envoyer" />
						    </form>
						<?php
					}

					else
					{
						?>
							<textarea name="dispo" form="sendEstimate" placeholder="Your seller's name, availability, telephone number, additional information..."></textarea><br />

				            <form target="" method="post" id="sendEstimate">
				            	<input type="submit" name="send" value="Send" />
						    </form>
						<?php
					}
				?>
	            
	        </span>
	    </h3>
	    <?php
	    }

	    else if (isset($_SESSION['curSuc']) && $_SESSION['curSuc'] != '')
	    { 
	    ?>
	    <h3 class="notifs">
	        <i class="material-icons" style="font-size: 44px; color: darkseagreen;">
	            check_circle
	        </i>
	        <br />
	        <span style="font-family: 'Blinker', sans-serif;
	        font-size: 20px;
	        text-align: center;
	        color: darkolivegreen;
	        margin-right: 2%;
	        margin-left: 2%;">
	            <?php
	                echo $_SESSION['curSuc'];
	                $_SESSION['curSuc'] = '';
	            ?>
	        </span>
	    </h3>
	    <?php
	    }


            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	    {
                ?>
                    <p class="mainTitle">
				        Estimation
			        </p>

                    <form target="" method="post">

                    	<h3 style="font-size: 23px; padding: 20px; border: 5px groove midnightblue; text-align: justify;">Pour les services de lavage de vitres, de vidage de gouttières, de tutorat informatique, de consultation logicielle avancée et de paysagement extérieur, l'estimation <u>exacte</u> doit se faire sur place. Veuillez entrer en <a href="https://electronet.ca#contact" target="_blank">contact avec nous</a> pour réserver dès maintenant votre estimation gratuite!</h3>

                    	<br/><br/>

                    	<h4 style="font-size: 22px; border-top: 2px solid midnightblue; border-bottom: 2px solid midnightblue; padding-top: 10px; padding-bottom: 10px;">Services extérieurs</h4>

                    	<br/>

                    	<h5 style="font-size: 20px;">Estimation <u>approximative</u> du lavage de vitres et du vidage des gouttières:</h5>

                    	<p>Nombre de vitres uniques:
                            <input type="text" name="windows" placeholder="#" value="">
                        </p>

                        <p>Nombre de vidage de gouttières:
                            <input type="text" name="gutters" placeholder="#" value="">
                        </p>

                        <br/>

						<h5 style="font-size: 22px;">Estimation <u>approximative</u> des services de paysagement, d'installation et de désinstallation de lumières de Noël, d'enlevage de vignes, de déglaçage, de salage résidentiel et d'entretien de piscine:</h5>

                    	<p><span style="font-size: 20px; color: midnightblue;">39,99 $</span><br/><span style="font-size: 10px;">(prix fixé à l'heure et par employé unique, sujet à modifications selon le niveau de difficulté des tâches à accomplir)</span></p>

                    	<br/><br/>

                    	<h4 style="font-size: 22px; border-top: 2px solid midnightblue; border-bottom: 2px solid midnightblue; padding-top: 10px; padding-bottom: 10px;">Services intérieurs</h4> 

                    	<br/>

                    	<h5 style="font-size: 20px;">Estimation <u>exacte</u> des services électroniques:</h5>

		                <p>Nombre de tours d'ordinateurs &agrave; nettoyer ext&eacute;rieurement:
                            <input type="text" name="cleanOutP" placeholder="#" value="">
                        </p>
		                <p>Nombre d'ordinateur(s) &agrave; consulter, &agrave; analyser et &agrave; faire un bilan:
                            <input type="text" name="cleanInP" placeholder="#" value="" />
                        </p>
		                <p>Nombre d'&eacute;cran(s) en deç&agrave; de 32 pouces &agrave; nettoyer:
                            <input type="text" name="screen0" placeholder="#" value="" />
                        </p>
		                <p>Nombre d'&eacute;cran(s) entre 32 et 60 pouces &agrave; nettoyer:
                            <input type="text" name="screen32" placeholder="#" value="" />
                        </p>
		                <p>Nombre d'&eacute;cran(s) au-del&agrave; de 60 pouces &agrave; nettoyer:
                            <input type="text" name="screen60" placeholder="#" value="" />
                        </p>

                        <br/>

                        <p>
                            <input style="font-size: 20px;" type="checkbox" name="checkTOS" value="" /> <span style="font-size: 20px;">J'ai lu et j'accepte les <a href="terms" target="_blank">conditions d'utilisation</a> reli&eacute;es &agrave; cet outil d'estimation.</span>
                        </p>

		                <input type="submit" name="estimate" value="Estimer">

	                </form>

                    <div style="background-color: lightgray; padding: 2% 0 3% 0; margin: 1% -4px -4px -4px;">
                        <p id="estimateValue">
                            Valeur de l'estimation*: <br />
                            <span style="color: red; font-size: 20px;">
                                <?php
                                    if ($_SESSION['estimateVal'] == 0)
                                    {
                                        echo 'N/A';
                                    }

                                    else
                                    {
                                        echo $_SESSION['estimateVal'] . ' $';
                                        $_SESSION['estimateVal'] = 0;
                                    }
                                ?>
                            </span>
                        </p>

                        <p id="disclaimer">
                            *Taxes <span style="text-decoration: underline;">incluses</span>, prix de l'estimation sujet à modifications.
                        </p>

                    </div>
                <?php
                }

                else
                {
                ?>
                    <p class="mainTitle">
				        Estimate
			        </p>

			        <form target="" method="post">

                    	<h3 style="font-size: 23px; padding: 20px; border: 5px groove midnightblue; text-align: justify;">For window washing services, gutter emptying, computer tutoring, advanced software consulting and outdoor landscaping, the <u>exact</u> estimate must be made in person. Please <a href="https://electronet.ca#contact" target="_blank">contact us</a> to book your free estimate now!</h3>

                    	<br/><br/>

                    	<h4 style="font-size: 22px; border-top: 2px solid midnightblue; border-bottom: 2px solid midnightblue; padding-top: 10px; padding-bottom: 10px;">External services</h4>

                    	<br/>

                    	<h5 style="font-size: 20px;"><u>Approximate</u> estimate of window washing and gutter emptying:</h5>

                    	<p>Number of unique panes:
                            <input type="text" name="windows" placeholder="#" value="">
                        </p>

                        <p>Number of gutters to empty:
                            <input type="text" name="gutters" placeholder="#" value="">
                        </p>

                        <br/>

						<h5 style="font-size: 22px;"><u>Approximate</u> estimate of landscaping, installation and removal services for Christmas lights, vine growing removal, icebreaking, residential salting and pool maintenance:</h5>

                    	<p><span style="font-size: 20px; color: midnightblue;">39,99 $</span><br/><span style="font-size: 10px;">(price fixed by hour and single employee, subject to modifications according to the level of difficulty of the tasks to be accomplished)</span></p>

                    	<br/><br/>

                    	<h4 style="font-size: 22px; border-top: 2px solid midnightblue; border-bottom: 2px solid midnightblue; padding-top: 10px; padding-bottom: 10px;">Interior services</h4> 

                    	<br/>

                    	<h5 style="font-size: 20px;"><u>Exact</u> estimate of electronic services:</h5>

		                <p>Number of computer towers to be cleaned externally:
                            <input type="text" name="cleanOutP" placeholder="#" value="">
                        </p>
		                <p>Number of computer(s) to consult, analyze and assess:
                            <input type="text" name="cleanInP" placeholder="#" value="" />
                        </p>
		                <p>Number of screens below 32 inches to clean:
                            <input type="text" name="screen0" placeholder="#" value="" />
                        </p>
		                <p>Number of screens between 32 and 60 inches to clean:
                            <input type="text" name="screen32" placeholder="#" value="" />
                        </p>
		                <p>Number of screens above 60 inches to clean:
                            <input type="text" name="screen60" placeholder="#" value="" />
                        </p>

                        <br/>

                        <p>
                            <input style="font-size: 20px;" type="checkbox" name="checkTOS" value="" /> <span style="font-size: 20px;">I have read and I accept the <a href="terms" target="_blank">terms of use</a> related to this estimation tool.</span>
                        </p>

		                <input type="submit" name="estimate" value="Estimate">

	                </form>

                    <div style="background-color: lightgray; padding: 2% 0 3% 0; margin: 1% -4px -4px -4px;">
                        <p id="estimateValue">
                            Estimate value*: <br />
                            <span style="color: red; font-size: 20px;">
                                <?php
                                    if ($_SESSION['estimateVal'] == 0)
                                    {
                                        echo 'N/A';
                                    }

                                    else
                                    {
                                        echo '$ ' . $_SESSION['estimateVal'];
                                        $_SESSION['estimateVal'] = 0;
                                    }
                                ?>
                            </span>
                        </p>

                        <p id="disclaimer">
                            *Taxes <span style="text-decoration: underline;">included</span>, price of the estimate subject to modifications.
                        </p>

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
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="terms">Termes et conditions d'utilisation</a> et de notre <a href="privacy">Politique de confidentialit&eacute;</a>. Tous les copyrights, marques d&eacute;pos&eacute;es et marques de service appartiennent aux propri&eacute;taires respectifs.
							<br />
							Cette page a &eacute;t&eacute; g&eacute;n&eacute;r&eacute;e en français. Pour modifier vos pr&eacute;f&eacute;rences linguistiques, veuillez vous r&eacute;f&eacute;rer aux <a href="params">param&egrave;tres</a> de votre compte.
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
							Use of this Web site constitutes acceptance of the <a href="../util/terms">Terms and Conditions</a> and <a href="privacy">Privacy policy</a>. All copyrights, trade marks and service marks belong to the corresponding owners.
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
			$_SESSION['error'] = 'Ce service est pr&eacute;sentement d&eacute;sactiv&eacute;.';
		}

		else
		{
			$_SESSION['error'] = 'This service is unavailable at this point and time.';
		}
        
		header('Location: ../../error');
    }
?>