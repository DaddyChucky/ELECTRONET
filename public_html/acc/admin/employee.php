
<link rel="stylesheet" href="employeeStyle.css" />

<?php
    include '../../head.php';
?>

<title>
    <?php 
        if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        {
            echo 'ELECTRONET > Liste des employés';
        }

        else
        {
            echo "ELECTRONET > Employees' list";
        }
    ?>
</title>
<?php

    if (isset($_SESSION['authPassed']) && $_SESSION['authPassed'] && isset($_SESSION['perms']) && $_SESSION['perms'] >= 3)
    {

		//FUNCTION AUTO UPDATE V/T TIERS UPON REFRESH
		//WORKER FUNCTION
		$i = 0;
		$req = $database->prepare('SELECT ID FROM payescurr');
		$req->execute();

		while ($result = $req->fetch())
		{
			$i++;
		}

		$max = $i;

		for ($i = 0; $i < $max; $i++)
		{
			$increment = 0;

			$req = $database->prepare('SELECT ID FROM payescurr WHERE IDworker=:IDworker AND payWorker=:payWorker');
			$req->execute(array(
				'IDworker' => $i,
				'payWorker' => 1
			));
			
			while ($result = $req->fetch())
			{
				if ($result)
				{
					$increment++;

					if ($increment >= 100)
					{
						$seek = $database->prepare('UPDATE users SET tierT=:tierT WHERE ID=:ID');
						$seek->execute(array(
							'tierT' => 2,
							'ID' => $i
						));
					}

					else if ($increment >= 50)
					{
						$seek = $database->prepare('UPDATE users SET tierT=:tierT WHERE ID=:ID');
						$seek->execute(array(
							'tierT' => 1,
							'ID' => $i
						));
					}
				}
			}
		}

		//SELLER FUNCTION
		for ($i = 0; $i < $max; $i++)
		{
			$increment = 0;

			$req = $database->prepare('SELECT ID FROM payescurr WHERE IDseller=:IDseller AND paySeller=:paySeller');
			$req->execute(array(
				'IDseller' => $i,
				'paySeller' => 1
			));
			
			while ($result = $req->fetch())
			{
				if ($result)
				{
					$increment++;

					if ($increment >= 100)
					{
						$seek = $database->prepare('UPDATE users SET tierV=:tierV WHERE ID=:ID');
						$seek->execute(array(
							'tierV' => 2,
							'ID' => $i
						));
					}

					else if ($increment >= 50)
					{
						$seek = $database->prepare('UPDATE users SET tierV=:tierV WHERE ID=:ID');
						$seek->execute(array(
							'tierV' => 1,
							'ID' => $i
						));
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
				if ($_SESSION['perms'] == 3)
				{
					if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        			{
        				?>
							<a href="../../acc/my">ACCUEIL</a> |
							<a href="../admin/powertool">GESTION</a> |
							<a href="../acc/util/params">PARAMÈTRES</a> |
							<a href="../util/help" style="cursor: help;">AIDE</a>
						<?php
        			}

        			else
        			{
        				?>
							<a href="../../acc/my">HOME</a> |
							<a href="../admin/powertool">MANAGEMENT</a> |
							<a href="../acc/util/params">SETTINGS</a> |
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
				Modifier un compte
			</p>

        <form target="" method="post">

            <input type="text" name="ID" placeholder="ID" value="" />
            <br />
            <input type="text" name="name" placeholder="Nom" value="" />
            <br />
            <input type="text" name="email" placeholder="Courriel" value="" />
            <br />
            <?php
            	if ($_SESSION['perms'] == 4)
            	{
            		?>
            			<input type="password" name="password" placeholder="Password" value="" />
            			<br />
            		<?php
            	}
            ?>
            <input type="text" name="perms" placeholder="Permissions" value="" />
            <br />
            <input type="text" name="validated" placeholder="Validation" value="" />
            <br />
            <?php
            	if ($_SESSION['perms'] == 4)
            	{
            		?>
            			<input type="text" name="ban" placeholder="Ban" value="" />
            			<br />
            			<input type="text" name="banReason" placeholder="Ban raison" value="" />
            			<br />
            		<?php
            	}
            ?>

            <input type="submit" name="modifyAcc" value="Modifier*" />

        </form>
    
        <span>
            <p id="disclaimer">*Les usagers ne seront pas avertis de cette modification.</p>
        </span>
        
        <span>
            <p>
                Utilisateurs
            </p>
        </span>

        <table>
            <tr>
                <th class="columnTitle">
                    ID
                </th>
                <th class="columnTitle">
                    Nom
                </th>
                <th class="columnTitle">
                    Courriel
                </th>
                <?php
                	if ($_SESSION['perms'] == 4)
                	{
                		?>
	                		<th class="columnTitle">
			                    Mot de passe
			                </th>
			            <?php
		           	}
		        ?>
                <th class="columnTitle">
                    Permissions
                </th>
                <th class="columnTitle">
                    Compte valid&#233;
                </th>
                <?php
                	if ($_SESSION['perms'] == 4)
                	{
                		?>
                			<th class="columnTitle">
			                    Ban
			                </th>
			                <th class="columnTitle">
			                    Ban raison
			                </th>
                		<?php
                	}
                ?>
            </tr>
				<?php
			}

			else
			{
				?>
					<p class="mainTitle">
				Modify An Account
			</p>

        <form target="" method="post">

            <input type="text" name="ID" placeholder="ID" value="" />
            <br />
            <input type="text" name="name" placeholder="Name" value="" />
            <br />
            <input type="text" name="email" placeholder="Email" value="" />
            <br />
            <?php
            	if ($_SESSION['perms'] == 4)
            	{
            		?>
            			<input type="password" name="password" placeholder="Password" value="" />
            			<br />
            		<?php
            	}
            ?>
            <input type="text" name="perms" placeholder="Permissions" value="" />
            <br />
            <input type="text" name="validated" placeholder="Validation" value="" />
            <br />
            <?php
            	if ($_SESSION['perms'] == 4)
            	{
            		?>
            			<input type="text" name="ban" placeholder="Ban" value="" />
            			<br />
            			<input type="text" name="banReason" placeholder="Ban reason" value="" />
            			<br />
            		<?php
            	}
            ?>
            <input type="submit" name="modifyAcc" value="Modify*" />

        </form>
    
        <span>
            <p id="disclaimer">*Users will not be notified of this modification.</p>
        </span>
        
        <span>
            <p>
                Users
            </p>
        </span>

        <table>
            <tr>
                <th class="columnTitle">
                    ID
                </th>
                <th class="columnTitle">
                    Name
                </th>
                <th class="columnTitle">
                    Email
                </th>
                <?php
                	if ($_SESSION['perms'] == 4)
                	{
                		?>
                			<th class="columnTitle">
			                    Password
			                </th>
                		<?php
                	}
                ?>
                <th class="columnTitle">
                    Permissions
                </th>
                <th class="columnTitle">
                    Account validated
                </th>
                <?php
                	if ($_SESSION['perms'] == 4)
                	{
                		?>
                			<th class="columnTitle">
			                    Ban
			                </th>
			                <th class="columnTitle">
			                    Ban reason
			                </th>
                		<?php
                	}
                ?>
            </tr>
				<?php
			}

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['perms']) && isset($_POST['validated']) && isset($_POST['modifyAcc']))
                {
                    if (!empty($_POST['ID']))
                    {
                        $count = 0;

                        $id = test_input($_POST['ID']);
                        $name = test_input($_POST['name']);
                        $email = test_input($_POST['email']);
                        $perms = test_input($_POST['perms']);
                        $validated = test_input($_POST['validated']);

                        if (isset($_POST['ban']) && isset($_POST['banReason']) && isset($_POST['password']))
	                	{
	                		$ban = $_POST['ban'];

	                		if ($ban != 0 && $ban != 1)
	                		{
	                			if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Le bannissement est invalide (entrer 0 ou 1 uniquement).';
								}

								else
								{
									$_SESSION['curErr'] = 'The ban is invalid (only enter 0 or 1).';
								}
	                		}

	                		else
	                		{
                				$banReason = $_POST['banReason'];
		                		$password = $_POST['password'];

		                		$password = password_hash($password, PASSWORD_BCRYPT, array(
									'cost' => 12
								));
	                		}
	                	}

	                	else
	                	{
	                		$ban = 0;
	                		$banReason = 'user is not banned';
	                		
	                		$req = $database->prepare('SELECT password FROM users WHERE ID=:ID');

	                		$req->execute(array(
	                			'ID' => $id
	                		));

	                		while ($result = $req->fetch())
	                		{
	                			if ($result)
	                			{
	                				$password = $result['password'];
	                				break;
	                			}
	                		}

	                	}

                        if ($perms == '0' || $perms == 'client' || $perms == 'user')
                        {
                            $permsToInt = 0;
                        }

                        else if ($perms == '1' || $perms == 'travailleur' || $perms == 'worker')
                        {
                            $permsToInt = 1;
                        }

                        else if ($perms == '2' || $perms == 'vendeur' || $perms == 'seller')
                        {
                            $permsToInt = 2;
                        }

                        else if ($perms == '3' || $perms == 'gestionnaire' || $perms == 'manager')
                        {
                            if ($_SESSION['perms'] <= 3)
                            {
                                if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Vous ne pouvez pas ajouter ces permissions à cet utilisateur.';
								}

								else
								{
									$_SESSION['curErr'] = 'You may not add these permissions to this user.';
								}

                                header('Location: employee');
                            }

                            else
                            {
                                $permsToInt = 3;
                            }
                        }

                        else if ($perms == '4' || $perms == 'admin')
                        {
                            if ($_SESSION['perms'] <= 3)
                            {
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Vous ne pouvez pas ajouter ces permissions à cet utilisateur.';
								}

								else
								{
									$_SESSION['curErr'] = 'You may not add these permissions to this user.';
								}
                                
                                header('Location: employee');
                            }

                            else
                            {
                                $permsToInt = 4;
                            }
                        }

                        else if (!empty($perms))
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Permissions invalides.';
							}

							else
							{
								$_SESSION['curErr'] = 'Invalid permissions.';
							}

                            header('Location: employee');
                        }

                        if ($validated == 'oui' || $validated == 'yes' || $validated == '1')
                        {
                            $validatedToInt = 1;
                        }

                        else if ($validated == 'non' || $validated == 'no' || $validated == '0')
                        {
                            $validatedToInt = 0;
                        }

                        else if (!empty($validated))
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'Validation invalide.';
							}

							else
							{
								$_SESSION['curErr'] = 'Invalid validation.';
							}

                            header('Location: employee');
                        }

                        //CHECK IF ID EXISTS AND ISN'T AN ADMIN/ORGANISER
                        $req = $database->prepare('SELECT name, email, perms, validated FROM users WHERE ID=:ID');

                        $req->execute(array(
                           'ID' => $id
                            ));

                        while ($result = $req->fetch())
                        {
                            $count++;

                            if (empty($name) && empty($email) && empty($perms) && empty($validated) && empty($banReason) && empty($ban) && empty($password))
                            {
								if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
								{
									$_SESSION['curErr'] = 'Entrer un ID et rien d\'autre n\'apporte aucun changement.';
								}

								else
								{
									$_SESSION['curErr'] = 'Only putting an ID doesn\'t make any change.';
								}

                                header('Location: employee');
                            }

                            if ($_SESSION['perms'] == 3)
                            {
                                if (empty($name) || is_numeric($name))
                                {
                                    $name = $result['name'];
                                }

                                if (empty($perms) || $perms < 0 || $perms > 4)
                                {
                                    $permsToInt = $result['perms'];
                                }

                                else if ($permsToInt == 69) //REMAINED UNCHANGED
                                {
                                    $permsToInt = $result['perms'];
                                }

                                if (empty($validated) || $validated < 0 || $validated > 1)
                                {
                                    $validatedToInt = $result['validated'];
                                }

                                else if ($validatedToInt == 69) //REMAINED UNCHANGED
                                {
                                    $validatedToInt = $result['validated'];
                                }

                                if ($result['perms'] == 4)
                                {
									if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										$_SESSION['curErr'] = 'Cet utilisateur est administrateur [4]; vous ne pouvez pas modifier son compte.';
									}

									else
									{
										$_SESSION['curErr'] = 'This user is an admin [4], therefore you cannot modify his or her account.';
									}
                                    
                                    header('Location: employee');
                                }

                                if ($result['perms'] == 3)
                                {
                                    if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										$_SESSION['curErr'] = 'Cet utilisateur est gestionnaire [3]; vous ne pouvez pas modifier son compte.';
									}

									else
									{
										$_SESSION['curErr'] = 'This user is a manager [3], therefore you cannot modify his or her account.';
									}

                                    header('Location: employee');
                                }
                            }

                            else
                            {
                                if (empty($name))
                                {
                                    $name = $result['name'];
                                }

                                if (empty($perms))
                                {
                                    $permsToInt = $result['perms'];
                                }

                                if (empty($validated))
                                {
                                    $validatedToInt = $result['validated'];
                                }
                            }

                            if (empty($email))
                            {
                                $email = $result['email'];
                            }

                        }

                        if ($count == 0)
                        {
                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curErr'] = 'ID inconnu.';
							}

							else
							{
								$_SESSION['curErr'] = 'Unknown ID.';
							}

                            header('Location: employee');
                        }

                        else if (empty($_SESSION['curErr']))
                        {
                            $req = $database->prepare('UPDATE users SET name=:name, email=:email, perms=:perms, validated=:validated, ban=:ban, banReason=:banReason, password=:password WHERE ID=:ID');

                            $req->execute(array(
                                'name' => $name,
                                'email' => $email,
                                'perms' => $permsToInt,
                                'validated' => $validatedToInt,
                                'ID' => $id,
                                'ban' => $ban,
                                'banReason' => $banReason,
                                'password' => $password
                                ));

                            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
							{
								$_SESSION['curSuc'] = 'Succ&egrave;s.';
							}

							else
							{
								$_SESSION['curSuc'] = 'Success.';
							}

                            header('Location: employee');
                        }

                        else
                        {
                            header('Location: employee');
                        }
                    }

                    else
                    {
						if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
						{
							$_SESSION['curErr'] = 'Veuillez fournir un ID.';
						}

						else
						{
							$_SESSION['curErr'] = 'ID input must be filled.';
						}
                        
                        header('Location: employee');
                    }
                }
            }

            $req = $database->prepare('SELECT ID, name, email, perms, tierV, tierT, validated, password, ban, banReason FROM users ORDER BY ID desc');

            $req->execute();

            while ($result = $req->fetch())
            {
                if ($result['perms'] <= 4) //CHANGE IF YOU WANT TO COMPLETELY VANISH HIGHER PRIVILEGES FROM THE LIST (<= 2)
                {
            ?>
                    <tr class="tableLine">
                        <td style="padding: 16px; border-right: 2px dashed black;">
                            <?php
                                if ($result['perms'] == 4)
                                {
                                    echo '??';
                                }
                                else
                                {
                                   echo $result['ID']; 
                                }                               
                            ?>
                        </td>
                        <td style="padding: 16px; border-right: 2px dashed black;">
                            <?php
                                echo $result['name'];
                            ?>
                        </td>
                        <td style="padding: 16px; border-right: 2px dashed black;">
                            <?php
                                if ($result['perms'] == 4)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
	                                        <span style="font-style: italic;">protégé</span>
	                                    <?php
									}

									else
									{
										?>
	                                        <span style="font-style: italic;">protected</span>
	                                    <?php
									}
                                    
                                }
                                else
                                {
                                    ?>
                                        <a href="mailto:<?php echo $result['email'];?>"><?php echo $result['email']; ?></a>
                                    <?php
                                }  
                            ?>
                        </td>

                        <?php
	                        if ($_SESSION['perms'] == 4)
	            			{
	            				?>
		            				<td style="padding: 16px; border-right: 2px dashed black;">
		            					<?php
			                                echo $result['password'];
			                            ?>
		            				</td>
		            			<?php
	            			}
	            		?>

                        <td style="padding: 16px; border-right: 2px dashed black;">
                            <?php
								if ($result['tierT'] == 0)
								{
									$desc = 'I (def)';
								}

								else if ($result['tierT'] == 1)
								{
									$desc = 'II (50t)';
								}

								else if ($result['tierT'] == 2)
								{
									$desc = 'III (100t)';
								}

								else
								{
									$desc = 'I (def)';
								}

								if ($result['tierV'] == 0)
								{
									$description = 'I (def)';
								}

								else if ($result['tierV'] == 1)
								{
									$description = 'II (50v)';
								}

								else if ($result['tierV'] == 2)
								{
									$description = 'III (100v)';
								}

								else
								{
									$description = 'I (def)';
								}

                                if ($result['perms'] == 0)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
	                                        <span style="color: darkslategray; font-weight: bold;">client</span>
	                                        <br />
	                                        [0]
	                                    <?php
									}

									else
									{
										?>
	                                        <span style="color: darkslategray; font-weight: bold;">customer</span>
	                                        <br />
	                                        [0]
	                                    <?php
									}
                                }

                                else if ($result['perms'] == 1)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
                                        <span style="color: dodgerblue; font-weight: bold;">travailleur</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">client</span>
                                        <br />
                                        [0]
                                    <?php
									}
									else
									{
										?>
                                        <span style="color: dodgerblue; font-weight: bold;">worker</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">customer</span>
                                        <br />
                                        [0]
                                    <?php
									}
                                    
                                }

                                else if ($result['perms'] == 2)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
                                        <span style="color: mediumseagreen; font-weight: bold;">vendeur</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">travailleur</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">client</span>
                                        <br />
                                        [0]
                                    <?php
									}

									else
									{
										?>
                                        <span style="color: mediumseagreen; font-weight: bold;">seller</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">worker</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">customer</span>
                                        <br />
                                        [0]
                                    <?php
									}
                                    
                                }

                                else if ($result['perms'] == 3)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
                                        <span style="color: deeppink; font-weight: bold;">gestionnaire</span>
                                        <br />
                                        [3]
										<br />
										<span style="color: mediumseagreen; font-weight: bold;">vendeur</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">travailleur</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">client</span>
                                        <br />
                                        [0]
                                    <?php
									}

									else
									{
										?>
                                        <span style="color: deeppink; font-weight: bold;">manager</span>
                                        <br />
                                        [3]
										<br />
										<span style="color: mediumseagreen; font-weight: bold;">seller</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">worker</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">customer</span>
                                        <br />
                                        [0]
                                    <?php
									}
                                    
                                }
                                else if ($result['perms'] == 4)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										?>
                                        <span style="color: darkred; font-weight: bold;">admin</span>
                                        <br />
                                        [4]
										<br />
										<span style="color: deeppink; font-weight: bold;">gestionnaire</span>
                                        <br />
                                        [3]
										<br />
										<span style="color: mediumseagreen; font-weight: bold;">vendeur</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">travailleur</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">client</span>
                                        <br />
                                        [0]
                                    <?php
									}

									else
									{
										?>
                                        <span style="color: darkred; font-weight: bold;">admin</span>
                                        <br />
                                        [4]
										<br />
										<span style="color: deeppink; font-weight: bold;">manager</span>
                                        <br />
                                        [3]
										<br />
										<span style="color: mediumseagreen; font-weight: bold;">seller</span><span style="color: red;"><?php echo ' ' . $description; ?></span>
                                        <br />
                                        [2]
										<br />
										<span style="color: dodgerblue; font-weight: bold;">worker</span><span style="color: red;"><?php echo ' ' . $desc; ?></span>
                                        <br />
                                        [1]
										<br />
										<span style="color: darkslategray; font-weight: bold;">customer</span>
                                        <br />
                                        [0]
                                    <?php
									}
                                    
                                }
                            ?>
                        </td>
                        <td style="
                                    padding: 16px; 
                                    border-right: 2px dashed black;
                                    <?php
                                        if ($result['validated'] && $result['perms'] != 4)
                                        {
                                            ?>
                                                background-color: lightgreen;
                                            <?php
                                        }

                                        else if (!$result['validated'] && $result['perms'] != 4)
                                        {
                                            ?>
                                                background-color: lightpink;
                                            <?php
                                        }
                                    ?>
                                    ">
                            <?php
                                if ($result['validated'] && $result['perms'] != 4)
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										echo 'oui';?><br /><?php echo '[1]';
									}

									else
									{
										echo 'yes';?><br /><?php echo '[1]';
									}
                                    
                                }

                                else if ($result['perms'] == 4)
                                {
                                    echo '?';
                                }

                                else
                                {
                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
									{
										echo 'non';?><br /><?php echo '[0]';
									}

									else
									{
										echo 'no';?><br /><?php echo '[0]';
									}
                                    
                                }
                            ?>
                        </td>
                        <?php
	                        if ($_SESSION['perms'] == 4)
	            			{
	            				?>
		            				<td style="padding: 16px; border-right: 2px dashed black;
		            				<?php
		            					if ($result['ban'] == 0)
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
			                                if ($result['ban'] == 0)
			                                {
			                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													echo 'non';?><br /><?php echo '[0]';
												}

												else
												{
													echo 'no';?><br /><?php echo '[0]';
												}
			                                }

			                                else
			                                {
			                                	if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
												{
													echo 'oui';?><br /><?php echo '[1]';
												}

												else
												{
													echo 'yes';?><br /><?php echo '[1]';
												}
			                                }
			                            ?>
		            				</td>
		            				<td style="padding: 16px; border-right: 2px dashed black;">
		            					<?php
		            						echo $result['banReason'];
		            					?>
		            				</td>
		            			<?php
	            			}
	            		?>
                    </tr>      
                <?php
                }
            }
            ?>
        </table>
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