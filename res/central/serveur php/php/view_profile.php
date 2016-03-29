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
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="">
                    <strong>Assili Akram </strong>  
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
                            $id = $_GET['id'];
                            try{
                                    $bdd = new PDO("pgsql:host=localhost;dbname=etd ; user= uapv1200086;  password= K42Y4Z ");
                                }
                                catch(EXCEPTION $e)
                                {
                                    die('ERREUR : '. $e->getMessage());
                                } 
                                
                                $req = $bdd->prepare('SELECT nom,prenom,login, telephone,avatar FROM users WHERE id = :id ');
                                $req->execute(array('id' => $id) );

                                while($donnees = $req->fetch())
                                {
                                    echo"<p>";
                                    echo "Nom : ".$donnees['nom']. "</br></br>";
                                    echo "Prenom : ".$donnees['prenom']. "</br></br>";
                                    echo "Tel : ".$donnees['telephone']. "</br></br>";
                                    echo '<spanstyle="display:inline-block;">Avatar :</span>';
                                    echo '<span style="display:inline-block;vertical-align:middle;padding-left:15px;padding-bottom:40px;">';
                                    echo '<img src="'.'../avatar/'.$donnees['avatar'].'" width="100" height ="100" alt="avatar"/></span>';
                                    echo "</p>";


                                }
                                $req->closeCursor();

                        ?>
						
						<?php
								try{
									$bdd = new PDO("pgsql:host=localhost;dbname=etd  ; user= uapv1200086;  password= K42Y4Z ");
								}
								catch(EXCEPTION $e)
								{
									die('ERREUR : '. $e->getMessage());
								} 
								
								$req1 = $bdd->query('SELECT id,nom,prenom,login FROM users ');
								
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
                                      
                                 
    					       <p class="change_link">
                                    <a href="../index.php" class="to_register"> Acceuil </a>
                                </p>

                        </div>
                        </div>
                        <div>
                        <div class="codrops-bottom">
                            <a href="">
                                <strong>&copy;Assili Akram </strong>  
                            </a>
                            <span class="right"></span>
                            <div class="clr"></div>
                        </div><!--/ Codrops top bar -->
                        </div>
                </div>  
            </section>
        </div>
    </body>
</html>