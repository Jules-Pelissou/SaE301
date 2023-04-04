<?php
/**
* définition de la classe itineraire
*/
class Utilisateur {
	 
	private $_pseudo;
	private $_nom;
	private $_prenom;
	private $_date_inscription;
	private $_mail;
	private $_mdp;
    private $_admin;
		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
        if (isset($donnees['pseudo']))       { $this->_pseudo =       $donnees['pseudo']; }
		if (isset($donnees['nom']))       { $this->_nom =       $donnees['nom']; }
		if (isset($donnees['prenom']))  { $this->_prenom =  $donnees['prenom']; }
		if (isset($donnees['date_inscription'])) { $this->_date_inscription = $donnees['date_inscription']; }
		if (isset($donnees['mail'])) { $this->_mail = $donnees['mail']; }
		if (isset($donnees['mdp']))  { $this->_mdp =  $donnees['mdp'];}		
		if (isset($donnees['admin']))    { $this->_admin =    $donnees['admin']; }
	}           
	// GETTERS //
	public function pseudo()       { return $this->_pseudo;}
	public function nom()       { return $this->_nom;}
	public function prenom()  { return $this->_prenom;}
	public function date_inscription() { return $this->_date_inscription;}
	public function mail() { return $this->_mail;}
	public function mdp()  { return $this->_mdp;}
	public function admin()    { return $this->_admin;}
	
		
	// SETTERS //
	public function setpseudo($pseudo)             { $this->_pseudo = $pseudo; }
	public function setnom($nom)             { $this->_nom = $nom; }
	public function setprenom($prenom)   { $this->_prenom= $prenom; }
	public function setdate_inscription($date_inscription) { $this->_date_inscription = $date_inscription; }
	public function setmail($mail) { $this->_mail = $mail; }
	public function setmdp($mdp)   { $this->_mdp = $mdp; }
	public function setadmin($admin)       { $this->_admin = $admin; }


}