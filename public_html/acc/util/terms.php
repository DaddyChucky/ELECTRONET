<link rel="stylesheet" href="../../indexB.css" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">

<?php 
    include '../../head.php';
?>
    <title>
        <?php 
            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'fr')
        	{
                echo 'ELECTRONET > Termes et conditions d\'utilisation';
            }
        
            else
            {
                echo 'ELECTRONET > Terms and Conditions of Use';
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

                header('Location: terms');

            }

            if ($_SESSION['lang'] == 'en')
            {
                $req = $database->prepare('UPDATE language SET lang=:lang WHERE IP=:IP');

                $req->execute(array(
                    'lang' => 'fr',
                    'IP' => $_SESSION['IP']
                ));

                header('Location: terms');

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
                                    <h2>Termes et conditions d'utilisation</h2>
                                    <p style="font-size: 20px; margin-right: 12%; margin-left: 12%; text-indent: 0; text-align: center;">
                                        <i>PRIÈRE DE LIRE ENTIÈREMENT LES CONDITIONS GÉNÉRALES AVANT TOUTE UTILISATION DE CE SITE WEB.</i>
                                    </p>
                                    <p>
                                        <span class="major-letter">L</span>es conditions générales qui suivent gouvernent et s’appliquent à votre utilisation ou recours au site « ELECTRONET » (le « site »), maintenu par Charles De Lafontaine.
                                        <br />
                                        En accédant au site ou en y navigant, vous déclarez avoir lu et compris les conditions générales d’utilisation et déclarez avoir lu et compris les conditions générales d’utilisation et déclarez être liés par ces conditions. Veuillez noter que nous pouvons modifier les conditions d’utilisation à tout moment, et ce, sans préavis. Votre utilisation continue du site sera considérée comme votre acceptation des conditions générales révisées.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">1.</span> <i>RESTRICTION FONDÉE SUR L’ÂGE</i> <br />
                                        Vous devez être âgé(e) d’au moins treize (13) ans pour utiliser ce site ou tout service inclus sur le présent site. En accédant à ou en utilisant ce site, vous déclarez être âgé(e) d'au moins treize (13) ans. Nous ne pourrons être tenus responsables d'une fausse déclaration concernant votre âge.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">2.</span> <i>PROPRIÉTÉ INTELLECTUELLE</i> <br />
                                       Toute propriété intellectuelle sur le site, à l'exception du contenu généré par les utilisateurs tel que défini ci-dessous, est possédée par nous ou nos concédants et inclut tout élément protégé par droits d'auteur, marque de commerce ou brevet. Tout le contenu sur le site, à l'exception du contenu généré par les utilisateurs tel que défini ci-dessous, y compris, mais sans s'y limiter, le texte, le logiciel, le code, la conception, les graphiques, les photos, les sons, la musique, les vidéos, les applications, les fonctionnalités interactives ainsi que tout autre contenu, est une œuvre collective sous le droit canadien ou sous tout autre droit des droits d'auteur et est la propriété d’ELECTRONET (Charles De Lafontaine). Les éléments figurant sur ce site ne peuvent être copiés, reproduits, publiés de nouveau, téléchargés, affichés, transmis, distribués, ni modifiés, en totalité ou en partie, que ce soit sous forme textuelle, graphique, audio, vidéo ou exécutable, sans notre autorisation écrite.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">3.</span> <i>UTILISATION DU CONTENU DE L'ENTREPRISE</i> <br />
                                        Nous pouvons vous fournir certaines informations en raison de votre utilisation du site, y compris, sans s'y limiter, des documents, des données ou des informations développés par nous, ou tout autre élément qui pourrait vous aider dans l'utilisation du site ou des services (le "Contenu de l'Entreprise"). Le Contenu de l'Entreprise ne peut être utilisé pour aucun autre objet que l'utilisation du site et des services offerts sur le site. Rien dans les présentes ne peut être interprété comme vous attribuant une licence ou des droits de propriété intellectuelle.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">4.</span> <i>CONTENU GÉNÉRÉ PAR LES UTILISATEURS</i> <br />
                                        Le "contenu généré par les utilisateurs" inclut les communications, éléments, informations, données, opinions, photos, profils, messages, notes, hyperliens, informations textuelles, conceptions, graphiques, sons ou tout autre contenu que vous et/ou d'autres utilisateurs du site publiez ou rendez disponibles sur ou à travers le site, à l'exception du contenu qui est notre propriété.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">5.</span> <i>COMPTE D'UTILISATEUR ET UTILISATION DU COMPTE</i> <br />
                                        Si votre utilisation du site requiert un compte vous identifiant comme utilisateur du site (un "compte d'utilisateur") :<br/>
                                        <span class="major-letter">a)</span> vous êtes le seul responsable de votre compte d'utilisateur, du maintien, de la confidentialité et de la sécurité de votre compte d'utilisateur et de tous les mots de passe reliés à votre compte d'utilisateur ainsi que de l'activité de toute personne qui a accès à votre compte avec ou sans votre permission;<br />
                                    <span class="major-letter">b)</span> vous acceptez de nous signaler immédiatement toute utilisation non-autorisée de votre compte d'utilisateur, de services à travers votre compte d'utilisateur, d'un mot de passe relié à votre compte d'utilisateur ou de toute autre atteinte à la sécurité de votre compte d'utilisateur ou de service fourni à travers votre compte d'utilisateur, et vous acceptez de nous venir en aide, tel que pourrons vous le demander, pour arrêter ou remédier à toute atteinte à la sécurité reliée à votre compte;<br />
                                    <span class="major-letter">c)</span> vous acceptez de fournir des informations d'utilisateur véridiques, exactes et actuelles, tel que nous pouvons le demander de temps à autre, et vous acceptez de nous signaler tout changement à vos informations d'utilisateur tel que requis afin que les informations que nous détenons soient véridiques, exactes et actuelles.

                                     </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">6.</span> <i>VENTE DE PRODUITS ET/OU SERVICES</i> <br />
                                        Nous pouvons vendre des biens ou services ou permettre à de tierces parties de vendre des biens ou des services sur notre site. Nous nous engageons à être aussi exacts que possible en ce qui a trait à toute information au sujet des biens et des services, incluant les descriptions de produits et les images de produits. Cependant, nous ne garantissons pas l'exactitude ou la fiabilité de toute information ayant trait à un produit et vous reconnaissez et convenez que l'achat de tels produits est à vos propres risques.<br />Pour les biens ou services vendus par de tierces parties, nous ne sommes en aucun cas responsables de tout produit et ne pouvons faire de garantie sur la qualité marchande, la conformité, la qualité, la sûreté ou la légalité de ces produits. Pour toute réclamation que vous pourriez avoir contre le fabricant ou le vendeur du produit, vous acceptez de poursuivre cette cause d'action contre le fabricant et/ou le vendeur et non contre nous. Vous acceptez de nous libérer de toute réclamation liée aux biens ou services manufacturés ou vendus par de tierces parties, incluant toute réclamation concernant la garantie ou responsabilité du fabricant.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">7.</span> <i>MARKETING ET PUBLICITÉ AFFILIÉS</i> <br />
                                        Par l'entremise du site et de ses services, nous pouvons pratiquer des activités de marketing affilié pour lesquelles nous recevons une commission ou un pourcentage des ventes. Nous pouvons également accepter de la publicité ou des commandites d'entreprises commerciales ou recevoir d'autres formes de compensation publicitaire.
                                    </p>
                                    <p>
                                        <span class="major-letter">8.</span> <i>UTILISATION ACCEPTABLE DU SITE</i> <br />
                                        Vous acceptez de ne pas utiliser le site pour des fins illicites ou toute autre fin interdite en vertu de la présente clause. Vous acceptez de ne pas utiliser le site de quelconque façon qui pourrait nuire au site, aux services ou à l'activité commerciale d’ELECTRONET (Charles De Lafontaine).<br />Vous acceptez également de ne pas utiliser le site pour les fins suivantes :<br />
                                        <span class="major-letter">a)</span> harceler, abuser ou menacer autrui ou autrement violer les droits d'une personne;<br />
                                        <span class="major-letter">b)</span> violer la propriété intellectuelle d’ELECTRONET (Charles De Lafontaine) ou de toute autre tierce partie;<br />
                                        <span class="major-letter">c)</span> télécharger ou transmettre des virus informatiques ou tout autre logiciel qui pourrait endommager la propriété d’ELECTRONET (Charles De Lafontaine);<br />
                                        <span class="major-letter">d)</span> commettre une fraude;<br />
                                        <span class="major-letter">e)</span> créer des activités de jeu, de la loterie ou un système pyramidal illicite ou y participer;<br />
                                        <span class="major-letter">f)</span> publier ou distribuer du matériel obscène ou diffamatoire;<br />
                                        <span class="major-letter">g)</span> publier ou distribuer tout matériel qui incite è la violence, à la haine, ou à la discrimination de quelque groupe que ce soit;<br />
                                        <span class="major-letter">h)</span> recueillir illicitement des informations sur autrui.
                                    </p>
                                    <p>
                                        <span class="major-letter">9.</span> <i>PROTECTION DE LA VIE PRIVÉE</i> <br />
                                        En utilisant notre site, il est possible que vous nous fournissiez certaines informations. En utilisant le site, vous nous autorisez à utiliser vos informations au Canada et dans tout pays dans lequel nous pourrions opérer.<br />Lorsque vous vous inscrivez pour un compte d'utilisateur, vous nous fournissez une adresse courriel valide et vous pourriez également nous fournir certaines informations additionnelles, telles que votre nom et/ou vos informations de facturation. Selon l'utilisation que vous faites de notre site, nous pouvons également recevoir de l'information d'applications externes que vous utilisez pour accéder à notre site ou nous pouvons recevoir de l'information sur vous par diverses technologies du web telles que les cookies, les historiques, les pixels invisibles (aussi appelés « GIF invisibles »), les balises et autres.<br />Nous utilisons l'information recueillie auprès de vous pour nous assurer que vous assurez une bonne expérience sur le site. Nous pouvons aussi tracer une partie de l'information passive reçue pour améliorer notre marketing et analytique et, pour ce faire, il se peut que nous travaillions avec des fournisseurs tiers.<br />Si vous désirez bloquer notre accès à toute information passive que nous recevons de l'utilisation de diverses technologies, vous pouvez choisir d'inactiver les cookies dans votre navigateur web. Sachez que nous recevrons tout de même les informations vous concernant que vous nous fournirez, tel que votre adresse courriel ou votre localisation.<br/>Si vous choisissez de résilier votre compte, nous entreposerons et retiendrons vos informations pendant une durée de temps raisonnable selon les législations fédérales, provinciales et d'ailleurs en vigueur.
                                    </p>
                                    <p>
                                        <span class="major-letter">10.</span> <i>DÉGAGEMENT DE RESPONSABILITÉ</i> <br />
                                        Notre site existe pour des fins de communications seulement. Vous reconnaissez et convenez que toute information publiée sur notre site n'est pas destinée à être un avis juridique, médical ou financier et aucun rapport fiduciaire n'a été créé entre vous et ELECTRONET (Charles De Lafontaine).<br/>Vous convenez également que votre achat services sur le site est à vos propres risques. Nous ne sommes responsables en aucun cas des conseils ou de toute autre information véhiculée sur le site.
                                    </p>
                                    <p>
                                        <span class="major-letter">11.</span> <i>INGÉNIERIE INVERSE ET SÉCURITÉ</i> <br />
                                        Vous ne pouvez entreprendre aucune des actions qui suivent :<br/>
                                        <span class="major-letter">a)</span> utiliser l'ingénierie inverse ou désassembler tout code ou logiciel sur ou de ce site;<br />
                                        <span class="major-letter">b)</span> violer ou tenter de violer la sécurité du site par tout accès non autorisé, le contournement du cryptage ou de tout autre outil de sécurité, l'exploitation des données ou l'interférence avec tout hôte, utilisateur ou réseau.


                                    </p>
                                    <p>
                                        <span class="major-letter">12.</span> <i>PERTES DE DONNÉES</i> <br />
                                        Nous ne sommes pas responsables de la sécurité de votre compte d'utilisateur ou du contenu de votre compte. L'utilisation du site est à vos risques.
                                    </p>
                                    <p>
                                        <span class="major-letter">13.</span> <i>INDEMNISATION</i> <br />
                                        Vous convenez de défendre, dédommager et de tenir indemne ELECTRONET (Charles De Lafontaine) et ses entreprises affiliées contre toute réclamation, poursuite ou demande, incluant les frais d'avocats, qui pourrait découler de ou qui se rapporte à votre utilisation ou votre abus du site, votre violation des présentes ou votre conduite et vos actions. Si nous choisissons de le faire, nous choisirons notre avocat et participerons à notre propre défense.
                                    </p>
                                    <p>
                                        <span class="major-letter">14.</span> <i>INTERRUPTIONS DE SERVICE</i> <br />
                                        Il se peut que nous ayons à interrompre votre accès au site afin d'effectuer des travaux de maintenant ou des travaux d'urgence non planifiés. Vous convenez que votre accès au site peut être affecté par une indisponibilité non planifiée ou non anticipée, pour quelque raison que ce soit, et que nous ne serons en aucun cas tenus responsable de dommages ou de pertes découlant de cette indisponibilité.
                                    </p>
                                    <p>
                                        <span class="major-letter">15.</span> <i>RÉSILIATION DU COMPTE D'UTILISATEUR</i> <br />
                                        Nous pouvons suspendre, limiter ou résilier votre compte d'utilisateur et votre utilisation du site è notre seule discrétion, à tout moment, sans préavis et pour quelque raison que ce soit, incluant le fonctionnement ou l'efficacité du site ou d'équipement ou de réseau nous appartenant ou appartenant à un tiers qui est perturbé par votre utilisation ou votre abus du site ou si vous avez été ou êtes actuellement en violation des termes des présentes. Nous n'aurons aucune responsabilité vis-à-vis des tiers, incluant un fournisseur tiers pour toute suspension, limite ou résiliation de votre accès au site.
                                    </p>
                                    <p>
                                        <span class="major-letter">16.</span> <i>AUCUNE GARANTIE</i> <br />
                                        Bien que nous ayons déployé des efforts raisonnables pour nous assurer que le contenu du présent site est exact, nous ne pouvons garantir que ledit contenu soit exempt d'erreurs, à jour ou exhaustif. En aucun cas, nous ne pourrons être tenus responsables de tout dommage pouvant découler d'une erreur se trouvant sur le site.<br/>Nous n'assumons aucune responsabilité quant à tout dommage découlant de la mauvaise utilisation du contenu du site. Nous ne pouvons non plus garantir que le site soit disponible sans interruption, sans erreur ni omission, ni que les défauts soient corrigés. Il n'est pas non plus possible de garantir que le site et les serveurs qui le rendent disponible sont exempts de virus ou de composantes nuisibles. Le site et son contenu sont fournis « tels quels » et « selon la disponibilité » sans déclaration, garantie ou condition de quelque nature que ce soit, expresse ou implicite.<br/>Si vous décidez de vous abonner à des services ou à des fonctions du site qui nécessitent un abonnement, vous acceptez de fournir des renseignements exacts et à jour à votre sujet comme l'exige le processus d'inscription ou d'abonnement pertinent, et de vous assurer de leur exactitude en effectuant les mises à jour nécessaires dès que possible. Vous acceptez d'assurer la confidentialité de tous les mots de passe ou autres identificateurs de compte que vous aurez choisis ou qui vous seront attribués au moment d'une inscription ou d'un abonnement sur ELECTRONET (Charles De Lafontaine) ou ses partenaires et d'assumer la responsabilité à l'égard de toutes les activités reliées à l'utilisation de ces mots de passe ou de ces comptes. De plus, vous acceptez de nous prévenir de toute utilisation non autorisée de votre mot de passe ou de votre compte de membre. Nous ne pouvons aucunement être tenus responsables, directement ou indirectement, des pertes ou dommages de quelque nature que ce soit découlant du défaut de vous conformer à la présente disposition ou liés à un tel défaut.<br/>Vous reconnaissez que nous pouvons, à notre seule et absolue discrétion, et ce, sans préavis, suspendre, annuler ou mettre fin à votre compte, à votre utilisation ou à votre accès au site ou à un de ses services, et retirer et supprimer tout renseignement ou contenu se rapportant au site ou à un des services offerts (et mettre fin à l'utilisation que vous en faites), pour quelque motif que ce soit, y compris si nous croyons que vous avez violé les présentes conditions. En outre, vous reconnaissez que nous ne serons aucunement responsables envers vous ou envers quiconque à la suite d'une telle suspension, annulation ou fin. Si vous êtes insatisfait d’ELECTRONET (Charles De Lafontaine) ou d'un de ses services, ou d'une des présentes conditions, des règles, des politiques, des lignes directrices ou de nos pratiques relativement à l'exploitation d’ELECTRONET (Charles De Lafontaine) ou d'un de ses services, votre seul recours consiste à cesser d'utiliser le site ou le service en question.
                                    </p>
                                    <p>
                                        <span class="major-letter">17.</span> <i>CONFIDENTIALITÉ</i> <br />
                                        Les communications via Internet sont sujettes à interception, perte ou altération, par conséquent, vous reconnaissez que les renseignements ou éléments que vous fournissez par voie électronique du fait que vous accédez à ce site ou en faites usage ne sont ni confidentiels ni exclusifs, sauf dans la mesure requise par les lois applicables et que les communications par courrier électronique non protégées sur Internet peuvent être interceptées, altérées ou se perdre.
                                    </p>
                                    <p>
                                        <span class="major-letter">18.</span> <i>LIMITATION DE LA RESPONSABILITÉ</i> <br />
                                        Nous ne sommes en aucun cas responsables des dommages que vous pourriez subir découlant de votre utilisation du site, dans la pleine mesure de la loi. La responsabilité maximale d’ELECTRONET (Charles De Lafontaine) découlant de votre utilisation du site est limitée à cent (100) dollars canadiens ou le montant payé à ELECTRONET (Charles De Lafontaine) dans les six derniers mois, en retenant le montant le plus élevé. Ceci est valable pour toute réclamation incluant, sans s'y limiter, la perte de profits ou de revenus, les dommages indirects ou punitifs, la négligence, la responsabilité civile ou la fraude de toute sorte. 
                                    </p>
                                    <p>
                                        <span class="major-letter">19.</span> <i>QUESTIONS ET INFORMATIONS ADDITIONNELLES</i> <br />
                                        Pour toute question ou pour obtenir de plus amples renseignements, nous vous prions de <a href="mailto:cdl.electronet@gmail.com">communiquer avec nous</a>.
                                    </p>
                                    <p>
                                        <span class="major-letter">20.</span> <i>DÉMENTI</i> <br />
                                        Ces Termes et conditions d’utilisation furent entièrement rédigées grâce à <a href="https://www.wonder.legal/" target="_blank">WONDER.LEGAL CANADA</a>. 
                                    </p>
                                    <br />
                                <?php
                                }

                                else
                                {
                                ?>
                                    <h2>Terms and Conditions of Use</h2>
                                    <p style="font-size: 20px; margin-right: 12%; margin-left: 12%; text-indent: 0; text-align: center;">
                                        <i>PLEASE READ THE ENTIRE TERMS AND CONDITIONS BEFORE USING THIS WEB SITE.</i>
                                    </p>
                                    <p>
                                        <span class="major-letter">T</span>he following terms and conditions govern and apply to your use or use of the site "ELECTRONET" (the "site"), maintained by Charles De Lafontaine.
                                        <br />
                                        By accessing or browsing the site, you declare to have read and understood the general conditions of use and to declare having read and understood the general conditions of use and to declare to be bound by these conditions. Please note that we may change the Terms of Use at any time without notice. Your continued use of the site will be deemed your acceptance of the revised terms and conditions.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">1.</span> <i>AGE BASED RESTRICTION</i> <br />
                                        You must be at least thirteen (13) years of age to use this site or any service included on this site. By accessing or using this site, you declare that you are at least thirteen (13) years old. We can not be held responsible for making a false statement about your age.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">2.</span> <i>INTELLECTUAL PROPERTY</i> <br />
                                       All intellectual property on the Site, other than user-generated content as defined below, is owned by us or our licensors and includes any material protected by copyright, trademark or patent. All content on the site, except for user-generated content as defined below, including but not limited to text, software, code, design, graphics, photos, sounds, music, videos, applications, interactive features and any other content, is a collective work under Canadian law or under any other copyright laws and is the property of ELECTRONET (Charles De Lafontaine). The elements contained on this site can not be copied, reproduced, re-published, downloaded, displayed, transmitted, distributed, or modified, in whole or in part, whether in textual, graphic, audio, video or executable form, without our written authorization.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">3.</span> <i>USE OF COMPANY CONTENT</i> <br />
                                       We may provide you with certain information as a result of your use of the Site, including, without limitation, any documents, data or information developed by us, or any other material that may assist you in the use of the Site or services (the "Company Content"). The Content of the Company may not be used for any purpose other than the use of the site and the services offered on the site. Nothing herein can be construed as granting you a license or intellectual property rights.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">4.</span> <i>CONTENT GENERATED BY USERS</i> <br />
                                       "User Generated Content" includes communications, elements, information, data, opinions, photos, profiles, messages, notes, hyperlinks, textual information, designs, graphics, sounds or any other content that you and / or others Site users post or make available on or through the site, except for the content that is our property.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">5.</span> <i>USER ACCOUNT AND ACCOUNT USE</i> <br />
                                        If your use of the site requires an account identifying you as a user of the site (a "user account"):<br/>
                                        <span class="major-letter">a)</span> you are solely responsible for your user account, the maintenance, confidentiality and security of your user account and all passwords related to your user account and the activity anyone who has access to your account with or without your permission;<br />
                                    <span class="major-letter">b)</span> you agree to report to us immediately any unauthorized use of your User Account, Services through your User Account, a password related to your User Account or any other breach of the User Agreement. security of your user or service account provided through your user account, and you agree to assist us, as may be required, to stop or remedy any security breaches related to your account;<br />
                                    <span class="major-letter">c)</span> you agree to provide truthful, accurate and up-to-date user information, as we may request from time to time, and you agree to notify us of any changes to your User Information as required so that the information that you we hold are truthful, accurate and current.

                                     </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">6.</span> <i>SALE OF PRODUCTS AND / OR SERVICES</i> <br />
                                       We may sell goods or services or allow third parties to sell goods or services on our site. We are committed to being as accurate as possible with any information about goods and services, including product descriptions and product images. However, we do not warrant the accuracy or reliability of any product information and you acknowledge and agree that the purchase of such products is at your own risk.<br />For goods or services sold by third parties, we are not responsible for any product and can not guarantee the merchantability, compliance, quality, safety or legality of these products. For any claim you may have against the manufacturer or seller of the product, you agree to pursue that cause of action against the manufacturer and / or seller and not against us. You agree to release us from any claim relating to goods or services manufactured or sold by third parties, including any claim relating to the warranty or liability of the manufacturer.
                                    </p>
                                    <br />
                                    <p>
                                        <span class="major-letter">7.</span> <i>AFFILIATED MARKETING AND ADVERTISING</i> <br />
                                        Through the site and its services, we may engage in affiliate marketing activities for which we receive a commission or percentage of sales. We may also accept advertising or sponsorship of commercial companies or receive other forms of advertising compensation.
                                    </p>
                                    <p>
                                        <span class="major-letter">8.</span> <i>ACCEPTABLE USE OF THE SITE</i> <br />
                                       You agree not to use the Site for any unlawful purpose or for any other purpose prohibited by this clause. You agree not to use the site in any way that could harm the site, services or business of ELECTRONET (Charles De Lafontaine).<br />You also agree not to use the site for the following purposes:<br />
                                        <span class="major-letter">a)</span> harass, abuse or threaten others or otherwise violate the rights of any person;<br />
                                        <span class="major-letter">b)</span> violate the intellectual property of ELECTRONET (Charles De Lafontaine) or any other third party;<br />
                                        <span class="major-letter">c)</span> download or transmit computer viruses or any other software that could damage the property of ELECTRONET (Charles De Lafontaine);<br />
                                        <span class="major-letter">d)</span> commit fraud;<br />
                                        <span class="major-letter">e)</span> create or participate in gambling activities, lotteries or unlawful pyramid schemes;<br />
                                        <span class="major-letter">f)</span> publish or distribute obscene or defamatory material;<br />
                                        <span class="major-letter">g)</span> publish or distribute any material that incites violence, hatred or discrimination of any group;<br />
                                        <span class="major-letter">h)</span> illegally collect information about others.
                                    </p>
                                    <p>
                                        <span class="major-letter">9.</span> <i>PROTECTION OF PRIVACY</i> <br />
                                        By using our site, you may be able to provide us with certain information. By using the site, you authorize us to use your information in Canada and in any country in which we may operate.<br />When you sign up for a user account, you provide us with a valid email address and you may also provide us with additional information, such as your name and / or billing information. Depending on the use you make of our site, we may also receive information from external applications that you use to access our site or we may receive information about you through various web technologies such as cookies, histories, invisible pixels (also called "invisible GIFs"), tags, and others.<br />We use the information collected from you to ensure that you have a good experience on the site. We can also trace some of the passive information received to improve our marketing and analytics and, to do so, we may be working with third-party vendors.<br />If you wish to block our access to any passive information that we receive from the use of various technologies, you may choose to inactivate cookies in your web browser. Please note that we will still receive information about you that you provide us, such as your email address or your location.<br/>If you choose to terminate your account, we will store and retain your information for a reasonable period of time in accordance with applicable federal, provincial and other laws.
                                    </p>
                                    <p>
                                        <span class="major-letter">10.</span> <i>DISCLAIMER OF LIABILITY</i> <br />
                                        Our site exists for communications purposes only. You acknowledge and agree that any information published on our site is not intended to be legal, medical or financial advice and no fiduciary relationship has been created between you and ELECTRONET (Charles De Lafontaine).<br/>You also agree that your purchase services on the site is at your own risk. We are not responsible for any advice or any other information on the site.
                                    </p>
                                    <p>
                                        <span class="major-letter">11.</span> <i>REVERSE ENGINEERING AND SECURITY</i> <br />
                                       You can not take any of the following actions:<br/>
                                        <span class="major-letter">a)</span> use reverse engineering or disassemble any code or software on or from this site;<br />
                                        <span class="major-letter">b)</span> violate or attempt to violate the security of the Site by any unauthorized access, bypassing encryption or any other security tool, the exploitation of data or interference with any host, user or network.


                                    </p>
                                    <p>
                                        <span class="major-letter">12.</span> <i>LOSS OF DATA</i> <br />
                                        We are not responsible for the security of your user account or the contents of your account. The use of the site is at your risk.
                                    </p>
                                    <p>
                                        <span class="major-letter">13.</span> <i>INDEMNITY</i> <br />
                                       You agree to defend, indemnify and hold harmless ELECTRONET (Charles De Lafontaine) and its Affiliates against any claim, suit or demand, including legal fees, that may arise out of or relating to your use or abuse of site, your violation of these terms or your conduct and actions. If we choose to do so, we will choose our lawyer and participate in our own defense.
                                    </p>
                                    <p>
                                        <span class="major-letter">14.</span> <i>SERVICE INTERRUPTIONS</i> <br />
                                        We may have to interrupt your access to the site in order to perform work now or unplanned emergency work. You agree that your access to the Site may be affected by unplanned or unplanned downtime for any reason and that we will not be liable for any damages or losses arising from such unavailability.
                                    </p>
                                    <p>
                                        <span class="major-letter">15.</span> <i>TERMINATION OF THE USER ACCOUNT</i> <br />
                                        We may suspend, limit or terminate your User Account and your use of the Site in our sole discretion, at any time, without notice and for any reason, including the operation or effectiveness of the Site or Equipment or network owned or owned by a third party that is disrupted by your use or abuse of the site or if you have been or are currently in violation of the terms hereof. We will have no liability to third parties, including a third-party provider for any suspension, limitation or termination of your access to the site.
                                    </p>
                                    <p>
                                        <span class="major-letter">16.</span> <i>NO WARRANTY</i> <br />
                                      Although we have made reasonable efforts to ensure that the content on this site is accurate, we can not guarantee that such content is free of errors, current or complete. In any case, we can not be held responsible for any damage that may arise from an error on the site.<br/>We assume no responsibility for any damage resulting from the misuse of the content of the site. We also can not guarantee that the site is available without interruption, without error or omission, or that defects are corrected. It is also not possible to guarantee that the site and the servers that make it available are free of viruses or harmful components. The site and its content are provided "as is" and "as available" without any representations, warranties or conditions of any kind, express or implied.<br/>If you decide to subscribe to services or features of the site that require a subscription, you agree to provide accurate and up-to-date information about yourself as required by the relevant registration or subscription process, and ensure their accuracy by making the necessary updates as soon as possible. You agree to ensure the confidentiality of all passwords or other account identifiers that you have chosen or that you will be assigned at the time of registration or subscription on ELECTRONET (Charles De Lafontaine) or its partners and d assume responsibility for all activities related to the use of these passwords or accounts. In addition, you agree to notify us of any unauthorized use of your password or membership account. We can not be held liable, directly or indirectly, for any loss or damage of any nature whatsoever resulting from the failure to comply with this provision or related to such default.<br/>You acknowledge that we may, in our sole and absolute discretion, without notice, suspend, cancel or terminate your account, use or access to the Site or any of its services, and remove and remove any information or content relating to the Site or any of the Services offered (and terminate your use thereof), for any reason whatsoever, including if we believe that you have violated these Terms. In addition, you acknowledge that we will not be liable to you or anyone else as a result of such suspension, cancellation or termination. If you are dissatisfied with ELECTRONET (Charles De Lafontaine) or any of its services, or any of these conditions, rules, policies, guidelines or practices relating to the operation of ELECTRONET (Charles De Lafontaine) or any of its services, your sole remedy is to stop using the site or service in question.
                                    </p>
                                    <p>
                                        <span class="major-letter">17.</span> <i>CONFIDENTIALITY</i> <br />
                                       Communication via the Internet is subject to interception, loss or alteration; therefore, you acknowledge that the information or material that you provide electronically by accessing or using this site is not confidential or proprietary, except the extent required by applicable law and that unprotected e-mail communications over the Internet may be intercepted, altered or lost.
                                    <p>
                                        <span class="major-letter">18.</span> <i>LIMITATION OF LIABILITY</i> <br />
                                        We are in no way responsible for any damages you may suffer as a result of your use of the site, to the fullest extent of the law. The maximum liability of ELECTRONET (Charles De Lafontaine) arising from your use of the site is limited to one hundred (100) Canadian dollars or the amount paid to ELECTRONET (Charles De Lafontaine) in the last six months, with the highest amount. This is valid for all claims including but not limited to loss of profits or income, indirect or punitive damages, negligence, civil liability or fraud of any kind.
                                    </p>
                                    <p>
                                        <span class="major-letter">19.</span> <i>ADDITIONAL QUESTIONS AND INFORMATION</i> <br />
                                        For any questions or for more information, please <a href="mailto:cdl.electronet@gmail.com">contact us</a>.
                                    </p>
                                    <p>
                                        <span class="major-letter">20.</span> <i>DISMISSAL</i> <br />
                                        These Terms and Conditions of Use were fully written by <a href="https://www.wonder.legal/" target="_blank">WONDER.LEGAL CANADA</a>. 
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

