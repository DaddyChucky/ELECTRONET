<?php 
	include 'variables.php';

	if (isset($_SESSION['changeLangFR']) && $_SESSION['changeLangFR'])
	{
		$_SESSION['changeLangFR'] = false;
		setcookie('lang', 'fr', time() + 365*24*3600, null, null, false, true);
		header('Location: ../acc/util/params');
		
	}

	else if (isset($_SESSION['changeLangEN']) && $_SESSION['changeLangEN'])
	{
		$_SESSION['changeLangEN'] = false;
		setcookie('lang', 'en', time() + 365*24*3600, null, null, false, true);  
		header('Location: ../acc/util/params');
		
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