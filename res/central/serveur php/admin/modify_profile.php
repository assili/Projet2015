<?php
				session_start();
				try{
					$bdd = new PDO("pgsql:host=localhost;dbname=etd ; user= uapv1200086;  password= K42Y4Z ");
				}
				catch(EXCEPTION $e)
				{
					die('ERREUR : '. $e->getMessage());
				} 

				$nbError = 0;
				$errorMessage =NULL;
				$login = htmlspecialchars($_POST['usernamesignup']);
				
				$nom = htmlspecialchars($_POST['namesignup']);
				
				$prenom = htmlspecialchars($_POST['prenomsignup']);
				
				$telephone = htmlspecialchars($_POST['phonesignup']);
				
				$email = htmlspecialchars($_POST['emailsignup']);
				
				$password = hash('md5',htmlspecialchars($_POST['passwordsignup']));
				
				$confirm_password = hash('md5',htmlspecialchars($_POST['passwordsignup_confirm']));
				

				
				//verification des variables
				if (!empty($email))
				{
					if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
					{
						$req = $bdd->prepare('UPDATE users SET email = :email WHERE id = :identifiant');
						$req->execute(array(
						    'email' => $email,
						    'identifiant' => $_SESSION['id']
					    ));
					    $req->closeCursor();
					}
					else
					{
							$errorMessage .= '<li> Vous aves essayez de modifier votre email, verifier la conformitée de ce mail, avant de soumettre</li>';
							if (!headers_sent()){    //If headers not sent yet... then do php redirect
								header("Location: affiche.php?message=2&errorMessage=$errorMessage"); exit;
							}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
								echo '<script type="text/javascript">';
								echo "window.location.href=\"affiche.php?message=2&errorMessage=$errorMessage\";";
								echo '</script>';
								echo '<noscript>';
								echo "<meta http-equiv=\"refresh\" content=\"0;url=affiche.php?message=2&errorMessage=$errorMessage\"/>";
								echo '</noscript>'; exit;
							}

					}

					$nbError++;
					
				}
				
				if (!empty($prenom))
				{
					$req = $bdd->prepare('UPDATE users SET prenom = :prenom WHERE id = :identifiant');
					$req->execute(array(
					    'prenom' => $prenom,
					    'identifiant' => $_SESSION['id']
				    ));
				    $req->closeCursor();
				    $nbError++;
				}
				
				if (!empty($nom))
				{
					$req = $bdd->prepare('UPDATE users SET nom = :nom WHERE id = :identifiant');
					$req->execute(array(
					    'nom' => $nom,
					    'identifiant' => $_SESSION['id']
				    ));
				    $req->closeCursor();
				    $nbError++;
				}
				
				if (!empty($telephone))
				{
					$req = $bdd->prepare('UPDATE users SET telephone = :telephone WHERE id = :identifiant');
					$req->execute(array(
					    'telephone' => $telephone,
					    'identifiant' => $_SESSION['id']
				    ));
				    $req->closeCursor();
					$nbError++;
				}
				
				if (!empty($login))
				{
					$req = $bdd->prepare('UPDATE users SET login = :login WHERE id = :identifiant');
					$req->execute(array(
					    'login' => $login,
					    'identifiant' => $_SESSION['id']
				    ));
				    $req->closeCursor();
				    $nbError++;
				}
								
				
				if ((!empty($password)) && (!empty($confirm_password)) && (isset($password)) && (isset($confirm_password)) )
				{
					if ($password == $confirm_password)
					{
						$req = $bdd->prepare('UPDATE users SET password = :password WHERE id = :identifiant');
						$req->execute(array(
						    'password' => $password,
						    'identifiant' => $_SESSION['id']
					    ));
					    $req->closeCursor();
					    //stock le cookie pendant 1 mois
							setcookie('id', "", time() - 3600, '/', null, false, true);
							setcookie('password', "", time() - 3600, '/', null, false, true);
							setcookie('keeplogin', "", time() - 3600, '/', null, false, true);
							//setcookie('prenom', $prenom, time() + 30*24*3600, '/', null, false, true);
					    unset($_COOKIE["id"]);
					    unset($_COOKIE["password"]);
					    unset($_COOKIE["keeplogin"]);
					    $nbError++;
					}
					else
					{
						$errorMessage .= '<li> Vous aves essayez de modifier votre mot de passe, verifier bien si vous avez respecter les regles</li>';
							if (!headers_sent()){    //If headers not sent yet... then do php redirect
								header("Location: affiche.php?message=2&errorMessage=$errorMessage"); exit;
							}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
								echo '<script type="text/javascript">';
								echo "window.location.href=\"affiche.php?message=2&errorMessage=$errorMessage\";";
								echo '</script>';
								echo '<noscript>';
								echo "<meta http-equiv=\"refresh\" content=\"0;url=affiche.php?message=2&errorMessage=$errorMessage\"/>";
								echo '</noscript>'; exit;
							}
					}
					
				}

				/*
					== Ici on verifie bien que l'avatar uploader par l'utilisateur
					== repond a nos aspiration
					== dans le cas contraire on l'apeche de stocker un avatar ou quoique ca soit dans la base 
					== de donnees
				*/
				
				if (!empty($_FILES['avatar']['name']))
				{
					
					if ($_FILES['avatar']['error']) {     
					  switch ($_FILES['nom_du_fichier']['error']){     
							   case 1: // UPLOAD_ERR_INI_SIZE     
							   $errorMessage .= '<li>Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !</li>';     
							   break;     
							   case 2: // UPLOAD_ERR_FORM_SIZE     
							   $errorMessage .= '<li>Le fichier dépasse la limite autorisée dans le formulaire HTML !</li>'; 
							   break;     
							   case 3: // UPLOAD_ERR_PARTIAL     
							   $errorMessage .= '<li>envoi du fichier a été interrompu pendant le transfert !</li>';     
							   break;     
							   case 4: // UPLOAD_ERR_NO_FILE     
							   $errorMessage .= '<li>Le fichier que vous avez envoyé a une taille nulle !</li>'; 
							   break; 
					  }  
					}     
					else 
					{     
					 // $_FILES['nom_du_fichier']['error'] vaut 0 soit UPLOAD_ERR_OK     
					 // ce qui signifie qu'il n'y a eu aucune erreur 
						$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
						//1. strrchr renvoie l'extension avec le point (« . »).
						//2. substr(chaine,1) ignore le premier caractère de chaine.
						//3. strtolower met l'extension en minuscules.
						$extension_upload = strtolower(  substr(  strrchr($_FILES['avatar']['name'], '.')  ,1)  );
						if ( in_array($extension_upload,$extensions_valides))
						{
							 					
							$idAvatar = md5(uniqid(rand(1,15),true)).'.'.$extension_upload; 
							$avatar = "../avatar/".$idAvatar.'.'.$extension_upload;
							$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'],$avatar);
							if ($resultat)
							{
								$req = $bdd->prepare('UPDATE users SET avatar = :avatar WHERE id = :identifiant');
								$req->execute(array(
								    'avatar' => $avatar,
								    'identifiant' => $_SESSION['id']
							    ));
							    $req->closeCursor();
							    $nbError++; 
							}

						}
						else
						{
							$errorMessage .= '<li> Les extensions reconnu dans ce site ne conviennent pas avec le votre, reesayez</li>';
							if (!headers_sent()){    //If headers not sent yet... then do php redirect
								header("Location: affiche.php?message=2&errorMessage=$errorMessage"); exit;
							}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
								echo '<script type="text/javascript">';
								echo "window.location.href=\"affiche.php?message=2&errorMessage=$errorMessage\";";
								echo '</script>';
								echo '<noscript>';
								echo "<meta http-equiv=\"refresh\" content=\"0;url=affiche.php?message=2&errorMessage=$errorMessage\"/>";
								echo '</noscript>'; exit;
							}
						}
					} 
					$nbError++;    
				}

				if ($nbError == 0)
				{
					if (!headers_sent()){    //If headers not sent yet... then do php redirect
								header("Location: index.php"); exit;
							}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
								echo '<script type="text/javascript">';
								echo "window.location.href=\"index.php\";";
								echo '</script>';
								echo '<noscript>';
								echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\"/>";
								echo '</noscript>'; exit;
							}
				}
				else
				{
					$errorMessage .= '<li>modification effectuée</li>';
					if (!headers_sent()){    //If headers not sent yet... then do php redirect
								header("Location: affiche.php?message=2&errorMessage=$errorMessage"); exit;
					}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
								echo '<script type="text/javascript">';
								echo "window.location.href=\"affiche.php?message=2&errorMessage=$errorMessage\";";
								echo '</script>';
								echo '<noscript>';
								echo "<meta http-equiv=\"refresh\" content=\"0;url=affiche.php?message=2&errorMessage=$errorMessage\"/>";
								echo '</noscript>'; exit;
					}
				}

?>