<?php
/**
* définition de la classe itineraire
*/
class Commentaire {
	 
	private $_id;
	private $_nom_jeu;
	private $_pseudo;
	private $_date_ajout;
	private $_commentaire;
	private $_valide;
		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
        if (isset($donnees['id']))  { $this->_id =  $donnees['id']; }
		if (isset($donnees['nom_jeu']))       { $this->_nom_jeu =       $donnees['nom_jeu']; }
		if (isset($donnees['pseudo']))       { $this->_pseudo =       $donnees['pseudo']; }
		if (isset($donnees['date_ajout']))		{$this->_date_ajout = $donnees['date_ajout'];}
		if (isset($donnees['commentaire'])) { $this->_commentaire = $donnees['commentaire']; }
		if (isset($donnees['valide']))		{$this->_valide = $donnees['valide'];}

	}           
	// GETTERS //
	public function id()  { return $this->_id;}
	public function nom_jeu()       { return $this->_nom_jeu;}
	public function pseudo()       { return $this->_pseudo;}
	public function date_ajout()	{return $this->_date_ajout;}
	public function commentaire() { return $this->_commentaire;}
	public function valide()	{return $this->_valide;}

		
	// SETTERS //
	public function setid($id)   { $this->_id= $id; }
	public function setnom_jeu($nom_jeu)             { $this->_nom_jeu = $nom_jeu; }
	public function setpseudo($pseudo)             { $this->_pseudo = $pseudo; }
	public function setdate_ajout($date_ajout)				{$this->_date_ajout = $date_ajout;}
	public function setcommentaire($commentaire) { $this->_commentaire = $commentaire; }
	public function setvalide($valide)				{$this->_valide = $valide;}


}

?>