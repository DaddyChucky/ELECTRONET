<link rel="stylesheet" href="../../indexB.css" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">

<?php 
    include '../../head.php';
?>
    <title>
        <?php 
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
                echo 'ELECTRONET > Politique de confidentialit&eacute;';
            }
        
            else
            {
                echo 'ELECTRONET > Privacy Policy';
            }
        ?>
    </title>
<?php
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

                header('Location: privacy');

            }

            if ($_SESSION['lang'] == 'en')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'fr',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: privacy');

            }
        }
    }
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
                                <a href= "../../../register" title="Se connecter / S'enregistrer">
							        <span>CONNEXION <span style="color: black;">/</span><br/>
								          INSCRIPTION</span><br/>
							        <i class="material-icons">supervisor_account</i>
						        </a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href= "../../../register" title="Connection / Register">
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
                                <a href="../../index#services">SERVICES</a>
						        <a href="../../index#estimate">ESTIMATION</a>
						        <a href="../../index#motto" style="text-decoration: none;">
							        <img src="../../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="../../index#partenariat">PARTENARIAT</a>
						        <a href="../../index#contact">CONTACT</a>
                            <?php
                            }

                            else
                            {
                            ?>
                                <a href="../../index#services">SERVICES</a>
						        <a href="../../index#estimate">ESTIMATE</a>
						        <a href="../../index#motto" style="text-decoration: none;">
							        <img src="../../img/mainPageLogo.png" alt="Image has been moved" class="mainLogo" />
						        </a>
						        <a href="../../index#partenariat">PARTNERSHIP</a>
						        <a href="../../index#contact">CONTACT</a>
                            <?php
                            }
                        ?>
						
					</p>
				
				</div>

			</header>

				<div class="background-content">

					<div class="sepBorder">

						<div class="mainContent2">
                            
                            <br />

                            <div>
                                <?php 
                                if ($_SESSION['lang'] == 'fr')
                                {
                                ?>
                                    <h2>Politique de confidentialité</h2>
                                    <p style="font-size: 20px; margin-right: 12%; margin-left: 12%; text-indent: 0; text-align: center;">
                                        <i>PRIÈRE DE LIRE ENTIÈREMENT LA POLITIQUE DE CONFIDENTIALITÉ AVANT TOUTE UTILISATION DE CE SITE WEB.</i>
                                    </p>
                                    <p>
                                        <span class="major-letter">N</span>ous recueillons des informations pour fournir de meilleurs services à tous nos utilisateurs - par exemple. votre langue préférée. Lorsque vous n'êtes pas connecté à un compte ELECTRONET, nous stockons les informations que nous collectons avec des identifiants uniques liés au navigateur, à l'application ou au périphérique que vous utilisez. Cela nous aide à faire des choses comme maintenir vos préférences de langue entre les sessions de navigation.
                                        <br /><br />
                                        Cette politique de confidentialité a pour but de vous aider à comprendre quelles informations nous collectons, pourquoi nous les collectons et comment vous pouvez mettre à jour, gérer, exporter et supprimer vos informations.
										<br /><br />
										<b>Effectif:</b> <?php echo date('y/m/d'); ?><br /><b>Dernière mise à jour:</b> 19/11/30
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">1.</span> <i>TYPE D'INFORMATIONS QUE NOUS RECUEILLONS</i> <br />
                                        Nous recueillons des informations pour fournir de meilleurs services à tous nos utilisateurs - par exemple. votre langue préférée. Lorsque vous n'êtes pas connecté à un compte ELECTRONET, nous stockons les informations que nous collectons avec des identifiants uniques liés au navigateur, à l'application ou au périphérique que vous utilisez. Cela nous aide à faire des choses comme maintenir vos préférences de langue entre les sessions de navigation.
										<br/>
										Lorsque vous êtes connecté, nous collectons également les informations que nous stockons avec votre compte ELECTRONET, que nous traitons comme des informations personnelles.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">2.</span> <i>VOS DONNÉES PERSONNELLES</i> <br />
                                       Lorsque vous créez un compte ELECTRONET, vous nous fournissez des informations personnelles comprenant votre nom, un email et un mot de passe. Même si vous n'êtes pas connecté à un compte ELECTRONET, vous pouvez choisir de nous fournir des informations, telles qu'une adresse e-mail, pour recevoir les mises à jour de nos services.
									   <br />
									   Nous collectons également le contenu que vous créez, téléchargez ou recevez des autres lorsque vous utilisez nos services. Cela inclut des éléments tels que les courriels que vous écrivez et recevez, les photos et les avatars que vous enregistrez et / ou téléchargez.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">3.</span> <i>INFORMATIONS COLLECTÉES</i> <br />
                                       Nous recueillons des informations sur les applications, les navigateurs et les appareils que vous utilisez pour accéder aux services d'ELECTRONET.
									   <br />
									   Les informations que nous collectons incluent des identifiants uniques, le type et les paramètres du navigateur, le type et les paramètres du périphérique, le système d'exploitation et le numéro de version de l'application. Nous collectons également des informations sur l'interaction de vos applications, navigateurs et appareils avec nos services, notamment l'adresse IP, les rapports d'incident, l'activité du système, ainsi que la date, l'heure et l'URL de référence de votre demande.
									   <br />
									   Nous recueillons et mettons à jour ces informations lorsque vous créez un compte chez nous ou lorsque vous vous connectez à votre compte ELECTRONET.
									   <br />
									   Enfin, nous collectons des informations sur votre position lorsque vous utilisez nos services. Votre position peut être déterminée avec plus ou moins de précision grâce aux adresses GPS et IP. (Cette information est stockée dans votre <b>journal de sécurité</b>!)
									   <br />
									   Nous utilisons diverses technologies pour collecter et stocker des informations, notamment des cookies, des pixels invisibles, un stockage local, tel que le stockage Web d'un navigateur ou des caches de données d'application, des bases de données et des journaux de serveur.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">4.</span> <i>UTILISATION DES DONNÉES</i> <br />
                                       Nous utilisons vos données privées pour améliorer, maintenir et développer nos services. Votre adresse e-mail est également utile pour nous de vous contacter. Ainsi, nous utilisons les informations pour améliorer la sécurité et la fiabilité de nos services.
									   <br />
									   Nous vous demanderons votre consentement avant d'utiliser vos informations personnelles à des fins non mentionnées dans la présente politique de confidentialité.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">5.</span> <i>PARTAGE DE VOS INFORMATIONS</i> <br />
                                        Nous ne partageons pas vos informations personnelles avec des sociétés, des organisations ou des personnes extérieures à ELECTRONET, sauf avec votre consentement (a), avec les administrateurs de domaine (b), pour un traitement externe (c) ou pour des raisons juridiques (d).<br/>
                                        <span class="major-letter">a)</span> nous partagerons des informations personnelles en dehors d'ELECTRONET avec votre consentement. Nous vous demanderons votre consentement explicite pour partager des informations personnelles sensibles;<br />
                                    <span class="major-letter">b)</span> les administrateurs de domaine peuvent accéder aux informations stockées sur votre compte (courrier électronique, nom, adresse IP, …), les conserver, consulter les statistiques relatives à votre compte, modifier le mot de passe de votre compte, suspendre ou résilier l’accès à votre compte, recevoir les informations de votre compte afin de satisfaire vos attentes. lois, règlements, procédures judiciaires ou demandes gouvernementales exécutoires applicables, et restreignent votre capacité à supprimer ou à modifier vos informations;<br />
                                    <span class="major-letter">c)</span> nous fournissons des informations personnelles à nos sociétés affiliées et autres entreprises ou personnes de confiance pour les traiter pour nous, conformément à nos instructions et conformément à notre politique de confidentialité et à toute autre mesure de confidentialité et de sécurité appropriée. Par exemple, nous utilisons des fournisseurs de services pour nous aider avec le support client;<br/>
									<span class="major-letter">d)</span> nous partagerons des informations personnelles en dehors d'ELECTRONET si nous croyons de bonne foi que l'accès, l'utilisation, la conservation ou la divulgation des informations est raisonnablement nécessaire pour respecter toute loi, réglementation, procédure juridique ou demande gouvernementale exécutoire, les <a href="terms">conditions d'utilisation</a> applicables, y compris les enquêtes sur les violations potentielles, détecter, prévenir ou traiter de toute autre manière des problèmes techniques, de sécurité ou de fraude, vous protéger contre les atteintes aux droits, à la propriété ou à la sécurité d'ELECTRONET, de nos utilisateurs ou du public, comme requis ou autorisé par loi.<br/>
									Nous pouvons partager des informations non personnellement identifiables publiquement et avec nos partenaires - tels que des éditeurs, des annonceurs, des développeurs ou des détenteurs de droits. Par exemple, nous partageons des informations publiquement pour montrer les tendances concernant l'utilisation générale de nos services. Nous autorisons également des partenaires spécifiques à collecter des informations à partir de votre navigateur ou de votre appareil à des fins de publicité et de mesure, à l'aide de leurs propres cookies ou technologies similaires.<br />
									Si ELECTRONET est impliqué dans une fusion, une acquisition ou une vente d’actifs, nous continuerons à assurer la confidentialité de vos informations personnelles et prévenez les utilisateurs concernés que les informations personnelles soient transférées ou soumises à une politique de confidentialité différente.

                                     </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">6.</span> <i>GARDER VOS INFORMATIONS SÉCURISÉES</i> <br />
                                       ELECTRONET est doté de puissantes fonctions de sécurité qui protègent en permanence vos informations. Les connaissances acquises grâce au maintien de nos services nous aident à détecter et à empêcher automatiquement les menaces à la sécurité de vous atteindre. Et si nous détectons quelque chose de risqué dont nous pensons que vous devriez être informé, nous vous en informerons et vous aiderons à suivre les étapes pour rester mieux protégé.<br/>Nous utilisons le cryptage pour protéger vos données pendant le transit. Nous passons également en revue nos pratiques de collecte, de stockage et de traitement des informations, y compris les mesures de sécurité physiques, afin d'empêcher tout accès non autorisé à nos systèmes. Enfin, nous limitons l'accès aux informations personnelles aux employés, sous-traitants et agents d'ELECTRONET ayant besoin de ces informations pour les traiter. Toute personne disposant de cet accès est soumise à de strictes obligations contractuelles en matière de confidentialité et peut faire l’objet de mesures disciplinaires ou peut être résiliée si elle ne respecte pas ces obligations.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">7.</span> <i>TRANSFERT DE DONNÉES</i> <br />
                                        Nous maintenons des serveurs partout dans le monde et vos informations peuvent être traitées sur des serveurs situés en dehors du pays où vous résidez. Les lois sur la protection des données varient d'un pays à l'autre, certaines offrant davantage de protection que d'autres. Peu importe où vos informations sont traitées, nous appliquons les mêmes protections décrites dans cette politique.<br/>Lorsque nous recevons des plaintes écrites officielles, nous répondons en contactant la personne qui a porté plainte. Nous travaillons avec les autorités réglementaires appropriées, y compris les autorités locales de protection des données, pour résoudre toute plainte concernant le transfert de vos données que nous ne pouvons pas résoudre directement avec vous.
                                    </p>
                                    <p>
                                        <span class="major-letter">8.</span> <i>APPLICATION DE CETTE POLITIQUE</i> <br />
										Cette politique de confidentialité s'applique à tous les services offerts par ELECTRONET. Cette politique de confidentialité ne s’applique pas aux services pour lesquels une politique de confidentialité distincte n’intègre pas cette politique de confidentialité. La présente politique de confidentialité ne s’applique pas aux services proposés par d’autres sociétés ou particuliers, y compris des produits ou des sites pouvant inclure des services ELECTRONET, vous être affichés dans les résultats de recherche ou être liés à nos services.
                                    </p>
                                    <p>
                                        <span class="major-letter">9.</span> <i>CHANGES TO THIS POLICY</i> <br />
                                        Nous changeons cette politique de confidentialité de temps en temps. Nous ne réduirons pas vos droits en vertu de la présente politique de confidentialité sans votre consentement explicite. Nous indiquons toujours la date à laquelle les dernières modifications ont été publiées. Si les modifications sont importantes, nous fournirons une notification plus visible (y compris, pour certains services, une notification par courrier électronique des modifications de la politique de confidentialité).
										<br />
										Si vous avez des questions concernant cette politique de confidentialité, vous pouvez <a href="mailto:cdl.electronet@gmail.com">nous contacter</a>.

                                    </p>
                                    <p>
                                        <span class="major-letter">10.</span> <i>DÉMENTI</i> <br />
                                        Cette politique de confidentialité fut entièrement rédigé grâce à la <a href="https://policies.google.com/privacy" target="_blank">politique de confidentialité de Google</a>.
                                    </p>
                                    <br />
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2>Privacy Policy</h2>
                                    <p style="font-size: 20px; margin-right: 12%; margin-left: 12%; text-indent: 0; text-align: center;">
                                        <i>PLEASE READ THE ENTIRE PRIVACY POLICY BEFORE USING THIS WEB SITE.</i>
                                    </p>
                                    <p>
                                        <span class="major-letter">W</span>hen you use our services, you’re trusting us with your information. We understand this is a big responsibility and work hard to protect your information and put you in control.
                                        <br /><br />
                                        This Privacy Policy is meant to help you understand what information we collect, why we collect it, and how you can update, manage, export, and delete your information.
										<br /><br />
										<b>Effective:</b> <?php echo date('y/d/m'); ?>
										<br />
										<b>Last updated:</b> 19/30/11
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">1.</span> <i>TYPE OF INFORMATION WE COLLECT</i> <br />
                                        We collect information to provide better services to all our users — e.g. your preferred language. When you’re not signed in to an ELECTRONET Account, we store the information we collect with unique identifiers tied to the browser, application, or device you’re using. This helps us do things like maintain your language preferences across browsing sessions.
										<br/>
										When you’re signed in, we also collect information that we store with your ELECTRONET account, which we treat as personal information.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">2.</span> <i>YOUR PERSONAL DATA</i> <br />
                                       When you create an ELECTRONET account, you provide us with personal information that includes your name, an email and a password. Even if you aren’t signed in to an ELECTRONET account, you might choose to provide us with information — like an email address to receive updates about our services.
									   <br />
									   We also collect the content you create, upload, or receive from others when using our services. This includes things like email you write and receive, photos and avatars you save and/or upload.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">3.</span> <i>INFORMATION COLLECTED</i> <br />
                                       We collect information about the apps, browsers, and devices you use to access ELECTRONET services.
									   <br />
									   The information we collect includes unique identifiers, browser type and settings, device type and settings, operating system, and application version number. We also collect information about the interaction of your apps, browsers, and devices with our services, including IP address, crash reports, system activity, and the date, time, and referrer URL of your request.
									   <br />
									   We collect and update this information when create an account with us or when you log in your ELECTRONET account.
									   <br />
									   Finally, we collect information about your location when you use our services. Your location can be determined with varying degrees of accuracy by GPS and IP address. (This information is stored in your <b>Security Journal</b>!)
									   <br />
									   We use various technologies to collect and store information, including cookies, pixel tags, local storage, such as browser web storage or application data caches, databases, and server logs.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">4.</span> <i>DATA USAGE</i> <br />
                                       We use your private data to enhance, maintain, and develop our services. Your email address is also useful for us to contact you. Thus, we use information to help improve safety and reliability of our services.
									   <br />
									   We’ll ask for your consent before using your information for a purpose that isn’t covered in this Privacy Policy.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">5.</span> <i>SHARING YOUR INFORMATION</i> <br />
                                        We do not share your personal information with companies, organizations, or individuals outside of ELECTRONET, except with your consent (a), with domain administrators (b), for external processing (c), or for legal reasons (d).<br/>
                                        <span class="major-letter">a)</span> we’ll share personal information outside of ELECTRONET when we have your consent. We’ll ask for your explicit consent to share any sensitive personal information;<br />
                                    <span class="major-letter">b)</span> domain administrators can access and retain information stored in your account (email, name, IP address, …), view statistics regarding your account, change your account password, suspend or terminate your account access, receive your account information in order to satisfy applicable law, regulation, legal process, or enforceable governmental request, and restrict your ability to delete or edit your information;<br />
                                    <span class="major-letter">c)</span> we provide personal information to our affiliates and other trusted businesses or persons to process it for us, based on our instructions and in compliance with our Privacy Policy and any other appropriate confidentiality and security measures. For example, we use service providers to help us with customer support;<br/>
									<span class="major-letter">d)</span> we will share personal information outside of ELECTRONET if we have a good-faith belief that access, use, preservation, or disclosure of the information is reasonably necessary to meet any applicable law, regulation, legal process, or enforceable governmental request, enforce applicable <a href="terms">Terms of Service</a>, including investigation of potential violations, detect, prevent, or otherwise address fraud, security, or technical issues, protect against harm to the rights, property or safety of ELECTRONET, our users, or the public as required or permitted by law.<br/>
									We may share non-personally identifiable information publicly and with our partners — like publishers, advertisers, developers, or rights holders. For example, we share information publicly to show trends about the general use of our services. We also allow specific partners to collect information from your browser or device for advertising and measurement purposes using their own cookies or similar technologies.<br />
									If ELECTRONET is involved in a merger, acquisition, or sale of assets, we’ll continue to ensure the confidentiality of your personal information and give affected users notice before personal information is transferred or becomes subject to a different privacy policy.

                                     </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">6.</span> <i>KEEPING YOUR INFORMATION LOCKED DOWN</i> <br />
                                       ELECTRONET is built with strong security features that continuously protect your information. The insights we gain from maintaining our services help us detect and automatically block security threats from ever reaching you. And if we do detect something risky that we think you should know about, we’ll notify you and help guide you through steps to stay better protected.<br/>We use encryption to keep your data private while in transit. Also, we review our information collection, storage, and processing practices, including physical security measures, to prevent unauthorized access to our systems. Finally, we restrict access to personal information to ELECTRONET employees, contractors, and agents who need that information in order to process it. Anyone with this access is subject to strict contractual confidentiality obligations and may be disciplined or terminated if they fail to meet these obligations.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">7.</span> <i>DATA TRANSFERS</i> <br />
                                        We maintain servers around the world and your information may be processed on servers located outside of the country where you live. Data protection laws vary among countries, with some providing more protection than others. Regardless of where your information is processed, we apply the same protections described in this policy.<br/>When we receive formal written complaints, we respond by contacting the person who made the complaint. We work with the appropriate regulatory authorities, including local data protection authorities, to resolve any complaints regarding the transfer of your data that we cannot resolve with you directly.
                                    </p>
                                    <p>
                                        <span class="major-letter">8.</span> <i>APPLIANCE OF THIS POLICY</i> <br />
										This Privacy Policy applies to all of the services offered by ELECTRONET. This Privacy Policy doesn’t apply to services that have separate privacy policies that do not incorporate this Privacy Policy. This Privacy Policy doesn’t apply to services offered by other companies or individuals, including products or sites that may include ELECTRONET services, be displayed to you in search results, or be linked from our services.
                                    </p>
                                    <p>
                                        <span class="major-letter">9.</span> <i>CHANGES TO THIS POLICY</i> <br />
                                        We change this Privacy Policy from time to time. We will not reduce your rights under this Privacy Policy without your explicit consent. We always indicate the date the last changes were published. If changes are significant, we’ll provide a more prominent notice (including, for certain services, email notification of Privacy Policy changes).
										<br />
										If you have any questions about this Privacy Policy, you can <a href="mailto:cdl.electronet@gmail.com">contact us</a>.

                                    </p>
                                    <p>
                                        <span class="major-letter">10.</span> <i>DISMISSAL</i> <br />
                                        This Privacy Policy was fully written according to <a href="https://policies.google.com/privacy" target="_blank">Google's Privacy Policy</a>.
                                    </p>
                                    <br />
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
							L'utilisation de ce site Web constitue l'acceptation de nos <a href="terms">Termes et conditions d'utilisation</a> et de notre <a href="privacy">Politique de confidentialité</a>. Tous les copyrights, marques déposées et marques de service appartiennent aux propriétaires respectifs.
							<form target="" method="post" style="text-align: left; margin-left: 15%;">Cette page a été générée en français. Pour traduire cette page en anglais, <input id="changeLang" type="submit" name="changeLang" value="cliquez ici">.</form>
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
							<form target="" method="post" style="text-align: left; margin-left: 15%;">This page was generated in English. To translate this page in French, <input id="changeLang" type="submit" name="changeLang" value="click here">.</form>
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

