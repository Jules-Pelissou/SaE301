<?php
/**
* Définjeuon d'une classe permettant de gérer les jeunéraires 
*   en relation avec la base de données	
*/
class NoterManager {
    
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

    public function getNote($info){
        $diviseur = 0;
        $notes = array();
		// print_r($info);
		$req = "SELECT `note` FROM `noter` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch())
		{
            $diviseur++;
			$notes[] = new note($donnees);

		};
		return $notes;
    }

    public function getSpecificnote($info)
    {
        $notes = array();
        $req = "SELECT * FROM noter WHERE pseudo LIKE ?";
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array($info));

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
            print_r($errorInfo);
        }

        while ($donnees = $stmt->fetch()) {
            $notes[] = new note($donnees);
        };
        return $notes;
    }

	public function search(Note $note){
		
		$req = "SELECT * FROM `noter` WHERE pseudo LIKE ? AND nom_jeu LIKE ?";			
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($note->pseudo(), $note->nom_jeu()));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		$existe = false;
		$note = array();
		while ($donnees = $stmt->fetch()) {
			$note[] = new Note($donnees);
			$existe = true;
		}
		return $existe;
	}

	public function add(Note $note){
		
		$req = "INSERT INTO noter (`id`,`nom_jeu`,`pseudo`,`date_ajout`,`note`) VALUES (?,?,?,?,?)";
		$stmt = $this->_db->prepare($req);
		$note = $stmt->execute(array($note->id(),$note->nom_jeu(), $note->pseudo(),date("Y-m-d H:i:s"), $note->note()));


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		echo "Note ajoutée";
		return $note;

	}

}