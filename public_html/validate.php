<?php
		
	include 'head.php';
    ?>
    <title>
            <?php 
                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
            	{
                    echo 'ELECTRONET > Validation du courriel';
                }
            
                else
                {
                    echo 'ELECTRONET > Email validation';
                }
            ?>
    </title>
    <?php
	//IF THERE IS A TOKEN
	if ($_GET['token'] != '')
	{
		filter_input(INPUT_GET, 'token', FILTER_SANITIZE_URL);
		//TODO - CUSTOMIZE TOKEN UPON ACCOUNT CREATION
		$token = $_GET['token'];

		$req = $database->prepare('SELECT ID, validated FROM users WHERE token=:token');

		$req->execute(array(

			'token' => $token

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
			if ($result['validated'] == 0)
			{
				$req = $database->prepare('UPDATE users SET validated=:validated WHERE token=:token');

				$req->execute(array(

					'validated' => 1,
					'token' => $token

				));

				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
            	{
            		$_SESSION['curSuc'] = 'Courriel valid&eacute; avec succ&egrave;s. Vous pouvez d&eacute;sormais vous connecter dans votre compte.';
            	}

            	else
            	{
            		$_SESSION['curSuc'] = 'Email successfully validated. You may log in your account.';
            	}

				header('location: register');
			}

			else
			{
				if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
            	{
            		$_SESSION['curInf'] = 'Courriel d&eacute;j&agrave; valid&eacute. Vous pouvez vous connecter dans votre compte.';
            	}

            	else
            	{
            		$_SESSION['curInf'] = 'Email already validated. You may log in your account.';
            	}

            	header('location: register');
			}	
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