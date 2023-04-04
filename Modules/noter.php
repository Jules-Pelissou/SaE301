<?php
/**
* définition de la classe itineraire
*/
class Note {
	 
	private $_id;
	private $_nom_jeu;
	private $_pseudo;
	private $_date_ajout;
	private $_note;

		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
        if (isset($donnees['id']))  { $this->_id =  $donnees['id']; }
        if (isset($donnees['nom_jeu']))       { $this->_nom_jeu =       $donnees['nom_jeu']; }
		if (isset($donnees['pseudo']))       { $this->_pseudo =       $donnees['pseudo']; }
		if (isset($donnees['date_ajout']))		{$this->_date_ajout = $donnees['date_ajout'];}
		if (isset($donnees['note'])) { $this->_note = $donnees['note']; }
	}           
	// GETTERS //
	public function id()  { return $this->_id;}
	public function nom_jeu()       { return $this->_nom_jeu;}
	public function pseudo()       { return $this->_pseudo;}
	public function date_ajout()	{return $this->_date_ajout;}
	public function note() { return $this->_note;}
	
		
	// SETTERS //
	public function setid($id)   { $this->_id= $id; }
	public function setnom_jeu($nom_jeu)             { $this->_nom_jeu = $nom_jeu; }
	public function setpseudo($pseudo)             { $this->_pseudo = $pseudo; }
	public function setdate_ajout($date_ajout)				{$this->_date_ajout = $date_ajout;}
	public function setnote($note) { $this->_note = $note; }


}

?>