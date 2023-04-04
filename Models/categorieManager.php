<?php

class CategorieManager
{

    private $_db; // Instance de PDO - objet de connexion au SGBD

    /**
     * Constructeur = injeualisation de la connexion vers le SGBD
     */
    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getCategorie()
    {
        $categorie = array();
        $req = "SELECT nom_categorie FROM categorie";
        $stmt = $this->_db->prepare($req);
        $stmt->execute();

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
            print_r($errorInfo);
        }

        while ($donnees = $stmt->fetch()) {
            $categorie[] = new categorie($donnees);
        };
        return $categorie;
    }

    public function add($info)
    {
       
		$req = "INSERT INTO categorie (`nom_categorie`) VALUES (?)";
		$stmt = $this->_db->prepare($req);
		$categorie = $stmt->execute(array($info->nom_categorie()));


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $categorie;
    }

    public function delete($info)
    {
        $req = "DELETE FROM `categorie` WHERE `nom_categorie` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));

		return $res;
    }

    public function search($info){

        $req = "SELECT * FROM `jeu` WHERE nom_categorie LIKE ?";			
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		$listejeu = array();
		while ($donnees = $stmt->fetch()) {
			$listejeu[] = new Jeu($donnees);
		}
		return $listejeu;
    }

    public function deleteJeucategorie($info){

        $req = "DELETE FROM `jeu` WHERE nom_categorie LIKE ?";			
		$stmt = $this->_db->prepare($req);
		$res = $stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		return $res;

    }

}

?>
