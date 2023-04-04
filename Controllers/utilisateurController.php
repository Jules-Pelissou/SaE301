<?php

include "Modules/utilisateur.php";
include "Models/utilisateurManager.php";

/**
* Définition d'une classe permettant de gérer les opération sur les utilisateurs 
*   
*/
class UtilisateurController {
    
	private $utilisateurManager;

    /**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		$this->twig= $twig;
		$this->utilisateurManager = new UtilisateurManager($db);
		$this->jeuManager = new JeuManager($db);
	}
        

	public function utilisateurAddForm() {
		echo $this->twig->render('utilisateurs/addutili.html.twig', []);
	}

	public function ajoutUtilisateur(){
		$utili = new Utilisateur($_POST);
		$ok = $this->utilisateurManager->ajout_utilisateur($utili);
		if ($ok) echo "Utilisateur ajouté" ;
		else echo "probleme lors de l'ajout";
	}

	public function utilisateurFormulaire() {
		echo $this->twig->render('utilisateurs/formconnexion.html.twig');
	}

    public function utilisateurConnexion($data){
        $connexion = $this->utilisateurManager->verif_authentification($data["pseudo"], $data["mdp"]);
		$admin = $this->utilisateurManager->verif_admin($data["pseudo"]);
        if ($connexion != false){
			$_SESSION['acces']="oui";
			$_SESSION['nom_utilisateur'] = $data["pseudo"];
			if ($admin != false){
				$_SESSION['admin']="oui";
				echo "Bienvenue Admin";

			}else{
				echo "Bienvenue, veuillez cliquer sur le menu pour l'actualiser ou faire F5";

			}
        }else{
			$_SESSION['acces']="non";
            echo "Mauvais identifiants";
        }
    }

	public function utilisateurDeconnexion(){
		$_SESSION['acces']='non';
		$_SESSION['admin']='non';
		$_SESSION['nom_utilisateur']="";
		echo "Vous êtes déconnecté, veuillez cliquer sur le nom du site pour l'actualiser ou faire F5 ([WIP])";
	}


}

?>