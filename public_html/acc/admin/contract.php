
<link rel="stylesheet" href="contractStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Liste des contrats';
        }

        else
        {
            echo "ELECTRONET > Contracts' list";
        }
    ?>
</title>

<?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 3)
    {
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
				if ($_SESSION['perms'] == 3)
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
                            <a href="../acc/util/params">PARAMÈTRES</a>
                        <?php
                    }

                    else
                    {
                        ?>
                            <a href="../../acc/my">HOME</a> |
                            <a href="../admin/powertool">MANAGEMENT</a> |
                            <a href="../admin/showRev">PAY EMPLOYEES</a> |
                            <a href="../admin/vars">GLOBAL VARIABLES</a> |
                            <a href="../acc/util/params">SETTINGS</a>
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
                        Liste des contrats
                    </p>
                <?php
            }

            else
            {
                ?>
                    <p class="mainTitle">
                        Contracts' List
                    </p>
                <?php
            }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['modifyContract']))
            {

                if (isset($_POST['num']) && isset($_POST['verified']) && isset($_POST['completed']) && isset($_POST['IDseller']) && isset($_POST['IDworker']) && isset($_POST['customer']) && isset($_POST['location']) && isset($_POST['datentime']) && isset($_POST['price']) && isset($_POST['method']) && isset($_POST['description']) && isset($_POST['noteWork']) && isset($_POST['noteWorker']) && isset($_POST['comments']))
                {
                    $num = test_input($_POST['num']);
                    $verified = test_input($_POST['verified']);
                    $completed = test_input($_POST['completed']);
                    $IDseller = test_input($_POST['IDseller']);
                    $IDworker = test_input($_POST['IDworker']);
                    $customer = test_input($_POST['customer']);
                    $location = test_input($_POST['location']);
                    $datentime = test_input($_POST['datentime']);
                    $price = test_input($_POST['price']);
                    $initialPrice = $price;
                    $method = test_input($_POST['method']);

                    if (isset($_POST['depot']) && isset($_POST['reste']) && isset($_POST['cut']) && isset($_POST['cutWorker']) && isset($_POST['bns']))
                    {
                        $depot = test_input($_POST['depot']);
                        $reste = test_input($_POST['reste']);
                        $cut = test_input($_POST['cut']);
                        $cutWorker = test_input($_POST['cutWorker']);
                        $bns = test_input($_POST['bns']);
                    }

                    $description = test_input($_POST['description']);
                    $noteWork = test_input($_POST['noteWork']);
                    $noteWorker = test_input($_POST['noteWorker']);
                    $comments = test_input($_POST['comments']);
                    $count = 0;

                    if (empty($num) || !is_numeric($num))
                    {
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Numéro de contrat invalide.';
						}

						else
						{
							$_SESSION['curErr'] = 'Contract number is invalid.';
						}

                        header('Location: contract');
                    }

                    else
                    {

                        if ($verified == 'oui' || $verified == '2')
                        {
                            $verifiedToInt = 2;
                        }

                        else if ($verified == 'non' || $verified == '0')
                        {
                            $verifiedToInt = 0;
                        }

                        else if ($verified == 'auto' || $verified == '1')
                        {
                            $verifiedToInt = 1;
                        }

                        if ($completed == 'oui' || $completed == '1')
                        {
                            $completedToInt = 1;
                        }

                        else if ($completed == 'non' || $completed == '2')
                        {
                            $completedToInt = 2;
                        }

                        else if ($completed == 'auto' || $completed == '0')
                        {
                            $completedToInt = 0;
                        }

                            //EVADE BUGS WITH COMPLETED & VERIFIED
                            if ($completedToInt == 1)
                            {
                                if (empty($verified))
                                {
                                    $verifiedToInt = 2;
                                }
                            }

                            else if ($completedToInt == 2)
                            {
                                if (empty($verified))
                                {
                                    $verifiedToInt = 0;
                                }
                            }

                        if (!empty($IDseller) && !is_numeric($IDseller))
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'ID vendeur est invalide.';
							}

							else
							{
								$_SESSION['curErr'] = 'Seller\'s ID is invalid.';
							}

                            header('Location: contract');
                        }

                        else
                        {

                            if (!empty($IDworker) && !is_numeric($IDworker))
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'ID travailleur est invalide.';
								}

								else
								{
									$_SESSION['curErr'] = 'Worker\'s ID is invalid.';
								}

                                header('Location: contract');
                            }

                            else
                            {
                                if (!empty($price) && !is_numeric($price) || $price < 0 || $price > 10000)
                                {
                                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										$_SESSION['curErr'] = 'Prix invalide.';
									}

									else
									{
										$_SESSION['curErr'] = 'Invalid price.';
									}

                                    header('Location: contract');
                                }

                                else
                                {

                                    if (!empty($depot) && !is_numeric($depot))
                                    {
                                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
										{
											$_SESSION['curErr'] = 'Dépôt invalide.';
										}

										else
										{
											$_SESSION['curErr'] = 'Invalid depot.';
										}

                                        header('Location: contract');
                                    }

                                    else
                                    {

                                        if (!empty($reste) && !is_numeric($reste))
                                        {
                                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
											{
												$_SESSION['curErr'] = 'Reste invalide.';
											}

											else
											{
												$_SESSION['curErr'] = 'Invalid leftover.';
											}

                                            header('Location: contract');
                                        }

                                        else
                                        {

                                            if (!empty($cut) && !is_numeric($cut))
                                            {
                                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													$_SESSION['curErr'] = 'Ristourne vendeur invalide.';
												}

												else
												{
													$_SESSION['curErr'] = 'Seller\'s cut invalid.';
												}

                                                header('Location: contract');
                                            }

                                            else
                                            {

                                                if (!empty($cutWorker) && !is_numeric($cutWorker))
                                                {
                                                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
													{
														$_SESSION['curErr'] = 'Ristourne travailleur invalide.';
													}

													else
													{
														$_SESSION['curErr'] = 'Worker\'s cut invalid.';
													}

                                                    header('Location: contract');
                                                }

                                                else if (isset($_POST['bns']) && !empty($bns) && !is_numeric($bns))
                                                {
                                                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
													{
														$_SESSION['curErr'] = 'Bonus invalide.';
													}

													else
													{
														$_SESSION['curErr'] = 'Bonus is invalid.';
													}

                                                    header('Location: contract');
                                                }

                                                else
                                                {

                                                    if (!empty($noteWork) && !is_numeric($noteWork))
                                                    {
                                                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
														{
															$_SESSION['curErr'] = 'Note travail invalide.';
														}

														else
														{
															$_SESSION['curErr'] = 'Invalid note work.';
														}

                                                        header('Location: contract');
                                                    }

                                                    else if ($noteWork < 0 || $noteWork > 100)
                                                    {
                                                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
														{
															$_SESSION['curErr'] = 'Note travail invalide.';
														}

														else
														{
															$_SESSION['curErr'] = 'Invalid note work.';
														}

                                                        header('Location: contract');
                                                    }

                                                    else
                                                    {
                                                        if (!empty($noteWorker) && !is_numeric($noteWorker))
                                                        {
                                                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
															{
																$_SESSION['curErr'] = 'Note travailleur invalide.';
															}

															else
															{
																$_SESSION['curErr'] = 'Invalid note worker.';
															}

                                                            header('Location: contract');
                                                        }

                                                        else if ($noteWorker < 0 || $noteWorker > 100)
                                                        {
                                                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
															{
																$_SESSION['curErr'] = 'Note travailleur invalide.';
															}

															else
															{
																$_SESSION['curErr'] = 'Invalid note worker.';
															}

                                                            header('Location: contract');
                                                        }

                                                        else
                                                        {
                                                            $req = $database->prepare('SELECT verified, completed, IDseller, IDworker, customer, location, datentime, price, depot, reste, method, cut, cutWorker, bns, description, noteWork, noteWorker, comments FROM contracts WHERE num=:num');

                                                            $req->execute(array(
                                                                'num' => $num
                                                                ));

                                                            while ($result = $req->fetch())
                                                            {
                                                                if ($result)
                                                                {
                                                                    $count++;

                                                                    if (empty($IDseller))
                                                                    {
                                                                        $IDseller = $result['IDseller'];
                                                                    }

                                                                    if (empty($IDworker))
                                                                    {
                                                                        $IDworker = $result['IDworker'];
                                                                    }

                                                                    if (empty($verified))
                                                                    {
                                                                        $verifiedToInt = $result['verified'];
                                                                    }

                                                                    if (empty($completed))
                                                                    {
                                                                        $completedToInt = $result['completed'];
                                                                    }

                                                                    if (empty($customer))
                                                                    {
                                                                        $customer = $result['customer'];
                                                                    }

                                                                    if (empty($location))
                                                                    {
                                                                        $location = $result['location'];
                                                                    }

                                                                    if (empty($datentime))
                                                                    {
                                                                        $datentime = $result['datentime'];
                                                                    }

                                                                    if (empty($price))
                                                                    {
                                                                        $price = $result['price'];

                                                                        if (empty($depot))
                                                                        {
                                                                            $depot = $result['depot'];
                                                                        }

                                                                        if (empty($reste))
                                                                        {
                                                                            $reste = $result['reste'];
                                                                        }

                                                                        if (empty($cut))
                                                                        {
                                                                            $cut = $result['cut'];
                                                                        }

                                                                        if (empty($cutWorker))
                                                                        {
                                                                            $cutWorker = $result['cutWorker'];
                                                                        }
                                                                    }

																	$price = round($price, 2);
																	
                                                                    $depot = $price * $_SESSION['const_depot'];
                                                                    $depot = round($depot, 2);
                                                                    $reste = $price - $depot;
                                                                    $reste = round($reste, 2);

                                                                    $searchTaxes = $database->prepare('SELECT taxes FROM vars');
                                                                    $searchTaxes->execute();

                                                                    while ($printTaxes = $searchTaxes->fetch())
                                                                    {
                                                                        if ($printTaxes)
                                                                        {
																			$taxes = $printTaxes['taxes'];
                                                                        }
                                                                    }

																	$searchTaxes = $database->prepare('SELECT cut, cut2, cut3, cutWorker, cutWorker2, cutWorker3 FROM vars');
																	$searchTaxes->execute();
																	while ($printTaxes = $searchTaxes->fetch())
																	{
																		if ($printTaxes)
																		{
																			$cut = $printTaxes['cut'];
																			$cut2 = $printTaxes['cut2'];
																			$cut3 = $printTaxes['cut3'];
																			$cutWorker = $printTaxes['cutWorker'];
																			$cutWorker2 = $printTaxes['cutWorker2'];
																			$cutWorker3 = $printTaxes['cutWorker3'];
																		}
																	}
																

																	$searchTaxes = $database->prepare('SELECT tierT FROM users WHERE ID=:ID');
																	$searchTaxes->execute(array(
																		'ID' => $IDworker
																	));

																	while ($printTaxes = $searchTaxes->fetch())
																	{
																		if ($printTaxes)
																		{
																			//MODIFIABLE TO
																			if ($printTaxes['tierT'] == 0)
																			{
																				$nb = $cutWorker;
																			}

																			else if ($printTaxes['tierT'] == 1)
																			{
																				$nb = $cutWorker2;
																			}

																			else if ($printTaxes['tierT'] == 2)
																			{
																				$nb = $cutWorker3;
																			}
																		}
																	}

																	$searchTaxes = $database->prepare('SELECT tierV FROM users WHERE ID=:ID');
																	$searchTaxes->execute(array(
																		'ID' => $IDseller
																	));

																	while ($printTaxes = $searchTaxes->fetch())
																	{
																		if ($printTaxes)
																		{
																			if ($printTaxes['tierV'] == 0)
																			{
																				$nb2 = $cut;
																			}

																			else if ($printTaxes['tierV'] == 1)
																			{
																				$nb2 = $cut2;
																			}

																			if ($printTaxes['tierV'] == 2)
																			{
																				$nb2 = $cut3;
																			}
																		}
																	}

                                                                    $cutWorker = ($price - $price * $taxes) * $nb;
                                                                    $cutWorker = round($cutWorker, 2);      
																	$cut = ($price - $price * $taxes) * $nb2;
                                                                    $cut = round($cut, 2);

                                                                    if (empty($method))
                                                                    {
                                                                        $method = $result['method'];
                                                                    }

																	if (empty($bns))
                                                                    {
                                                                        $bns = $result['bns'];
                                                                    }

                                                                    if (empty($description))
                                                                    {
                                                                        $description = $result['description'];
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

                                                                    //FIXING BUGS RELATED TO VERIFIED AND COMPLETED
                                                                    if ($result['completed'] == 1)
                                                                    {
                                                                        if ($verifiedToInt != 2)
                                                                        {
                                                                            $verifiedToInt = 2;
                                                                        }
                                                                    }

                                                                    if ($result['completed'] == 0)
                                                                    {
                                                                        if ($verifiedToInt == 0)
                                                                        {
                                                                            $completedToInt = 2;
                                                                        }
                                                                    }

                                                                    if ($_SESSION['perms'] == 3)
                                                                    {
                                                                        //TRIES TO CHANGE PRICE WHILE CONTRACT IS ALREADY COMPLETED
                                                                        if (!empty($initialPrice) && $result['completed'] == 1)
                                                                        {
																			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
																			{
																				$_SESSION['curErr'] = 'Contrat complété; le prix ne peut être modifié.';
																			}

																			else
																			{
																				$_SESSION['curErr'] = 'Contract is completed, therefore price cannot be modified.';
																			}

                                                                            header('Location: contract');
                                                                        }

                                                                        else
                                                                        {
                                                                            $updatedBy = $_SESSION['ID'];

                                                                            $req = $database->prepare('UPDATE contracts SET IDseller=:IDseller, IDworker=:IDworker, customer=:customer, location=:location, datentime=:datentime, price=:price, method=:method, depot=:depot, reste=:reste, cut=:cut, cutWorker=:cutWorker, bns=:bns, description=:description, noteWork=:noteWork, noteWorker=:noteWorker, comments=:comments, verified=:verified, completed=:completed, lastUpdated=:lastUpdated, updatedBy=:updatedBy WHERE num=:num');

                                                                            $req->execute(array(
                                                                                'num' => $num,
                                                                                'IDseller' => $IDseller,
                                                                                'IDworker' => $IDworker,
                                                                                'customer' => $customer,
                                                                                'location' => $location,
                                                                                'datentime' => $datentime,
                                                                                'price' => $price,
                                                                                'method' => $method,
                                                                                'depot' => $depot,
                                                                                'reste' => $reste,
                                                                                'cut' => $cut,
                                                                                'cutWorker' => $cutWorker,
																				'bns' => $bns,
                                                                                'description' => $description,
                                                                                'noteWork' => $noteWork,
                                                                                'noteWorker' => $noteWorker,
                                                                                'comments' => $comments,
                                                                                'verified' => $verifiedToInt,
                                                                                'completed' => $completedToInt,
                                                                                'lastUpdated' => time(),
                                                                                'updatedBy' => $updatedBy
                                                                                ));
                                                                        }
                                                                    }

                                                                    else
                                                                    {
                                                                        $updatedBy = 'adm';

                                                                        $req = $database->prepare('UPDATE contracts SET IDseller=:IDseller, IDworker=:IDworker, customer=:customer, location=:location, datentime=:datentime, price=:price, method=:method, depot=:depot, reste=:reste, cut=:cut, cutWorker=:cutWorker, bns=:bns, description=:description, noteWork=:noteWork, noteWorker=:noteWorker, comments=:comments, verified=:verified, completed=:completed, lastUpdated=:lastUpdated, updatedBy=:updatedBy WHERE num=:num');

                                                                        $req->execute(array(
                                                                            'num' => $num,
                                                                            'IDseller' => $IDseller,
                                                                            'IDworker' => $IDworker,
                                                                            'customer' => $customer,
                                                                            'location' => $location,
                                                                            'datentime' => $datentime,
                                                                            'price' => $price,
                                                                            'method' => $method,
                                                                            'depot' => $depot,
                                                                            'reste' => $reste,
                                                                            'cut' => $cut,
                                                                            'cutWorker' => $cutWorker,
                                                                            'bns' => $bns,
                                                                            'description' => $description,
                                                                            'noteWork' => $noteWork,
                                                                            'noteWorker' => $noteWorker,
                                                                            'comments' => $comments,
                                                                            'verified' => $verifiedToInt,
                                                                            'completed' => $completedToInt,
                                                                            'lastUpdated' => time(),
                                                                            'updatedBy' => $updatedBy
                                                                            ));
																			//DEBUG: echo $num . '//' . $IDseller . '//' . $IDworker . '//' . $customer . '//' . $location . '//' . $datentime . '//' . $price . '//' . $method . '//' . $depot . '//' . $reste . '//' . $cut . '//' . $cutWorker . '//' . $bns . '//' . $description . '//' . $noteWork . '//' . $noteWorker . '//' . $comments . '//' . $verifiedToInt . '//' . $completedToInt . '//' . time() . '//' . $updatedBy;
                                                                    }

                                                                    //UPDATE SELLER'S PAYCHECK
                                                                    if ($verifiedToInt == 2) //VERIFIED
                                                                    {
                                                                        $increment = 0;

                                                                        //CHECK EXISTENCE OF PAY
                                                                        $check = $database->prepare('SELECT ID FROM payescurr WHERE contractNum=:contractNum');

                                                                        $check->execute(array(
                                                                            'contractNum' => $num
                                                                            ));

                                                                        while ($existence = $check->fetch())
                                                                        {
                                                                            if ($existence['ID'])
                                                                            {
                                                                                $increment++;
                                                                            }
                                                                        }

                                                                        //CASE 0 - PAY DOES NOT EXIST, CREATE
                                                                        if ($increment == 0)
                                                                        {
                                                                            $check = $database->prepare('INSERT INTO payescurr(IDseller, contractNum, cut, datentime, paySeller) VALUES(:IDseller, :contractNum, :cut, :datentime, :paySeller)');

                                                                            $check->execute(array(
                                                                                'IDseller' => $IDseller,
                                                                                'contractNum' => $num,
                                                                                'cut' => $cut,
                                                                                'datentime' => time(),
                                                                                'paySeller' => 1
                                                                                ));
                                                                        }

                                                                        //CASE 1 - PAY DOES EXIST, UPDATE
                                                                        else if ($increment == 1)
                                                                        {
                                                                            $check = $database->prepare('UPDATE payescurr SET datentime=:datentime, paySeller=:paySeller, cut=:cut, IDseller=:IDseller WHERE contractNum=:contractNum');

                                                                            $check->execute(array(
                                                                                'datentime' => time(),
                                                                                'paySeller' => 1,
                                                                                'IDseller' => $IDseller,
                                                                                'cut' => $cut,
                                                                                'contractNum' => $num
                                                                                ));
                                                                        }
                                                                    }

                                                                    else
                                                                    {
                                                                        //UPDATE PAID IF CONTRACT EXISTS
                                                                        $increment = 0;

                                                                        //CHECK EXISTENCE OF PAY
                                                                        $check = $database->prepare('SELECT ID FROM payescurr WHERE contractNum=:contractNum');

                                                                        $check->execute(array(
                                                                            'contractNum' => $num
                                                                            ));

                                                                        while ($existence = $check->fetch())
                                                                        {
                                                                            if ($existence['ID'])
                                                                            {
                                                                                $increment++;
                                                                            }
                                                                        }

                                                                        if ($increment == 1)
                                                                        {
                                                                            $check = $database->prepare('UPDATE payescurr SET datentime=:datentime, paySeller=:paySeller, cut=:cut, IDseller=:IDseller WHERE contractNum=:contractNum');

                                                                            $check->execute(array(
                                                                                'datentime' => time(),
                                                                                'paySeller' => 0,
                                                                                'IDseller' => $IDseller,
                                                                                'cut' => $cut,
                                                                                'contractNum' => $num
                                                                                ));
                                                                        }
                                                                    }


                                                                    //UPDATE WORKER'S PAYCHECK
                                                                    if ($completedToInt == 1)
                                                                    {
																		$increment = 0;

                                                                        //CHECK EXISTENCE OF PAY
                                                                        $check = $database->prepare('SELECT ID FROM payescurr WHERE contractNum=:contractNum');

                                                                        $check->execute(array(
                                                                            'contractNum' => $num
                                                                            ));

                                                                        while ($existence = $check->fetch())
                                                                        {
                                                                            if ($existence['ID'])
                                                                            {
                                                                                $increment++;
                                                                            }
                                                                        }
                                                                        //CASE 0 - PAY DOES NOT EXIST, CREATE
                                                                        if ($increment == 0)
                                                                        {
                                                                            $check = $database->prepare('INSERT INTO payescurr(IDworker, contractNum, cutWorker, datentime, payWorker, bns) VALUES(:IDworker, :contractNum, :cutWorker, :datentime, :payWorker, :bns)');

                                                                            $check->execute(array(
                                                                                'IDworker' => $IDworker,
                                                                                'contractNum' => $num,
                                                                                'cutWorker' => $cutWorker,
                                                                                'datentime' => time(),
                                                                                'payWorker' => 1,
																				'bns' => $bns
                                                                                ));
                                                                        }

                                                                        //CASE 1 - PAY DOES EXIST, UPDATE
                                                                        else if ($increment == 1)
                                                                        {
                                                                            $check = $database->prepare('UPDATE payescurr SET datentime=:datentime, payWorker=:payWorker, cutWorker=:cutWorker, IDworker=:IDworker, bns=:bns WHERE contractNum=:contractNum');

                                                                            $check->execute(array(
                                                                                'datentime' => time(),
                                                                                'payWorker' => 1,
                                                                                'IDworker' => $IDworker,
                                                                                'cutWorker' => $cutWorker,
                                                                                'contractNum' => $num,
																				'bns' => $bns
                                                                                ));
                                                                        }
                                                                    }

																	else
																	{
																		//UPDATE PAID IF CONTRACT EXISTS
                                                                        $increment = 0;

                                                                        //CHECK EXISTENCE OF PAY
                                                                        $check = $database->prepare('SELECT ID FROM payescurr WHERE contractNum=:contractNum');

                                                                        $check->execute(array(
                                                                            'contractNum' => $num
                                                                            ));

                                                                        while ($existence = $check->fetch())
                                                                        {
                                                                            if ($existence['ID'])
                                                                            {
                                                                                $increment++;
                                                                            }
                                                                        }

                                                                        if ($increment == 1)
                                                                        {
                                                                            $check = $database->prepare('UPDATE payescurr SET datentime=:datentime, payWorker=:payWorker, cutWorker=:cutWorker, IDworker=:IDworker, bns=:bns WHERE contractNum=:contractNum');

                                                                            $check->execute(array(
                                                                                'datentime' => time(),
                                                                                'payWorker' => 0,
                                                                                'IDworker' => $IDworker,
                                                                                'cutWorker' => $cutWorker,
                                                                                'contractNum' => $num,
																				'bns' => $bns
                                                                                ));
                                                                        }
																	}
                                                                }
                                                            }

                                                            if ($count == 0)
                                                            {
																if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
																{
																	$_SESSION['curErr'] = 'Numéro de contrat invalide.';
																}

																else
																{
																	$_SESSION['curErr'] = 'Invalid contract number.';
																}
                                                                
                                                                header('Location: contract');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
{
    ?>
    <span>
        <p>Contrats non v&#233;rifi&#233;s</p>
    </span>  
     
        <table>
            <tr>
                <th class="columnTitle">
                    # Contrat
                </th>

                <th class="columnTitle">
                    ID Vendeur
                </th>

                <th class="columnTitle">
                    ID Travailleur
                </th>

                <th class="columnTitle">
                    Client
                </th>

                <th class="columnTitle">
                    Location
                </th>
           
                <th class="columnTitle">
                    Date
                </th>
      
                <th class="columnTitle">
                    Prix
                </th>

                <th class="columnTitle">
                    D&#233;p&#xF4;t
                </th>

                <th class="columnTitle">
                    Ristourne V.
                </th>

                <th class="columnTitle">
                    Ristourne T.
                </th>
          
                <th class="columnTitle">
                    Description
                </th>

            </tr>
    <?php
}

else
{  
    ?>
        <span>
        <p>Non-verified contracts</p>
    </span>  
     
        <table>
            <tr>
                <th class="columnTitle">
                    Contract #
                </th>

                <th class="columnTitle">
                    ID Seller
                </th>

                <th class="columnTitle">
                    ID Worker
                </th>

                <th class="columnTitle">
                    Customer
                </th>

                <th class="columnTitle">
                    Location
                </th>
           
                <th class="columnTitle">
                    Date
                </th>
      
                <th class="columnTitle">
                    Price
                </th>

                <th class="columnTitle">
                    Deposit
                </th>

                <th class="columnTitle">
                    Cut S.
                </th>

                <th class="columnTitle">
                    Cut W.
                </th>
          
                <th class="columnTitle">
                    Description
                </th>

            </tr>
    <?php
}

            $req = $database->prepare('SELECT num, IDseller, customer, location, datentime, price, depot, cut, cutWorker, description, IDworker, verified FROM contracts ORDER BY num ASC');

            $req->execute();

            while ($result = $req->fetch())
            {
               //UNVERIFIED CONTRACTS FIRST
               if ($result['verified'] == 1)
               {
                        ?>
               
                        <tr class="tableLine">

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['num'];
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['IDseller'];
                                ?>
                            </td>

                            <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                <?php
                                    echo $result['IDworker'];
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['customer'];
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['location'];
                                ?>
                            </td>

                            <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                <?php
                                    echo $result['datentime'];
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['price'] . ' $';
                                ?>
                            </td>

                            <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                <?php
                                    echo $result['depot'] . ' $';
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['cut'] . ' $';
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['cutWorker'] . ' $';
                                ?>
                            </td>

                            <td style="padding: 16px; border-right: 2px dashed black;">
                                <?php
                                    echo $result['description'];
                                ?>
                            </td>
                            
                        </tr>
                        
               <?php
               }
            }
               ?>
                </table>

                <?php
                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                    {
                        ?>
                            <span>
                    <p>Contrats non compl&#233;t&#233;s</p>
                </span>  
                 
                    <table>
                        <tr>
                            <th class="columnTitle">
                                # Contrat
                            </th>

                            <th class="columnTitle">
                                ID Travailleur
                            </th>

                            <th class="columnTitle">
                                Client
                            </th>

                            <th class="columnTitle">
                                Location
                            </th>
                       
                            <th class="columnTitle">
                                Date
                            </th>
                  
                            <th class="columnTitle">
                                Prix
                            </th>

                            <th class="columnTitle">
                                Reste
                            </th>

                            <th class="columnTitle">
                                M&#233;thode
                            </th>

                            <th class="columnTitle">
                                Ristourne T.
                            </th>
                      
                            <th class="columnTitle">
                                Description
                            </th>
                       
                            <th class="columnTitle">
                                Note travail
                            </th>
                       
                            <th class="columnTitle">
                                Note travailleur
                            </th>
                       
                            <th class="columnTitle">
                                Commentaires
                            </th>

                        </tr>
                        <?php
                    }

                    else
                    {
                        ?>
                            <span>
                    <p>Non-completed contracts</p>
                </span>  
                 
                    <table>
                        <tr>
                            <th class="columnTitle">
                                Contract #
                            </th>

                            <th class="columnTitle">
                                ID Worker
                            </th>

                            <th class="columnTitle">
                                Customer
                            </th>

                            <th class="columnTitle">
                                Location
                            </th>
                       
                            <th class="columnTitle">
                                Date
                            </th>
                  
                            <th class="columnTitle">
                                Price
                            </th>

                            <th class="columnTitle">
                                Rest
                            </th>

                            <th class="columnTitle">
                                Method
                            </th>

                            <th class="columnTitle">
                                Cut W.
                            </th>
                      
                            <th class="columnTitle">
                                Description
                            </th>
                       
                            <th class="columnTitle">
                                Note work
                            </th>
                       
                            <th class="columnTitle">
                                Note workers
                            </th>
                       
                            <th class="columnTitle">
                                Comments
                            </th>

                        </tr>
                        <?php
                    }

                        $req = $database->prepare('SELECT num, customer, location, datentime, price, method, reste, cutWorker, description, IDworker, noteWork, noteWorker, comments, verified, completed FROM contracts ORDER BY num ASC');

                        $req->execute();

                        while ($result = $req->fetch())
                        {
                            if ($result['verified'] == 2 && $result['completed'] == 0)
                            {
                                ?>
               
                                <tr class="tableLine">

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['num'];
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['IDworker'];
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['customer'];
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['location'];
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            echo $result['datentime'];
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['price'] . ' $';
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            echo $result['reste'] . ' $';
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            echo $result['method'];
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['cutWorker'] . ' $';
                                        ?>
                                    </td>

                                    <td style="padding: 16px; border-right: 2px dashed black;">
                                        <?php
                                            echo $result['description'];
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            if ($result['noteWork'] == 0)
                                            {
                                                echo 'N/A';
                                            }

                                            else
                                            {
                                                echo $result['noteWork'] . '/100';
                                            }
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            if ($result['noteWorker'] == 0)
                                            {
                                                echo 'N/A';
                                            }

                                            else
                                            {
                                                echo $result['noteWorker'] . '/100';
                                            }
                                        ?>
                                    </td>

                                    <td style="color: red; font-size: 14px; padding: 16px; border-right: 2px dashed black; background-color: gray; background: url(../../img/diagonalStripes.png), no-repeat, fixed; background-size: cover;">
                                        <?php
                                            echo $result['comments'];
                                        ?>
                                    </td>

                                </tr>

                                <?php
                            }
                        }
                                ?>
                    </table>

                    <?php

                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                        {
                            ?>
                                <span>
                        <p>Historique des contrats</p>
                    </span>  
                 
                    <table>
                        <tr>
                            <th class="columnTitle">
                                # Contrat
                            </th>

                            <th class="columnTitle">
                                ID Vendeur
                            </th>

                            <th class="columnTitle">
                                ID Travailleur
                            </th>

                            <th class="columnTitle">
                                Client
                            </th>

                            <th class="columnTitle">
                                Location
                            </th>
                       
                            <th class="columnTitle">
                                Date
                            </th>
                  
                            <th class="columnTitle">
                                Prix
                            </th>

                            <th class="columnTitle">
                                D&#233;p&#xF4;t
                            </th>

                            <th class="columnTitle">
                                Reste
                            </th>

                            <th class="columnTitle">
                                M&#233;thode
                            </th>

                            <th class="columnTitle">
                                Ristourne V.
                            </th>

                            <th class="columnTitle">
                                Ristourne T.
                            </th>

                            <th class="columnTitle">
                                Bonus T.
                            </th>
                      
                            <th class="columnTitle">
                                Description
                            </th>
                       
                            <th class="columnTitle">
                                Note travail
                            </th>
                       
                            <th class="columnTitle">
                                Note travailleur
                            </th>
                       
                            <th class="columnTitle">
                                Commentaires
                            </th>

                            <th class="columnTitle">
                                V&#233;rifi&#233;
                            </th>

                            <th class="columnTitle">
                                Compl&#233;t&#233;
                            </th>

                        </tr>
                            <?php
                        }

                        else
                        {
                            ?>
                                <span>
                        <p>Contracts' historic</p>
                    </span>  
                 
                    <table>
                        <tr>
                            <th class="columnTitle">
                                Contract #
                            </th>

                            <th class="columnTitle">
                                ID Seller
                            </th>

                            <th class="columnTitle">
                                ID Worker
                            </th>

                            <th class="columnTitle">
                                Customer
                            </th>

                            <th class="columnTitle">
                                Location
                            </th>
                       
                            <th class="columnTitle">
                                Date
                            </th>
                  
                            <th class="columnTitle">
                                Price
                            </th>

                            <th class="columnTitle">
                                Deposit
                            </th>

                            <th class="columnTitle">
                                Rest
                            </th>

                            <th class="columnTitle">
                                Method
                            </th>

                            <th class="columnTitle">
                                Cut S.
                            </th>

                            <th class="columnTitle">
                                Cut W.
                            </th>

                            <th class="columnTitle">
                                Bonus W.
                            </th>
                      
                            <th class="columnTitle">
                                Description
                            </th>
                       
                            <th class="columnTitle">
                                Note work
                            </th>
                       
                            <th class="columnTitle">
                                Note workers
                            </th>
                       
                            <th class="columnTitle">
                                Comments
                            </th>

                            <th class="columnTitle">
                                Verified
                            </th>

                            <th class="columnTitle">
                                Completed
                            </th>

                        </tr>
                            <?php
                        }
                    
                        $req = $database->prepare('SELECT num, IDseller, customer, location, datentime, price, method, depot, reste, cut, cutWorker, bns, description, IDworker, noteWork, noteWorker, comments, verified, completed FROM contracts ORDER BY num DESC');

                        $req->execute();

                        while ($result = $req->fetch())
                        {
                            if ($result['verified'] == 0 && $result['completed'] == 2 || $result['verified'] == 2 && $result['completed'] == 1 || $result['verified'] == 2 && $result['completed'] == 2)
                            {
                                ?>
                                    <tr class="tableLine">

                                        <td style="
                                                    padding: 16px; 
                                                    border-right: 2px dashed black;
                                                    <?php
                                                        if ($result['verified'] == 2 && $result['completed'] == 1)
                                                        {
                                                            ?>
                                                                background-color: lightgreen;
                                                            <?php
                                                        }

                                                        else
                                                        {
                                                            ?>
                                                                background-color: lightpink;
                                                            <?php
                                                        }
                                                        
                                                    ?>
                                                    ">
                                            <?php
                                                echo $result['num'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['IDseller'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['IDworker'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['customer'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['location'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['datentime'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['price'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['depot'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['reste'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['method'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['cut'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['cutWorker'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['bns'] . ' $';
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['description'];
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                if ($result['noteWork'] == 0)
                                                {
                                                    echo 'N/A';
                                                }

                                                else
                                                {
                                                    echo $result['noteWork'] . '/100';
                                                }
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                if ($result['noteWorker'] == 0)
                                                {
                                                    echo 'N/A';
                                                }

                                                else
                                                {
                                                    echo $result['noteWorker'] . '/100';
                                                }
                                            ?>
                                        </td>

                                        <td style="padding: 16px; border-right: 2px dashed black;">
                                            <?php
                                                echo $result['comments'];
                                            ?>
                                        </td>

                                        <td style="
                                                    padding: 16px; 
                                                    border-right: 2px dashed black;
                                                    <?php
                                                        if ($result['verified'] == 0)
                                                        {
                                                            ?>
                                                                background-color: lightpink;
                                                            <?php
                                                        }

                                                        else
                                                        {
                                                            ?>
                                                                background-color: lightgreen;
                                                            <?php
                                                        }
                                                    ?>
                                                    ">
                                            <?php
                                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                                            {
                                                if ($result['verified'] == 0)
                                                {
                                                    echo 'non';
                                                }

                                                else
                                                {
                                                    echo 'oui';
                                                }
                                            }

                                            else
                                            {
                                                if ($result['verified'] == 0)
                                                {
                                                    echo 'no';
                                                }

                                                else
                                                {
                                                    echo 'yes';
                                                }
                                            }
                                                
                                            ?>
                                        </td>

                                        <td style="
                                                    padding: 16px; 
                                                    border-right: 2px dashed black;
                                                    <?php

                                                        if ($result['completed'] == 2)
                                                        {
                                                            ?>
                                                                background-color: lightpink;
                                                            <?php
                                                        }

                                                        else
                                                        {
                                                            ?>
                                                                background-color: lightgreen;
                                                            <?php
                                                        }
                                                    ?>
                                                    ">
                                            <?php
                                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                                            {
                                                 if ($result['completed'] == 2)
                                                {
                                                    echo 'non';
                                                }

                                                else
                                                {
                                                    echo 'oui';
                                                }
                                            }

                                            else
                                            {
                                                 if ($result['completed'] == 2)
                                                {
                                                    echo 'no';
                                                }

                                                else
                                                {
                                                    echo 'yes';
                                                }
                                            }
                                               
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }

                                ?>

                    </table>

                    <?php
                        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                        {
                            ?>
                                <span>
                        <p>Modifier un contrat</p>
                    </span>

                    <form target="" method="post">

                        <input type="text" name="num" placeholder="# Contrat" value="" />
                        <br />
                        <input type="text" name="verified" placeholder="V&#233;rifi&#233;" value="" />
                        <br />
                        <input type="text" name="completed" placeholder="Compl&#233;t&#233;" value="" />
                        <br />
                        <input type="text" name="IDseller" placeholder="ID Vendeur" value="" />
                        <br />
                        <input type="text" name="IDworker" placeholder="ID Travailleur" value="" />
                        <br />
                        <input type="text" name="customer" placeholder="Client" value="" />
                        <br />
                        <input type="text" name="location" placeholder="Location" value="" />
                        <br />
                        <input type="text" name="datentime" placeholder="Date" value="" />
                        <br />
                        <input type="text" name="price" placeholder="Prix" value="" />
                        <br />
                        <?php
                            if ($_SESSION['perms'] == 4)
                            {
                        ?>
                                <input type="text" name="depot" placeholder="D&#233;p&#xF4;t" value="" />
                                <br />
                                <input type="text" name="reste" placeholder="Reste" value="" />
                                <br />
                                <input type="text" name="cut" placeholder="Ristourne V." value="" />
                                <br />
                                <input type="text" name="cutWorker" placeholder="Ristourne T." value="" />
                                <br />
                                <input type="text" name="bns" placeholder="Bonus T." value="" />
                                <br />
                        <?php
                            }
                        ?>
                        <input type="text" name="method" placeholder="M&#233;thode" value="" />
                        <br />
                        <input type="text" name="description" placeholder="Description" value="" />
                        <br />
                        <input type="text" name="noteWork" placeholder="Note travail" value="" />
                        <br />
                        <input type="text" name="noteWorker" placeholder="Note travailleur" value="" />
                        <br />
                        <input type="text" name="comments" placeholder="Commentaires" value="" />
                        <br />

                        <input type="submit" name="modifyContract" value="Modifier" />

                    </form>
                            <?php
                        }

                        else
                        {
                            ?>

                                <span>
                        <p>Modify a contract</p>
                    </span>

                    <form target="" method="post">

                        <input type="text" name="num" placeholder="Contract #" value="" />
                        <br />
                        <input type="text" name="verified" placeholder="Verified" value="" />
                        <br />
                        <input type="text" name="completed" placeholder="Completed" value="" />
                        <br />
                        <input type="text" name="IDseller" placeholder="ID Seller" value="" />
                        <br />
                        <input type="text" name="IDworker" placeholder="ID Worker" value="" />
                        <br />
                        <input type="text" name="customer" placeholder="Customer" value="" />
                        <br />
                        <input type="text" name="location" placeholder="Location" value="" />
                        <br />
                        <input type="text" name="datentime" placeholder="Date" value="" />
                        <br />
                        <input type="text" name="price" placeholder="Price" value="" />
                        <br />
                        <?php
                            if ($_SESSION['perms'] == 4)
                            {
                        ?>
                                <input type="text" name="depot" placeholder="Deposit" value="" />
                                <br />
                                <input type="text" name="reste" placeholder="Rest" value="" />
                                <br />
                                <input type="text" name="cut" placeholder="Cut S." value="" />
                                <br />
                                <input type="text" name="cutWorker" placeholder="Cut W." value="" />
                                <br />
                                <input type="text" name="bns" placeholder="Bonus W." value="" />
                                <br />
                        <?php
                            }
                        ?>
                        <input type="text" name="method" placeholder="Method" value="" />
                        <br />
                        <input type="text" name="description" placeholder="Description" value="" />
                        <br />
                        <input type="text" name="noteWork" placeholder="Note work" value="" />
                        <br />
                        <input type="text" name="noteWorker" placeholder="Note worker" value="" />
                        <br />
                        <input type="text" name="comments" placeholder="Comments" value="" />
                        <br />

                        <input type="submit" name="modifyContract" value="Modify" />

                    </form>
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
        
        header('Location: ../../error');
    }
?>