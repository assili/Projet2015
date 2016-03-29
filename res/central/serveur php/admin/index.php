<?php
session_start(); // On démarre la session AVANT toute chose
?>

<?php
	include('verif_login.php');
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
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/animate-custom.css" />
		<script src="../js/jquery.js"></script>

		
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
								 else echo "C'est votre première visite, nous en sommes ravis d'avoir visité ce site";
						
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
                        <h1> Profil </h1>
                             <?php
                             	
                             		echo"<p>";
                                    echo "Nom : ".$_SESSION['nom']. "</br></br>";
                                    echo "Prenom : ".$_SESSION['prenom']. "</br></br>";
                                    echo "Email : ".$_SESSION['email']. "</br></br>";
                                    echo "Tel : ".$_SESSION['telephone']. "</br></br>";
                                    echo '<spanstyle="display:inline-block;">Avatar :</span>';
                                    echo '<span style="display:inline-block;vertical-align:middle;padding-left:15px;padding-bottom:40px;">';
                                    echo '<img src="'.'../avatar/'.$_SESSION['avatar'].'" width="100" height ="100" alt="avatar"/></span>';
                                    echo "</p>";

                            ?>   
							
							
							<button>modifier Profil</button> 
							
							
							<?php
								try{
									$bdd = new PDO("pgsql:host=localhost;dbname=etd  ; user= uapv1200086;  password= K42Y4Z ");
								}
								catch(EXCEPTION $e)
								{
									die('ERREUR : '. $e->getMessage());
								} 
								
								$req1 = $bdd->query('SELECT id,nom,prenom,login FROM users ');/// statistique ************
								$req2 = $bdd->query('SELECT id,nom,prenom,login FROM stat ');/// jeux en cours ***********
								
							?>
						
						<h1>Statistique du joueur </h1>
						<div class="CSSTableGenerator" >
                        	<table>
							
							<tr>
							  <td>Id</td>
							  <td>Nom</td>
							  <td>Prenom</td>
							  <td>Profil</td>
							  <td>classement</td>
							</tr>
						  
							<?php
								while($donnees = $req1->fetch())
								{
                                    $identifiant = $donnees['id'];
									echo "<tr>";
									echo "<td>".$donnees['id']."</td>";
									echo "<td>".$donnees['nom']."</td>";
									echo "<td>".$donnees['prenom']."</td>";
									echo "<td><a href=\"php/view_profile.php?id=$identifiant\">".$donnees['login']."</a></td>";
									echo "</tr>";
									
								}
							
							?>
							
							</table>
						</div>	
						
						
						
						<h1>Jeux en cours </h1>
						<div class="CSSTableGenerator" >
                        	<table>
							
							<tr>
							  <td>Id</td>
							  <td>Nom</td>
							  <td>Prenom</td>
							  <td>Profil</td>
							  <td>classement</td>
							</tr>
						  
							<?php
								while($donnees = $req2->fetch())
								{
                                    $identifiant = $donnees['id'];
									echo "<tr>";
									echo "<td>".$donnees['id']."</td>";
									echo "<td>".$donnees['nom']."</td>";
									echo "<td>".$donnees['prenom']."</td>";
									echo "<td><a href=\"php/view_profile.php?id=$identifiant\">".$donnees['login']."</a></td>";
									echo "</tr>";
									
								}
							
							?>
							
							</table>
						</div>	


                        

                                                    
                        <div class="modif" style="display:none;">
                            <form  action="modify_profile.php"  method="POST" autocomplete="on"  enctype="multipart/form-data"  /> 
                                <h1> Changing profil </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup"  type="text" placeholder="akramassili" />
                                </p>
								<p> 
                                    <label for="namesignup" class="youname" data-icon="u">Your name</label>
                                    <input id="namesignup" name="namesignup"  type="text" placeholder="assili" />
                                </p>
								<p> 
                                    <label for="prenomsignup" class="youprenom" data-icon="u">Your first name</label>
                                    <input id="prenomsignup" name="prenomsignup"  type="text" placeholder="akram" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup"  type="email" placeholder="akram_assili@live.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup"  type="password" placeholder="eg. X8df!9O"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm"  type="password" placeholder="eg. X8df!9O"/>
                                </p>
								<p> 
                                    <label for="phonesignup" class="phone" data-icon="u">Your phone</label>
                                    <input id="phonesignup" name="phonesignup"  type="text" placeholder="06 28 28 24 16" />
                                </p>
								 <p> 
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                    <input  name="avatar"  type="file" />
                                </p>
                                <p class="signin button"> 
									<input type="submit" value="Sign up"/> 
								</p>
                               
                            </form>
                           				
                     	</div>
							<p class="change_link">
								<a href="../index.php" class="to_register"> Acceuil </a>
							</p>
                        </div>                        
                   </div>
                </div>  

                <div class="pied">
	                <div class="codrops-bottom">
		                <a href="">
		                    <strong>&copy;Assili Akram </strong>  
		                </a>
		                <span class="right"></span>
	                <div class="clr"></div>
	            	</div><!--/ Codrops top bar -->
	            </div>

            </section>
			</div>
			 

            <!-- script javascript -->
        <script>
			$( "button" ).click(function() {
			  $( ".modif" ).toggle( "slow" );
			});

			$( "button" ).click(function() {
			  $( ".pied" ).toggle( "slow" );
			});

		</script>


    </body>
</html>