<?php

		$formulaire = $_GET['formulaire'];
		switch ($formulaire) {
		case "1" :
		// traitement de ton formulaire 1
					$nbError = 0;
				$errorMessage = NULL;
				
				$login = htmlspecialchars($_POST['usernamesignup']);
				
				$nom = htmlspecialchars($_POST['namesignup']);
				
				$prenom = htmlspecialchars($_POST['prenomsignup']);
				
				$telephone = htmlspecialchars($_POST['phonesignup']);
				
				$email = htmlspecialchars($_POST['emailsignup']);
				
				$password = hash('md5',htmlspecialchars($_POST['passwordsignup']));
				
				$confirm_password = hash('md5',htmlspecialchars($_POST['passwordsignup_confirm']));
				
				//verification des variables
				if (empty($email))
				{
					$nbError++;	
				}
				
				if (empty($prenom))
				{
					$nbError++;	
				}
				
				if (empty($nom))
				{
					$nbError++;	
				}
				
				if (empty($telephone))
				{
					$nbError++;	
					
				}
				
				if (empty($login))
				{
					$nbError++;	
				}
				
				if (empty($password))
				{
					$nbError++;	
				}
				
				if (empty($confirm_password))
				{
					$nbError++;	
				}
				
				if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email) or empty($email))
				{
					$nbError++;
					$errorMessage .= '<li> password inaxct</li>';
				}
				
				if ($password != $confirm_password)
				{
					$nbError++;
					$errorMessage .= '<li>verifier votre password</li>';
					
				}

				/*
					== Ici on verifie bien que l'avatar uploader par l'utilisateur
					== repond a nos aspiration
					== dans le cas contraire on l'apeche de stocker un avatar ou quoique ca soit dans la base 
					== de donnees
				*/
				
				if (empty($_FILES['avatar']['name']))
				{
					$nbError++;
					$errorMessage .= '<li>Verifier si vous avez bien charger un ficher</li>';	
				}
				else
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
						if ( !in_array($extension_upload,$extensions_valides))
						{
							$nbError++;
							$errorMessage .= '<li>Extension incorrecte</li>'; 
						}
						//verification des dimensions de l'image
						/*$image_sizes = getimagesize($_FILES['avatar']['tmp_name']);
						if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) $errorMessage .= '<li>Image trop grande</li>';   */
					}     
				}

				/*  == Fin de la verification ======== de l'avatar uploader == */



				
				if ($nbError == 0) // si tout est bon on mets la base de donnee a jour avec le nouveau inscrit
				{
					$idAvatar = md5(uniqid(rand(1,15),true)).'.'.$extension_upload; 
					$avatar = "../avatar/".$idAvatar.'.'.$extension_upload;
					$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'],$avatar);
					if (!$resultat) $errorMessage .= '<li>Transfere non reussi</li>'; 
					
					try{
						$bdd = new PDO("pgsql:host=localhost;dbname=etd ; user= uapv1200086;  password= K42Y4Z ");
					}
					catch(EXCEPTION $e)
					{
						die('ERREUR : '. $e->getMessage());
					} 
					
					$req = $bdd->prepare("INSERT INTO  users(nom,prenom,login,password,avatar,telephone,email)VALUES(:nom, :prenom, :login, :password, :avatar, :telephone, :email)");
					$req->execute($tab = array(
						'nom' => $nom,
						'prenom' => $prenom,
						'login' => $login,
						'password'=>$password,
						'avatar' =>$idAvatar,
						'telephone' =>$telephone,
						'email' => $email
					 ));
					 
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
				else // sinon on renvoi l'utilisateur dans la page inscription 
				{
					
					//==== Redirect... Try PHP header redirect, then Java redirect, then try http redirect.:
				
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
				break;


		 
		case "2" :
				// traitement de ton formulaire 2
				$username = htmlspecialchars($_POST['username']);
				$password = hash('md5',htmlspecialchars($_POST['password']));
				$erreurLogin = 0;
				$erreurLoginMessage = NULL;
				
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
					
					$req = $bdd->prepare('SELECT nom,prenom,login,password,avatar FROM users WHERE password = :password AND login = :login');
				    $req->execute(array('password' => $password, 'login' => $username));
					 $donnees = $req->fetch();
					if (($donnees['login'] == $username) && ($donnees['password'] == $password)) 
					{

						$login = $donnees['login'];
						$nom = $donnees['nom'];
						$prenom = $donnees['prenom'];
						$avatar =$donnees['avatar'];

						if (!headers_sent()){    //If headers not sent yet... then do php redirect
							header("Location: affiche.php?login=$login&nom=$nom&prenom=$prenom&avatar=$avatar&message=1"); exit;
						}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
							echo '<script type="text/javascript">';
							echo "window.location.href=\"affiche.php?login=$login&nom=$nom&prenom=$prenom&avatar=$avatar&message=1\";";
							echo '</script>';
							echo '<noscript>';
							echo "<meta http-equiv=\"refresh\" content=\"0;url=affiche.php?login=$login&nom=$nom&prenom=$prenom&avatar=$avatar&message=1\"/>";
							echo '</noscript>'; exit;
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
		
				break;
		}

	//declaration de variables
	
	

?>