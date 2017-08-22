<?php
	
	function open_database_connection() //Permet de se connecter avec la Base de données
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
    	$query= 'SELECT id_util FROM utilisateur WHERE nom_util="'.$nom_util.'"';//Requete pour récupérer l'id utilisateur a partir du nom d'utilisateur

    	$id_util = NULL;

    	if($result = mysqli_query($link, $query ))// On lance la requete
		{
			$res = mysqli_fetch_assoc($result);// On récupère le résultat dans un tableau
			$id_util = $res['id_util'];
		}

		close_database_connection($link);  // On se deconnecte de la BDD

		return $id_util;// On rend un entier ou NULL si on ne le trouve pas
    }

    function liste_filiere() //Requete pour recuperer tout les noms de fillière
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$query= 'SELECT nom_fil FROM filiere';//Requete pour récupérer tout  les noms de fillière
    	$result = mysqli_query($link, $query ); // On lance la requete
		if(mysqli_num_rows($result)) //On verifie si la requete a rendue quelque chose
		{
			while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans un tableau
			{
			$liste[] = $val['nom_fil'];
			}
		}
		mysqli_free_result( $result ); // On libère la variable result
		close_database_connection($link); // On se deconnecte de la BDD
		return $liste; // On rend un tableau indicé

    }

	function is_user( $nom_util, $mot_de_passe ) //Verifie si la personne est un Utilisateur  grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isuser = False ; //Initialisation du booleen qui accepte ou non le nom d'utilisateur et mot de passe
		$link = open_database_connection(); //Connexion a la base de données
		$query= 'SELECT nom_util FROM utilisateur WHERE nom_util="'.$nom_util.'" and mot_de_passe="'.$mot_de_passe.'"';//Requete pour verifier le nom d'utilisateur et le mot de passe
		$result = mysqli_query($link, $query ); // On lance la requete
		if(mysqli_num_rows($result)) //On verifie si la requete a rendue quelque chose
		{
			$isuser = True; //La personne est un utilisateur
		}
		mysqli_free_result( $result ); // On libère la variable result
		close_database_connection($link); // On se deconnecte de la BDD
		return $isuser; // On rend un BOOLEEN
	}

	function is_admin( $nom_util, $mot_de_passe ) //Verifie si l'utilisateur est un admin grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isadmin = False ; //Initialisation du booleen qui accepte ou non le nom d'utilisateur et mot de passe
		$link = open_database_connection(); //Connexion a la base de données
		$query= 'SELECT nom_util FROM utilisateur WHERE nom_util="'.$nom_util.'" and mot_de_passe="'.$mot_de_passe.'" and admin=1'; //Requete pout verifier le nom d'utilisateur et le mot de passe et le booleen de l'admin
		$result = mysqli_query($link, $query ); // On lance la requete
		if(mysqli_num_rows($result)) //On verifie si la requete a rendue quelque chose
		{
			$isadmin = True; // L'utilisateur est un admin 
		}
		mysqli_free_result( $result ); // On libère la variable result
		close_database_connection($link); // On se deconnecte de la BDD
		return $isadmin; // On rend un BOOLEEN
	}

	function is_ban( $nom_util, $mot_de_passe ) //Verifie si l'utilisateur est un admin grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isadmin = False ; //Initialisation du booleen qui accepte ou non le nom d'utilisateur et mot de passe
		$link = open_database_connection(); //Connexion a la base de données
		$query= 'SELECT nom_util FROM utilisateur WHERE nom_util="'.$nom_util.'" and mot_de_passe="'.$mot_de_passe.'" and banni=1'; //Requete pout verifier le nom d'utilisateur et le mot de passe et si l'utilisateur est banni
		$result = mysqli_query($link, $query ); // On lance la requete
		if(mysqli_num_rows($result)) //On verifie si la requete a rendue quelque chose
		{
			$isadmin = True; // L'utilisateur est banni
		}
		mysqli_free_result( $result ); // On libère la variable result
		close_database_connection($link); // On se deconnecte de la BDD
		return $isadmin; // On rend un BOOLEEN
	}

	function sign_up($nom, $prenom, $email, $nom_util, $mot_de_passe, $mot_de_passe_confime, $nom_fil, $option_sport, $nom_univ )  // Permet d'envoyer les données d'inscription a la Base de données
	{
		$link = open_database_connection();		//Connexion a la base de données
		$id = cherche_id($nom_util); //On verifie si le nom d'utilisateur existe déja

		if($mot_de_passe == $mot_de_passe_confime)
		{
			if($id == NULL)
			{
				$link = open_database_connection();		//Connexion a la base de données
				$query = 'SELECT id_fil FROM filiere WHERE nom_fil="'.$nom_fil.'"'; //Requete pour rechercher l'id de la fillière correspondant au nom de la filière
				$result = mysqli_query($link, $query );		//On lance la requete
				if(mysqli_num_rows($result))	//On verifie si la requete a foncionner
				{
					$id_filliere = mysqli_fetch_assoc($result);	//On recupère le résultat 
					$id_fil = (int) $id_filliere["id_fil"];	//On convertit le résultat en entier

				}
				mysqli_free_result($result); // On libère la variable result
				$query = 'INSERT INTO utilisateur (nom, prenom, email, nom_util, mot_de_passe, id_fil, option_sport, nom_univ) VALUES ("'.$nom.'", "'.$prenom.'", "'.$email.'", "'.$nom_util.'", "'.$mot_de_passe.'", '.$id_fil.', '.$option_sport.', "'.$nom_univ.'")'; //Requete pour ajouter les informations du nouvelle utilisateur a la BDD
				mysqli_query($link, $query ); //On lance la requete

				$id_util=cherche_id($nom_util);
				$query = 'INSERT INTO a_un_score_de(id_util, id_mat) SELECT '.$id_util.' AS id_util, id_mat FROM matiere';//Requete pour initialiser les scores de l'utilisateur a 0
				mysqli_query($link, $query ); //On lance la requete
			}else
			{
				echo "Erreur, nom d'utilisateur déjà présent";
			}
		}else
		{
			echo"Erreur, mots_de pase incohérent";
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

    function prepare_test($nom_util, $mot_de_passe, $nom_mat) // récupère les id des questions auquel un utilisateur n'a pas répondu en fonction de la matière
    {
    	$link = open_database_connection(); //Connexion a la base de données

		$query= 'SELECT question.id_q FROM question, matiere WHERE matiere.id_mat =question.id_mat AND titre_mat = "'.$nom_mat.'" AND question.id_q NOT IN(SELECT question.id_q FROM question, matiere, a_repondue, utilisateur WHERE matiere.id_mat=question.id_mat AND question.id_q=a_repondue.id_q AND utilisateur.id_util =a_repondue.id_util AND titre_mat="'.$nom_mat.'" AND utilisateur.nom_util="'.$nom_util.'" AND utilisateur.mot_de_passe="'.$mot_de_passe.'") LIMIT 10'; // Requete pour recuperer les question dans une matiere auquel l'utilisateur n'a jamais repondu
		 
		if($result = mysqli_query($link, $query ))// On lance la requete
		{
			while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans un tableau
			{
			$question[] = $val['id_q'];
			}
		}

		mysqli_free_result($result); // On libère la variable result

		close_database_connection($link);  // On se deconnecte de la BDD

		return $question; // On rend un tableau indicé
    }

    function prepare_defi($nom_util, $mot_de_passe, $nom_mat) // récupère les id des questions auquel un utilisateur n'a pas répondu en fonction de la matière
    {
    	$link = open_database_connection(); //Connexion a la base de données

		$query= 'SELECT question.id_q FROM question, matiere, a_repondue, utilisateur WHERE matiere.id_mat=question.id_mat AND question.id_q=a_repondue.id_q AND utilisateur.id_util =a_repondue.id_util AND titre_mat="'.$nom_mat.'" AND utilisateur.nom_util="'.$nom_util.'" AND utilisateur.mot_de_passe="'.$mot_de_passe.'"'; // Requete pour recuperer les question dans une matiere auquel l'utilisateur a deja repondu
		 
		if($result = mysqli_query($link, $query ))// On lance la requete
		{
			while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans un tableau
			{
			$question[] = $val['id_q'];
			}
		}


		mysqli_free_result($result); // On libère la variable result

		close_database_connection($link);  // On se deconnecte de la BDD

		return $question; // On rend le tableau indicé
    }

    function recup_1_description_question($id_q)
    {
    	if($id_q != NULL && $id_q != 0)
    	{
    		$link = open_database_connection(); //Connexion a la base de données
	    	$query= 'SELECT id_q, description FROM question Q WHERE id_q='.id_q.'';
	    	if($result = mysqli_query($link, $query ))// On lance la requete
				{
					$val = mysqli_fetch_assoc($result); // On récupère le résultat dans un tableau
					$question['id_q'] = $val['id_q'];
					$question['description'] = $val['description'];
					mysqli_free_result($result); // On libère la variable result
				}

				close_database_connection($link);  // On se deconnecte de la BDD
				
		    	return $question;// On rend un tableau nominal
    	}
    }

    function recup_description_question_multi($tab_id_q) // Transforme un tableau d'id de question en un tableau d'énoncé des même questions en conservant leurs id
    {
    	if($tab_id_q != NULL)
    	{
    		$link = open_database_connection(); //Connexion a la base de données
	    	$query= 'SELECT id_q, description FROM question Q WHERE Q.id_q IN ('.implode(',',$tab_id_q).')'; //requete pour récuperer la description des questions implode permet de transformer un tableau en une table utilisable dans les requêtes SQL
	    	if($result = mysqli_query($link, $query ))// On lance la requete
			{
				while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans un tableau
				{
				$question['id_q'][] = $val['id_q'];
				$question['description'][] = $val['description'];
				}
				mysqli_free_result($result); // On libère la variable result
			}

			close_database_connection($link);  // On se deconnecte de la BDD
			
	    	return $question;// On rend un tableau nominal de tableau indicé
    	}
    }

    function recup_1_rep($id_q)
    {
		if($id_q != NULL)
    	{
    		$reponse=NULL;
    		$link = open_database_connection(); //Connexion a la base de données

			$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id_q.' AND type_rep=1 AND R.id_r=RP.id_r'; //Requête pour récupérer la ou les réponses vrai de la question 
			if($result = mysqli_query($link, $query ))// On lance la requete
			{
				$nb_rep=4-mysqli_num_rows($result); //si il y a des réponse vrai on calcule le nombre de réponse fausse qu'il faudrat ajouter
				while($val = mysqli_fetch_assoc($result)) // On récupère le résultat de la requete dans le tableau final
				{
				$reponse['id_q'][] = $val['id_q'];
				$reponse['id_r'][] = $val['id_r'];
				$reponse['description'][] = $val['description'];
				}
				mysqli_free_result($result); // On libère la variable result

				$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
				if($result = mysqli_query($link, $query ))// On lance la requete
				{
					$aux = array(); // On creer ou vide le tableau aux
					while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
					{
						$aux['id_q'][] = $val['id_q'];
						$aux['id_r'][] = $val['id_r'];
						$aux['description'][] = $val['description'];
					}

					mysqli_free_result($result); // On libère la variable result

					if(isset($aux['id_q']))
					{
						$tab_alea=array_rand($aux['id_r'], $nb_rep); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
						foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
						{
							$reponse['id_q'][] = $aux['id_q'][$cle];
							$reponse['id_r'][] = $aux['id_r'][$cle];
							$reponse['description'][] = $aux['description'][$cle];
						}
					}
				}

			}else //Sinon on récupère directement 4 réponse fausse en utilisant la meme méthode qu'en haut
			{
				$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
				if($result = mysqli_query($link, $query ))// On lance la requete
				if($result = mysqli_query($link, $query ))// On lance la requete
				{
					$aux = array(); // On creer ou vide le tableau aux
					while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
					{
						$aux['id_q'][] = $val['id_q'];
						$aux['id_r'][] = $val['id_r'];
						$aux['description'][] = $val['description'];
					}

					mysqli_free_result($result); // On libère la variable result

					if(isset($aux['id_q']))
					{
						$tab_alea=array_rand($aux['id_r'], 4); //On selectionne 4 réponses parmis les réponses fausse 
						foreach($tab_alea as $cle)//On remplis le tableau final avec les réponses fausses
						{
							$reponse['id_q'][] = $aux['id_q'][$cle];
							$reponse['id_r'][] = $aux['id_r'][$cle];
							$reponse['description'][] = $aux['description'][$cle];
						}
					}
				}
			}

			close_database_connection($link);  // On se deconnecte de la BDD
			
	    	return $reponse;// On rend un tableau nominal de tableau indicé
    	}
    }

    function recup_rep_multi($tab_id_q)
    {
		if($tab_id_q != NULL)
    	{
    		$reponse=NULL;
    		$link = open_database_connection(); //Connexion a la base de données
			foreach($tab_id_q as $id) //Parcours du Tableau des id des questions
			{
				$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=1 AND R.id_r=RP.id_r'; //Requête pour récupérer la ou les réponses vrai de la question 
				if($result = mysqli_query($link, $query ))// On lance la requete
				{
					$nb_rep=4-mysqli_num_rows($result); //si il y a des réponse vrai on calcule le nombre de réponse fausse qu'il faudrat ajouter
					while($val = mysqli_fetch_assoc($result)) // On récupère le résultat de la requete dans le tableau final
					{
					$reponse['id_q'][] = $val['id_q'];
					$reponse['id_r'][] = $val['id_r'];
					$reponse['description'][] = $val['description'];
					}
					mysqli_free_result($result); // On libère la variable result

					$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
					if($result = mysqli_query($link, $query ))// On lance la requete
					{
						$aux = array(); // On creer ou vide le tableau aux
						while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
						{
							$aux['id_q'][] = $val['id_q'];
							$aux['id_r'][] = $val['id_r'];
							$aux['description'][] = $val['description'];
						}

						mysqli_free_result($result); // On libère la variable result

						if(isset($aux['id_q']))
						{
							$tab_alea=array_rand($aux['id_r'], $nb_rep); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
							foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
							{
								$reponse['id_q'][] = $aux['id_q'][$cle];
								$reponse['id_r'][] = $aux['id_r'][$cle];
								$reponse['description'][] = $aux['description'][$cle];
							}
						}
					}

				}else //Sinon on récupère directement 4 réponse fausse en utilisant la meme méthode qu'en haut
				{
					$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
					if($result = mysqli_query($link, $query ))// On lance la requete
					if($result = mysqli_query($link, $query ))// On lance la requete
					{
						$aux = array(); // On creer ou vide le tableau aux
						while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
						{
							$aux['id_q'][] = $val['id_q'];
							$aux['id_r'][] = $val['id_r'];
							$aux['description'][] = $val['description'];
						}

						mysqli_free_result($result); // On libère la variable result

						if(isset($aux['id_q']))
						{
							$tab_alea=array_rand($aux['id_r'], 4); //On selectionne 4 réponses parmis les réponses fausse 
							foreach($tab_alea as $cle)//On remplis le tableau final avec les réponses fausses
							{
								$reponse['id_q'][] = $aux['id_q'][$cle];
								$reponse['id_r'][] = $aux['id_r'][$cle];
								$reponse['description'][] = $aux['description'][$cle];
							}
						}
					}
				}
				
			}

			close_database_connection($link);  // On se deconnecte de la BDD
			
	    	return $reponse;// On rend un tableau nominal de tableau indicé
    	}
    }
	
	function verif_rep($id_q, $tab_rep) //PAS FINI\\
    {
    	$link = open_database_connection(); //Connexion a la base de données
    }

    function envoi_defi($nom_util_dem, $nom_util_rec, $id_q)
    {
    	$link = open_database_connection(); //Connexion a la base de données

    	if($nom_util_dem != $nom_util_rec)
    	{
    		$id_util_dem=cherche_id($nom_util_dem);
	    	$id_util_rec=cherche_id($nom_util_rec);

	    	$query1= 'SELECT * FROM demande_defi WHERE id_dem = '.$id_util_dem.' AND id_rec = '.$id_util_rec.'';
	    	$result1=mysqli_query($link, $query1);
	    	$query2= 'SELECT * FROM demande_defi WHERE id_dem = '.$id_util_rec.' AND id_rec = '.$id_util_dem.'';
	    	$result2=mysqli_query($link, $query2);

	    	if(!mysqli_num_rows($result1) && !mysqli_num_rows($result2))
	    	{
	    		$query= 'INSERT INTO `demande_defi`(id_dem, id_rec, id_q) VALUES ('.$id_util_dem.','.$id_util_rec.','.$id_q.')';
	    		mysqli_query($link, $query);
	    	}else
	    	{
	    		echo 'Erreur, demande de défi déjà existante';
	    	}

	    	
    	}else
	    {
	    	echo 'Erreur, les nom d\'utilisateur son egaux';
	    }

    	close_database_connection($link);  // On se deconnecte de la BDD
    }

    function envoi_ami($nom_util_dem, $nom_util_rec)
    {
    	$link = open_database_connection(); //Connexion a la base de données

    	if($nom_util_dem != $nom_util_rec)
    	{
	    	$id_util_dem=cherche_id($nom_util_dem);
	    	$id_util_rec=cherche_id($nom_util_rec);
	    	$query1= 'SELECT * FROM demande_ami WHERE id_dem = '.$id_util_dem.' AND id_rec = '.$id_util_rec.'';
	    	$result1=mysqli_query($link, $query1);
	    	$query2= 'SELECT * FROM demande_ami WHERE id_dem = '.$id_util_rec.' AND id_rec = '.$id_util_dem.'';
	    	$result2=mysqli_query($link, $query2);
	    	if(!mysqli_num_rows($result1) && !mysqli_num_rows($result2))
	    	{
	    		$query= 'INSERT INTO `demande_ami`(id_dem, id_rec) VALUES ('.$id_util_dem.','.$id_util_rec.')';
	    		mysqli_query($link, $query);
	    	}else
	    	{
	    		echo 'Erreur, demande d\'amie déjà existante';
	    	}
	    }else
	    {
	    	echo 'Erreur, les nom d\'utilisateur son egaux';
	    }

	    close_database_connection($link);  // On se deconnecte de la BDD
    }

    function supprimer_vielle_demande_ami()
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$query='DELETE FROM demande_ami WHERE DATEDIFF(NOW(), date_envoie) > 30';
    	mysqli_query($link, $query);
    	close_database_connection($link);  // On se deconnecte de la BDD
    }

    function supprimer_vielle_demande_defi()
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$query='DELETE FROM demande_defi WHERE DATEDIFF(NOW(), date_envoie) > 30';
    	mysqli_query($link, $query);
    	close_database_connection($link);  // On se deconnecte de la BDD
    }

    function recup_demande_ami_recu($nom_util) //Récupère les demande d'ami que l'utilisateur a recu
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);
    	$query= 'SELECT * FROM demande_ami WHERE id_rec = '.$id_util.'';
    	$result= mysqli_query($link, $query);
    	while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
		{
			$aux['id_dem'][] = $val['id_dem'];
			$aux['id_rec'][] = $val['id_rec'];
			$aux['date_envoie'][] = $val['date_envoie'];
		}
		mysqli_free_result($result); // On libère la variable result
    }

    function recup_demande_ami_envoyer($nom_util) //Récupère les demande d'ami que l'utilisateur a envoyé
    {
    	$link = open_database_connection(); //Connexion a la base de données
    	$id_util=cherche_id($nom_util);
    	$query= 'SELECT * FROM demande_ami WHERE id_dem = '.$id_util.'';
    	$result= mysqli_query($link, $query);
    	while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans le tableau aux
		{
			$aux['id_dem'][] = $val['id_dem'];
			$aux['id_rec'][] = $val['id_rec'];
			$aux['date_envoie'][] = $val['date_envoie'];
		}
		mysqli_free_result($result); // On libère la variable result

    }

    function accepte_ami($id_util_dem, $id_util_rec)
   {
   		$link = open_database_connection(); //Connexion a la base de données



   }

?>