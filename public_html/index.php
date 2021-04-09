<link rel="stylesheet" href="ib7.css" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="../scripts/slowMoving.js"></script>

<?php 
    include 'head.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST['changeLang']))
        {

            if ($_SESSION['lang'] == 'fr')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'en',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: index');

            }

            if ($_SESSION['lang'] == 'en')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'fr',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: index');

            }
        }
    }
?>

	<title>
        <?php 
            if ($_SESSION['lang'] == 'fr')
            {
                echo 'ELECTRONET > Accueil';
            }

            else
            {
                echo 'ELECTRONET > Home';
            }
        ?>
    </title>

    <?php 
            if ($_SESSION['lang'] == 'fr')
            {
            ?>
                <p id="screen-to-small"><b style="text-decoration: underline;">Erreur fatale d'affichage:</b><br/><br/>ELECTRONET ne supporte pas les écrans en-deçà de 50 pixels ni les écrans au-delà de 2 000 pixels.<br />S'il-vous-plaît, rectifiez les dimensions de votre écran et rafraîchissez la page (en appuyant F5).</p>
            <?php
            }

            else
            {
            ?>
                <p id="screen-to-small"><b style="text-decoration: underline;">Fatal display error:</b><br/><br/>ELECTRONET does not support screens below 50 pixels or screens beyond 2000 pixels.<br />Please correct the dimensions of your screen and refresh the page (by pressing F5).</p>
            <?php
            }
    ?>
	

	<body>

		<section>
			
			<header>

				<div class="header">
					
					<p>
                        <?php 
                            if ($_SESSION['lang'] == 'fr')
                            {
                            ?>
                                <a href= "../register" title="Se connecter / S'enregistrer">
							        <span>CONNEXION <span style="color: black;">/</span><br/>
								          INSCRIPTION</span><br/>
							        <i class="material-icons">supervisor_account</i>
						        </a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href= "../register" title="Connection / Register">
							        <span>CONNECTION <span style="color: black;">/</span><br/>
								          REGISTER</span><br/>
							        <i class="material-icons">supervisor_account</i>
						        </a>
                            <?php
                            }
                        ?>

					</p>
					
				</div>

				<div class="topLinks">

					<p>
                        <?php 
                            if ($_SESSION['lang'] == 'fr')
                            {
                            ?>
                                <a href="#services">SERVICES</a>
						        <a href="#estimate">ESTIMATION</a>
						        <a href="#motto" style="text-decoration: none;">
							        <img src="../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="#partenariat">PARTENARIAT</a>
						        <a href="#contact">CONTACT</a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href="#services">SERVICES</a>
						        <a href="#estimate">ESTIMATE</a>
						        <a href="#motto" style="text-decoration: none;">
							        <img src="../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="#partenariat">PARTNERSHIP</a>
						        <a href="#contact">CONTACT</a>
                            <?php
                            }
                        ?>
						
					</p>
				
				</div>

			</header>

				<div class="background-content">

					<div class="sepBorder">
                    
						<div class="mainContent">

                            <?php
                                if ($_SESSION['lang'] == 'fr')
                                {
                                    ?>
                                         <p>
                                            <form target="" method="post" style="text-align: right; margin-top: 20px; margin-right: 1%;">
                                            <i class="material-icons" style="color: mediumspringgreen; font-size: 14px;">phone</i> <span style="font-size: 16px;">(819) 328-6404</span> |
                                            <i class="material-icons" style="color: dodgerblue; font-size: 14px;">email</i> <span><a href="mailto:admin@electronet.ca" style="font-size: 16px;">admin@electronet.ca</a></span> <br/>
                                            <input style="text-align: right; font-size: 16px;" id="changeLang" type="submit" name="changeLang" value="Translate in English">
                                            </form>
                                        </p> 
                                    <?php
                                }

                                else
                                {
                                    ?>
                                         <p>
                                            <form target="" method="post" style="text-align: right; margin-top: 20px; margin-right: 1%;">
                                            <i class="material-icons" style="color: mediumspringgreen; font-size: 14px;">phone</i> <span style="font-size: 16px;">(819) 328-6404</span> |
                                            <i class="material-icons" style="color: dodgerblue; font-size: 14px;">email</i> <span><a href="mailto:admin@electronet.ca" style="font-size: 16px;">admin@electronet.ca</a></span> <br/>
                                            <input style="text-align: right; font-size: 16px;" id="changeLang" type="submit" name="changeLang" value="Traduire en français">
                                            </form>
                                        </p> 
                                    <?php
                                }
                            ?>

							<div id="main-images"><br /></div>
                                
                            <?php 
                            if ($_SESSION['lang'] == 'fr')
                            {
                            ?>
                                <div id="motto">
								    <h1>« Par des étudiants, pour des étudiants. »</h1>
							    </div>
                            <?php
                            }

                            else
                            {
                            ?>
                                <div id="motto">
								    <h1>« For students, by students. »</h1>
							    </div>
                            <?php
                            }
                            ?>

                            <br />

							<div>
                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <h2>Qui sommes-nous ?</h2>

								    <p><span class="major-letter">E</span>LECTRONET est une compagnie qui se spécialise dans les travaux résidentiels. Initialement fondé par un étudiant, ELECTRONET encourage de ce fait l'emploi estudiantin en formant et en engageant des étudiants à <b>VOTRE</b> service.<br/>Vous êtes du type <b>intérieur</b> ? Que ce soit pour un bilan, un nettoyage, une consultation, un projet, une analyse de vos systèmes, logiciels et périphériques informatiques, ELECTRONET s'occupe de vous.<br/>Vous êtes davantage du type <b>extérieur</b> ? Que ce soit pour un déneigement de toit, un entretien de piscine, des travaux de déglaçage et d'entretien paysager, un lavage de vitres, ou encore, un vidage de gouttières, ELECTRONET est <b>LA</b> solution.</p>

								    <p id="button-reserve">
									    <button>
										    <a href="#estimate">Réservez votre estimation dès maintenant</a>
									    </button>
								    </p>
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2>Who are we ?</h2>

								    <p><span class="major-letter">E</span>LECTRONET is a company that specializes in residential work. Initially founded by a student, ELECTRONET therefore encourages student employment by training and hiring students at <b>YOUR</b> service.<br/>Are you an <b>indoor</b> type? Whether for a review, cleaning, consultation, project or analysis of your systems, software and computer peripherals, ELECTRONET takes care of you.<br/>Are you an <b>outdoor</b> type? Whether for snow removal on the roof, pool maintenance, icebreaking and landscaping work, window washing, or even emptying gutters, ELECTRONET is <b>THE</b> solution.</p>

								    <p id="button-reserve">
									    <button>
										    <a href="#estimate">Book your estimate now</a>
									    </button>
								    </p>
                                <?php
                                }
                                ?>
								
                                
							</div>
						    
                            <br />

							<div>
                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <h2 id="services">Services intérieurs offerts</h2>
								    <table class="services">
								      <tr>
									    <th style="text-align: center; color: indianred;"><i class="material-icons">build</i></th>
									    <th style="text-align: center; color: mediumspringgreen;"><i class="material-icons">speaker_notes</i></th>
									    <th style="text-align: center; color: dodgerblue;"><i class="material-icons">computer</i></th>
								      </tr>
								      <tr>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Nettoyage externe d'ordinateur (de bureau seulement)</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Bilan, consultation, tutorat et analyse logicielle</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Nettoyage d'écrans</td>
								      </tr>
								      <tr>
                                        <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">L</span>orsque la poussière s'accumule, les périphériques externes de votre ordinateur risquent de surchauffer. Il est donc important, au moins une fois par année, de décomposer votre ordinateur de bureau et de nettoyer/dépoussiérer ses composantes. Laissez nos étudiants le faire à votre place et ce, de façon efficace et bon marché, en choisissant ELECTRONET !</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">V</span>ous voulez accélérer la vitesse d'exécution de votre ordinateur/portable ? Vous êtes au bon endroit. Chez ELECTRONET, nos étudiants se chargent de dresser un bilan complet de votre ordinateur. En cernant les logiciels critiques et les périphériques internes qui ralentissent vos tâches quotidiennes, ELECTRONET vous aide à commencer ou à achever votre projet personnel ou à envergure entrepreneuriale, et ce, à faible coût. Laissez nos étudiants vous servir !</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">D</span>es taches ou de la poussière couvrent un ou plusieurs de vos écrans ? À l'aide de notre solution pour écrans et de lingettes microfibres, nos étudiants s'occupent de les rendre étincelants à nouveau, et ce, à très faible coût.</td>
									  </tr>
								    </table>

								    <h2 id="services">Services extérieurs offerts</h2>
								    <table class="services">
								      <tr>
									    <th style="text-align: center; color: #FFFF66;"><i class="material-icons">local_florist</i></th>
									    <th style="text-align: center; color: #C0C0C0;"><i class="material-icons">wb_incandescent</i></th>
									    <th style="text-align: center; color: orange;"><i class="material-icons">house</i></th>
								      </tr>
								      <tr>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Piscine, vignes et paysagement</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Lumières de Noël, déneigement de toit et déglaçage</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Vitres et gouttières</td>
								      </tr>
								      <tr>
                                        <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">L'</span>entretien d'une piscine est à la fois une tâche complexe et énergivore. ELECTRONET s'occupe d'économiser votre temps, énergie et argent en ayant des étudiants à votre service. Vous avez des vignes qui encombrent votre belle demeure ? Laissez nos étudiants vous en défaire, et ce, à faible coût! Vous avez des travaux de paysagement en tête ? Nous avons la main-d'œuvre! Réservez votre estimation dès maintenant, soit par téléphone, courriel ou en créant votre compte, pour connaître nos tarifs.</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">V</span>ous voulez installer ou désinstaller vos lumières de Noël à très faible coût ? Vous êtes bien tombés! Chez ELECTRONET, nos étudiants vous prendront en charge et feront le travail à votre place, et ce, de façon professionnelle. Votre toit est comblé de neige ? Vos marches ou votre entrée sont recouvertes de glace ? Nous nous en chargeons!</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">C</span>hez ELECTRONET, nous nous engageons à ce que vos vitres redeviennent étincelantes. À l'aide de notre solution pour vitres et de lingettes microfibres, nos étudiants manipulent le verre avec brio, et ce, à très faible coût. Votre gouttière est remplie de feuilles, de brindilles ou de bardeaux ? Notre personnel s'en occupe et veille à ce que vos gouttières coulent à nouveau!</td>
									  </tr>
								    </table>
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2 id="services">Interior services offered</h2>
								    <table class="services">
								      <tr>
									    <th style="text-align: center; color: indianred;"><i class="material-icons">build</i></th>
									    <th style="text-align: center; color: mediumspringgreen;"><i class="material-icons">speaker_notes</i></th>
									    <th style="text-align: center; color: dodgerblue;"><i class="material-icons">computer</i></th>
								      </tr>
								      <tr>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">External computer cleaning (desktops only)</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Assessment, consultation, tutoring and software analysis</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Screen cleaning</td>
								      </tr>
								      <tr>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">W</span>hen dust accumulates, external devices on your computer may overheat. It is therefore important, at least once a year, to decompose your desktop and clean / dust its components. Let our students do it for you, efficiently and inexpensively, by choosing ELECTRONET!</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">W</span>ant to speed up the speed of your computer / laptop? You are in the right place. At ELECTRONET, our students take care of drawing up a complete assessment of your computer. By identifying critical software and internal devices that slow down your day-to-day tasks, ELECTRONET helps you start or complete your personal or entrepreneurial project at a low cost. Let our students serve you!</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">S</span>tains or dust cover one or more of your screens? Using our screen solution and microfiber wipes, our students are looking to make them sparkle again, and at a very low cost.</td>
									  </tr>
								    </table>
								    
								    <h2 id="services">Outdoor services offered</h2>
								    <table class="services">
								      <tr>
									    <th style="text-align: center; color: #FFFF66;"><i class="material-icons">local_florist</i></th>
									    <th style="text-align: center; color: #C0C0C0;"><i class="material-icons">wb_incandescent</i></th>
									    <th style="text-align: center; color: orange;"><i class="material-icons">house</i></th>
								      </tr>
								      <tr>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Swimming pool, vineyards and landscaping</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Christmas lights, roof snow removal and de-icing</td>
									    <td style="text-align: center; font-size: 20px; padding: 2% 1% 2% 1%;">Windows and gutters</td>
								      </tr>
								      <tr>
                                        <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">P</span>ool maintenance is both a complex and energy-consuming task. ELECTRONET takes care of saving your time, energy and money by having students at your service. Do you have vines cluttering your beautiful home? Let our students take care of it at a low cost! Do you have landscaping in mind? We have the workforce! Reserve your estimate now, either by phone, email or by creating your account, to find out our rates.</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">D</span>o you want to install or uninstall your Christmas lights at a very low cost? You fell well! At ELECTRONET, our students will take care of you and do the work for you, in a professional manner. Is your roof filled with snow? Are your steps or entryway covered in ice? We take care of it!</td>
									    <td style="text-align: justify; font-size: 15px; text-indent: 32px;"><span class="major-letter">A</span>t ELECTRONET, we are committed to making your windows sparkle again. Using our window solution and microfiber wipes, our students handle glass brilliantly at very low cost. Is your gutter filled with leaves, twigs or shingles? Our staff takes care of it and ensures that your gutters flow again!</td>
									  </tr>
								    </table>
                                <?php
                                }
                                ?>
								
							</div>

                            <br />

                            <div>
                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <h2 id="estimate">Estimation</h2>

                                    <div id="alt-image-1"></div>

                                    <p><span class="major-letter">N</span>os membres inscrits bénéficient d'un outil d'estimation gratuit et simple d'utilisation.  Qu'attendez-vous ? Inscrivez-vous !<br/><br/>Afin d’éviter les fausses demandes, les abus et les robots, il est désormais obligatoire de créer son compte ELECTRONET avant de réclamer une estimation. Cela dit, si vous ne désirez pas créer un compte avec nous, veuillez s’il-vous-plaît entrer en <a href="#contact">contact</a> avec nous et nous serons heureux de vous épauler.</p>
                                
								    <p id="button-reserve">
									    <button>
										    <a href="../register">Je désire cr&eacute;er mon compte ELECTRONET</a>
									    </button>
								    </p>
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2 id="estimate">Estimate</h2>

                                    <div id="alt-image-1"></div>

                                    <p><span class="major-letter">O</span>ur registered members benefit from a free and easy-to-use estimation tool. What are you waiting for? Sign up!<br/><br/>In order to avoid false requests, abuse and robots, it is now compulsory to create an ELECTRONET account before requesting an estimate. That said, if you do not wish to create an account with us, please <a href="#contact">contact</a> us directly and we will be happy to assist you.</p>
                                
								    <p id="button-reserve">
									    <button>
										    <a href="../register">I want to create my ELECTRONET account</a>
									    </button>
								    </p>
                                <?php
                                }
                                ?>
                            </div>

                            <br />

                            <div id="partenariat">
                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <h2 id="estimate">Partenariat</h2>

                                    <div id="alt-image-2"></div>

                                    <p><span class="major-letter">V</span>ous avez une idée ingénieuse ou un projet coopératif en tête et désirez vous lancer ? N'attendez pas ! ELECTRONET est toujours ouvert et réceptif aux demandes de partenariat. Afin de nous faire parvenir votre demande, veuillez vous rendre dans la rubrique <span style="font-style: italic;">Aide</span> de votre compte client ou vous <a href="../register">inscrire</a> si cela n'est pas déjà fait.</p>
                                
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2 id="estimate">Partnership</h2>

                                    <div id="alt-image-2"></div>

                                    <p><span class="major-letter">D</span>o you have an ingenious idea or a cooperative project in mind and want to get started? Do not wait! ELECTRONET is always open and receptive to partnership requests. To send us your request, please go to the <span style="font-style: italic;">Help</span> section of your customer account or <a href="../register">register</a> if you have not already done so.</p>
                                <?php
                                }
                                ?>
                                
                            </div>

                            <br />

                            <div id="contact">
                                <h2 id="estimate">Contact</h2>

                                <div id="alt-image-3"></div>

                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <p><span class="major-letter">V</span>ous avez une ou plusieurs questions concernant nos services offerts ? N'hésitez pas à <a href="mailto:admin@electronet.ca">communiquer directement avec nous par courriel</a> ou à visiter la rubrique <span style="font-style: italic;">Aide</span> de votre compte client.<br/><br/>Enfin, vous avez aussi l’option de nous téléphoner ou nous envoyer un message texte au numéro suivant : (819) 328-6404. Bien que les services en-ligne d’ELECTRONET soient toujours accessibles, veuillez prendre note que notre rétroaction face à vos appels téléphoniques ou messages textes peuvent comporter un délai considérable et humain.</p>
                                <?php
                                }

                                else
                                {
                                ?>
                                    <p><span class="major-letter">D</span>o you have one or more questions about our services? Feel free to <a href="mailto:admin@electronet.ca">contact us directly by email</a> or visit the <span style="font-style: italic;">Help</span> section of your customer account.<br/><br/>Finally, you also have the option of calling us or sending us a text message to the following number: (819) 328-6404. Although ELECTRONET's online services are always available, please note that our feedback regarding your phone calls or text messages may take a considerable and human time.</p> 
                                <?php
                                }
                                ?>
                                
                            </div>
                            
                            <br />
						</div>

					</div>

				</div>

		</section>
			
	<footer>
		<div>
			<p>
				<?php 
					if ($_SESSION['lang'] == 'fr')
					{
				?>
						<p class="footContent">
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="../acc/util/terms">Termes et conditions d'utilisation</a> et de notre <a href="../acc/util/privacy">Politique de confidentialité</a>. Tous les copyrights, marques déposées et marques de service appartiennent aux propriétaires respectifs.
							<form id="footContentChangeLang" target="" method="post">Cette page a été générée en français. Pour traduire cette page en anglais, <input id="changeLang" type="submit" name="changeLang" value="cliquez ici">.</form>
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
							<form id="footContentChangeLang" target="" method="post">This page was generated in English. To translate this page in French, <input id="changeLang" type="submit" name="changeLang" value="click here">.</form>
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
</body>

