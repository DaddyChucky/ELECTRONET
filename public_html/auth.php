<link rel="stylesheet" href="authStyle.css" />

<?php

include 'head.php';
?>
<title>
        <?php 
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
                echo 'ELECTRONET > Authentification';
            }
        
            else
            {
                echo 'ELECTRONET > Authenticator';
            }
        ?>
</title>
<?php
    
	if (isset($_SESSION['doubleVerif']) && $_SESSION['doubleVerif'] == 2)
	{
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
			
			else if (isset($_POST['code']) && isset($_POST['enter']))
			{

				$code = test_input($_POST['code']);

				if (is_numeric($code))
				{
					//CHECK IF TOKEN MATCHES DATABASE
					$req = $database->prepare('SELECT verifTime FROM users WHERE verifToken=:verifToken AND ID=:ID');
					$req->execute(array(
						'verifToken' => $code,
						'ID' => $_SESSION['ID']
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
						//TOKEN EXISTS
						//ONLY ACCEPT NON-EXPIRED TOKEN
						if (time() <= $result['verifTime'])
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

							$_SESSION['doubleVerif'] = 0;
							$_SESSION['authPassed'] = true;
							header('Location: ../acc/my');
						}

						else
						{
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['error'] = 'Votre code d\'authentification a expir&eacute; (+15 min).<br/>Reconnectez-vous dans le site et regardez votre courriel pour rentrer un nouveau code valide';
							}

							else
							{
								$_SESSION['error'] = 'Your authenticator code has expired (+15 min).<br/>Relog in the Website and check your email to enter a valid (new) code.';
							}
						}
					}

					else
					{
						$_SESSION['i']++;

						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Code d\'authentification invalide.';
						}

						else
						{
							$_SESSION['curErr'] = 'Invalid authenticator code.';
						}

						header('Location: auth');
					}
					
				}

				else
				{
					$_SESSION['i']++;

					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
					{
						$_SESSION['curErr'] = 'Code d\'authentification invalide.';
					}

					else
					{
						$_SESSION['curErr'] = 'Invalid authenticator code.';
					}
					
					header('Location: auth');
				}
				
			}
		}

		if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
		{	
		?>
			<div>
				<h1 id="mainTitle">Double authentification</h1>
				<p id="disclaimer">
					Pour v&eacute;rifier qu'il s'agit bien de vous, <span style="font-style: italic;"><?php echo $_SESSION['name'] ?></span>, veuillez entrer ci-bas le code envoy&eacute; &agrave; l'adresse suivante: <br />
					<span style="color: darkred; font-size: 20px;">
						<?php 
							echo substr($_SESSION['email'], 0, 3) . '***' . substr($_SESSION['email'], -11, 11); 
						?>
					</span>
				</p>
				<form target="" method="post">
					<input type="text" name="code" placeholder="# # # # # #" value="" />
					<input type="submit" name="enter" value="Valider" />
				</form>
			</div>
		<?php
		}
		else
		{
			?>
				<h1 id="mainTitle">Double Authenticator</h1>
				<p id="disclaimer">
					To verify that this is you, <span style="font-style: italic;"><?php echo $_SESSION['name'] ?></span>, please enter the code sent to the following address below: <br />
					<span style="color: darkred; font-size: 20px;">
						<?php 
							echo substr($_SESSION['email'], 0, 3) . '***' . substr($_SESSION['email'], -11, 11); 
						?>
					</span>
				</p>
				<form target="" method="post">
					<input type="text" name="code" placeholder="# # # # # #" value="" />
					<input type="submit" name="enter" value="Validate" />
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

		header('Location: ../../error');
	}

?>