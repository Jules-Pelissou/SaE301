<?php
/**
* Définjeuon d'une classe permettant de gérer les jeunéraires 
*   en relation avec la base de données	
*/
class CommenterManager {
    
	private $_db; // Instance de PDO - objet de connexion au SGBD
        
	/**
	* Constructeur = injeualisation de la connexion vers le SGBD
	*/
	public function __construct($db) {
		$this->_db=$db;
	}
        
	/**
	* ajout d'un jeu dans la BD
	* @param jeu à ajouter
	* @return int true si l'ajout a bien eu lieu, false sinon
	*/

    public function getCommentaire($info){
        $commentaires = array();
		// print_r($info);
		$req = "SELECT `id`, `nom_jeu`, `pseudo`, date_format(date_ajout,'%d-%m-%Y')as `date_ajout`, `commentaire` FROM `commenter` WHERE nom_jeu LIKE ? and valide=1";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch())
		{
			$commentaires[] = new commentaire($donnees);
		};
		return $commentaires;

    }

    public function getSpecificcommentaire($info)
    {
        $commentaires = array();
        $req = "SELECT * FROM commenter WHERE pseudo LIKE ? and valide =1";
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array($info));

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
            print_r($errorInfo);
        }

        while ($donnees = $stmt->fetch()) {
            $commentaires[] = new commentaire($donnees);
        };
        return $commentaires;
    }

	public function add(Commentaire $commentaire){
		
		$req = "INSERT INTO commenter (`id`,`nom_jeu`,`pseudo`,`date_ajout`,`commentaire`, valide) VALUES (?,?,?,?,?,0)";
		$stmt = $this->_db->prepare($req);
		$commentaire = $stmt->execute(array($commentaire->id(),$commentaire->nom_jeu(), $commentaire->pseudo(),date("Y-m-d H:i:s"), $commentaire->commentaire()));


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		echo "Commentaire ajouté, veuillez attendre la vérification avant de le voir apparaître";
		return $commentaire;

	}

	public function search(Commentaire $commentaire){
		
		$req = "SELECT * FROM `commenter` WHERE pseudo LIKE ? AND nom_jeu LIKE ?";			
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($commentaire->pseudo(), $commentaire->nom_jeu()));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		$existe = false;
		$comm = array();
		while ($donnees = $stmt->fetch()) {
			$comm[] = new Note($donnees);
			$existe = true;
		}
		return $existe;
	}

}