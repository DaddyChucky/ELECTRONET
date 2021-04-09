<link rel="stylesheet" href="authStyle.css" />

<?php

include 'head.php';
?>
    <title>
        <?php 
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
                echo 'ELECTRONET > Mot de passe oubli&eacute;';
            }
        
            else
            {
                echo 'ELECTRONET > Forgotten Password';
            }
        ?>
    </title>
<?php
	//IF THERE IS A TOKEN
	if ($_GET['rp'] != '')
	{
		filter_input(INPUT_GET, 'rp', FILTER_SANITIZE_URL);

		$token = $_GET['rp'];

		$req = $database->prepare('SELECT ID, name FROM users WHERE iforgot=:iforgot');

		$req->execute(array(

			'iforgot' => $token

		));

		while ($result = $req->fetch())
		{
			if ($result)
			{
				break;
			}
		}

		//IF TOKEN MATCHES WITH DATABASE
		if ($result)
		{
			$_SESSION['name'] = $result['name'];
			$_SESSION['ID'] = $result['ID'];

			include 'cur.php';


			if ($_SERVER['REQUEST_METHOD'] === 'POST')
			{
				if ($_SESSION['i'] > 7)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['error'] = 'Trop de tentatives.';
					}

					else
					{
						$_SESSION['error'] = 'Too many attempts.';
					}

					header('Location: error');
				}

				if (isset($_POST['newPass']) && isset($_POST['confirmNewPass']))
				{
					//CHECKS IF INPUTS ARE FILLED
                    if (!empty($_POST['newPass']) || !empty($_POST['confirmNewPass']))
                    {
                        $newPass = test_input($_POST['newPass']);
                        $confirmPass = test_input($_POST['confirmNewPass']);

                        //CHECKS IF NEW PASSWORD IS OK
                        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&*_-]{8,50}$/', $newPass))
                        {
							//CHECKS IF CONFIRMATION IS OK
							if ($newPass == $confirmPass)
							{
								$print = generateRandomString();

								//ENCRYPT NEW PASS
								$password = password_hash($newPass, PASSWORD_BCRYPT, array(
									'cost' => 12
								));

								$req = $database->prepare('UPDATE users SET password=:password, passChDate=:passChDate, iforgot=:iforgot WHERE ID=:ID');
								$req->execute(array(
									'password' => $password,
									'passChDate' => time(),
									'ID' => $_SESSION['ID'],
									'iforgot' => $print
								));

								$_SESSION['sendPassModify'] = true;

								header('Location: mail');
							}

							else
							{
								$_SESSION['i']++;

								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = '&eacute;chec dans la confirmation des mots de passe.';
								}

								else
								{
									$_SESSION['curErr'] = 'Password confirmation did not pass.';
								}
							}
						}
						
						else
						{
							$_SESSION['i']++;

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
						$_SESSION['i']++;

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

			}
			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
			{
				?>
					<div>
						<h1 id="mainTitle">Mot de passe oubli&eacute;</h1>
						<p id="disclaimer">
							Bonjour. Veuillez choisir un nouveau mot de passe pour votre compte ELECTRONET: <br />
						</p>
						<form target="" method="post">
							<input type="password" name="newPass" placeholder="Nouveau mot de passe*" value="" /><br/>
							<p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">*Doit contenir au moins 8 caractères, dont une majuscule et un chiffre.</p>
							<input type="password" name="confirmNewPass" placeholder="Confirmation du nouveau mot de passe" value="" /><br/>
							<input type="submit" name="update" value="Modifier" />
						</form>
					</div>
				<?php
			}

			else
			{
				?>
					<div>
						<h1 id="mainTitle">Forgotten Password</h1>
						<p id="disclaimer">
							Hello. Please enter a new password for your ELECTRONET account: <br />
						</p>
						<form target="" method="post">
							<input type="password" name="newPass" placeholder="New password*" value="" /><br/>
							<p style="padding-right: 20%; padding-left: 20%; font-size: 10px; font-style: italic; text-align: left;">*Must contain at least 8 characters, including a capital letter and a number.</p>
							<input type="password" name="confirmNewPass" placeholder="Confirm new password" value="" /><br/>
							<input type="submit" name="update" value="Modify" />
						</form>
					</div>
				<?php
			}

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

			header('Location: ../error');
		}
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

		header('Location: ../error');
	}

?>