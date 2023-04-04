<?php

class UtilisateurManager
{

    private $_db; // Instance de PDO - objet de connexion au SGBD

    /**
     * Constructeur = injeualisation de la connexion vers le SGBD
     */
    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getUtilisateur()
    {
        $pseudo = array();
        $req = "SELECT pseudo FROM utilisateur";
        $stmt = $this->_db->prepare($req);
        $stmt->execute();

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
            print_r($errorInfo);
        }

        while ($donnees = $stmt->fetch()) {
            $pseudo[] = new Utilisateur($donnees);
        };
        return $pseudo;
    }

    public function getSpecificutilisateur($info)
    {
        $pseudo = array();
        $req = "SELECT `pseudo`, `nom`, `prenom`, date_format(date_inscription,'%d/%c/%Y')as `date_inscription`, `mail`, `mdp`, `admin` FROM utilisateur WHERE pseudo LIKE ?";
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array($info));

        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
            print_r($errorInfo);
        }

        while ($donnees = $stmt->fetch()) {
            $pseudo[] = new Utilisateur($donnees);
        };
        return $pseudo;
    }
    
    public function verif_authentification($pseudo, $mdp)
    {
        $req = "SELECT `pseudo`,`mdp` FROM utilisateur WHERE pseudo = ? AND mdp = ?";
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array($pseudo, $mdp));
        
        // pour debuguer les requêtes SQL
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
        print_r($errorInfo);
        }

        if ($data=$stmt->fetch()){
            $connexion = new Utilisateur($data);
            return $connexion;
        }else{
            $connexion = false;
            return $connexion;
        }        
    }

    public function verif_admin($pseudo){

        $req = "SELECT * FROM utilisateur WHERE pseudo = ? AND admin = 1";
        $stmt = $this->_db->prepare($req);
        $stmt->execute(array($pseudo));
        
        // pour debuguer les requêtes SQL
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] != 0) {
        print_r($errorInfo);
        }


        if ($data=$stmt->fetch()){
            $admin = new Utilisateur($data);
            return $admin;
        }else{
            $admin = false;
            return $admin;
        }

    }

    public function ajout_utilisateur(Utilisateur $utili){
        $req ="INSERT INTO `utilisateur` (`pseudo`, `nom`, `prenom`, `date_inscription`, `mail`, `mdp`, `admin`) VALUES (?,?,?,?,?,?,0)";
        $stmt = $this->_db->prepare($req);
        $utili = $stmt->execute(array($utili->pseudo(),$utili->nom(),$utili->prenom(),date("Y-m-d"),$utili->mail(),$utili->mdp()));

        // pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $utili;
    }
}

?>
