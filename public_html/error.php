<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
<link href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap" rel="stylesheet">

<style>
    
button {
    background-color: lightgreen;
    border: none;
    color: black;
    padding: 11px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin-top: -2%;
    font-family: 'Crimson Text', serif;
    border-radius: 10%;
}

button:hover
{
    background-color: mediumseagreen;
    transition: background-color 0.5s;
    cursor: grabbing;
}


</style>

<?php
	
	include 'variables.php';
    include 'functions.php';

	//CHECKS IF FATAL ERROR
	if ($_SESSION['error'] != '')
	{
?>
		<section style="margin: 5% 8% 5% 8%; text-align: center; font-family: 'Blinker', sans-serif;">

			<div>
				<p>
                    <i class="material-icons" style="color: red; font-size: 80px;">
                        warning
                    </i>
                    <br />

					<span style="font-size: 28px; font-weight: bold; color: black; font-family: 'Crimson Text', serif, Tahoma, Geneva, Verdana; margin: 2%;">
						<?php 
						    echo $_SESSION['error']; 
						?>
					</span>
                </p>
                <br/>
                <p>
                    <?php
                        if ($_SESSION['lang'] == 'fr')
                        {
                            ?>
                                <a href="../index">
                                    <button>RETOUR À LA PAGE D'ACCUEIL</button>
                                </a>
                            <?php
                        }
                        
                        else
                        {
                            ?>
                                <a href="../index">
                                    <button>BACK TO THE HOMEPAGE</button>
                                </a>
                            <?php
                        }
                    ?>
                    
                </p>
                <?php
                    session_unset();
                    session_destroy();
                    session_regenerate_id(true);
                ?>
			</div>

		</section>

	<?php
	}

	//IF USER VISITS THE PAGE WITHOUT ANY FATAL ERROR
	else
	{
		session_unset();
		session_destroy();
		session_regenerate_id(true);
		header('Location: ../index');
	}

?>