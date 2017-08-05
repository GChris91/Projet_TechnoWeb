<?php

	function open_database_connection() //Permet de se connecter avec la Base de données
	{
		$link = mysqli_connect('localhost', 'root', '', 'bdd_serious_game')or die("Impossible de se connecter : " . mysql_error());
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

	function transfert()
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