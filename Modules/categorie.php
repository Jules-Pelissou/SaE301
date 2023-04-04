<?php
/**
* définition de la classe itineraire
*/
class Categorie {
	 
	private $_nom_categorie;
		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
		if (isset($donnees['nom_categorie']))    { $this->_nom_categorie =    $donnees['nom_categorie']; }
	}           
	// GETTERS //
	public function nom_categorie()    { return $this->_nom_categorie;}
	
		
	// SETTERS //
	public function setnom_categorie($nom_categorie)       { $this->_nom_categorie = $nom_categorie; }


}

?>