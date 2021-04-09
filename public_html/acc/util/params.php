<link rel="stylesheet" href="paramsStyle.css" />

<?php
    include '../../head.php';
?>
<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
	    {
            echo 'ELECTRONET > Paramètres et sécurité';
        }

        else
        {
            echo 'ELECTRONET > Settings and security';
        }
    ?>
</title>
<?php
    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 0)
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //CHANGE NAME
            if (isset($_POST['changeName']))
            {
                if (isset($_POST['newName']))
                {
                    $newName = test_input($_POST['newName']);

                    if (!preg_match("/^[a-zA-Z\s-]*$/", $newName) || iconv_strlen($newName) >= 30 || empty($newName))
                    {
                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Nouveau nom invalide.';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid new name.';
						} 
                    }

                    else if ($newName == $_SESSION['name'])
                    {
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Votre nouveau nom doit être différent.';
						}

						else
						{
							$_SESSION['curErr'] = 'Your new name must be different.';
						}          
                    }

                    else
                    {
                        $req = $database->prepare('UPDATE users SET name=:name WHERE ID=:ID');
                        $req->execute(array(
                            'name' => $newName,
                            'ID' => $_SESSION['ID']
                        ));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = "Votre nom a changé avec succès. Il va être modifié lors de votre déconnexion.";
						}

						else
						{
							$_SESSION['curSuc'] = 'Your name was changed successfully. It will change once you log out.';
						}
                    }
                }
            }

            //CHANGE PASSWORD
            if (isset($_POST['changePass']))
            {
                if (isset($_POST['pass']) && isset($_POST['newPass']) && isset($_POST['confirmPass']))
                {
                    //CHECKS IF INPUTS ARE FILLED
                    if (!empty($_POST['pass']) || !empty($_POST['newPass']) || !empty($_POST['confirmPass']))
                    {
                        $pass = test_input($_POST['pass']);
                        $newPass = test_input($_POST['newPass']);
                        $confirmPass = test_input($_POST['confirmPass']);

                        //CHECKS IF OLD PASSWORD MATCHES
                        if (password_verify($pass, $_SESSION['password']))
                        {
                            //CHECKS IF NEW PASSWORD IS OK
                            if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&*_-]{8,50}$/', $newPass) && $pass != $newPass)
                            {

                                //CHECKS IF CONFIRMATION IS OK
                                if ($newPass == $confirmPass)
                                {
                                    //ENCRYPT NEW PASS
                                    $password = password_hash($newPass, PASSWORD_BCRYPT, array(
                                        'cost' => 12
                                    ));

                                    $req = $database->prepare('UPDATE users SET password=:password, passChDate=:passChDate WHERE ID=:ID');
                                    $req->execute(array(
                                        'password' => $password,
                                        'passChDate' => time(),
                                        'ID' => $_SESSION['ID']
                                    ));

                                    $_SESSION['sendPassModify'] = true;

                                    header('Location: ../../mail');
                                }

                                else
                                {
									if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										$_SESSION['curErr'] = 'Échec dans la confirmation des mots de passe';
									}

									else
									{
										$_SESSION['curErr'] = 'Password confirmation did not pass.';
									}
                                }
                            }

                            else
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Nouveau mot de passe invalide.';
								}

								else
								{
									$_SESSION['curErr'] = 'Invalid new password.';
								}
                            }
                        }

                        else
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Dernier mot de passe invalide.';
							}

							else
							{
								$_SESSION['curErr'] = 'Invalid old password.';
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
							$_SESSION['curErr'] = 'All entries must be filled.';
						}
                    }
                }

                else
                {
                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Impossible de changer le mot de passe.';
					}

					else
					{
						$_SESSION['curErr'] = 'Unable to change password.';
					}
                }
            }

            //CHANGE EMAIL
            if (isset($_POST['changeMail']))
            {
                if (isset($_POST['mail']) && isset($_POST['newMail']) && isset($_POST['confirmMail']))
                {
                    $mail = test_input($_POST['mail']);
                    $newMail = test_input($_POST['newMail']);
                    $confirmMail = test_input($_POST['confirmMail']);

                    if ($mail == $_SESSION['email'])
                    {
                    	$req = $database->prepare('SELECT ID FROM users WHERE email=:email');

                    	$req->execute(array(
                    		'email' => $newMail
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
                    		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Nouveau courriel invalide.';
							}

							else
							{
								$_SESSION['curErr'] = 'Invalid new email.';
							}
                    	}

                    	else
                    	{

	                        if (filter_var($newMail, FILTER_VALIDATE_EMAIL) && $newMail != $mail)
	                        {
	                            //GET TOKEN FOR EMAIL VERIFICATION
	                            $token = generateRandomString();

	                            $req = $database->prepare('UPDATE users SET email=:email, token=:token, validated=:validated WHERE ID=:ID');
	                            $req->execute(array(
	                                'email' => $newMail,
	                                'token' => $token,
	                                'validated' => 0,
	                                'ID' => $_SESSION['ID']
	                            ));

	                            $_SESSION['newMailNotif'] = true;

	                            $_SESSION['newMail'] = $newMail;
	                            $_SESSION['token'] = "https://electronet.ca/validate?token=" . $token; //CHANGE FOR WEBSITE ADDRESS

	                            header('Location: ../../mail');
	                        }

	                        else
	                        {
	                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Nouveau courriel invalide.';
								}

								else
								{
									$_SESSION['curErr'] = 'Invalid new email.';
								}
	                        }
	                    }
                    }

                    else
                    {
                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Dernier courriel invalide.';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid old email.';
						}
                    }

                }

                else
                {
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Impossible de changer le courriel.';
					}

					else
					{
						$_SESSION['curErr'] = 'Unable to change email.';
					}     
                }
            }


			//UPDATE DOUBLE VERIFICATION
			if (isset($_POST['enableDoubleVerif']) || isset($_POST['disableDoubleVerif']))
			{
				if (isset($_POST['enableDoubleVerif']))
				{
					$verif = 1;
				}

				else if (isset($_POST['disableDoubleVerif']))
				{
					$verif = 2;
				}

				//enable it
				if ($verif == 1)
				{
					$req = $database->prepare('UPDATE users SET doubleVerif=:doubleVerif');
					$req->execute(array(
						'doubleVerif' => 1
					));

					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curInf'] = 'Authentificateur activé.';
					}

					else
					{
						$_SESSION['curInf'] = 'Authenticator activated.';
					}
				}

				//disable it
				else if ($verif == 2)
				{
					$req = $database->prepare('UPDATE users SET doubleVerif=:doubleVerif');
					$req->execute(array(
						'doubleVerif' => 0
					));

					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curInf'] = 'Authentificateur désactivé.';
					}

					else
					{
						$_SESSION['curInf'] = 'Authenticator deactivated.';
					}
				}
			}


			//CHANGE LANGUAGE
			if (isset($_POST['langFR']) || isset($_POST['langEN']))
			{
				if (isset($_POST['langFR']))
				{
					//UPDATE TO FRENCH LANGUAGE
					$req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

					$req->execute(array(
						'lang' => 'fr',
						'IP' => $_SESSION['IP']
					));

					$_SESSION['lang'] = 'fr';
				}

				else if (isset($_POST['langEN']))
				{
					//UPDATE TO ENGLISH LANGUAGE
					$req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

					$req->execute(array(
						'lang' => 'en',
						'IP' => $_SESSION['IP']
					));

					$_SESSION['lang'] = 'en';
				}
			}


			//CHANGE AVATAR
			if (isset($_POST['updateAvatar']) && isset($_FILES['myAvatar']) && $_FILES['myAvatar']['error'] == 0)
			{
				if ($_FILES['myAvatar']['size'] <= 1000000)
				{
					$fileName = pathinfo($_FILES['myAvatar']['name']);
					$fileExtension = $fileName['extension'];
					$authExtensions = array('jpg', 'jpeg', 'gif', 'png');

					if (in_array($fileExtension, $authExtensions))
					{
						$avatarName = 'uploads/' . $_SESSION['ID'] . '.' . $fileExtension;

						move_uploaded_file($_FILES['myAvatar']['tmp_name'], $avatarName);

						//UPDATE DATABASE'S AVATAR INFO
						$req = $database->prepare('UPDATE users SET avatar=:avatar WHERE ID=:ID');
						$req->execute(array(
							'avatar' => $avatarName,
							'ID' => $_SESSION['ID']
						));

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curSuc'] = 'Avatar modifié avec succès.';
						}

						else
						{
							$_SESSION['curSuc'] = 'Avatar successfully modified.';
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
						$_SESSION['curErr'] = 'Image trop massive (> 1 Mo).';
					}

					else
					{
						$_SESSION['curErr'] = 'Image too big (> 1 Mb).';
					}
				}
			}
			

			//DISCONNECT
			if (isset($_POST['disconnect']))
			{
			    session_destroy();
			    session_start();
			    session_regenerate_id(true);
				
				header('Location: ../../index');
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
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../util/estimate">ESTIMATION</a> |
							<a href="../util/request">POSTULER</a> |
							<a href="../util/params" id="current">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../util/estimate">ESTIMATE</a> |
							<a href="../util/request">APPLY</a> |
							<a href="../util/params" id="current">SETTINGS</a> |
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
							<a href="../util/params" id="current">PARAMÈTRES</a> |
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
							<a href="../util/params" id="current">SETTINGS</a> |
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
							<a href="../util/params" id="current">PARAMÈTRES</a> |
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
							<a href="../util/params" id="current">SETTINGS</a> |
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
							<a href="../util/params" id="current">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../util/params" id="current">SETTINGS</a> |
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
							<a href="../util/params" id="current">PARAMÈTRES</a>
						<?php
					}

					else
					{
						?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../admin/showRev">PAY EMPLOYEES</a> |
							<a href="../admin/vars">GLOBAL VARIABLES</a> |
							<a href="../util/params" id="current">SETTINGS</a>
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
						Paramètres et sécurité
					</p>
				<?php
			}

			else
			{
				?>
					<p class="mainTitle">
						Settings and Security
					</p>
				<?php
			}

			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				?>
					<span>
		                <p>Changement de nom</p>
		            </span>

		            <form target="" method="post">
		                <input type="text" name="newName" placeholder="Nouveau nom" value="<?php echo $_SESSION['name'];?>" />
		                <br />
		                <input type="submit" name="changeName" value="Modifier" />
		            </form>

					<br />

					<span>
						<p>Changement de mot de passe</p>
		            </span>

		            <p style="text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%;">
		                Dernière modification il y a
		                <?php
				        $nb = (time() - $_SESSION['passChDate']) / 86400;

				        if (round($nb, 0) > 2)
				        {
					        echo round($nb, 0) . ' jours';
				        }

				        else
				        {
					        echo round($nb, 0) . ' jour';
				        }
		                ?>
		            </p>

				    <form target="" method="post">
					    <input type="password" name="pass" placeholder="Ancien mot de passe" value=""><br>
					    <input type="password" name="newPass" placeholder="Nouveau mot de passe" value=""><br>
					    <input type="password" name="confirmPass" placeholder="Confirmer nouveau mot de passe" value=""><br>
					    <input type="submit" name="changePass" value="Modifier">
				    </form>

					<br />

					<span>
		                <p>Changement de courriel</p>
		            </span>

		            <form target="" method="post">
		                <input type="text" name="mail" placeholder="Ancien courriel" value="<?php echo $_SESSION['email'];?>" />
		                <br />
		                <input type="text" name="newMail" placeholder="Nouveau courriel" value="" />
		                <br />
		                <input type="text" name="confirmMail" placeholder="Confirmer nouveau courriel" value="" />
		                <br />
		                <input type="submit" name="changeMail" value="Modifier" />
		            </form>

					<br />

					<span>
		                <p>Double authentification</p>
						<?php
							$req = $database->prepare('SELECT doubleVerif FROM users WHERE ID=:ID');
							$req->execute(array(
								'ID' => $_SESSION['ID']
							));
							while ($result = $req->fetch())
							{
								if ($result['doubleVerif'] == 1)
								{
									$check = true;
								}

								else if ($result['doubleVerif'] == 0)
								{
									$check = false;
								}
							}
						?>

						<?php
							if (isset($check) && !$check)
							{
								?>
									<p style="text-decoration: none; text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%; color: darkred;">
										DÉSACTIVÉ
									</p>
								<?php
							}

							else if (isset($check) && $check)
							{
								?>
									<p style="text-decoration: none; text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%; color: mediumseagreen;">
										ACTIVÉ
									</p>
								<?php
							}
							?>
					</span>

				<form target="" method="post">

					<?php
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						if (isset($check) && !$check)
						{
							?>
								<input type="submit" name="enableDoubleVerif" value="Activer" />
							<?php
						}

						else if (isset($check) && $check)
						{
							?>
								<input type="submit" name="disableDoubleVerif" value="Désactiver" />
							<?php
						}
					}
					else
					{
						if (isset($check) && !$check)
						{
							?>
								<input type="submit" name="enableDoubleVerif" value="Activate" />
							<?php
						}

						else if (isset($check) && $check)
						{
							?>
								<input type="submit" name="disableDoubleVerif" value="Deactivate" />
							<?php
						}
					}
					?>
				</form>
							
					<br />
                    
					<span id="translate">
		                <p>Langue</p>
					</span>
					<form target="" method="post">
						<?php
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							?>
								<input type="submit" name="langEN" value="Translate in English" />
							<?php
						}

						else
						{
							?>
								<input type="submit" name="langFR" value="Traduire en Français" />
							<?php
						}
						?>
					</form>

					<br />

					<a href="logs" style="" id="linker">
					<div id="logs">
						<p>
							<p style="text-decoration: underline; color: darkred; font-size: 24px;">
								Journal de sécurité
							</p>
							<p id="newEvent">
								<?php
									$i = 0;
									$req = $database->prepare('SELECT ID FROM logs WHERE userID=:userID AND hide=:hide');
									$req->execute(array(
										'userID' => $_SESSION['ID'],
										'hide' => 0
									));

									while ($result = $req->fetch())
									{
										if ($result)
										{
											$i++;
										}
									}

									if ($i > 0)
									{
										?>
											<i class="material-icons" style="font-size: 20px; color: indianred;">
													gavel
											</i>
										<?php
									}

									if ($i == 1)
									{
										if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
										{
											echo $i . ' nouvel événement à consulter';
										}
								
										else
										{
											echo $i . ' new event to review';
										}
									}

									else if ($i > 1)
									{
										if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
										{
											echo $i . ' nouveaux événements à consulter';
										}
								
										else
										{
											echo $i . ' new events to review';
										}
									}
								?>
							</p>
						</p>
					</div>
				</a>
				
				<br />

				<span>
						<p>Avatar</p>
					</span>

					<p class="avatar">
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
							<img src="<?php echo $avatarName; ?>" alt="Error loading avatar" />
					</p>

					<form target="" method="post" enctype="multipart/form-data">

						<input type="file" id="file" class="inputfile" name="myAvatar" />
						<?php
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<label id="label" for="file">Sélectionner un avatar</label> <br />
								<?php
							}

							else
							{
								?>
									<label id="label" for="file">Select an avatar</label> <br />
								<?php
							}
						?>
						<br />
		                <input type="submit" name="updateAvatar" value="Modifier" />
					</form>

					<br />

					<div id="disconnect">

						<form target="" method="post">
							<input type="submit" name="disconnect" value="Se déconnecter">
						</form>

					</div>
				<?php
			}

			else
			{
				?>
					<span>
		                <p>Name change</p>
		            </span>

		            <form target="" method="post">
		                <input type="text" name="newName" placeholder="New name" value="<?php echo $_SESSION['name'];?>" />
		                <br />
		                <input type="submit" name="changeName" value="Modify" />
		            </form>

					<br />

					<span>
						<p>Password change</p>
		            </span>

		            <p style="text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%;">
		                Not updated since 
		                <?php
				        $nb = (time() - $_SESSION['passChDate']) / 86400;

				        if (round($nb, 0) > 2)
				        {
					        echo round($nb, 0) . ' days';
				        }

				        else
				        {
					        echo round($nb, 0) . ' day';
				        }
		                ?>
		            </p>

				    <form target="" method="post">
					    <input type="password" name="pass" placeholder="Former password" value=""><br>
					    <input type="password" name="newPass" placeholder="New password" value=""><br>
					    <input type="password" name="confirmPass" placeholder="Confirm new password" value=""><br>
					    <input type="submit" name="changePass" value="Modify">
				    </form>

					<br />

					<span>
		                <p>Email change</p>
		            </span>

		            <form target="" method="post">
		                <input type="text" name="mail" placeholder="Former email" value="<?php echo $_SESSION['email'];?>" />
		                <br />
		                <input type="text" name="newMail" placeholder="New email" value="" />
		                <br />
		                <input type="text" name="confirmMail" placeholder="Confirm new email" value="" />
		                <br />
		                <input type="submit" name="changeMail" value="Modify" />
		            </form>

					<br />

					<span>
		                <p>Double authentication</p>
						<?php
							$req = $database->prepare('SELECT doubleVerif FROM users WHERE ID=:ID');
							$req->execute(array(
								'ID' => $_SESSION['ID']
							));
							while ($result = $req->fetch())
							{
								if ($result['doubleVerif'] == 1)
								{
									$check = true;
								}

								else if ($result['doubleVerif'] == 0)
								{
									$check = false;
								}
							}
						?>

						<?php
							if (isset($check) && !$check)
							{
								?>
									<p style="text-decoration: none; text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%; color: darkred;">
										DEACTIVATED
									</p>
								<?php
							}

							else if (isset($check) && $check)
							{
								?>
									<p style="text-decoration: none; text-align: center; margin-right: auto; margin-left: auto; font-family: 'Blinker', sans-serif; font-size: 12px; font-style: italic; margin-top: 0%; margin-bottom: 1%; color: mediumseagreen;">
										ACTIVATED
									</p>
								<?php
							}
							?>
					</span>

					<form target="" method="post">
						<?php
							if (isset($check) && !$check)
							{
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									?>
										<input type="submit" name="enableDoubleVerif" value="Activer" />
									<?php
								}

								else
								{
									?>
										<input type="submit" name="enableDoubleVerif" value="Activate" />
									<?php
								}
							
							}

							else if (isset($check) && $check)
							{
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									?>
										<input type="submit" name="disableDoubleVerif" value="Désactiver" />
									<?php
								}

								else
								{
									?>
										<input type="submit" name="disableDoubleVerif" value="Deactivate" />
									<?php
								}
							
							}
						?>	
		            </form>

					<br />

					<span id="translate">
		                <p>Language</p>
					</span>
					<form target="" method="post">
						<?php
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							?>
								<input type="submit" name="langEN" value="Translate in English" />
							<?php
						}

						else
						{
							?>
								<input type="submit" name="langFR" value="Traduire en français" />
							<?php
						}
						?>
					</form>

					<br />

					<a href="logs" style="" id="linker">
					<div id="logs">
						<p>
							<p style="text-decoration: underline; color: darkred; font-size: 24px;">
								Security journal
							</p>
							<p id="newEvent">
								<?php
									$i = 0;
									$req = $database->prepare('SELECT ID FROM logs WHERE userID=:userID AND hide=:hide');
									$req->execute(array(
										'userID' => $_SESSION['ID'],
										'hide' => 0
									));

									while ($result = $req->fetch())
									{
										if ($result)
										{
											$i++;
										}
									}

									if ($i > 0)
									{
										?>
											<i class="material-icons" style="font-size: 20px; color: indianred;">
													gavel
											</i>
										<?php
									}

									if ($i == 1)
									{
										if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
										{
											echo $i . ' nouvel événement à consulter';
										}
								
										else
										{
											echo $i . ' new event to review';
										}
									}

									else if ($i > 1)
									{
										if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
										{
											echo $i . ' nouveaux événements à consulter';
										}
								
										else
										{
											echo $i . ' new events to review';
										}
									}
								?>
							</p>
						</p>
					</div>
				</a>
				
				<br />

				<span>
						<p>Avatar</p>
					</span>

					<p class="avatar">
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
							<img src="<?php echo $avatarName; ?>" alt="Error loading avatar" />
					</p>

					<form target="" method="post" enctype="multipart/form-data">

						<input type="file" id="file" class="inputfile" name="myAvatar" data-multiple-caption="{count} files selected" multiple />
						<?php
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								?>
									<label id="label" for="file">Sélectionner un avatar</label> <br />
								<?php
							}

							else
							{
								?>
									<label id="label" for="file">Select an avatar</label> <br />
								<?php
							}
						?>
						<br />
		                <input type="submit" name="updateAvatar" value="Modify" />
					</form>

					<br />

					<div id="disconnect">

						<form target="" method="post">
							<input type="submit" name="disconnect" value="Disconnect">
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
       
	   <!--<p id="credentials">
           ID: #<?php echo $_SESSION['ID'] ?> / <?php
                                                if ($_SESSION['perms'] == 0)
                                                {
                                                    ?>
                                                        <span style="color: darkslategray;">client</span>
                                                    <?php
                                                }

                                                else if ($_SESSION['perms'] == 1)
                                                {
                                                    ?>
                                                        <span style="color: dodgerblue;">travailleur</span>
                                                    <?php
                                                }

                                                else if ($_SESSION['perms'] == 2)
                                                {
                                                    ?>
                                                        <span style="color: mediumseagreen;">vendeur</span>
                                                    <?php
                                                }

                                                else if ($_SESSION['perms'] == 3)
                                                {
                                                    ?>
                                                        <span style="color: deeppink;">gestionnaire</span>
                                                    <?php
                                                }

                                                else if ($_SESSION['perms'] == 4)
                                                {
                                                    ?>
                                                        <span style="color: darkred;">admin</span>
                                                    <?php
                                                }
                                                    ?>
            <br />
            <span style="font-style: initial; font-size: 12px;">
                Compte créé il y a
                <?php
                    $nb = (time() - $_SESSION['creation']) / 86400;

                    if (round($nb, 0) > 2)
                    {
                        echo round($nb, 0) . ' jours';
                    }

                    else
                    {
                        echo round($nb, 0) . ' jour';
                    }
                ?>
            </span>
        </p>-->

		<script>
			var inputs = document.querySelectorAll( '.inputfile' );
			Array.prototype.forEach.call( inputs, function( input )
			{
				var label	 = input.nextElementSibling,
					labelVal = label.innerHTML;

				input.addEventListener( 'change', function( e )
				{
					var fileName = '';
					if( this.files && this.files.length > 1 )
						fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
					else
						fileName = e.target.value.split( '\' ).pop();

					if( fileName )
						label.querySelector( 'span' ).innerHTML = fileName;
					else
						label.innerHTML = labelVal;
				});
			});
		</script>
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