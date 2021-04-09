<link rel="stylesheet" href="bgREG.css" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">

<?php

	include 'head.php';
    
	//AUTO REDIRECTS IF LOGGED IN
	if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'])
	{
		header('Location: ../acc/my');
	}

	//AUTO REDIRECTS TO AUTHENTICATOR
	if (isset($_SESSION['doubleVerif']) && $_SESSION['doubleVerif'] == 2)
	{
		header('Location: ../auth');
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
        if (isset($_POST['forgotPassword']))
		{
			if (isset($_POST['id']))
			{
				$id = test_input($_POST['id']);
				
				$req = $database->prepare('SELECT ID, name, email FROM users WHERE ID=:ID');

				$req->execute(array(
					'ID' => $id
				));

				while ($result = $req->fetch())
				{
					if ($result)
					{
						break;
					}
				}

				if ($result)
				{
					$_SESSION['ID'] = $result['ID'];
					$_SESSION['name'] = $result['name'];
					$_SESSION['email'] = $result['email'];

					$print = generateRandomString();

					$_SESSION['token'] = "https://electronet.ca/iforgot?rp=" . $print; //CHANGE FOR WEBSITE ADDRESS

					$req = $database->prepare('UPDATE users SET iforgot=:iforgot WHERE ID=:ID');

					$req->execute(array(
						'iforgot' => $print,
						'ID' => $_SESSION['ID']
					));

					$_SESSION['iforgot'] = 1;

					header('Location: mail');
				}
				
				else
				{
					$req = $database->prepare('SELECT ID, name, email FROM users WHERE email=:email');

					$req->execute(array(
						'email' => $id
					));

					while ($result = $req->fetch())
					{
						if ($result)
						{
							break;
						}
					}

					if ($result)
					{
						$_SESSION['ID'] = $result['ID'];
						$_SESSION['name'] = $result['name'];
						$_SESSION['email'] = $result['email'];

						$print = generateRandomString();

						$_SESSION['token'] = "https://electronet.ca/iforgot?rp=" . $print; //CHANGE FOR WEBSITE ADDRESS

						$req = $database->prepare('UPDATE users SET iforgot=:iforgot WHERE ID=:ID');

						$req->execute(array(
							'iforgot' => $print,
							'ID' => $_SESSION['ID']
						));

						$_SESSION['iforgot'] = true;

						header('Location: mail');
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curInf'] = 'Veuillez d\'abord indiquer dans le champ « Courriel ou ID » votre courriel ou num&eacute;ro d\'identification dans la section d\'identification.';
						}

						else
						{
							$_SESSION['curInf'] = 'Please indicate your email or identification number in the case "Email or ID" in the Login section.';
						}
					}
				}	
			}

			else
			{
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					$_SESSION['curInf'] = 'Veuillez d\'abord indiquer dans le champ « Courriel ou ID » votre courriel ou num&eacute;ro d\'identification dans la section d\'identification.';
				}

				else
				{
					$_SESSION['curInf'] = 'Please indicate your email or identification number in the case "Email or ID" in the Login section.';
				}
			}

		}

		else if (isset($_POST['forgotEmail']))
		{
			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				$_SESSION['curInf'] = 'Veuillez nous ';
				$_SESSION['curInf'] .= '<a href="mailto:cdl.electronet@gmail.com">contacter directement</a>';
				$_SESSION['curInf'] .= ' avec toutes les informations que vous pouvez recueillir concernant votre compte perdu. Merci.';
			}

			else
			{
				$_SESSION['curInf'] = 'Please ';
				$_SESSION['curInf'] .= '<a href="mailto:cdl.electronet@gmail.com">contact us directly</a>';
				$_SESSION['curInf'] .= ' with any information you can gather regarding your lost account. Thank you.';
			}
		}

        else if (isset($_POST['changeLang']))
        {

            if ($_SESSION['lang'] == 'fr')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'en',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: register');

            }

            if ($_SESSION['lang'] == 'en')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'fr',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: register');
            }
        }

		//ACCOUNT CREATION
		else if (isset($_POST['accountCreation']))
		{
			//CHECK IF USER HAS MANIPULATED INPUTS
			if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['confirmPass']))
			{
				//TESTING INPUTS
				$name = test_input($_POST['name']);
				$email = test_input($_POST['email']);
				$pass = test_input($_POST['pass']);
				$confirmPass = test_input($_POST['confirmPass']);

				//CHECKS IF ALL INPUTS ARE FILLED
				if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['confirmPass']))
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Toutes les saisies doivent &ecirc;tre remplies.';
					}

					else
					{
						$_SESSION['curErr'] = 'All inputs must be filled.';
					}
				}

				//CHECKS IF NAME IS OK
				else if (!preg_match("/^[a-zA-Z\s-]*$/", $name) || iconv_strlen($name) >= 30)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Nom invalide.';
					}

					else
					{
						$_SESSION['curErr'] = 'Invalid name.';
					}
				}

				//CHECKS IF EMAIL IS OK
				else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Courriel invalide.';
					}

					else
					{
						$_SESSION['curErr'] = 'Invalid email.';
					}
				}

				//CHECKS IF PASSWORD IS OK
				else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&*_-]{8,50}$/', $pass))
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Mot de passe invalide.';
					}

					else
					{
						$_SESSION['curErr'] = 'Invalid password.';
					}
				}

				//CHECKS IF PASSWORD CONFIRMATION MATCHES PASSWORD
				else if ($pass != $confirmPass)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Les mots de passe ne correspondent pas.';
					}

					else
					{
						$_SESSION['curErr'] = 'Passwords do no match.';
					}
				}

				//EVERYTHING PASSED, INJECTING INTO DATABASE
				else
				{
					//CHECKS EMAIL PRESENCE IN DATABASE
					$req = $database->prepare('SELECT ID FROM users WHERE email=:email');

					$req->execute(array(

						'email' => $email

					));

					while ($result = $req->fetch())
					{
						if ($result)
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['error'] = 'Un compte d&eacute;j&agrave; existant utilise ce courriel.';
							}

							else
							{
								$_SESSION['error'] = 'An existing account uses this email.';
							}

							header('Location: ../error');
						}
						break;
					}

					//EMAIL DOES NOT EXIST, CONTINUE
					if (!$result)
					{
						//HASHING PASSWORD
						$pass = password_hash($pass, PASSWORD_BCRYPT, array(
							'cost' => 12
						));

						//GET TOKEN FOR EMAIL VERIFICATION
						$token = generateRandomString();
						$print = generateRandomString();

						//INSERT INFO INTO DATABASE
						$req = $database->prepare('INSERT INTO users(name, email, password, token, iforgot, creation, passChDate) VALUES(:name, :email, :password, :token, :iforgot, :creation, :passChDate)');

						$req->execute(array(

							'name' => $name,
							'email' => $email,
							'password' => $pass,
							'token' => $token,
							'iforgot' => $print,
							'creation' => time(),
							'passChDate' => time()

						));

						$_SESSION['sendCreationEmail'] = true;

						$_SESSION['name'] = $name;
						$_SESSION['email'] = $email;
						$_SESSION['token'] = "https://electronet.ca/validate?token=" . $token; //CHANGE FOR WEBSITE ADDRESS

						header('Location: ../mail');
					}
				}

			}

			else
			{
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					$_SESSION['error'] = 'L\'utilisateur a manipul&eacute; les saisies.';
				}

				else
				{
					$_SESSION['error'] = 'User manipulated inputs.';
				}

				header('Location: ../error');
			}

		}

		else if (isset($_POST['accountLogin']))
		{
			//CHECK IF USER HAS MANIPULATED INPUTS
			if (isset($_POST['id']) && isset($_POST['pass']))
			{
				//TESTING INPUTS
				$id = test_input($_POST['id']);
				$pass = test_input($_POST['pass']);

				//CHECKS IF USER'S EMAIL WITHIN THE DATABASE
				$req = $database->prepare('SELECT ID, name, email, token, validated, password, perms, creation, passChDate, doubleVerif, ban, banReason FROM users WHERE email=:email');

				$req->execute(array(
					'email' => $id
				));

				while ($result = $req->fetch())
				{
					if ($result)
					{
						break;
					}
				}

				if (!$result)
				{
					//CHECKS IF USER'S ID WITHIN THE DATABASE
					$req = $database->prepare('SELECT ID, name, email, token, validated, password, perms, creation, passChDate, doubleVerif, ban, banReason FROM users WHERE ID=:ID');

					$req->execute(array(
						'ID' => $id
					));

					while ($result = $req->fetch())
					{
						if ($result)
						{
							break;
						}
					}

					if (!$result)
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'ID/courriel et/ou mot de passe invalide(s).';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid ID/email and/or password.';
						}
					}
				}

					//EMAIL/ID EXISTS, CHECKS IF PASSWORD MATCHES DATABASE
					if (password_verify($pass, $result['password']))
					{
						$_SESSION['name'] = $result['name'];
						$_SESSION['email'] = $result['email'];

						//IF PASSWORD MATCHES, CHECK IF USER EMAIL'S VERIFICATION
						if ($result['validated'] == 0)
						{
							$_SESSION['resendCreationEmail'] = true;

							$_SESSION['token'] = "https://electronet.ca/validate?token=" . $result['token']; //CHANGE FOR WEBSITE ADDRESS

							header('Location: ../mail');
						}

						else
						{
							if ($result['ban'] == true)
							{
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$print = 'Votre compte ELECTRONET li&eacute; au courriel ' . $result['email'] . ' (ID: ' . $result['ID'] . ') a été banni par un administrateur. Raison: ' . $result['banReason'];

									$_SESSION['curErr'] = $print;
								}

								else
								{
									$print = 'Your ELECTRONET account related to the email ' . $result['email'] . ' (ID: ' . $result['ID'] . ') has been banned by an administrator. Reason: ' . $result['banReason'];

									$_SESSION['curErr'] = $print;
								}
							}

							else
							{
								$_SESSION['ID'] = $result['ID'];
								$_SESSION['password'] = $result['password'];
								$_SESSION['perms'] = $result['perms'];
								$_SESSION['creation'] = $result['creation'];
								$_SESSION['passChDate'] = $result['passChDate'];

								if ($result['doubleVerif'] == 1)
								{
									$_SESSION['doubleVerif'] = 1;

									$_SESSION['verifToken'] = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);

									//UPDATE VERIFTOKEN & VERIFTIME
									$req = $database->prepare('UPDATE users SET verifToken=:verifToken, verifTime=:verifTime WHERE ID=:ID');
									$req->execute(array(
										'verifToken' => $_SESSION['verifToken'],
										'verifTime' => time() + 900,
										'ID' => $_SESSION['ID']
									));

									header('Location: ../mail');
								}

								else
								{
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
									
									//LOGS THE ENTRY
									$req = $database->prepare('INSERT INTO logs(userID, IP, tStamp, browser) VALUES(:userID, :IP, :tStamp, :browser)');

									$req->execute(array(

										'userID' => $_SESSION['ID'],
										'IP' => $_SESSION['IP'],
										'tStamp' => $tStamp,
										'browser' => get_browser_name($_SERVER['HTTP_USER_AGENT'])
									));

									$_SESSION['authPassed'] = true;
									header('Location: ../acc/my');
								}
							}
						}
					}

					else
					{
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'ID/courriel et/ou mot de passe invalide(s).';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid ID/email and/or password.';
						}
					}

			}

			else
			{
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
				{
					$_SESSION['error'] = 'L\'utilisateur a manipul&eacute; les saisies.';
				}

				else
				{
					$_SESSION['error'] = 'User manipulated inputs.';
				}
				
				header('Location: ../error');
			}
		}

		else
		{
			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				$_SESSION['error'] = 'Erreur fatale.';
			}

			else
			{
				$_SESSION['error'] = 'Fatal error.';
			}

			header('Location: ../error');
		}
	}

