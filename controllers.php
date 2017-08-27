<?php

    function acceuil_action($error)
    {         
        require 'view/Page_accueil_invite.php';    
    }

    function sign_in_action($error)
    {
        $liste=liste_filiere();        
        require 'view/Page_Inscription.php';
        if(!empty($_POST['username']))
		{
			$link = open_database_connection();
			$nom=$_POST['last_name'];
			$prenom=$_POST['first_name'];
			$email=$_POST['email'];
			$nom_util=$_POST['username'];
			$mot_de_passe=mysqli_real_escape_string($link, htmlspecialchars($_POST['password']));
			$mot_de_passe_confime=mysqli_real_escape_string($link, htmlspecialchars($_POST['password_confirmation']));
			$nom_fil=$_POST['nom_fil'];
			$option_sport= empty($_POST['Option_Sport']) ? 0 : 1;
			$nom_univ=$_POST['university'];
			$error="";

			if($nom_fil != "")
			{
				if(!empty($nom) && !empty($prenom) && !empty($email) && !empty($nom_util) && !empty($mot_de_passe) && !empty($mot_de_passe_confime) && !empty($nom_fil) && !empty($nom_univ))
				{
					$error = sign_up($nom, $prenom, $email, $nom_util, $mot_de_passe, $mot_de_passe_confime, $nom_fil, $option_sport, $nom_univ, $error);
					if($error == "")
					{
						echo "Vous avez bien été inscit, vous allez être rediriger vers la page d'accueil dans 5 secondes"; // NE S'AFFICHE PAS
						header('refresh:5 url=/Serious_Game/index.php');
  						exit();
					}
				}else
				{
					$error="Formulaire Incomplet";
				}
			}else
			{
				$error="Fillière non selectionner";
			}
			

			if($error != "")
			{
				echo $error;
			}
			
		}
    }

    function login_action($error)
    {         
         require 'view/Page_Login.php';
    }

    function FAQ_action($error)
    {         
       require 'view/FAQ.php';   
    }        

    function acceuil_util_action($login, $error)   
    {                  
    	require 'view/Page_Accueil_Utilisateur.php';   
    }

    function acceuil_admin_action($login, $error)   
    {                
    	require 'view/Page_Admin.php';   
    }     
    
?>
