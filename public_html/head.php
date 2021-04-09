<!DOCTYPE html>
<html>

<head>
    
    <!--[if lt IE 9]>
    		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"> </script>
    	<!-->
    
    <meta charset="UTF-8">
    <meta name="description" content="Sp&eacute;cialiste des travaux r&eacute;sidentiels. / Specialist in residential work.">
    <meta name="keywords" content="ELECTRONET, electronet, electro, net, ELECTRO, NET, nettoyage, computer, cleaning, screen, écran, écrans, ecrans, ecran, conseil, conseils, specialist, specialists, towers, computer, advice, advices, jeunes, emploi, etudiants, étudiant, étudiants, etudiant, bilan, consultation, projet, analyse, systemes, systeme, systèmes, système, logiciels, logiciel, périphérique, peripherique, peripheriques, périphériques, company, dépoussiérer, depoussierer, surchauffe, faible, cout, coût, cheap, estimate, free, estimation, student, students, employment, book, booking, external, internal, interne, externe, cleaning, assessment, assessments, consultation, analysis, software, softwares, critical, dust, devices, piscine, vigne, vignes, piscines, lumiere, lumières, lumière, lumieres, noel, Noël, déneigement, toit, toiture, déglaçage, paysager, paysagement, vitres, lavage, vidage, gouttières, gouttieres, swimming, pool, vineyards, vine, vines, landscaping, land, christmas, Christmas, light, lights, roof, snow, romoval, ice, icing, de-icing, windows, gutters, estimate, free, partner, partnership, contact, account, electro, electronet, gatineau, chelsea, ottawa, net">
    <meta name="author" content="Charles De Lafontaine, ELECTRONET">
    <meta name="viewporth" content="width=device-width, initial-scale=1.0">
    
    <!-- OVERALL USE OF ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- PAGE NAV. ICON -->
    <link rel="icon" href="../../img/computer.png">
    
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Blinker:100,400,900&display=swap" rel="stylesheet" />
    
    <!-- START DATABASE CONNECTION -->
    <?php 
    	include 'session.php'; 
    	include 'variables.php'; 
    	include 'functions.php'; 
    ?>
    
    <!-- RETRIEVE PAGE LANGUAGE -->
    <?php
    	//CHECK IF USER'S IP WITHIN THE DATABASE
    	$req = $database->prepare('SELECT lang FROM language WHERE IP=:IP');
    
    	$req->execute(array(
    		'IP' => $_SESSION['IP']
    	));
    
    	while ($result = $req->fetch())
    	{
    		if ($result)
    		{
    			$_SESSION['lang'] = $result['lang'];
    		}
    	}
    
    	//UPDATE LANGUAGE DATABASE WITH DEFAULT SETTINGS (FRENCH)
    	if ($_SESSION['lang'] == '')
    	{
    		$req = $database->prepare('INSERT INTO language(IP, lang) VALUES(:IP, :lang)');
    
    		$req->execute(array(
    			'IP' => $_SESSION['IP'],
    			'lang' => 'fr'
    		));
    	}
    ?>
    
    <!-- Gads AUTO
    <script data-ad-client="ca-pub-6735028082586611" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
</head>