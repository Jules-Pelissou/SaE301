<?php
/**
* définition de la classe itineraire
*/
class Jeu {
	 
	private $_nom_jeu;
	private $_photo;
	private $_nombre_joueurs;
	private $_duree_jeu;
	private $_regles;
	private $_materiel;
	private $_pseudo;
	private $_nom_categorie;
	private $_date_ajout;
	private $_valide;
		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
		if (isset($donnees['nom_jeu']))       { $this->_nom_jeu =       $donnees['nom_jeu']; }
		if (isset($donnees['photo']))  { $this->_photo =  $donnees['photo']; }
		if (isset($donnees['nombre_joueurs'])) { $this->_nombre_joueurs = $donnees['nombre_joueurs']; }
		if (isset($donnees['duree_jeu'])) { $this->_duree_jeu = $donnees['duree_jeu']; }
		if (isset($donnees['regles']))  { $this->_regles =  $donnees['regles'];}
		if (isset($donnees['materiel']))    { $this->_materiel =    $donnees['materiel']; }		
		if (isset($donnees['pseudo']))       { $this->_pseudo =       $donnees['pseudo']; }
		if (isset($donnees['nom_categorie']))    { $this->_nom_categorie =    $donnees['nom_categorie']; }
		if (isset($donnees['date_ajout']))		{$this->_date_ajout = $donnees['date_ajout'];}
		if (isset($donnees['valide']))		{$this->_valide = $donnees['valide'];}
	}           
	// GETTERS //
	public function nom_jeu()       { return $this->_nom_jeu;}
	public function photo()  { return $this->_photo;}
	public function nombre_joueurs() { return $this->_nombre_joueurs;}
	public function duree_jeu() { return $this->_duree_jeu;}
	public function regles()  { return $this->_regles;}
	public function materiel()  { return $this->_materiel;}
	public function pseudo()       { return $this->_pseudo;}
	public function nom_categorie()    { return $this->_nom_categorie;}
	public function date_ajout()	{return $this->_date_ajout;}
	public function valide()	{return $this->_valide;}
	
		
	// SETTERS //
	public function setnom_jeu($nom_jeu)             { $this->_nom_jeu = $nom_jeu; }
	public function setphoto($photo)   { $this->_photo= $photo; }
	public function setnombre_joueurs($nombre_joueurs) { $this->_nombre_joueurs = $nombre_joueurs; }
	public function setduree_jeu($duree_jeu) { $this->_duree_jeu = $duree_jeu; }
	public function setregles($regles)   { $this->_regles = $regles; }
	public function setmateriel($materiel)             { $this->_materiel = $materiel; }
	public function setpseudo($pseudo)             { $this->_pseudo = $pseudo; }
	public function setnom_categorie($nom_categorie)       { $this->_nom_categorie = $nom_categorie; }
	public function setdate_ajout($date_ajout)				{$this->_date_ajout = $date_ajout;}
	public function setvalide($valide)				{$this->_valide = $valide;}


}

?>