?>

<title>
        <?php 
            if ($_SESSION['lang'] == 'fr')
            {
                echo 'ELECTRONET > Connexion/Cr&eacute;er un compte';
            }

            else
            {
                echo 'ELECTRONET > Connection/Register';
            }
        ?>
</title>

<?php 
    if ($_SESSION['lang'] == 'fr')
    {
    ?>
        <p id="screen-to-small"><b style="text-decoration: underline;">Erreur fatale d'affichage:</b><br/><br/>ELECTRONET ne supporte pas les &eacute;crans en-deç&agrave; de 50 pixels ni les &eacute;crans au-del&agrave; de 2 000 pixels.<br />S'il-vous-plaît, rectifiez les dimensions de votre &eacute;cran et rafraîchissez la page (en appuyant F5).</p>
    <?php
    }

    else
    {
    ?>
        <p id="screen-to-small"><b style="text-decoration: underline;">Fatal display error:</b><br/><br/>ELECTRONET does not support screens below 50 pixels or screens beyond 2000 pixels.<br />Please correct the dimensions of your screen and refresh the page (by pressing F5).</p>
    <?php
    }
?>
	

	<body>

        <section>
			
			<header>

				<div class="header">
					
					<p>
                        <?php
                            if ($_SESSION['lang'] == 'fr')
                            {
                            ?>
                                <a href= "../register" title="Se connecter / S'enregistrer">
							        <span>CONNEXION <span style="color: black;">/</span><br/>
								          INSCRIPTION</span><br/>
							        <i class="material-icons">supervisor_account</i>
						        </a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href= "../register" title="Connection / Register">
							        <span>CONNECTION <span style="color: black;">/</span><br/>
								          REGISTER</span><br/>
							        <i class="material-icons">supervisor_account</i>
						        </a>
                            <?php
                            }
                        ?>

					</p>
					
				</div>

				<div class="topLinks">

					<p>
                        <?php 
                            if ($_SESSION['lang'] == 'fr')
                            {
                            ?>
                                <a href="../#services">SERVICES</a>
						        <a href="../#estimate">ESTIMATION</a>
						        <a href="../#motto" style="text-decoration: none;">
							        <img src="../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="../#partenariat">PARTENARIAT</a>
						        <a href="../#contact">CONTACT</a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href="../#services">SERVICES</a>
						        <a href="../#estimate">ESTIMATE</a>
						        <a href="../#motto" style="text-decoration: none;">
							        <img src="../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="../#partenariat">PARTNERSHIP</a>
						        <a href="../#contact">CONTACT</a>
                            <?php
                            }
                        ?>
						
					</p>
				
				</div>

			</header>

				<div class="background-content">

					<div class="sepBorder">

						<div class="mainContent">

                        <br />

                        <?php

                        include 'cur.php';

                        if ($_SESSION['lang'] == 'fr')
                        {
                        ?>
                            <h2>Cr&eacute;ation d'un compte client</h2>

	                            <form class="form" target="" method="post">

		                            <input type="text" name="name" placeholder="Nom*" value=""><br>
		                            <p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">*Ne peut pas contenir chiffres ou symboles.</p>
		                            <input type="text" name="email" placeholder="Courriel" value=""><br>
		                            <input type="password" name="pass" placeholder="Mot de passe**" value=""><br>
		                            <p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">**Doit contenir au moins 8 caractères, dont une majuscule et un chiffre.</p>
		                            <input type="password" name="confirmPass" placeholder="Confirmation du mot de passe" value=""><br>

		                            <input type="submit" name="accountCreation" value="Cr&eacute;er">

	                            </form>

                            <br>

                            <h2>S'identifier</h2>

	                            <form class="form" target="" method="post">

		                            <input type="text" name="id" placeholder="Courriel ou ID" value=""><br>
		                            <input type="password" name="pass" placeholder="Mot de passe" value=""><br>

		                            <input type="submit" name="accountLogin" value="Entrer"><br/>

									<span id="iforgot"> 
										<input type="submit" name="forgotPassword" value="Mot de passe oubli&eacute; ?"> ou <input type="submit" name="forgotEmail" value="Courriel/ID oubli&eacute; ?">
									</span>

	                            </form>

                        <?php
                        }

                        else
                        {
                        ?>
                            <h2>Create a customer account</h2>

	                            <form class="form" target="" method="post">

		                            <input type="text" name="name" placeholder="Name*" value=""><br>
		                            <p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">*May not contain numbers or symbols.</p>
		                            <input type="text" name="email" placeholder="Email" value=""><br>
		                            <input type="password" name="pass" placeholder="Password**" value=""><br>
		                            <p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">**Must contain at least 8 characters, including a capital letter and a number.</p>
		                            <input type="password" name="confirmPass" placeholder="Confirm password" value=""><br>

		                            <input type="submit" name="accountCreation" value="Create">

	                            </form>

                            <br>

                            <h2>Login</h2>

	                            <form class="form" target="" method="post">

		                            <input type="text" name="id" placeholder="Email or ID" value=""><br>
		                            <input type="password" name="pass" placeholder="Password" value=""><br>

		                            <input type="submit" name="accountLogin" value="Enter"><br>

									<span id="iforgot"> 
										<input type="submit" name="forgotPassword" value="Forgot password?"> or <input type="submit" name="forgotEmail" value="Forgot email/ID?">
									</span>
	                            </form>
                        <?php
                        }
                        ?>

                                <br />
                        </div>

                    </div>

                </div>
        </section>
			
    <footer>
	    <div>
		    <p>
			    <?php 
				    if ($_SESSION['lang'] == 'fr')
				    {
			    ?>
					    <p class="footContent">
						    L'utilisation de ce site Web constitue l'acceptation de nos <a href="../acc/util/terms">Termes et conditions d'utilisation</a> et de notre <a href="../acc/util/privacy">Politique de confidentialit&eacute;</a>. Tous les copyrights, marques d&eacute;pos&eacute;es et marques de service appartiennent aux propri&eacute;taires respectifs.
						    <form id="lastformula" target="" method="post">Cette page a &eacute;t&eacute; g&eacute;n&eacute;r&eacute;e en français. Pour traduire cette page en anglais, <input id="changeLang" type="submit" name="changeLang" value="cliquez ici">.</form>
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
						    <form id="lastformula" target="" method="post">This page was generated in English. To translate this page in French, <input id="changeLang" type="submit" name="changeLang" value="click here">.</form>
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
</body>


