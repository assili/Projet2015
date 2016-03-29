<?php
session_start(); // On démarre la session AVANT toute chose
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
        <title>Login and Registration Form witd HTML5 and CSS3</title>
        <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form witd HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="autdor" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
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
								 else echo "C'est votre premi&egrave;re visite, vous &ecirc;tes le bienvenue;";
						?>
						<?php 
						$add = $_SERVER['REMOTE_ADDR'];
						echo " votre IP: $add"; 
						?>
				
					</strong>  
                </a>
                <span class="right">
                   
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            
            <section>				
                <div id="container_demo" >
				
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="admin/index.php?formulaire=2" method="POST" autocomplete="on"> 
                                <h1>curve fever</h1> 
								<h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your  username </label>
                                    <?php
                                        if (!empty($_COOKIE['keeplogin']))
                                         echo '<input id="username" name="username" required="required" type="text" value="'.$_COOKIE['id'].'" />';
                                        else
                                            echo '<input id="username" name="username" required="required" type="text" placeholder="myusername "/>';
                                    ?>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <?php
                                        if (!empty($_COOKIE['keeplogin']))
                                        echo '<input id="password" name="password" required="required" type="password" value="'.$_COOKIE['password'].'" /> ';
                                        else
                                            echo '<input id="password" name="password"  type="password" placeholder="*******" />';
                                    ?>
                                    
                                </p>
                                <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Keep me logged in</label>
								</p>
								
                                <p class="login button"> 
                                    <input type="submit" value="Login" /> 
								</p>								
                            </Form>
							
							
							
							<?php
								try{
									$bdd = new PDO("pgsql:host=localhost;dbname=etd  ; user= uapv1200086;  password= K42Y4Z ");
								}
								catch(EXCEPTION $e)
								{
									die('ERREUR : '. $e->getMessage());
								} 
								
								$req = $bdd->query('SELECT id,nom,prenom,login FROM users ');
								
							?>
                            <h1>Liste des joueurs </h1>
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
								while($donnees = $req->fetch())
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
						    <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
							</p>
														
                        </div>

                        <div id="register" class="animate form">
                            <form  action="php/valid_inscription.php?formulaire=1"  method="POST" autocomplete="on"  enctype="multipart/form-data"/> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="Myusernames" />
                                </p>
								<p> 
                                    <label for="namesignup" class="youname" data-icon="u">Your name</label>
                                    <input id="namesignup" name="namesignup" required="required" type="text" placeholder="Assili" />
                                </p>
								<p> 
                                    <label for="prenomsignup" class="youprenom" data-icon="u">Your first name</label>
                                    <input id="prenomsignup" name="prenomsignup" required="required" type="text" placeholder="Akram" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="Akram_assili@live.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="******"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="******"/>
                                </p>
								<p> 
                                    <label for="phonesignup" class="phone" data-icon="u">Your phone</label>
                                    <input id="phonesignup" name="phonesignup" required="required" type="text" placeholder="06 28 28 24 16" />
                                </p>
								 <p> 
                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                    <input  name="avatar"  type="file" />
                                </p>
                                <p class="signin button"> 
									<input type="submit" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
							
						
                        </div>
						
                    </div>
                </div> 
				

            </section>
			
			
			
			
			
        </div>
        <div class="codrops-bottom">
                <a href="">
                    <strong>&copy;Assili akram </strong>  
                </a>
                <span class="right">
                   
                </span>
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
    </body>
</html>