
<link rel="stylesheet" href="workStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Travaux';
        }

        else
        {
            echo 'ELECTRONET > Works';
        }
    ?>
</title>
<?php
    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 1)
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['num']) && isset($_POST['method']) && isset($_POST['noteWork']) && isset($_POST['noteWorker']) && isset($_POST['comments']) && isset($_POST['modifyWork']))
            {
                if ($_POST['modifyWork'])
                {
                    $num = test_input($_POST['num']);
                    $method = test_input($_POST['method']);
                    $noteWork = test_input($_POST['noteWork']);
                    $noteWorker = test_input($_POST['noteWorker']);
                    $comments = test_input($_POST['comments']);

                    if (!empty($noteWork) && is_numeric($noteWork))
					{
						$noteWork = round($noteWork, 0);
					}

					if (!empty($noteWorker) && is_numeric($noteWorker))
					{
						$noteWorker = round($noteWorker, 0);
					}

                    if (!empty($num))
                    {
                        $req = $database->prepare('SELECT method, noteWork, noteWorker, comments, IDworker FROM contracts WHERE num=:num');

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
                            
                            header('Location: work');
                        }

                        //CHECKS IF WORKER CAN MODIFY CONTRACT
                        //CHECKS IF CONTRACT IS EMITTED FOR HIM
                        else if ($_SESSION['ID'] == $result['IDworker'])
                        {
                            //NOT UPDATING EMPTY FORMS
                            if (empty($method) && empty($noteWork) && empty($noteWorker) && empty($comments))
                            {
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Vous ne pouvez pas mettre qu\'un ID!';
								}

								else
								{
									$_SESSION['curErr'] = 'Only putting an ID doesn\'t make any change!';
								}
                                    
                                header('Location: work');
                            }

                            if (empty($method))
                            {
                                $method = $result['method'];
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

                            if ($noteWork < 0 || $noteWork > 100 || $noteWorker < 0 || $noteWorker > 100 || !is_numeric($noteWork) || !is_numeric($noteWorker))
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Notes invalides.';
								}

								else
								{
									$_SESSION['curErr'] = 'Invalid notes.';
								}

                                header('Location: work');
                            }

                            //EVERYTHING GOOD, UPDATE
                            $req = $database->prepare('UPDATE contracts SET method=:method, noteWork=:noteWork, noteWorker=:noteWorker, comments=:comments, lastUpdated=:lastUpdated, updatedBy=:updatedBy WHERE num=:num');

                            $req->execute(array(
								'method' => $method,
								'noteWork' => $noteWork,
								'noteWorker' => $noteWorker,
								'comments' => $comments,
                                'lastUpdated' => time(),
                                'updatedBy' => $_SESSION['ID'],
                                'num' => $num
                                ));
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
                            
                            header('Location: work');
                        }
                    }

                    else
                    {
                        $_SESSION['curErr'] = 'You must enter a contract number.';
                        header('Location: work');
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
				if ($_SESSION['perms'] == 1)
				{
                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                    {
                        ?>
                            <a href="../../acc/my">ACCUEIL</a> |
                            <a href="../util/work" id="current">TRAVAUX</a> |
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
                            <a href="../util/work" id="current">WORKS</a> |
                            <a href="../util/pay">PAY</a> |
                            <a href="../util/histo">HISTORIC</a> |
                            <a href="../util/params">SETTINGS</a> |
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
                            <a href="../util/work" id="current">TRAVAUX</a> |
                            <a href="../util/seller">VENTES</a> |
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
                            <a href="../util/work" id="current">WORKS</a> |
                            <a href="../util/seller">SELLS</a> |
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
			?>

			<p style="margin-bottom: 4%;">
				<iframe src="https://calendar.google.com/calendar/b/3/embed?height=600&amp;wkst=1&amp;bgcolor=%237986CB&amp;ctz=America%2FToronto&amp;src=Y2RsLmVsZWN0cm9uZXRAZ21haWwuY29t&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=ZnIuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230B8043&amp;mode=WEEK&amp;showTabs=1&amp;showPrint=1&amp;showNav=1&amp;title=ELECTRONET%20-%20AGENDA" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
			</p>

            <?php

                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
                {
                    ?>
                        <p class="mainTitle">
                            Modifier un travail
                        </p>

                         <form target="" method="post">

                            <input type="text" name="num" placeholder="# Contrat" value="" /> <br />
                            <input type="text" name="method" placeholder="Méthode de paiement" value="" /> <br />
                            <input type="text" name="noteWork" placeholder="Note des travaux" value="" /> <br />
                            <input type="text" name="noteWorker" placeholder="Note des travailleurs" value=""> <br />
                            <input type="text" name="comments" placeholder="Commentaires client" value=""> <br/>

                            <input type="submit" name="modifyWork" value="Modifier" />
                        </form>

                        <span>
                            <p id="disclaimer">*Vous pouvez uniquement modifier vos travaux exécutés ou en cours d'éxécution.</p>
                        </span>
                    <?php
                }

                else
                {
                    ?>
                        <p class="mainTitle">
                            Modify A Work
                        </p>

                        <form target="" method="post">

                            <input type="text" name="num" placeholder="Contract # value="" /> <br />
                            <input type="text" name="method" placeholder="Payment method" value="" /> <br />
                            <input type="text" name="noteWork" placeholder="Note of work carried out" value="" /> <br />
                            <input type="text" name="noteWorker" placeholder="Workers note" value=""> <br />
                            <input type="text" name="comments" placeholder="Client's comments" value=""> <br/>

                            <input type="submit" name="modifyWork" value="Modify" />
                        </form>

                        <span>
                            <p id="disclaimer">*You can only modify your works that have been executed or are in progress.</p>
                        </span>
                    <?php
                }
            ?>
			
        <?php
        //SHOW CONTRACTS
        $req = $database->prepare('SELECT customer, location, datentime, method, description, reste, cutWorker, completed, lastUpdated, updatedBy, num, bns, noteWork, noteWorker, comments FROM contracts WHERE IDworker=:IDworker ORDER BY num DESC');

        $req->execute(array(
            'IDworker' => $_SESSION['ID']
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
                                                Contrat #<?php echo $result['num'] . ' ';
                                        }
            
                                        //STATUS
                                        if ($result['completed'] == 2) //DENIED COMPLETION
                                        {
            ?>
            <i class="material-icons" style="color: red;" title="Sale denied">close</i>
            <?php
                                        }

                                        else if ($result['completed'] == 0) //PENDING COMPLETION
                                        {
            ?>
            <i class="material-icons" style="color: cornflowerblue;" title="Sale not yet verified">refresh</i>
            <?php
                                        }

                                        else if ($result['completed'] == 1) //GRANTED COMPLETION
                                        {
            ?>
            <i class="material-icons" style="color: gray;" title="Sale verified">check</i>
            <?php
                                        }
            ?>
        </th>
    </tr>
    <?php
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            ?>
                <tr>
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
            Date et heure des travaux:
            <b>
                <?php echo $result['datentime']; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Paiement restant à effectuer:
            <b>
                <?php echo $result['reste'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Méthode de paiement:
            <b>
                <?php echo $result['method']; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Pourboires clairs:
            <b>
                <?php echo $result['bns'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Ristourne:
            <b>
                <?php echo $result['cutWorker'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Note des travaux effectués:
            <b>
                <?php echo $result['noteWork']; ?>
            </b>
                <?php echo '/100'; ?>
        </td>
    </tr>
    <tr>
        <td>
            Note des travailleurs:
            <b>
                <?php echo $result['noteWorker']; ?>
            </b>
                <?php echo '/100'; ?>
        </td>
    </tr>
    <tr>
        <td>
            Commentaires client:
            <b>
                <?php echo $result['comments']; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            <?php
                if ($result['completed'] == 1)
                {
                    echo 'Travaux r&#233;alis&#233;s le ' . $result['datentime'];
                }

                else if ($result['completed'] == 2)
                {
                    echo 'Travaux non r&#233;alis&#233;s.';
                }

                else
                {
                    echo 'Travaux &#xE0; r&#233;aliser.';
                }
            ?>
        </td>
    </tr>
            <?php
        }

        else
        {
            ?>
                <tr>
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
            Date and time of work:
            <b>
                <?php echo $result['datentime']; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Last payment due:
            <b>
                <?php echo $result['reste'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Payment method:
            <b>
                <?php echo $result['method']; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Cleared tips:
            <b>
                <?php echo $result['bns'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Cut:
            <b>
                <?php echo $result['cutWorker'] . ' $'; ?>
            </b>
        </td>
    </tr>
    <tr>
        <td>
            Note of the work carried out:
            <b>
                <?php echo $result['noteWork']; ?>
            </b>
                <?php echo '/100'; ?>
        </td>
    </tr>
    <tr>
        <td>
            Workers note:
            <b>
                <?php echo $result['noteWorker']; ?>
            </b>
                <?php echo '/100'; ?>
        </td>
    </tr>
    <tr>
        <td>
            Client's comments:
            <b>
                <?php echo $result['comments']; ?>
            </b>
        </td>
    </tr>
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
            <?php
        }
    ?>
    
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