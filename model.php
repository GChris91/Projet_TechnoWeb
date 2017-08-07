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

	function is_user( $nom_util, $mot_de_passe ) //Verifie si la personne est un Utilisateur  grace a son Nom d'Utilisateur et son Mot de Passe
	{
		$isuser = False ; //Initialisation du booleen qui accepte ou non le nom d'utilisateur et mot de passe
		$link = open_database_connection(); //Connexion a la base de données
		$query= 'SELECT nom_util FROM utilisateur WHERE nom_util="'.$nom_util.'" and mot_de_passe="'.$mot_de_passe.'"';//Requete pout verifier le nom d'utilisateur et le mot de passe
		$result = mysqli_query($link, $query ); // On lance la requete
		if(mysqli_num_rows($result)) //On verifie si la requete a rendue quelque chose
		{
			$isuser = True; //La personne est un utilisateur
		}
		mysqli_free_result( $result ); // On libère la variable result
		close_database_connection($link); // On se deconnecte de la BDD
		return $isuser; // On rend le résultatS
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
		return $isadmin; // On rend le résultat
	}

	function sign_up($nom, $prenom, $email, $nom_util, $mot_de_passe, $nom_fil)  // Permet d'envoyer les données d'inscription a la Base de données
	{
		$link = open_database_connection();		//Connexion a la base de données
		$query = 'SELECT id_fil FROM filiere WHERE nom_fil="'.$nom_fil.'"'; //Requete pour rechercher l'id de la fillière correspondant au nom de la filière
		$result = mysqli_query($link, $query );		//On lance la requete
		if(mysqli_num_rows($result))	//On verifie si la requete a foncionner
		{
			$id_fillière = mysqli_fetch_assoc($result);	//On recupère le résultat 
			$id_fil = (int) $id_fillière["id_fil"];	//On convertit le résultat en entier

		}
		mysqli_free_result($result); // On libère la variable result
		$query = 'INSERT INTO utilisateur (nom, prenom, email, nom_util, mot_de_passe, id_fil) VALUES ("'.$nom.'", "'.$prenom.'", "'.$email.'", "'.$nom_util.'", "'.$mot_de_passe.'", "'.$id_fil.'")'; //Requete pour ajouter les informations du nouvelle utilisateur a la BDD
		mysqli_query($link, $query ); //On lance la requete
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

		$query= 'SELECT question.id_q FROM question, matiere WHERE matiere.id_mat =question.id_mat AND titre_mat = "'.$nom_mat.'" AND question.id_q NOT IN(SELECT question.id_q FROM question, matiere, a_repondue, utilisateur WHERE matiere.id_mat=question.id_mat AND question.id_q=a_repondue.id_q AND utilisateur.id_util =a_repondue.id_util AND titre_mat="'.$nom_mat.'" AND utilisateur.nom_util="'.$nom_util.'" AND utilisateur.mot_de_passe="'.$mot_de_passe.'")'; // Requete pour recuperer les question dans une matiere auquel l'utilisateur n'a jamais repondu
		 
		if($result = mysqli_query($link, $query ))// On lance la requete
		{
			while($val = mysqli_fetch_assoc($result)) // On récupère le résultat dans un tableau
			{
			$question[] = $val['id_q'];
			}
		}


		mysqli_free_result($result); // On libère la variable result

		close_database_connection($link);  // On se deconnecte de la BDD

		return $question; // On rend le tableau
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

		return $question; // On rend le tableau
    }

    function affiche_Qs($result) // Transforme un tableau d'id de question en un tableau d'énoncé des même questions en conservant leurs id
    {
    	if($result != NULL)
    	{
    		$link = open_database_connection(); //Connexion a la base de données
	    	$query= 'SELECT id_q, description FROM question Q WHERE Q.id_q IN ('.implode(',',$result).')'; //requete pour récuperer la description des questions implode permet de transformer un tableau en une table utilisable dans les requêtes SQL
	    	if($res = mysqli_query($link, $query ))// On lance la requete
			{
				while($val = mysqli_fetch_assoc($res)) // On récupère le résultat dans un tableau
				{
				$question['id_q'][] = $val['id_q'];
				$question['description'][] = $val['description'];
				}
				mysqli_free_result($res); // On libère la variable result
			}
			
	    	return $question;// On rend le tableau
    	}
    }
	//array_rand
    function recup_rep($result)
    {
		if($result != NULL)
    	{
    		$reponse=NULL;
    		$link = open_database_connection(); //Connexion a la base de données
			foreach($result as $id) //Parcours du Tableau des id des questions
			{
				$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=1 AND R.id_r=RP.id_r'; //Requête pour récupérer la ou les réponses vrai de la question 
				if($res = mysqli_query($link, $query ))// On lance la requete
				{
					$nb_rep=4-mysqli_num_rows($res); //si il y a des réponse vrai on calcule le nombre de réponse fausse qu'il faudrat ajouter
					while($val = mysqli_fetch_assoc($res)) // On récupère le résultat dans le tableau final
					{
					$reponse['id_q'][] = $val['id_q'];
					$reponse['id_r'][] = $val['id_r'];
					$reponse['description'][] = $val['description'];
					}
					mysqli_free_result($res); // On libère la variable result

					$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
					if($res = mysqli_query($link, $query ))// On lance la requete
					{
						$aux = array(); // On creer ou vide le tableau aux
						while($val = mysqli_fetch_assoc($res)) // On récupère le résultat dans le tableau aux
						{
							$aux['id_q'][] = $val['id_q'];
							$aux['id_r'][] = $val['id_r'];
							$aux['description'][] = $val['description'];
						}
						mysqli_free_result($res); // On libère la variable result
						$tab_alea=array_rand($aux['id_r'], $nb_rep); //On selectionne parmis les réponses fausse le nombre calculer plus tot $nb_rep 
						foreach($tab_alea as $cle) //On remplis le tableau final avec les réponses fausses
						{
							$reponse['id_q'][] = $aux['id_q'][$cle];
							$reponse['id_r'][] = $aux['id_r'][$cle];
							$reponse['description'][] = $aux['description'][$cle];
						}
					}

				}else //Sinon on récupère directement 4 réponse fausse en utilisant la meme méthode qu'en haut
				{
					$query= 'SELECT id_q, R.id_r,description FROM reponse R,reponse_possible RP WHERE id_q='.$id.' AND type_rep=0 AND R.id_r=RP.id_r'; //Requête pour récupérer les réponses fausses de la question 
					if($res = mysqli_query($link, $query ))// On lance la requete
					if($res = mysqli_query($link, $query ))// On lance la requete
					{
						$aux = array(); // On creer ou vide le tableau aux
						while($val = mysqli_fetch_assoc($res)) // On récupère le résultat dans le tableau aux
						{
							$aux['id_q'][] = $val['id_q'];
							$aux['id_r'][] = $val['id_r'];
							$aux['description'][] = $val['description'];
						}
						mysqli_free_result($res); // On libère la variable result
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
			
	    	return $reponse;// On rend le tableau
    	}
    }