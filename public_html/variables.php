<?php
	//STARTING SESSION
	if (!isset($_SESSION))
	{
		session_start();
	}


    //GLOBAL VARIABLES 
	//MODIFIED TO REAL VALUE IN SESSION.PHP
    if (!isset($_SESSION['const_cut']))
    {
        $_SESSION['const_cut'] = 0;
    }

    if (!isset($_SESSION['const_cutWorker']))
    {
        $_SESSION['const_cutWorker'] = 0;
    }

    if (!isset($_SESSION['const_depot']))
    {
        $_SESSION['const_depot'] = 0;
    }


	//SESSION VARIABLES
    if (!isset($_SESSION['roof']))
 	{
   		$_SESSION['roof'] = 0;
	}

	if (!isset($_SESSION['pool']))
 	{
   		$_SESSION['pool'] = 0;
	}

	if (!isset($_SESSION['ice']))
 	{
   		$_SESSION['ice'] = 0;
	}

	if (!isset($_SESSION['vines']))
 	{
   		$_SESSION['vines'] = 0;
	}

	if (!isset($_SESSION['gutters']))
 	{
   		$_SESSION['gutters'] = 0;
	}

	if (!isset($_SESSION['pays']))
 	{
   		$_SESSION['pays'] = 0;
	}

	if (!isset($_SESSION['error']))
 	{
   		$_SESSION['error'] = '';
	}

	if (!isset($_SESSION['impotF']))
 	{
   		$_SESSION['impotF'] = 0;
	}

	if (!isset($_SESSION['sendEstimate']))
 	{
   		$_SESSION['sendEstimate'] = false;
	}

	if (!isset($_SESSION['estimateAdd']))
 	{
   		$_SESSION['estimateAdd'] = '';
	}

	if (!isset($_SESSION['impotP']))
 	{
   		$_SESSION['impotP'] = 0;
	}

	if (!isset($_SESSION['RRQ']))
 	{
   		$_SESSION['RRQ'] = 0;
	}

	if (!isset($_SESSION['receiverName']))
 	{
   		$_SESSION['receiverName'] = '';
	}

	if (!isset($_SESSION['receiverEmail']))
 	{
   		$_SESSION['receiverEmail'] = '';
	}

	if (!isset($_SESSION['receiptReceiver']))
 	{
   		$_SESSION['receiptReceiver'] = 0;
	}

	if (!isset($_SESSION['sendReceipt']))
 	{
   		$_SESSION['sendReceipt'] = 0;
	}

	if (!isset($_SESSION['RQAPemploye']))
 	{
   		$_SESSION['RQAPemploye'] = 0;
	}

	if (!isset($_SESSION['RQAPemployeur']))
 	{
   		$_SESSION['RQAPemployeur'] = 0;
	}

	if (!isset($_SESSION['AEemploye']))
 	{
   		$_SESSION['AEemploye'] = 0;
	}

	if (!isset($_SESSION['AEemployeur']))
 	{
   		$_SESSION['AEemployeur'] = 0;
	}

	if (!isset($_SESSION['datentimeReceiver']))
 	{
   		$_SESSION['datentimeReceiver'] = '';
	}

	if (!isset($_SESSION['AEemployeReceiver']))
 	{
   		$_SESSION['AEemployeReceiver'] = 0;
	}

	if (!isset($_SESSION['RQAPemployeReceiver']))
 	{
   		$_SESSION['RQAPemployeReceiver'] = 0;
	}

	if (!isset($_SESSION['RRQReceiver']))
 	{
   		$_SESSION['RRQReceiver'] = 0;
	}

	if (!isset($_SESSION['impotPReceiver']))
 	{
   		$_SESSION['impotPReceiver'] = 0;
	}

	if (!isset($_SESSION['impotFReceiver']))
 	{
   		$_SESSION['impotFReceiver'] = 0;
	}

	if (!isset($_SESSION['brutReceiver']))
 	{
   		$_SESSION['brutReceiver'] = 0;
	}

	if (!isset($_SESSION['revReceiver']))
 	{
   		$_SESSION['revReceiver'] = 0;
	}

	if (!isset($_SESSION['CST']))
 	{
   		$_SESSION['CST'] = 0;
	}

	if (!isset($_SESSION['CNESSTemployeur']))
 	{
   		$_SESSION['CNESSTemployeur'] = 0;
	}

	if (!isset($_SESSION['FSS']))
 	{
   		$_SESSION['FSS'] = 0;
	}

	if (!isset($_SESSION['curErr']))
	{
		$_SESSION['curErr'] = '';
	}

	if (!isset($_SESSION['curInf']))
	{
		$_SESSION['curInf'] = '';
	}

	if (!isset($_SESSION['curSuc']))
	{
		$_SESSION['curSuc'] = '';
	}

	if (!isset($_SESSION['sessionStartTime']))
	{
		$_SESSION['sessionStartTime'] = time();
	}

	if (!isset($_SESSION['name']))
	{
		$_SESSION['name'] = '';
	}

	if (!isset($_SESSION['email']))
	{
		$_SESSION['email'] = '';
	}

	if (!isset($_SESSION['bug']))
	{
		$_SESSION['bug'] = '';
	}

	if (!isset($_SESSION['prob']))
	{
		$_SESSION['prob'] = '';
	}

	if (!isset($_SESSION['misc']))
	{
		$_SESSION['misc'] = '';
	}

	if (!isset($_SESSION['newMail']))
	{
		$_SESSION['newMail'] = '';
	}

	if (!isset($_SESSION['sendCreationEmail']))
	{
		$_SESSION['sendCreationEmail'] = false;
	}

	if (!isset($_SESSION['resendCreationEmail']))
	{
		$_SESSION['resendCreationEmail'] = false;
	}

	if (!isset($_SESSION['newMailNotif']))
	{
		$_SESSION['newMailNotif'] = false;
	}

	if (!isset($_SESSION['notifPassEmail']))
	{
		$_SESSION['notifPassEmail'] = false;
	}

	if (!isset($_SESSION['authPassed']))
	{
		$_SESSION['autPassed'] = false;
	}

	if (!isset($_SESSION['sendPassModify']))
	{
		$_SESSION['sendPassModify'] = false;
	}

	if (!isset($_SESSION['perms']))
	{
		$_SESSION['perms'] = 0;
	}

	if (!isset($_SESSION['creation']))
	{
		$_SESSION['creation'] = 0;
	}

	if (!isset($_SESSION['passChDate']))
	{
		$_SESSION['passChDate'] = 0;
	}

	if (!isset($_SESSION['estimateVal']))
	{
		$_SESSION['estimateVal'] = 0;
	}
	
	if (!isset($_SESSION['IP']))
	{
		$_SESSION['IP'] = '';
	}

	if (!isset($_SESSION['doubleVerif']))
	{
		$_SESSION['doubleVerif'] = 0;
	}

	if (!isset($_SESSION['iforgot']))
	{
		$_SESSION['iforgot'] = false;
	}

	if (!isset($_SESSION['token']))
	{
		$_SESSION['token'] = '';
	}

	if (!isset($_SESSION['verifToken']))
	{
		$_SESSION['verifToken'] = 0;
	}

	if (!isset($_SESSION['windows']))
	{
		$_SESSION['windows'] = 0;
	}

	if (!isset($_SESSION['i']))
	{
		$_SESSION['i'] = 0;
	}

	if (!isset($_SESSION['lang']))
	{
		$_SESSION['lang'] = '';
	}

	if (!isset($_SESSION['sendHelp']))
	{
		$_SESSION['sendHelp'] = 0;
	}

	if (!isset($_SESSION['receiveUpdates']))
	{
		$_SESSION['receiveUpdates'] = 0;
	}


	//COMMON VARS
	if (!isset($cleanInP))
	{
		$cleanInP = 0;
	}

	if (!isset($password))
	{
		$password = '';
	}

	if (!isset($cleanOutP))
	{
		$cleanOutP = 0;
	}

	if (!isset($ban))
	{
		$ban = 0;
	}

	if (!isset($banReason))
	{
		$banReason = '';
	}

	if (!isset($brut))
	{
		$brut = 0;
	}

	if (!isset($costEmployer))
	{
		$costEmployer = 0;
	}

	if (!isset($screen0))
	{
		$screen0 = 0;
	}

	if (!isset($screen32))
	{
		$screen32 = 0;
	}

	if (!isset($screen60))
	{
		$screen60 = 0;
	}

	if (!isset($taxes))
	{
		$taxes = 0;
	}

	if (!isset($onlBoost))
	{
		$onlBoost = 0;
	}

	if (!isset($day))
	{
		$day = 0;
	}

	if (!isset($print))
	{
		$print = '';
	}

	if (!isset($windows))
	{
		$windows = 0;
	}

	if (!isset($gutters))
	{
		$gutters = 0;
	}

	if (!isset($tStamp))
	{
		$tStamp = '';
	}

	if (!isset($const))
	{
		$const = 0;
	}

	if (!isset($count))
	{
		$count = 0;
	}

    if (!isset($increment))
	{
		$increment = 0;
	}

	if (!isset($impotP))
	{
		$impotP = 0;
	}

	if (!isset($impotF))
	{
		$impotF = 0;
	}

	if (!isset($RRQ))
	{
		$RRQ = 0;
	}

	if (!isset($RQAPemploye))
	{
		$RQAPemploye = 0;
	}

	if (!isset($RQAPemployeur))
	{
		$RQAPemployeur = 0;
	}

	if (!isset($AEemploye))
	{
		$AEemploye = 0;
	}

	if (!isset($AEemployeur))
	{
		$AEemployeur = 0;
	}

	if (!isset($CST))
	{
		$CST = 0;
	}

	if (!isset($CNESSTemployeur))
	{
		$CNESSTemployeur = 0;
	}

	if (!isset($FSS))
	{
		$FSS = 0;
	}

	if (!isset($clientName))
	{
		$clientName = '';
	}

	if (!isset($clientLoc))
	{
		$clientLoc = '';
	}

	if (!isset($datentime))
	{
		$datetime = '';
	}

	if (!isset($price))
	{
		$price = 0;
	}

    if (!isset($initialPrice))
	{
		$initialPrice = 0;
	}

	if (!isset($desc))
	{
		$desc = '';
	}

    if (!isset($description))
	{
		$description = '';
	}

    if (!isset($cut))
	{
		$cut = 0;
	}

	if (!isset($cut2))
	{
		$cut2 = 0;
	}

	if (!isset($cut3))
	{
		$cut3 = 0;
	}

    if (!isset($cutWorker))
	{
		$cutWorker = 0;
	}

	if (!isset($cutWorker2))
	{
		$cutWorker2 = 0;
	}

	if (!isset($cutWorker3))
	{
		$cutWorker3 = 0;
	}

	if (!isset($tierV))
	{
		$tierV = 0;
	}

	if (!isset($tierT))
	{
		$tierT = 0;
	}

    if (!isset($nb))
	{
		$nb = 0;
	}

	if (!isset($nb2))
	{
		$nb2 = 0;
	}

    if (!isset($total))
    {
        $total = 0;
    }

	if (!isset($tot))
    {
        $tot = 0;
    }

    if (!isset($id))
    {
        $id = 0;
    }

    if (!isset($name))
    {
        $name = '';
    }

    if (!isset($courriel))
    {
        $courriel = '';
    }

    if (!isset($perms))
    {
        $perms = '';
    }

    if (!isset($validated))
    {
        $validated = '';
    }

    if (!isset($validatedToInt))
    {
        $validatedToInt = 69;
    }

    if (!isset($permsToInt))
    {
        $permsToInt = 69;
    }

    if (!isset($depot))
    {
        $depot = 0;
    }

    if (!isset($reste))
    {
        $reste = 0;
    }

    if (!isset($num))
    {
        $num = 0;
    }

	if (!isset($check))
    {
        $check = 0;
    }

    if (!isset($verified))
    {
        $verified = '';
    }

    if (!isset($verifiedToInt))
    {
        $verifiedToInt = 0;
    }

	if (!isset($verif))
    {
        $verif = 0;
    }

    if (!isset($completed))
    {
        $completed = '';
    }

    if (!isset($completedToInt))
    {
        $completedToInt = 0;
    }

    if (!isset($IDseller))
    {
        $IDseller = 0;
    }

    if (!isset($IDworker))
    {
        $IDworker = 0;
    }

    if (!isset($customer))
    {
        $customer = '';
    }

    if (!isset($location))
    {
        $location = '';
    }

    if (!isset($method))
    {
        $method = '';
    }

    if (!isset($noteWork))
    {
        $noteWork = 0;
    }

    if (!isset($noteWorker))
    {
        $noteWorker = 0;
    }

    if (!isset($comments))
    {
        $comments = '';
    }

    if (!isset($updatedBy))
    {
        $updatedBy = '';
    }

	if (!isset($i))
    {
        $i = 0;
    }

	if (!isset($maxID))
    {
        $maxID = 0;
    }

	if (!isset($max))
    {
        $max = 0;
    }

	if (!isset($token))
    {
        $token = '';
    }

	if (!isset($verifToken))
    {
        $verifToken = 0;
    }

	if (!isset($code))
    {
        $code = 0;
    }

	if (!isset($fileName))
    {
        $fileName = '';
    }

	if (!isset($fileExtension))
    {
        $fileExtension = '';
    }

	if (!isset($authExtensions))
    {
        $authExtensions = array('', '', '', '');
    }

	if (!isset($avatarName))
    {
        $avatarName = '';
    }

	if (!isset($misc))
    {
        $misc = '';
    }

	if (!isset($bug))
    {
        $bug = '';
    }

	if (!isset($prob))
    {
        $prob = '';
    }
?>