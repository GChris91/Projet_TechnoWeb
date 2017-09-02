<?php
	
	function open_database_connection() //Permet de se connecter avec la Base de données
	{
		$link = mysqli_connect('localhost', 'user', 'KXDz1nnMclEoR1eK', 'bdd_serious_game')or die("Impossible de se connecter : " . mysql_error());
		mysqli_set_charset ($link, "utf8");
		return $link;
	}

	function open_database_admin_connection() //Permet de se connecter avec la Base de données
	{
		$link = mysqli_connect('localhost', 'root', '', 'bdd_serious_game')or die("Impossible de se connecter : " . mysql_error());
		mysqli_set_charset ($link, "utf8");
		return $link;
	}

	function close_database_connection($link) //Permet de se déconnecter avec la Base de données
	{
		mysqli_close($link);
	}

	function cherche_id($nom_util) // Cherche l'id d'un utilisateur en fonction de son nom d'utilisateur
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	if($query= mysqli_prepare ($link, 'SELECT id_util FROM utilisateur WHERE nom_util=?'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 's', $nom_util))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $id_util))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
	    	exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		mysqli_stmt_fetch($query) ;//On récupère le résultat
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}
    	
    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
    	mysqli_stmt_close($query);// On ferme la requête préparé	
		close_database_connection($link);  // On se deconnecte de la BDD

		return $id_util;// On rend un entier ou NULL si on ne le trouve pas
    }

    function liste_filiere() //Requete pour recuperer tout les noms de fillière
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	if($query= mysqli_prepare ($link, 'SELECT id_fil, nom_fil FROM filiere'))//On prépare la requête
    	{
    		if(mysqli_stmt_execute($query))// On lance la requête
    		{
    			if(!mysqli_stmt_bind_result($query, $id_fil, $nom_fil))// On prépare les variables qui récupèrent le résultat
    			{
    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
    			}
    		}else
    		{
    			exit('Erreur lors de l\'execution de la commande SQL');
    		}	
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
				{
					$liste['id_fil'][] = $id_fil;
					$liste['nom_fil'][] = $nom_fil;
				}
			}else
			{
				$liste==NULL;
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé
		close_database_connection($link); // On se deconnecte de la BDD
		return $liste; // On rend un tableau nominal de tableau indicé

    }

    function liste_matiere() //Requete pour recuperer tout les noms de fillière
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	if($query= mysqli_prepare ($link, 'SELECT * FROM matiere'))//On prépare la requête
    	{
    		if(mysqli_stmt_execute($query))// On lance la requête
    		{
    			if(!mysqli_stmt_bind_result($query, $id_mat, $titre_mat))// On prépare les variables qui récupèrent le résultat
    			{
    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
    			}
    		}else
    		{
    			exit('Erreur lors de l\'execution de la commande SQL');
    		}	
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
				{
					echo $liste['id_mat'][] = $id_mat;
					 echo $liste['titre_mat'][] = $titre_mat;
				}
			}else
			{
				$liste==NULL;
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé
		close_database_connection($link); // On se deconnecte de la BDD
		return $liste; // On rend un tableau nominal de tableau indicé

    }

	function is_user($nom_util, $mot_de_passe) //Verifie si la personne est un Utilisateur  grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isuser = False ; //Initialisation du booleen qui accepte ou non le nom d'utilisateur et mot de passe
		$link = open_database_connection(); //Connexion a la base de données
		if($query= mysqli_prepare ($link, 'SELECT id_util FROM utilisateur WHERE nom_util=? AND mot_de_passe=?'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'ss', $nom_util, $mot_de_passe))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $id_util))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				$isuser = True; //La personne est un utilisateur
			}

    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

		mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé
		close_database_connection($link); // On se deconnecte de la BDD
		return $isuser; // On rend un BOOLEEN
	}

	function is_admin($nom_util, $mot_de_passe) //Verifie si l'utilisateur est un admin grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isadmin = False ; //Initialisation du booleen qui vérifie si l'utilisateur est un admin
		$link = open_database_connection(); //Connexion a la base de données
		if($query= mysqli_prepare ($link, 'SELECT id_util FROM utilisateur WHERE nom_util=? AND mot_de_passe=? AND admin=1'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'ss', $nom_util, $mot_de_passe))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $id_util))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				$isadmin = True; //La personne est un utilisateur
			}

    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

		mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé
		close_database_connection($link); // On se deconnecte de la BDD
		return $isadmin; // On rend un BOOLEEN
	}

	function is_ban($nom_util, $mot_de_passe) //Verifie si l'utilisateur est banni grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isban = False ; //Initialisation du booleen qui vérifie si l'utilisateur est banni
		$link = open_database_connection(); //Connexion a la base de données
		if($query= mysqli_prepare ($link, 'SELECT id_util FROM utilisateur WHERE nom_util=? AND mot_de_passe=? AND banni=1'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'ss', $nom_util, $mot_de_passe))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $id_util))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				$isban = True; //La personne est un utilisateur
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

		mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé
		close_database_connection($link); // On se deconnecte de la BDD
		return $isban; // On rend un BOOLEEN
	}

	//FAIRE DATE DE NAISSANCE VALIDE\\

	function sign_up($nom, $prenom, $date_naissance, $adresse, $email, $nom_univ, $id_fil, $nom_util, $mot_de_passe, $mot_de_passe_confime, $option_sport)  // Permet d'envoyer les données d'inscription a la Base de données
	{
		$link = open_database_connection();		//Connexion a la base de données
		$id = cherche_id($nom_util); //On verifie si le nom d'utilisateur existe déja

		if($mot_de_passe == $mot_de_passe_confime)
		{
			if($id == NULL)
			{
				if($query= mysqli_prepare ($link, 'INSERT INTO utilisateur (nom, prenom, date_naissance, adresse, email, nom_univ, id_fil, nom_util, mot_de_passe, option_sport) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'ssssssdssd', $nom, $prenom, $date_naissance, $adresse, $email, $nom_univ, $id_fil, $nom_util, $mot_de_passe, $option_sport))// On lie les variables d'entrer à la requête
			    	{
			    		if(!mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

		    	if(mysqli_stmt_store_result($query))
		    	{
		    		if(!mysqli_stmt_affected_rows($query)) //On verifie si la requete a bien ajouter une ligne
					{
						return "Erreur, l'inscription n'a pas abouti dans la base de données"; //La personne est un utilisateur
					}

		    	}else
		    	{
		    		exit('Erreur lors de la sauvegarde du resultat');
		    	}

		    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
				mysqli_stmt_close($query);// On ferme la requête préparé

				$id_util=cherche_id($nom_util);

				if($query= mysqli_prepare ($link, 'INSERT INTO a_un_score_de(id_util, id_mat) SELECT ? AS id_util, id_mat FROM matiere'))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'd', $id_util))// On lie les variables d'entrer à la requête
			    	{
			    		if(!mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

		    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
				mysqli_stmt_close($query);// On ferme la requête préparé

			}else
			{
				return "Erreur, nom d'utilisateur déjà présent";
			}
		}else
		{
			return "Erreur, mots de passe incohérent";
		}

		close_database_connection($link); // On se deconnecte de la BDD
	}

	/*VOIR http://beaussier.developpez.com/articles/php/mysql/blob/#LIII  POUR DE L'AIDE*/

	function transfert() //transfert des fichier image dans la BDD
	{
        $ret        = false;
        $img_blob   = '';
        $img_taille = 0;
        $img_type   = '';
        $img_nom    = '';
        $taille_max = 250000;
        $ret        = is_uploaded_file($_FILES['fic']['tmp_name']);
        
        if (!$ret) 
        {
            echo "Problème de transfert";
            return false;
        }else 
        {
            // Le fichier a bien été reçu
            $img_taille = $_FILES['fic']['size'];
            
            if ($img_taille > $taille_max)
            {
                echo "Trop gros !";
                return false;
            }

            $img_type = $_FILES['fic']['type'];
            $img_nom  = $_FILES['fic']['name'];

            $link = open_database_connection();
            $img_blob = file_get_contents ($_FILES['fic']['tmp_name']);
	        $req = 'INSERT INTO avatar (nom_img, taille_img, type_img, blob_img) VALUES ("'.$img_nom .'", "'.$img_taille.'", "'.$img_type.'", "'.addslashes ($img_blob).'")';
	        
	        mysqli_query ($link, $req);
	        close_database_connection($link);
	        return true;
        }
    }

    function prepare_test($nom_util, $id_mat) // récupère les id des questions auquel un utilisateur n'a pas répondu en fonction de l'id de la matière choisie
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$id_util = cherche_id($nom_util);
		 
		if($id_util != NULL)
		{
			if($query= mysqli_prepare ($link, 'SELECT id_q FROM question WHERE id_mat =? AND id_q NOT IN(SELECT question.id_q FROM question, a_repondue WHERE question.id_q=a_repondue.id_q AND id_util =? AND id_mat=?)'))//On prépare la requête
	    	{
	    		if(mysqli_stmt_bind_param($query, 'ddd', $id_mat, $id_util, $id_mat))// On lie les variables d'entrer à la requête
		    	{
		    		if(mysqli_stmt_execute($query))// On lance la requête
		    		{
		    			if(!mysqli_stmt_bind_result($query, $id_q))// On prépare les variables qui récupèrent le résultat
		    			{
		    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
		    			}
		    		}else
		    		{
		    			exit('Erreur lors de l\'execution de la commande SQL');
		    		}	
		    	}else
		    	{
		    		exit('Erreur lors du lien des variables à la commande SQL');
		    	}
	    	}else
	    	{
	    		exit('Erreur lors de la création la commande SQL');
	    	}

	    	if(mysqli_stmt_store_result($query))
	    	{
	    		if(mysqli_stmt_num_rows($query) >= 5) //On verifie si la requete a rendue quelque chose
				{
					while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
					{
						$liste[] = $id_q;
					}

				}else
				{
					return 'Nombre de question insuffisant pour faire un Test';
				}

	    	}else
	    	{
	    		exit('Erreur lors de la sauvegarde du resultat');
	    	}
		}else
		{
			exit('Nom d\'Utilisateur non reconnu');
		}	
		

		mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé

		$tab_alea=array_rand($liste, 5); //On selectionne parmis les questions trouvée 10 question au hasard

		foreach ($tab_alea as $cle) 
		{
			$question[]=$liste[$cle];
		}

		close_database_connection($link);  // On se deconnecte de la BDD

		return $question; // On rend un tableau indicé
    }

    function prepare_defi($nom_util, $id_mat) // récupère les id des questions auquel un utilisateur n'a pas répondu en fonction de la matière
    {
    	$link = open_database_connection(); //Connexion a la base de données

		$id_util = cherche_id($nom_util);
		 
		if($id_util != NULL)
		{
			if($query= mysqli_prepare ($link, 'SELECT question.id_q FROM question, a_repondue WHERE question.id_q=a_repondue.id_q AND id_util =? AND id_mat=?'))//On prépare la requête
	    	{
	    		if(mysqli_stmt_bind_param($query, 'ddd', $id_mat, $id_util, $id_mat))// On lie les variables d'entrer à la requête
		    	{
		    		if(mysqli_stmt_execute($query))// On lance la requête
		    		{
		    			if(!mysqli_stmt_bind_result($query, $id_q))// On prépare les variables qui récupèrent le résultat
		    			{
		    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
		    			}
		    		}else
		    		{
		    			exit('Erreur lors de l\'execution de la commande SQL');
		    		}	
		    	}else
		    	{
		    		exit('Erreur lors du lien des variables à la commande SQL');
		    	}
	    	}else
	    	{
	    		exit('Erreur lors de la création la commande SQL');
	    	}

	    	if(mysqli_stmt_store_result($query))
	    	{
	    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
				{
					while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
					{
						$question[] = $id_q;
					}

				}else
				{
					return 'Aucune question trouvée';
				}

	    	}else
	    	{
	    		exit('Erreur lors de la sauvegarde du resultat');
	    	}
		}else
		{
			exit('Nom d\'Utilisateur non reconnu');
		}

		mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé

		close_database_connection($link);  // On se deconnecte de la BDD

		return $question; // On rend le tableau indicé
    }

    function recup_1_description_question($id_q) // Transforme un id de question en un tableau d'énoncé des même questions en conservant son id
    {
		$link = open_database_connection(); //Connexion a la base de données

		if($query= mysqli_prepare ($link, 'SELECT id_q, description FROM question Q WHERE id_q=?'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $id_q, $description))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				mysqli_stmt_fetch($query); // On récupère le résultat dans un tableau
				$question['id_q'] = $id_q;
				$question['description'] = $description;
			}else
			{
				return 'Id_question Inconnu';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé

		close_database_connection($link);  // On se deconnecte de la BDD
			
	    return $question;// On rend un tableau nominal
    }

    function recup_description_question_multi($tab_id_q) // Transforme un tableau d'id de question en un tableau d'énoncés des même questions en conservant leurs id
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$ch=implode(', ',$tab_id_q);
		if($query= mysqli_prepare ($link, 'SELECT id_q, description FROM question Q WHERE Q.id_q IN ('.$ch.')'))//On prépare la requête
    	{
    		if(mysqli_stmt_execute($query))// On lance la requête
    		{
    			if(!mysqli_stmt_bind_result($query, $id_q, $description))// On prépare les variables qui récupèrent le résultat
    			{
    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
    			}
    		}else
    		{
    			exit('Erreur lors de l\'execution de la commande SQL');
    		}	
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
				{
					$question['id_q'][] = $id_q;
					$question['description'][] = $description;
				}

			}else
			{
				return 'Id_questions Inconnu';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}

    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
		mysqli_stmt_close($query);// On ferme la requête préparé

			close_database_connection($link);  // On se deconnecte de la BDD
			
	    	return $question;// On rend un tableau nominal de tableau indicé
    }

    function recup_1_rep($id_q)
    {
    	$reponse=NULL;

		if($id_q != NULL)
    	{
    		$link = open_database_connection(); //Connexion a la base de données

    		if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=1 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses vrai
	    	{
	    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
		    	{
		    		if(mysqli_stmt_execute($query))// On lance la requête
		    		{
		    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
		    			{
		    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
		    			}
		    		}else
		    		{
		    			exit('Erreur lors de l\'execution de la commande SQL');
		    		}	
		    	}else
		    	{
		    		exit('Erreur lors du lien des variables à la commande SQL');
		    	}
	    	}else
	    	{
	    		exit('Erreur lors de la création la commande SQL');
	    	}

	    	if(mysqli_stmt_store_result($query))
	    	{
	    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
				{
					$nb_rep=4-mysqli_stmt_num_rows($query); //si il y a des réponse vrai on calcule le nombre de réponse fausse qu'il faudrat ajouter
					while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
					{
						$reponse['id_q'][] = $id_q;
						$reponse['id_r'][] = $id_r;
						$reponse['description'][] = $description;
					}

					mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
					mysqli_stmt_close($query);// On ferme la requête préparé

					if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=0 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses fausse
			    	{
			    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
				    	{
				    		if(mysqli_stmt_execute($query))// On lance la requête
				    		{
				    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
				    			{
				    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
				    			}
				    		}else
				    		{
				    			exit('Erreur lors de l\'execution de la commande SQL');
				    		}	
				    	}else
				    	{
				    		exit('Erreur lors du lien des variables à la commande SQL');
				    	}
			    	}else
			    	{
			    		exit('Erreur lors de la création la commande SQL');
			    	}

			    	if(mysqli_stmt_store_result($query))
			    	{
			    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
						{
							$aux = array(); // On creer le tableau aux
							while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
							{
								$aux['id_q'][] = $id_q;
								$aux['id_r'][] = $id_r;
								$aux['description'][] = $description;
							}

							$tab_alea=array_rand($aux['id_r'], $nb_rep); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
							foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
							{
								$reponse['id_q'][] = $aux['id_q'][$cle];
								$reponse['id_r'][] = $aux['id_r'][$cle];
								$reponse['description'][] = $aux['description'][$cle];
							}

						}else
						{
							return 'Aucune réponse fausse trouvée';
						}
			    	}else
			    	{
			    		exit('Erreur lors de la sauvegarde du resultat');
			    	}

			    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
					mysqli_stmt_close($query);// On ferme la requête préparé
					
				}else //Sinon on récupère directement 4 réponse fausse en utilisant la meme méthode qu'en haut
				{
					if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=0 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses fausse
			    	{
			    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
				    	{
				    		if(mysqli_stmt_execute($query))// On lance la requête
				    		{
				    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
				    			{
				    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
				    			}
				    		}else
				    		{
				    			exit('Erreur lors de l\'execution de la commande SQL');
				    		}	
				    	}else
				    	{
				    		exit('Erreur lors du lien des variables à la commande SQL');
				    	}
			    	}else
			    	{
			    		exit('Erreur lors de la création la commande SQL');
			    	}

			    	if(mysqli_stmt_store_result($query))
			    	{
			    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
						{
							$aux = array(); // On creer le tableau aux
							while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
							{
								$aux['id_q'][] = $id_q;
								$aux['id_r'][] = $id_r;
								$aux['description'][] = $description;
							}

							$tab_alea=array_rand($aux['id_r'], 4); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
							foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
							{
								$reponse['id_q'][] = $aux['id_q'][$cle];
								$reponse['id_r'][] = $aux['id_r'][$cle];
								$reponse['description'][] = $aux['description'][$cle];
							}

						}else
						{
							return 'Aucune réponse fausse trouvée';
						}
			    	}else
			    	{
			    		exit('Erreur lors de la sauvegarde du resultat');
			    	}

			    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
					mysqli_stmt_close($query);// On ferme la requête préparé
				}
	    	}else
	    	{
	    		exit('Erreur lors de la sauvegarde du resultat');
	    	}

		}else
		{
			exit('id_q est NULL');
		}

		close_database_connection($link);  // On se deconnecte de la BDD
			
	    return $reponse;// On rend un tableau nominal de tableau indicé
    }

    function recup_rep_multi($tab_id_q)
    {
		if($tab_id_q != NULL)
    	{
    		$reponse=NULL;
    		$link = open_database_connection(); //Connexion a la base de données
			foreach($tab_id_q as $id_q) //Parcours du Tableau des id des questions
			{
				if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=1 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses vrai
		    	{
		    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
			    	{
			    		if(mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
			    			{
			    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
			    			}
			    		}else
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

		    	if(mysqli_stmt_store_result($query))
		    	{
		    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
					{
						$nb_rep=4-mysqli_stmt_num_rows($query); //si il y a des réponse vrai on calcule le nombre de réponse fausse qu'il faudrat ajouter
						while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
						{
							$reponse['id_q'][] = $id_q;
							$reponse['id_r'][] = $id_r;
							$reponse['description'][] = $description;
						}

						mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé

						if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=0 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses fausse
				    	{
				    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
					    	{
					    		if(mysqli_stmt_execute($query))// On lance la requête
					    		{
					    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
					    			{
					    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
					    			}
					    		}else
					    		{
					    			exit('Erreur lors de l\'execution de la commande SQL');
					    		}	
					    	}else
					    	{
					    		exit('Erreur lors du lien des variables à la commande SQL');
					    	}
				    	}else
				    	{
				    		exit('Erreur lors de la création la commande SQL');
				    	}

				    	if(mysqli_stmt_store_result($query))
				    	{
				    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
							{
								$aux = array(); // On creer le tableau aux
								while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
								{
									$aux['id_q'][] = $id_q;
									$aux['id_r'][] = $id_r;
									$aux['description'][] = $description;
								}

								$tab_alea=array_rand($aux['id_r'], $nb_rep); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
								foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
								{
									$reponse['id_q'][] = $aux['id_q'][$cle];
									$reponse['id_r'][] = $aux['id_r'][$cle];
									$reponse['description'][] = $aux['description'][$cle];
								}

							}else
							{
								return 'Aucune réponse fausse trouvée';
							}
				    	}else
				    	{
				    		exit('Erreur lors de la sauvegarde du resultat');
				    	}

				    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé
						
					}else //Sinon on récupère directement 4 réponse fausse en utilisant la meme méthode qu'en haut
					{
						if($query= mysqli_prepare ($link, 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q=? AND type_rep=0 AND R.id_r=RP.id_r'))//On prépare la requête pour récuperer les réponses fausse
				    	{
				    		if(mysqli_stmt_bind_param($query, 'd', $id_q))// On lie les variables d'entrer à la requête
					    	{
					    		if(mysqli_stmt_execute($query))// On lance la requête
					    		{
					    			if(!mysqli_stmt_bind_result($query, $id_q, $id_r, $description))// On prépare les variables qui récupèrent le résultat
					    			{
					    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
					    			}
					    		}else
					    		{
					    			exit('Erreur lors de l\'execution de la commande SQL');
					    		}	
					    	}else
					    	{
					    		exit('Erreur lors du lien des variables à la commande SQL');
					    	}
				    	}else
				    	{
				    		exit('Erreur lors de la création la commande SQL');
				    	}

				    	if(mysqli_stmt_store_result($query))
				    	{
				    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
							{
								$aux = array(); // On creer le tableau aux
								while(mysqli_stmt_fetch($query)) // On récupère le résultat de la requete dans le tableau final
								{
									$aux['id_q'][] = $id_q;
									$aux['id_r'][] = $id_r;
									$aux['description'][] = $description;
								}

								$tab_alea=array_rand($aux['id_r'], 4); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
								foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
								{
									$reponse['id_q'][] = $aux['id_q'][$cle];
									$reponse['id_r'][] = $aux['id_r'][$cle];
									$reponse['description'][] = $aux['description'][$cle];
								}

							}else
							{
								return 'Aucune réponse fausse trouvée';
							}
				    	}else
				    	{
				    		exit('Erreur lors de la sauvegarde du resultat');
				    	}

				    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé
					}
		    	}else
		    	{
		    		exit('Erreur lors de la sauvegarde du resultat');
		    	}
			}

			close_database_connection($link);  // On se deconnecte de la BDD
			
	    	return $reponse;// On rend un tableau nominal de tableau indicé
    	}else
	    {
	    	exit('Erreur le tableau d\'id est NULL');
	    }
    }
	
    function envoi_defi($nom_util_dem, $nom_util_rec, $id_q) //fonction pour enregistrer un envoi de défi dans la BDD
    {
    	$link = open_database_connection(); //Connexion a la base de données

    	if($nom_util_dem != $nom_util_rec)
    	{
    		$id_util_dem=cherche_id($nom_util_dem);
	    	$id_util_rec=cherche_id($nom_util_rec);

	    	if($query= mysqli_prepare ($link, 'SELECT * FROM demande_defi WHERE (id_dem =? AND id_rec =?) OR (id_dem =? AND id_rec =?) '))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'dddd', $id_util_dem, $id_util_rec, $id_util_rec, $id_util_dem))// On lie les variables d'entrer à la requête
			    	{
			    		if(mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			if(!mysqli_stmt_bind_result($query, $id_util1, $id_util2, $date, $id_que))// On prépare les variables qui récupèrent le résultat
			    			{
			    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
			    			}
			    		}else
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

		    	if(mysqli_stmt_store_result($query))
		    	{
		    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
					{
						return 'Erreur, demande de défi déjà existante';	
					}else
					{
						mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé

				    	if($query= mysqli_prepare ($link, 'INSERT INTO `demande_defi`(id_dem, id_rec, id_q) VALUES (?,?,?)'))//On prépare la requête
				    	{
				    		if(mysqli_stmt_bind_param($query, 'ddd', $id_util_dem, $id_util_rec, $id_q))// On lie les variables d'entrer à la requête
					    	{
					    		if(!mysqli_stmt_execute($query))// On lance la requête
					    		{
					    			exit('Erreur lors de l\'execution de la commande SQL');
					    		}	
					    	}else
					    	{
					    		exit('Erreur lors du lien des variables à la commande SQL');
					    	}
				    	}else
				    	{
				    		exit('Erreur lors de la création la commande SQL');
				    	}

					    if(mysqli_stmt_store_result($query))
				    	{
				    		if(!mysqli_stmt_affected_rows($query)) //On verifie si la requete a ajouter une ligne dans la BDD
							{
								return 'Envoi du défi échoué';
							}
				    	}else
				    	{
				    		exit('Erreur lors de la sauvegarde du resultat');
				    	}
					}
		    	}else
		    	{
		    		exit('Erreur lors de la sauvegarde du resultat');
		    	} 	
    	}else
	    {
	    	return 'Erreur, les nom d\'utilisateur son egaux';
	    }


		close_database_connection($link);  // On se deconnecte de la BDD
	    return 'Envoi du défi réussi';	    
    }

    function envoi_ami($nom_util_dem, $nom_util_rec)
    {
	    $link = open_database_connection(); //Connexion a la base de données

    	if($nom_util_dem != $nom_util_rec)
    	{
    		$id_util_dem=cherche_id($nom_util_dem);
	    	$id_util_rec=cherche_id($nom_util_rec);

	    	if($query= mysqli_prepare ($link, 'SELECT * FROM demande_ami WHERE (id_dem =? AND id_rec =?) OR (id_dem =? AND id_rec =?) '))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'dddd', $id_util_dem, $id_util_rec, $id_util_rec, $id_util_dem))// On lie les variables d'entrer à la requête
			    	{
			    		if(mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			if(!mysqli_stmt_bind_result($query, $id_util1, $id_util2, $date))// On prépare les variables qui récupèrent le résultat
			    			{
			    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
			    			}
			    		}else
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

		    	if(mysqli_stmt_store_result($query))
		    	{
		    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
					{
						return 'Erreur, demande d\'amie déjà existante';	
					}else
					{
						mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé

				    	if($query= mysqli_prepare ($link, 'INSERT INTO `demande_ami`(id_dem, id_rec) VALUES (?,?)'))//On prépare la requête
				    	{
				    		if(mysqli_stmt_bind_param($query, 'dd', $id_util_dem, $id_util_rec))// On lie les variables d'entrer à la requête
					    	{
					    		if(!mysqli_stmt_execute($query))// On lance la requête
					    		{
					    			exit('Erreur lors de l\'execution de la commande SQL');
					    		}	
					    	}else
					    	{
					    		exit('Erreur lors du lien des variables à la commande SQL');
					    	}
				    	}else
				    	{
				    		exit('Erreur lors de la création la commande SQL');
				    	}

					    if(mysqli_stmt_store_result($query))
				    	{
				    		if(!mysqli_stmt_affected_rows($query)) //On verifie si la requete a ajouter une ligne dans la BDD
							{
								return 'Envoi de la demande échoué';
							}
				    	}else
				    	{
				    		exit('Erreur lors de la sauvegarde du resultat');
				    	}
					}
		    	}else
		    	{
		    		exit('Erreur lors de la sauvegarde du resultat');
		    	} 	
    	}else
	    {
	    	return 'Erreur, les nom d\'utilisateur son egaux';
	    }

	    close_database_connection($link);  // On se deconnecte de la BDD
	    return 'Envoi de la demande réussi';
    }

    function supprimer_vielle_demande_ami() //Permet de supprimer les demandes d'ami vielle de 1 mois
    {
    	$link = open_database_admin_connection(); //Connexion a la base de données
    	if($query= mysqli_prepare ($link, 'DELETE FROM demande_ami WHERE DATEDIFF(NOW(), date_envoie) > 30'))//On prépare la requête
		    	{
			    		if(!mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}
		mysqli_stmt_close($query);// On ferme la requête préparé
    	close_database_connection($link);  // On se deconnecte de la BDD
    }

    function supprimer_vielle_demande_defi() //Permet de supprimer les demandes de défis vielle de 1 mois
    {
    	$link = open_database_admin_connection(); //Connexion a la base de données
    	if($query= mysqli_prepare ($link, 'DELETE FROM demande_defi WHERE DATEDIFF(NOW(), date_envoie) > 30'))//On prépare la requête
		    	{
			    		if(!mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}
		mysqli_stmt_close($query);// On ferme la requête préparé
    	close_database_connection($link);  // On se deconnecte de la BDD
    }

    function recup_demande_ami_recu($nom_util) //Récupère les demande d'ami que l'utilisateur a recu
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);
    
	    	if($query= mysqli_prepare ($link, 'SELECT * FROM demande_ami WHERE id_rec =?'))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'd', $id_util))// On lie les variables d'entrer à la requête
			    	{
			    		if(mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			if(!mysqli_stmt_bind_result($query, $id_dem, $id_rec, $date))// On prépare les variables qui récupèrent le résultat
			    			{
			    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
			    			}
			    		}else
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}

	    	if(mysqli_stmt_store_result($query))
	    	{
	    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
				{
						while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
						{
							$tab['id_dem'][] = $id_dem;
							$tab['id_rec'][] = $id_rec;
							$tab['date_envoie'][] =$date;
						}
						mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
						mysqli_stmt_close($query);// On ferme la requête préparé
    					close_database_connection($link);  // On se deconnecte de la BDD
						return $tab;
				}else
				{
					return 'Aucune demande d\'amie recu';
				}
	    	}else
	    	{
	    		exit('Erreur lors de la sauvegarde du resultat');
	    	}
    }

    function recup_demande_ami_envoyer($nom_util) //Récupère les demande d'ami que l'utilisateur a envoyé
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);
    
    	if($query= mysqli_prepare ($link, 'SELECT * FROM demande_ami WHERE id_dem =?'))//On prépare la requête
	    	{
	    		if(mysqli_stmt_bind_param($query, 'd', $id_util))// On lie les variables d'entrer à la requête
		    	{
		    		if(mysqli_stmt_execute($query))// On lance la requête
		    		{
		    			if(!mysqli_stmt_bind_result($query, $id_dem, $id_rec, $date))// On prépare les variables qui récupèrent le résultat
		    			{
		    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
		    			}
		    		}else
		    		{
		    			exit('Erreur lors de l\'execution de la commande SQL');
		    		}	
		    	}else
		    	{
		    		exit('Erreur lors du lien des variables à la commande SQL');
		    	}
	    	}else
	    	{
	    		exit('Erreur lors de la création la commande SQL');
	    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
					while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
					{
						$tab['id_dem'][] = $id_dem;
						$tab['id_rec'][] = $id_rec;
						$tab['date_envoie'][] =$date;
					}
					mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
					mysqli_stmt_close($query);// On ferme la requête préparé
    				close_database_connection($link);  // On se deconnecte de la BDD
					return $tab;
			}else
			{
				return 'Aucune demande d\'amie recu';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}
    }

    function accepte_ami($id_util_dem, $id_util_rec)
   {
   		$link = open_database_admin_connection(); //Connexion a la base de données

   		if($query= mysqli_prepare ($link, 'DELETE FROM demande_ami WHERE id_dem=? AND id_rec=?'))//On prépare la requête
	    	{
	    		if(mysqli_stmt_bind_param($query, 'dd', $id_util_dem, $id_util_rec))// On lie les variables d'entrer à la requête
		    	{
		    		if(!mysqli_stmt_execute($query))// On lance la requête
		    		{
		    			exit('Erreur lors de l\'execution de la commande SQL');
		    		}	
		    	}else
		    	{
		    		exit('Erreur lors du lien des variables à la commande SQL');
		    	}
	    	}else
	    	{
	    		exit('Erreur lors de la création la commande SQL');
	    	}


    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_affected_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				mysqli_stmt_close($query);// On ferme la requête préparé

				if($query= mysqli_prepare ($link, 'INSERT INTO liste_ami (id_ami1, id_ami2) VALUES (?,?),(?,?)'))//On prépare la requête
		    	{
		    		if(mysqli_stmt_bind_param($query, 'dddd', $id_util_dem, $id_util_rec, $id_util_rec, $id_util_dem))// On lie les variables d'entrer à la requête
			    	{
			    		if(!mysqli_stmt_execute($query))// On lance la requête
			    		{
			    			exit('Erreur lors de l\'execution de la commande SQL');
			    		}	
			    	}else
			    	{
			    		exit('Erreur lors du lien des variables à la commande SQL');
			    	}
		    	}else
		    	{
		    		exit('Erreur lors de la création la commande SQL');
		    	}
			}else
			{
				return 'Erreur, demande d\'amie inexistante';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}
    	mysqli_stmt_close($query);// On ferme la requête préparé
    	close_database_connection($link);  // On se deconnecte de la BDD
   }

   function recup_info_profil($nom_util) //rend un tableau des données personnel de l'utilisateur donné en entrer
   {
   		$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);

   		if($query= mysqli_prepare ($link, 'SELECT nom, prenom, date_naissance, adresse, email, nom_fil, nom_univ, nom_util, titre, niveau, option_sport, admin FROM utilisateur, filiere WHERE filiere.id_fil=utilisateur.id_fil AND id_util =?'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'd', $id_util))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $nom, $prenom, $date_naissance, $adresse, $email, $nom_fil, $nom_univ, $nom_util, $titre, $niveau, $option_sport, $admin))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				mysqli_stmt_fetch($query); // On récupère le résultat dans le tableau
				$tab['nom'] = $nom;
				$tab['prenom'] = $prenom;
				$tab['date_naissance'] = $date_naissance;
				$tab['adresse'] = $adresse;
				$tab['email'] =$email;
				$tab['nom_fil'] =$nom_fil;
				$tab['nom_univ'] =$nom_univ;
				$tab['nom_util'] =$nom_util;
				$tab['titre'] =$titre;
				$tab['niveau'] =$niveau;
				$tab['option_sport'] =$option_sport;
				$tab['admin'] =$admin;
				
			}else
			{
				return 'Utilisateur inconnu';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}
    	
    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
    	mysqli_stmt_close($query);// On ferme la requête préparé
    	close_database_connection($link);  // On se deconnecte de la BDD

    	return $tab;
   }

   function recup_note_profil($nom_util)//recupère les notes de l'utilisateur donné en entrer
   {
   		$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);

   		if($query= mysqli_prepare ($link, 'SELECT titre_mat, nb_point  FROM a_un_score_de, matiere WHERE a_un_score_de.id_mat=matiere.id_mat AND id_util =?'))//On prépare la requête
    	{
    		if(mysqli_stmt_bind_param($query, 'd', $id_util))// On lie les variables d'entrer à la requête
	    	{
	    		if(mysqli_stmt_execute($query))// On lance la requête
	    		{
	    			if(!mysqli_stmt_bind_result($query, $titre_mat, $nb_point))// On prépare les variables qui récupèrent le résultat
	    			{
	    				exit('Erreur lors du lien des variables au résultat de la commande SQL');
	    			}
	    		}else
	    		{
	    			exit('Erreur lors de l\'execution de la commande SQL');
	    		}	
	    	}else
	    	{
	    		exit('Erreur lors du lien des variables à la commande SQL');
	    	}
    	}else
    	{
    		exit('Erreur lors de la création la commande SQL');
    	}

    	if(mysqli_stmt_store_result($query))
    	{
    		if(mysqli_stmt_num_rows($query)) //On verifie si la requete a rendue quelque chose
			{
				while(mysqli_stmt_fetch($query)) // On récupère le résultat dans un tableau
					{
						$tab['titre_mat'][] = $titre_mat;
						$tab['nb_point'][] = $nb_point;
					}
				
			}else
			{
				return 'Aucune demande d\'amie recu';
			}
    	}else
    	{
    		exit('Erreur lors de la sauvegarde du resultat');
    	}
    	
    	mysqli_stmt_free_result($query);//On libère le résultat de la requête préparé
    	mysqli_stmt_close($query);// On ferme la requête préparé
    	close_database_connection($link);  // On se deconnecte de la BDD

    	return $tab;
   }

?>