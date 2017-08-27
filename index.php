<?php
   
   require_once 'model.php';     
   require_once 'controllers.php';

   session_start();

   $error="";

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

   if('/Serious_Game/' == $uri)
   {
        $uri='/Serious_Game/index.php';
   }

     if(!isset($_SESSION['nom_util']))                                      //ON VERIFIE SI L'UTILISATEUR EST CONNECTER
     {            
     	if(!isset($_POST['nom_util']) || !isset($_POST['mot_de_passe'])) 
     	{               
     		$error='Non Connecter';
     		if('/Serious_Game/index.php' == $uri)   //SI L'UTILISATEUR N'EST PAS CONNECTER IL N'A ACCES QUE A CES PAGES (Il)
		    {
		       Acceuil_action($error); 

		    }elseif ('/Serious_Game/index.php/Page_Inscription.php' == $uri)
		    {
		       sign_in_action($error);

	        }elseif ('/Serious_Game/index.php/Page_Login.php' == $uri)
	        {
	           login_action($error);

	        }elseif('/Serious_Game/index.php/FAQ' == $uri)
	        {
	           FAQ_action($error);
	        }else
	        {
	        	echo "ERROR 404";
	        } 

     	}elseif(!is_user($_POST['nom_util'],$_POST['mot_de_passe']))  // ON VERIFIE SI LES DONNEES LOGIN SONT BONNES
     	{     
     		echo $error='Nom d\'utilisateur ou mot de passe incorrect';        
     		header('refresh:2 url=/Serious_Game/index.php/Page_Login.php');
  			exit();

     	}elseif(is_admin($_POST['nom_util'],$_POST['mot_de_passe'])) // ON SE CONNECTE EN TANT QU'ADMIN
     	{
     		$_SESSION['nom_util'] = $_POST['nom_util'];             
     		$login = $_SESSION['nom_util']; 
     		header('Location: /Serious_Game/index.php/Page_Admin.php');
  			exit();
     		

     	}elseif(is_ban($_POST['nom_util'],$_POST['mot_de_passe'])) //ON EST BANNI
     	{
     		echo $error='Votre Compte a été banni pour une durée indéterminé';
     	}else 													// ON SE CONNECTE EN TANT QU'UTILISATEUR
     	{
     		$_SESSION['nom_util'] = $_POST['nom_util'];             
     		$login = $_SESSION['nom_util']; 
     		header('Location: /Serious_Game/index.php/Page_Accueil_Utilisateur.php');
  			exit();

     	}
     }else                                              // SI L'UTILISATEUR EST DEJA CONNECTER OU SI IL VIENT DE SE CONNECTER ON L'AUTORISE A ACCEDER AU AUTRE PAGE
     { 
     	$login = $_SESSION['nom_util'] ; 
        // route la requête en interne     
        if('/Serious_Game/index.php/Page_Accueil_Utilisateur.php' == $uri) 
        {
        	acceuil_util_action($login, $error);

        }elseif( '/Serious_Game/index.php/Page_Admin.php' == $uri ) //POUR L'INSTANT IL N'Y A AUCUNE PAGE ASSOCIE
        {         
        	acceuil_admin_action($login, $error);

        }elseif('/Serious_Game/index.php' == $uri)   //SI L'UTILISATEUR N'EST PAS CONNECTER IL N'A ACCES QUE A CES PAGES (Il)
	    {
	       Acceuil_action($error); 

	    }elseif ('/Serious_Game/index.php/Page_Inscription.php' == $uri)
	    {
	       sign_in_action($error);

        }elseif('/Serious_Game/index.php/FAQ' == $uri)
	    {
	       FAQ_action($error);

        }elseif('/Serious_Game/logout' == $uri )
        {         
        	session_destroy();        
        	acceuil_action($error); 
        	   
        }else
        {
        	echo "ERROR 404";
        }  
     }   
        
?>