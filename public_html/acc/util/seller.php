
<link rel="stylesheet" href="sellStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Ventes';
        }

        else
        {
            echo 'ELECTRONET > Sells';
        }
    ?>
</title>

<?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 1)
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['num']) && isset($_POST['clientName']) && isset($_POST['clientLoc']) && isset($_POST['datentime']) && isset($_POST['price']) && isset($_POST['desc']) && isset($_POST['modifyContract']))
            {
                if ($_POST['modifyContract'])
                {
                    $num = test_input($_POST['num']);
                    $clientName = test_input($_POST['clientName']);
                    $clientLoc = test_input($_POST['clientLoc']);
                    $datentime = test_input($_POST['datentime']);
                    $price = test_input($_POST['price']);

                    if (is_numeric($price))
                    {
                        $price = round($price, 2);
                    }

                    $desc = test_input($_POST['desc']);

                    if (!empty($num))
                    {
                        $req = $database->prepare('SELECT IDseller, customer, location, datentime, price, description, verified, completed FROM contracts WHERE num=:num');

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

                        //CHECKS IF SELLER CAN MODIFY CONTRACT
                        //CHECKS IF CONTRACT IS EMITTED BY HIM
                        else if ($_SESSION['ID'] == $result['IDseller'])
                        {
                            //CHECKS IF CONTRACT CAN BE MODIFIED
                            if ($result['verified'] == 1 && $result['completed'] == 0)
                            {
                                //NOT UPDATING EMPTY FORMS
                                if (empty($clientName) && empty($clientLoc) && empty($datentime) && empty($price) && empty($desc))
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

                                if (empty($clientName))
                                {
                                    $clientName = $result['customer'];
                                }

                                if (empty($clientLoc))
                                {
                                    $clientLoc = $result['location'];
                                }

                                if (empty($datentime))
                                {
                                    $datentime = $result['datentime'];
                                }

                                if (empty($price))
                                {
                                    $price = $result['price'];
                                }

                                else if ($price <= 0 || $price > 10000 || !is_numeric($price))
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

                                if (empty($desc))
                                {
                                    $desc = $result['description'];
                                }

                                    //GRAB TAXES
                                    $req = $database->prepare('SELECT taxes FROM vars');

                                    $req->execute();

                                    while ($result = $req->fetch())
                                    {
                                        if ($result)
                                        {
                                            break;
                                        }
                                    }

                                    $depot = $price * $_SESSION['const_depot'];
                                    $depot = round($depot, 2);

                                    $reste = $price - $depot;
                                    $reste = round($reste, 2);

                                    $cut = ($price - $price * $result['taxes']) * $_SESSION['const_cut'];
                                    $cut = round($cut, 2);

                                    $cutWorker = ($price - $price * $taxes) * $_SESSION['const_cutWorker'];
                                    $cutWorker = round($cutWorker, 2);

                                        //EVERYTHING GOOD, UPDATE
                                        $req = $database->prepare('UPDATE contracts SET customer=:customer, location=:location, datentime=:datentime, price=:price, depot=:depot, reste=:reste, cut=:cut, cutWorker=:cutWorker, description=:description, lastUpdated=:lastUpdated, updatedBy=:updatedBy WHERE num=:num');

                                        $req->execute(array(
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
                                            'updatedBy' => $_SESSION['ID'],
                                            'num' => $num
                                            ));
                            }

                            else
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Ce contrat ne peut être modifié*.';
								}

								else
								{
									$_SESSION['curErr'] = 'This contract may not be modified*.';
								}

                            }
                        }

                        else
                        {
							if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Vous ne pouvez pas modifier ce contrat*.';
							}

							else
							{
								$_SESSION['curErr'] = 'You may not modify this contract*.';
							}
                            
                        }
                    }

                    else
                    {
                        $_SESSION['curErr'] = 'You must enter a contract number.';
                    }
                }
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
				if ($_SESSION['perms'] == 2)
				{
                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                    {
                        ?>
                            <a href="../../acc/my">ACCUEIL</a> |
                            <a href="../util/estimate">ESTIMATION</a> |
                            <a href="../util/work">TRAVAUX</a> |
                            <a href="../util/seller" id="current">VENTES</a> |
                            <a href="../util/pay">REVENU</a> |
                            <a href="../util/histo">HISTORIQUE</a> |
                            <a href="../util/params">PARAMÈTRES</a> |
                            <a href="../util/help" style="cursor: help;">AIDE</a>
                        <?php
                    }

                    else
                    {
                        ?>
                            <a href="../../acc/my">HOME</a> |
                            <a href="../util/estimate">ESTIMATE</a> |
                            <a href="../util/work">WORKS</a> |
                            <a href="../util/seller" id="current">SELLS</a> |
                            <a href="../util/pay">PAY</a> |
                            <a href="../util/histo">HISTORIC</a> |
                            <a href="../util/params">SETTINGS</a> |
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
                            <a href="../util/params">PARAMÈTRES</a> |
                            <a href="../util/help" style="cursor: help;">AIDE</a>
                        <?php
                    }

                    else
                    {
                        ?>
                            <a href="../../acc/my">HOME</a> |
                            <a href="../admin/powertool">MANAGEMENT</a> |
                            <a href="../util/params">SETTINGS</a> |
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
                            <a href="../util/params">PARAMÈTRES</a>
                        <?php
                    }

                    else
                    {
                        ?>
                            <a href="../../acc/my">HOME</a> |
                            <a href="../admin/powertool">MANAGEMENT</a> |
                            <a href="../admin/showRev">PAY EMPLOYEES</a> |
                            <a href="../admin/vars">GLOBAL VARIABLES</a> |
                            <a href="../util/params">SETTINGS</a>
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
                        Modifier une vente
                    </p>

                    <form target="" method="post">

                        <input type="text" name="num" placeholder="# Contrat" value="" /> <br />
                        <input type="text" name="clientName" placeholder="Nom client" value="" /> <br />
                        <input type="text" name="clientLoc" placeholder="Location client" value="" /> <br />
                        <input type="text" name="datentime" placeholder="Date et heure des travaux (jj/mm/aaaa HH:mm)" value=""> <br />
                        <input type="text" name="price" placeholder="Coût des travaux" value=""> <br/>
                        <input type="text" name="desc" placeholder="Description des travaux" value=""> <br/>

                        <input type="submit" name="modifyContract" value="Modifier" />
                    </form>

                    <span>
                        <p id="disclaimer">*Vous pouvez uniquement modifier vos ventes en cours et non celles d&#233;j&#xE0; v&#233;rifi&#233;es ou compl&#233;t&#233;es.</p>
                    </span>
                <?php
            }

            else
            {
                ?>
                    <p class="mainTitle">
                        Modify A Sell
                    </p>

                    <form target="" method="post">

                        <input type="text" name="num" placeholder="Contract #" value="" /> <br />
                        <input type="text" name="clientName" placeholder="Client's name" value="" /> <br />
                        <input type="text" name="clientLoc" placeholder="Client's location" value="" /> <br />
                        <input type="text" name="datentime" placeholder="Date and time of work (dd/mm/yyyy HH:mm)" value=""> <br />
                        <input type="text" name="price" placeholder="Works' cost" value=""> <br/>
                        <input type="text" name="desc" placeholder="Works' description" value=""> <br/>

                        <input type="submit" name="modifyContract" value="Modify" />
                    </form>

                    <span>
                        <p id="disclaimer">*You can only modify your current sales and not those already verified or completed.</p>
                    </span>
                <?php
            }
        ?>

        <?php
        //SHOW CONTRACTS
        $req = $database->prepare('SELECT num, customer, location, datentime, price, cut, description, verified, completed, lastUpdated, updatedBy FROM contracts WHERE IDseller=:IDseller ORDER BY num DESC');

        $req->execute(array(
            'IDseller' => $_SESSION['ID']
            ));

        while ($result = $req->fetch())
        {
            if ($result)
            {
?>
                <table style="  border: 8px double;
                                border-color: black;
                                text-align: center;
                                margin-right: auto;
                                margin-left: auto;
                                margin-top: 4%;
                                margin-bottom: 4%;
                                width: 50%;
                                height: 50%;
                                font-family: 'Blinker', sans-serif;
                                <?php
                                if ($result['completed'] == 1)
                                {
                                ?>
                                color: gray;
                                border-color: gray;
                                background: url(../../img/grayStripes.png), no-repeat, fixed;
                                background-size: cover;
                                <?php
                                }

                                else if ($result['completed'] == 2)
                                {
                                ?>
                                color: red;
                                border-color: red;
                                background: url(../../img/redStripes.jpg), no-repeat, fixed;
                                background-size: cover;
                                <?php   
                                }
                                ?>
                                ">

    <tr>
        <th style="border-bottom: 2px dashed;
                                     border-color: black;
                                     <?php
                                     if ($result['completed'] == 1)
                                     {
                                     ?>
                                     border-color: gray;
                                     <?php
                                     }
                                     else if ($result['completed'] == 2)
                                     {
                                     ?>
                                     border-color: red;
                                     <?php
                                     }
                                     ?>
                                     text-align: center; 
                                     font-size: 34px; 
                                     font-weight: initial;
                                     ">
                                     <?php
                                     if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                                    {
                                        ?>
                                            Contrat #<?php echo $result['num'] . ' ';
                                    }

                                    else
                                    {
                                        ?>
                                            Contract #<?php echo $result['num'] . ' ';
                                    }
            
                                        //STATUS
                                        if ($result['verified'] == 0) //DENIED VERIFICATION
                                        {
            ?>
            <i class="material-icons" style="color: red;" title="Sale denied">close</i>
            <?php
                                        }

                                        else if ($result['verified'] == 1) //PENDING VERIFICATION
                                        {
            ?>
            <i class="material-icons" style="color: cornflowerblue;" title="Sale not yet verified">refresh</i>
            <?php
                                        }

                                        else if ($result['verified'] == 2 && $result['completed'] == 0) //VERIFIED
                                        {
            ?>
            <i class="material-icons" style="color: mediumseagreen;" title="Sale verified">check</i>
            <?php
                                        }

                                        else if ($result['verified'] == 2 && $result['completed'] == 1)
                                        {
            ?>
            <i class="material-icons" style="color: gray;">check</i>
            <?php
                                        }
            ?>
        </th>
    </tr>
    <tr>
        <?php
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            ?>
            <td>
                Client:
                <b>
                    <?php echo $result['customer']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Adresse:
                <b>
                    <?php echo $result['location']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Prix:
                <b>
                    <?php echo $result['price'] . ' $'; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Ristourne:
                <b>
                    <?php echo $result['cut'] . ' $'; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Travaux et disponibilit&#233;s:
            <br />
                <b>
                    <?php echo $result['description']; ?>
                </b>
            </td>
         </tr>
            <?php
        }

        else
        {
            ?>
            <td>
                Client:
                <b>
                    <?php echo $result['customer']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Address:
                <b>
                    <?php echo $result['location']; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Price:
                <b>
                    <?php echo $result['price'] . ' $'; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Cut:
                <b>
                    <?php echo $result['cut'] . ' $'; ?>
                </b>
            </td>
        </tr>
        <tr>
            <td>
                Works and due time:
                <br />
                <b>
                    <?php echo $result['description']; ?>
                </b>
            </td>
         </tr>
            <?php
        }
        ?>
    <tr>
        <td>
            <?php
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
            {
                if ($result['completed'] == 1)
                {
                    echo 'Travaux r&#233;alis&#233;s le ' . $result['datentime'] . '.';
                }

                else if ($result['completed'] == 2)
                {
                    echo 'Travaux non r&#233;alis&#233;s.';
                }

                else
                {
                    echo 'Travaux &#xE0; r&#233;aliser le ' . $result['datentime'] . '.';
                }
                
            }

            else
            {
                if ($result['completed'] == 1)
                {
                    echo 'Works carried out on ' . $result['datentime'] . '.';
                }

                else if ($result['completed'] == 2)
                {
                    echo 'Travaux not yet carried out.';
                }

                else
                {
                    echo 'Works due on ' . $result['datentime'] . '.';
                }
            }
               
            ?>
        </td>
    </tr>
    <tr>
        <td style="font-size: 12px; text-align: right; padding-right: 1%;">
            <?php
                $nb = time() - $result['lastUpdated'];
                echo 'gen ID: #' . round($nb,0) . '/' . $result['updatedBy']; //USED FOR DEBUG ONLY
             ?>
        </td>
    </tr>
</table>
            <?php  
            }
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

		header('Location: ../../error');
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