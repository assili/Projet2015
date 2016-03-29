<?php
session_start(); // On d�marre la session AVANT toute chose
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login and Registration Form with HTML5 and CSS3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="../css/demo.css" />
        <link rel="stylesheet" type="text/css" href="../css/style_1.css" />
		<link rel="stylesheet" type="text/css" href="../css/animate-custom.css" />
		<script src="../js/jquery.js"></script>
		<script>
			$(document).ready(function(){
			  $("#hide").click(function(){
				$("em").hide();
			  });
			  $("#show").click(function(){
				$("em").show();
			  });
			});
		</script>
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="">
                    <strong>
						<?php   
								if (!empty($_SESSION['nom']) && !empty($_SESSION['prenom']))
								 echo $_SESSION['nom']. ' '.$_SESSION['prenom'];
								 else echo "C'est votre premi�re visite, nous en sommes ravis d'avoir visit� ce site";
						
						?> 
					</strong>  
                </a>
                <span class="right">
                   
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            
            <section>				
                <div id="container_demo" >
                    <div id="wrapper"> 
                        <div id="login" class="animate form">            
				           
                            <?php
								
								$formulaire = $_GET['message'];
								switch ($formulaire) {
									case "1" :
											function reverse_strrchr($haystack, $needle) // fonction  qui fait le contraire de strrchr
											{
												$pos = strrpos($haystack, $needle);
												if($pos === false) {
													return $haystack;
												}
												return substr($haystack, 0, $pos + 1);
											}
											$nom  = $_GET['nom'];
											$prenom  = $_GET['prenom'];
											$login  = $_GET['login'];
											$avatar = $_GET['avatar'];
											$dir = "../avatar";
											 
											// Ouvre un dossier bien connu, et liste tous les fichiers
											if (is_dir($dir)) {
												if ($dh = opendir($dir)) {
												   // while (($file = readdir($dh)) !== false) 
													
														//if ($avatar == reverse_strrchr($file,'.'))
													echo '<span style=" display:inline-block;"><img src="'.$dir.'/'.$avatar.'" width="100" height ="100" "/></span>';

													
													closedir($dh);
												}
											}
											
											echo "<p style=\"display:inline-block; vertical-align:top; padding-left:20px; \">";
                                            echo "Bonjour  <strong>$login</strong></br>";
											echo "NOM : <strong>$nom</strong></br>";
											echo "PRENOM : <strong>$prenom</strong></br></p>";		
											echo '<button id="show">Show</button>';
											echo '<em>If you click on the  button, I will disappear.</em>';
											echo '<button id="hide">Hide</button>';
																						
											echo'<p class="change_link">';
											echo'	<a href="../index.php" class="to_register"> Accueil </a>';
											echo'</p>';
											
											break;
											
									case "2" :
											$errorMessage = $_GET['errorMessage'];
											echo "<p>";
											echo "<ul>";
											echo "$errorMessage";
											echo "</ul>";
											echo "</p>";
											echo'<p class="change_link">';
											echo'	Already a member ?';
											echo'	<a href="../index.php#toregister" class="to_register"> Try again </a>';
											echo'</p>';
									
											break;
								}
                            ?>             
                                 
						
                               
                        </div>
                   </div>
                </div>  
            </section>
			<div class="codrops-bottom">
                <a href="">
                    <strong>&copy;Assili Akram </strong>  
                </a>
                <span class="right">
                   
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
        </div>
    </body>
</html>