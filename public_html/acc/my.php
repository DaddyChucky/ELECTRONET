<link rel="stylesheet" href="BACKGROUND.css" />

<?php

include '../head.php';
?>
<title>
        <?php 
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
                echo 'ELECTRONET > Mon compte';
            }
        
            else
            {
                echo 'ELECTRONET > My account';
            }
        ?>
</title>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{

		if (isset($_POST['completeWork']))
		{

			if (isset($_POST['num']) && isset($_POST['method']) && isset($_POST['bns']) && isset($_POST['noteWork']) && isset($_POST['noteWorker']) && isset($_POST['comments']))
			{
				$num = test_input($_POST['num']);
				$method = test_input($_POST['method']);
				$bns = test_input($_POST['bns']);
				$noteWork = test_input($_POST['noteWork']);
				$noteWorker = test_input($_POST['noteWorker']);
				$comments = test_input($_POST['comments']);

				if (!empty($noteWork) && is_numeric($noteWork))
				{
					$noteWork = round($noteWork, 0);
				}

				if (!empty($bns) && is_numeric($bns))
				{
					$noteWork = round($noteWork, 2);
				}

				if (!empty($noteWorker) && is_numeric($noteWorker))
				{
					$noteWorker = round($noteWorker, 0);
				}

                    if (!empty($num))
                    {
                        $req = $database->prepare('SELECT method, bns, noteWork, noteWorker, comments, IDworker, completed FROM contracts WHERE num=:num');

                        $req->execute(array(
                            'num' => $num
                            ));

                        while ($result = $req->fetch())
                        {
                            if ($result)
                            {
                                break;
                            }
                        }

                        //CHECKS CONTRACT EXISTENCE
                        if (!$result)
                        {
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Le contrat saisi est inconnu.';
							}

							else
							{
								$_SESSION['curErr'] = 'Contract entered is unknown.';
							}
                            
                        }

						//CHECKS IF CONTRACT IS COMPLETABLE
						else if ($result['completed'] == 1 || $result['completed'] == 2)
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Ce contrat ne peut pas être complété.';
							}

							else
							{
								$_SESSION['curErr'] = 'This contract may not be completed.';
							}
						}

                        //CHECKS IF WORKER CAN MODIFY CONTRACT
                        //CHECKS IF CONTRACT IS EMITTED FOR HIM
                        else if ($_SESSION['ID'] == $result['IDworker'])
                        {
                            //NOT UPDATING EMPTY FORMS
                            if (empty($method) && empty($noteWork) && empty($noteWorker) && empty($comments) && empty($bns))
                            {
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Vous ne pouvez pas mettre qu\'un ID!';
								}

								else
								{
									$_SESSION['curErr'] = 'Only putting an ID doesn\'t make any change!';
								}
                            }

                            if (empty($method))
                            {
                                $method = $result['method'];
                            }

                            if (empty($noteWork))
                            {
                                $noteWork = $result['noteWork'];
                            }

                            if (empty($noteWorker))
                            {
                                $noteWorker = $result['noteWorker'];
                            }

                            if (empty($comments))
                            {
                                $comments = $result['comments'];
                            }

							if (empty($bns))
                            {
                                $bns = $result['bns'];
                            }

							if (!is_numeric($bns))
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Pourboires invalides.';
								}

								else
								{
									$_SESSION['curErr'] = 'Invalid tips.';
								}
                            }

                            if ($noteWork < 0 || $noteWork > 100 || $noteWorker < 0 || $noteWorker > 100 || !is_numeric($noteWork) || !is_numeric($noteWorker))
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Notes invalides.';
								}

								else
								{
									$_SESSION['curErr'] = 'Invalid notes.';
								}

                            }

							$bns = round($bns, 2);

                            //EVERYTHING GOOD, UPDATE
                            $req = $database->prepare('UPDATE contracts SET completed=:completed, method=:method, bns=:bns, noteWork=:noteWork, noteWorker=:noteWorker, comments=:comments, lastUpdated=:lastUpdated, updatedBy=:updatedBy WHERE num=:num');

                            $req->execute(array(
								'completed' => '1',
								'method' => $method,
								'bns' => $bns,
								'noteWork' => $noteWork,
								'noteWorker' => $noteWorker,
								'comments' => $comments,
                                'lastUpdated' => time(),
                                'updatedBy' => $_SESSION['ID'],
                                'num' => $num
                                ));

								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curSuc'] = 'Contrat #' . $num . ' complété avec succès.';
								}

								else
								{
									$_SESSION['curSuc'] = 'Contract #53' . $num . ' successfully completed.';
								}
							
                        }

                        else
                        {
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Vous ne pouvez pas compléter ce contrat.';
							}

							else
							{
								$_SESSION['curErr'] = 'You may not complete this contract.';
							}
                        }
                    }

                    else
                    {
                        $_SESSION['curErr'] = 'You must enter a contract number.';
                    }
			}
		}


		if (isset($_POST['addContract']))
		{

			if (isset($_POST['clientName']) && isset($_POST['clientLoc']) && isset($_POST['datentime']) && isset($_POST['price']) && isset($_POST['desc']) && !empty($_POST['clientName']) && !empty($_POST['price']))
			{
				$clientName = test_input($_POST['clientName']);
				$clientLoc = test_input($_POST['clientLoc']);
				$datentime = test_input($_POST['datentime']);
				$price = test_input($_POST['price']);
				$desc = test_input($_POST['desc']);

                //SELLER'S CUT
                $req = $database->prepare('SELECT taxes FROM vars');

                $req->execute();

                while ($result = $req->fetch())
                {
                    if ($result)
                    {
                        break;
                    }
                }

                $cut = ($price - $price * $result['taxes']) * $_SESSION['const_cut'];
                $cut = round($cut, 2);

                $cutWorker = 0;

                $depot = $price * $_SESSION['const_depot'];
                $depot = round($depot, 2);

                $reste = $price - $depot;
                $reste = round($reste, 2);

				if ($_POST['addContract'])
				{
					//CHECKS IF PRICE IS RIGHT (HAHA!)
					if (is_numeric($price) && $price > 0 && $price < 10000)
					{
						$price = round($price, 2);

						$req = $database->prepare('INSERT INTO contracts(IDseller, customer, location, datentime, price, depot, reste, cut, cutWorker, description, lastUpdated, updatedBy) VALUES(:IDseller, :customer, :location, :datentime, :price, :depot, :reste, :cut, :cutWorker, :description, :lastUpdated, :updatedBy)');

						$req->execute(array(

							'IDseller' => $_SESSION['ID'],
							'customer' => $clientName,
							'location' => $clientLoc,
							'datentime' => $datentime,
							'price' => $price,
                            'depot' => $depot,
                            'reste' => $reste,
                            'cut' => $cut,
                            'cutWorker' => $cutWorker,
							'description' => $desc,
                            'lastUpdated' => time(),
                            'updatedBy' => $_SESSION['ID']
						));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = 'Contrat ajouté avec succès.';
						}

						else
						{
							$_SESSION['curSuc'] = 'Contract successfully added.';
						}				
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Prix invalide.';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid price.';
						}
					}
				}
			}

			else
			{
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					$_SESSION['curErr'] = 'Toutes les saisies doivent être remplies.';
				}

				else
				{
					$_SESSION['curErr'] = 'All inputs must be correctly filled.';
				}
			}
		}
	}

	if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'])
	{
    ?>

	<div class="header">

		<p class="logo">
			<a href="" style="text-decoration: none;">
				<img src="../img/logo.png" alt="Error loading logo.png" />
			</a>

			<span class="cred">
				<a href="../acc/util/params">
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
				<a href="../acc/util/params">
					<img src="<?php echo '../acc/util/' . $avatarName; ?>" alt="Error loading avatar" class="avatar" />
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
							<a href="" id="current">ACCUEIL</a> |
							<a href="../acc/util/estimate">ESTIMATION</a> |
							<a href="../acc/util/request">POSTULER</a> |
							<a href="../acc/util/params">PARAMÈTRES</a> |
							<a href="../acc/util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="" id="current">HOME</a> |
							<a href="../acc/util/estimate">ESTIMATE</a> |
							<a href="../acc/util/request">APPLY</a> |
							<a href="../acc/util/params">SETTINGS</a> |
							<a href="../acc/util/help" style="cursor: help;">HELP</a>
						<?php
					}
					
				}

				else if ($_SESSION['perms'] == 1)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="" id="current">ACCUEIL</a> |
							<a href="../acc/util/work">TRAVAUX</a> |
							<a href="../acc/util/pay">REVENU</a> |
							<a href="../acc/util/histo">HISTORIQUE</a> |
							<a href="../acc/util/params">PARAMÈTRES</a> |
							<a href="../acc/util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="" id="current">HOME</a> |
							<a href="../acc/util/work">WORKS</a> |
							<a href="../acc/util/pay">PAY</a> |
							<a href="../acc/util/histo">HISTORIC</a> |
							<a href="../acc/util/params">SETTINGS</a> |
							<a href="../acc/util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 2)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="" id="current">ACCUEIL</a> |
							<a href="../acc/util/estimate">ESTIMATION</a> |
							<a href="../acc/util/work">TRAVAUX</a> |
							<a href="../acc/util/seller">VENTES</a> |
							<a href="../acc/util/pay">REVENU</a> |
							<a href="../acc/util/histo">HISTORIQUE</a> |
							<a href="../acc/util/params">PARAMÈTRES</a> |
							<a href="../acc/util/help" style="cursor: help;">AIDE</a>
					<?php
					}

					else
					{
						?>
							<a href="" id="current">HOME</a> |
							<a href="../acc/util/estimate">ESTIMATE</a> |
							<a href="../acc/util/work">WORKS</a> |
							<a href="../acc/util/seller">SELLS</a> |
							<a href="../acc/util/pay">PAY</a> |
							<a href="../acc/util/histo">HISTORIC</a> |
							<a href="../acc/util/params">SETTINGS</a> |
							<a href="../acc/util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 3)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="" id="current">ACCUEIL</a> |
							<a href="../acc/admin/powertool">GESTION</a> |
							<a href="../acc/util/params">PARAMÈTRES</a> |
							<a href="../acc/util/help" style="cursor: help;">AIDE</a>
					<?php
					}

					else
					{	
						?>
							<a href="" id="current">HOME</a> |
							<a href="../acc/admin/powertool">MANAGEMENT</a> |
							<a href="../acc/util/params">SETTINGS</a> |
							<a href="../acc/util/help" style="cursor: help;">HELP</a>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 4)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<a href="" id="current">ACCUEIL</a> |
							<a href="../acc/admin/powertool">GESTION</a> |
							<a href="../acc/admin/showRev">REVENUS EMPLOYÉS</a> |
							<a href="../acc/admin/vars">VARIABLES GLOBALES</a> |
							<a href="../acc/util/params">PARAMÈTRES</a>
						<?php
					}

					else
					{
						?>
							<a href="" id="current">HOME</a> |
							<a href="../acc/admin/powertool">MANAGEMENT</a> |
							<a href="../acc/admin/showRev">PAY EMPLOYEES</a> |
							<a href="../acc/admin/vars">GLOBAL VARIABLES</a> |
							<a href="../acc/util/params">SETTINGS</a>
						<?php
					}
				}
			?>
			
		</p>
	</div>

	<div class="content">

		<div>
			<?php
				include '../cur.php';
			?>

			<!-- TOP RIGHT LINKERS -->
				    
				<?php
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p id="nav-icons" style="text-align: right; margin-top: -1%; margin-right: 1%;">
								<a href="https://electronet.ca">
									<i class="material-icons" class="top-page-icons" title="Page d'accueil" style="color: midnightblue; font-size: 40px;">
										home
									</i>
								</a>
								<a href="../acc/util/params#translate">
									<i class="material-icons" class="top-page-icons" title="Translate in English" style="color: lightgreen; font-size: 40px;">
										translate
									</i>
								</a>
								<a href="https://electronet.ca/error">
									<i class="material-icons" class="top-page-icons" title="Se déconnecter" style="color: darkred; font-size: 40px;">
										power_settings_new
									</i>
								</a>
							</p>
						<?php
					}

					else
					{
						?>
							<p id="nav-icons" style="text-align: right; margin-top: -1%; margin-right: 1%;">
								<a href="https://electronet.ca">
									<i class="material-icons" class="top-page-icons" title="Home page" style="color: midnightblue; font-size: 40px;">
										home
									</i>
								</a>
								<a href="../acc/util/params#translate">
									<i class="material-icons" class="top-page-icons" title="Traduire en Français" style="color: lightgreen; font-size: 40px;">
										translate
									</i>
								</a>
								<a href="https://electronet.ca/error">
									<i class="material-icons" class="top-page-icons" title="Disconnect" style="color: darkred; font-size: 40px;">
										power_settings_new
									</i>
								</a>
							</p>
						<?php
					}
				?>
			


			<?php
				if ($_SESSION['perms'] == 0)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p class="mainTitle">Mon compte</p>
							<p class="sentences">
								<span style="font-style: italic;">Bienvenue</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
								<br />
								Voici toutes les fonctionnalités liées à votre compte <span style="color: darkslategray;">client</span>:
							</p>

							<table class="functionalities">
								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/estimate">Faire une estimation</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/request">Postuler et devenir employé</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/params">Paramètres et sécurité</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/help" style="cursor: help;">Aide</a></td>
								</tr>

							</table>
						<?php
					}

					else
					{
						?>
							<p class="mainTitle">My Account</p>
								<p class="sentences">
									<span style="font-style: italic;">Welcome</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
									<br />
									Here are all the features related to your <span style="color: darkslategray;">client</span>'s account:
								</p>

								<table class="functionalities">
									<tr>
										<td><i class="material-icons">arrow_right_alt</i></td>
										<td><a href="../acc/util/estimate">Make an estimate</a></td>
									</tr>

									<tr>
										<td><i class="material-icons">arrow_right_alt</i></td>
										<td><a href="../acc/util/request">Apply and become an employee</a></td>
									</tr>

									<tr>
										<td><i class="material-icons">arrow_right_alt</i></td>
										<td><a href="../acc/util/params">Settings and security</a></td>
									</tr>

									<tr>
										<td><i class="material-icons">arrow_right_alt</i></td>
										<td><a href="../acc/util/help" style="cursor: help;">Help</a></td>
									</tr>

								</table>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 1)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
							<p class="mainTitle">Mon compte</p>
							<p class="sentences">
								<span style="font-style: italic;">Bienvenue</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
								<br />
								Voici toutes les fonctionnalités liées à votre compte <span style="color: dodgerblue;">travailleur</span>:
							</p>

							<table class="functionalities">

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/work">Mes travaux</a></td>
								</tr>

								<p>
									<iframe src="https://calendar.google.com/calendar/b/3/embed?height=600&amp;wkst=1&amp;bgcolor=%237986CB&amp;ctz=America%2FToronto&amp;src=Y2RsLmVsZWN0cm9uZXRAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=ZnIuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230B8043&amp;mode=WEEK&amp;showTabs=1&amp;showPrint=1&amp;showNav=1&amp;title=ELECTRONET%20-%20AGENDA" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
								</p>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/pay">Prochaine paie</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/histo">Historique des paies</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/estimate">Outil d'estimation</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/params">Paramètres et sécurité</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/help" style="cursor: help;">Aide</a></td>
								</tr>

							</table>

							<p class="submitSell">
								Compléter un travail
							</p>

							<form target="" method="post">
							
								<input type="text" name="num" placeholder="# Contrat" value=""> <br />
								<input type="text" name="method" placeholder="Méthode de paiement" value=""> <br />
								<input type="text" name="bns" placeholder="Pourboires clairs (additionnés au paiement)" value=""> <br />
								<input type="text" name="noteWork" placeholder="Note des travaux effectués" value=""> <br />
								<input type="text" name="noteWorker" placeholder="Note des travailleurs" value=""> <br/>
								<input type="text" name="comments" placeholder="Commentaires client" value=""> <br/>

								<input type="submit" name="completeWork" value="Compléter">

							</form>

						<?php
					}

					else 
					{
						?>
							<p class="mainTitle">My Account</p>
							<p class="sentences">
								<span style="font-style: italic;">Welcome</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
								<br />
								Here are all the features related to your <span style="color: dodgerblue;">worker</span>'s account:
							</p>

							<table class="functionalities">

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/work">My works</a></td>
								</tr>

								<p>
									<iframe src="https://calendar.google.com/calendar/b/3/embed?height=600&amp;wkst=1&amp;bgcolor=%237986CB&amp;ctz=America%2FToronto&amp;src=Y2RsLmVsZWN0cm9uZXRAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=ZnIuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230B8043&amp;mode=WEEK&amp;showTabs=1&amp;showPrint=1&amp;showNav=1&amp;title=ELECTRONET%20-%20AGENDA" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
								</p>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/pay">Next pay</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/histo">Pays' historic</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/estimate">Estimation tool</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/params">Settings and security</a></td>
								</tr>

								<tr>
									<td><i class="material-icons">arrow_right_alt</i></td>
									<td><a href="../acc/util/help" style="cursor: help;">Help</a></td>
								</tr>

							</table>

							<p class="submitSell">
								Complete a work
							</p>

							<form target="" method="post">
							
								<input type="text" name="num" placeholder="Contract #" value=""> <br />
								<input type="text" name="method" placeholder="Payment method" value=""> <br />
								<input type="text" name="bns" placeholder="Clear tips (added to total payment)" value=""> <br />
								<input type="text" name="noteWork" placeholder="Note of work carried out" value=""> <br />
								<input type="text" name="noteWorker" placeholder="Workers note" value=""> <br/>
								<input type="text" name="comments" placeholder="Client's comments" value=""> <br/>

								<input type="submit" name="completeWork" value="Complete">

							</form>
						<?php
					}
				}

				else if ($_SESSION['perms'] == 2)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
						<p class="mainTitle">Mon compte</p>
						<p class="sentences">
							<span style="font-style: italic;">Bienvenue</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Voici toutes les fonctionnalités liées à votre compte <span style="color: mediumseagreen;">vendeur</span>:
						</p>

						<table class="functionalities">

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Outil d'estimation</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">Mes travaux</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">Mes ventes</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Prochaine paie</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Historique des paies</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Paramètres et sécurité</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Aide</a></td>
							</tr>

						</table>

						<p class="submitSell">
							Compléter un travail
						</p>

						<form target="" method="post">

							<input type="text" name="num" placeholder="# Contrat" value=""> <br />
							<input type="text" name="method" placeholder="Méthode de paiement" value=""> <br />
							<input type="text" name="bns" placeholder="Pourboires clairs (additionnés au paiement)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note des travaux effectués" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Note des travailleurs" value=""> <br/>
							<input type="text" name="comments" placeholder="Commentaires client" value=""> <br/>

							<input type="submit" name="completeWork" value="Compléter">

						</form>

						<p class="submitSell">
							Soumettre une nouvelle vente
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Nom du client" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Adresse du client" value=""> <br />
							<input type="text" name="datentime" placeholder="Date et heure des travaux (jj/mm/aaaa HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Coût des travaux" value=""> <br/>
							<input type="text" name="desc" placeholder="Description des travaux" value=""> <br/>

							<input type="submit" name="addContract" value="Soumettre">

						</form>
					<?php
					}

					else
					{
						?>
						<p class="mainTitle">My Account</p>
						<p class="sentences">
							<span style="font-style: italic;">Welcome</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Here are all the features related to your <span style="color: mediumseagreen;">seller</span>'s account:
						</p>

						<table class="functionalities">

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Estimation tool</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">My works</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">My sells</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Next pay</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Pays' historic</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Settings and security</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Help</a></td>
							</tr>
							
						</table>

						<p class="submitSell">
							Complete a work
						</p>

						<form target="" method="post">
							
							<input type="text" name="num" placeholder="Contract #" value=""> <br />
							<input type="text" name="method" placeholder="Payment method" value=""> <br />
							<input type="text" name="bns" placeholder="Clear tips (added to total payment)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note of work carried out" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Workers note" value=""> <br/>
							<input type="text" name="comments" placeholder="Client's comments" value=""> <br/>

							<input type="submit" name="completeWork" value="Complete">

						</form>

						<p class="submitSell">
							Submit a new sell
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Client's name" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Client's address" value=""> <br />
							<input type="text" name="datentime" placeholder="Date and time of work (dd/mm/yyyy HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Works' cost" value=""> <br/>
							<input type="text" name="desc" placeholder="Works' description" value=""> <br/>

							<input type="submit" name="addContract" value="Submit">

						</form>
					<?php
					}
				}

				else if ($_SESSION['perms'] == 3)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
						<p class="mainTitle">Mon compte</p>
						<p class="sentences">
							<span style="font-style: italic;">Bienvenue</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Voici toutes les fonctionnalités liées à votre compte <span style="color: deeppink;">gestionnaire</span>:
						</p>

						<table class="functionalities">
							
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/powertool">Outils de gestion</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Outil d'estimation</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">Mes travaux</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">Mes ventes</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Prochaine paie</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Historique des paies</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Paramètres et sécurité</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Aide</a></td>
							</tr>

						</table>

						<p class="submitSell">
							Compléter un travail
						</p>

						<form target="" method="post">

							<input type="text" name="num" placeholder="# Contrat" value=""> <br />
							<input type="text" name="method" placeholder="Méthode de paiement" value=""> <br />
							<input type="text" name="bns" placeholder="Pourboires clairs (additionnés au paiement)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note des travaux effectués" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Note des travailleurs" value=""> <br/>
							<input type="text" name="comments" placeholder="Commentaires client" value=""> <br/>

							<input type="submit" name="completeWork" value="Compléter">

						</form>

						<p class="submitSell">
							Soumettre une nouvelle vente
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Nom du client" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Adresse du client" value=""> <br />
							<input type="text" name="datentime" placeholder="Date et heure des travaux (jj/mm/aaaa HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Coût des travaux" value=""> <br/>
							<input type="text" name="desc" placeholder="Description des travaux" value=""> <br/>

							<input type="submit" name="addContract" value="Soumettre">

						</form>
					<?php
					}

					else
					{
						?>
						<p class="mainTitle">My Account</p>
						<p class="sentences">
							<span style="font-style: italic;">Welcome</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Here are all the features related to your <span style="color: deeppink;">manager</span>'s account:
						</p>

						<table class="functionalities">
							
							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/powertool">Manager's tools</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Estimation tool</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">My works</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">My sells</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Next pay</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Pays' historic</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Settings and security</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Help</a></td>
							</tr>

						</table>

						<p class="submitSell">
							Complete a work
						</p>

						<form target="" method="post">
							
							<input type="text" name="num" placeholder="Contract #" value=""> <br />
							<input type="text" name="method" placeholder="Payment method" value=""> <br />
							<input type="text" name="bns" placeholder="Clear tips (added to total payment)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note of work carried out" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Workers note" value=""> <br/>
							<input type="text" name="comments" placeholder="Client's comments" value=""> <br/>

							<input type="submit" name="completeWork" value="Complete">

						</form>

						<p class="submitSell">
							Submit a new sell
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Client's name" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Client's address" value=""> <br />
							<input type="text" name="datentime" placeholder="Date and time of work (dd/mm/yyyy HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Works' cost" value=""> <br/>
							<input type="text" name="desc" placeholder="Works' description" value=""> <br/>

							<input type="submit" name="addContract" value="Submit">

						</form>
					<?php
					}
					
				}

				else if ($_SESSION['perms'] == 4)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						?>
						<p class="mainTitle">Mon compte</p>
						<p class="sentences">
							<span style="font-style: italic;">Bienvenue</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Voici toutes les fonctionnalités liées à votre compte <span style="color: darkred;">administrateur</span>:
						</p>

						<table class="functionalities">

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/powertool">Outils de gestion</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/showRev">Revenus des employés</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/vars">Variables globales</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Outil d'estimation</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">Mes travaux</a></td>
							</tr>

							<p>
								<iframe src="https://calendar.google.com/calendar/b/3/embed?height=600&amp;wkst=1&amp;bgcolor=%237986CB&amp;ctz=America%2FToronto&amp;src=Y2RsLmVsZWN0cm9uZXRAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=ZnIuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230B8043&amp;mode=WEEK&amp;showTabs=1&amp;showPrint=1&amp;showNav=1&amp;title=ELECTRONET%20-%20AGENDA" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
							</p>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">Mes ventes</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Prochaine paie</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Historique des paies</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Paramètres et sécurité</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Aide</a></td>
							</tr>

						</table>

						<p class="submitSell">
							Compléter un travail
						</p>

						<form target="" method="post">

							<input type="text" name="num" placeholder="# Contrat" value=""> <br />
							<input type="text" name="method" placeholder="Méthode de paiement" value=""> <br />
							<input type="text" name="bns" placeholder="Pourboires clairs (additionnés au paiement)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note des travaux effectués" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Note des travailleurs" value=""> <br/>
							<input type="text" name="comments" placeholder="Commentaires client" value=""> <br/>

							<input type="submit" name="completeWork" value="Compléter">

						</form>

						<p class="submitSell">
							Soumettre une nouvelle vente
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Nom du client" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Adresse du client" value=""> <br />
							<input type="text" name="datentime" placeholder="Date et heure des travaux (jj/mm/aaaa HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Coût des travaux" value=""> <br/>
							<input type="text" name="desc" placeholder="Description des travaux" value=""> <br/>

							<input type="submit" name="addContract" value="Soumettre">

						</form>
					<?php
					}

					else
					{
						?>
						<p class="mainTitle">My Account</p>
						<p class="sentences">
							<span style="font-style: italic;">Welcome</span> <?php echo $_SESSION['name'] . ' (ID: #' . $_SESSION['ID'] . ')'; ?>,
							<br />
							Here are all the features related to your <span style="color: darkred;">administrator</span>'s account:
						</p>

						<table class="functionalities">

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/powertool">Manager's tools</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/showRev">Pay employees</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/admin/vars">Global variables</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/estimate">Estimation tool</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/work">My works</a></td>
							</tr>

							<p>
								<iframe src="https://calendar.google.com/calendar/b/3/embed?height=600&amp;wkst=1&amp;bgcolor=%237986CB&amp;ctz=America%2FToronto&amp;src=Y2RsLmVsZWN0cm9uZXRAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=ZnIuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230B8043&amp;mode=WEEK&amp;showTabs=1&amp;showPrint=1&amp;showNav=1&amp;title=ELECTRONET%20-%20AGENDA" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
							</p>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/seller">My sells</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/pay">Next pay</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/histo">Pays' historic</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/params">Settings and security</a></td>
							</tr>

							<tr>
								<td><i class="material-icons">arrow_right_alt</i></td>
								<td><a href="../acc/util/help" style="cursor: help;">Help</a></td>
							</tr>

						</table>

						<p class="submitSell">
							Complete a work
						</p>

						<form target="" method="post">
							
							<input type="text" name="num" placeholder="Contract #" value=""> <br />
							<input type="text" name="method" placeholder="Payment method" value=""> <br />
							<input type="text" name="bns" placeholder="Clear tips (added to total payment)" value=""> <br />
							<input type="text" name="noteWork" placeholder="Note of work carried out" value=""> <br />
							<input type="text" name="noteWorker" placeholder="Workers note" value=""> <br/>
							<input type="text" name="comments" placeholder="Client's comments" value=""> <br/>

							<input type="submit" name="completeWork" value="Complete">

						</form>

						<p class="submitSell">
							Submit a new sell
						</p>

						<form target="" method="post">

							<input type="text" name="clientName" placeholder="Client's name" value=""> <br />
							<input type="text" name="clientLoc" placeholder="Client's address" value=""> <br />
							<input type="text" name="datentime" placeholder="Date and time of work (dd/mm/yyyy HH:mm)" value=""> <br />
							<input type="text" name="price" placeholder="Works' cost" value=""> <br/>
							<input type="text" name="desc" placeholder="Works' description" value=""> <br/>

							<input type="submit" name="addContract" value="Submit">

						</form>
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

		header('Location: ../error');
	}
?>
