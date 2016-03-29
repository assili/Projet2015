

<?php

	// traitement de ton formulaire 2
				$username = htmlspecialchars($_POST['username']);
				if (isset($_COOKIE['keeplogin']))
					$password =htmlspecialchars($_POST['password']);
				else
					$password = hash('md5',htmlspecialchars($_POST['password']));
					
				$keeplogin = false;
				$erreurLogin = 0;
				$erreurLoginMessage = NULL;
				
				if (!empty($_POST['loginkeeping']))
				{
					$keeplogin = true;
				}
				
				if (empty($username))
				{
					$erreurLogin++;
					$erreurLoginMessage .= '<li>Vous n\'avez pas entrer votre identifiant</li>';
				}
				
				if (empty($password))
				{
					$erreurLogin++;
					$erreurLoginMessage .= '<li>Vous n\'avez pas entrer votre identifiant</li>';
				}
				
				if ($erreurLogin == 0)
				{
					try{
						$bdd = new PDO("pgsql:host=localhost;dbname=etd ; user= uapv1200086;  password= K42Y4Z ");
					}
					catch(EXCEPTION $e)
					{
						die('ERREUR : '. $e->getMessage());
					} 
					
					$req = $bdd->prepare('SELECT id,nom,prenom,login,password,avatar,telephone,email FROM users WHERE password = :password AND login = :login');
				    $req->execute(array('password' => $password, 'login' => $username));
					 $donnees = $req->fetch();
					if (($donnees['login'] == $username) && ($donnees['password'] == $password)) 
					{
						$id = $donnees['id'];
						$login = $donnees['login'];
						$nom = $donnees['nom'];
						$prenom = $donnees['prenom'];
						$avatar =$donnees['avatar'];
						$telephone =$donnees['telephone'];
						$email =$donnees['email'];
						
						//demarrage de la sesssion										
						
						$_SESSION['id'] = $id;
						$_SESSION['nom'] = $nom;
						$_SESSION['prenom'] = $prenom;
						$_SESSION['avatar'] = $avatar;
						$_SESSION['telephone'] = $telephone;
						$_SESSION['email'] = $email;
						
						
						//verifi si l'utilisateur souhaite qu'on se souviens de lui
						if ($keeplogin)
						{
							
							//stock le cookie pendant 1 mois
							setcookie('id', $username, time() + 30*24*3600, '/', null, false, true);
							setcookie('password', $password, time() + 30*24*3600, '/', null, false, true);
							setcookie('keeplogin', "oui", time() + 30*24*3600, '/', null, false, true);
							//setcookie('prenom', $prenom, time() + 30*24*3600, '/', null, false, true);
						}
						else
						{
							//creation d'un cookie apres la fin de sa session il sont supprimer 
							setcookie('id_current', $username);
							setcookie('password_current', $password);

							//setcookie('nom', $nom);
							//setcookie('prenom', $prenom);
						}
						
						
					}
					else
					{
						if (!headers_sent()){    //If headers not sent yet... then do php redirect
							header('Location: ../index.php'); exit;
						}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
							echo '<script type="text/javascript">';
							echo 'window.location.href="../index.php";';
							echo '</script>';
							echo '<noscript>';
							echo '<meta http-equiv="refresh" content="0;url=../index.php"/>';
							echo '</noscript>'; exit;
						}
					}
					
					
				}
				else
				{
				
					if (!headers_sent()){    //If headers not sent yet... then do php redirect
						header('Location: ../index.php'); exit;
					}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
						echo '<script type="text/javascript">';
						echo 'window.location.href="../index.php";';
						echo '</script>';
						echo '<noscript>';
						echo '<meta http-equiv="refresh" content="0;url=../index.php"/>';
						echo '</noscript>'; exit;
					}
					
				}		
		
				

?>