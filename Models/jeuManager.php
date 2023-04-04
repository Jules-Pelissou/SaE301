<?php

/**
 * Définjeuon d'une classe permettant de gérer les jeunéraires 
 *   en relation avec la base de données	
 */
class JeuManager
{

	private $_db; // Instance de PDO - objet de connexion au SGBD

	/**
	 * Constructeur = injeualisation de la connexion vers le SGBD
	 */
	public function __construct($db)
	{
		$this->_db = $db;
	}

	/**
	 * ajout d'un jeu dans la BD
	 * @param jeu à ajouter
	 * @return int true si l'ajout a bien eu lieu, false sinon
	 */

	public function searchadd (Jeu $jeu){

		$req = "SELECT * FROM `jeu` WHERE nom_jeu LIKE ?";			
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($jeu->nom_jeu()));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		$existe = false;
		$note = array();

		while ($donnees = $stmt->fetch()) {
			$note[] = new Jeu($donnees);
			$existe = true;
		}
		return $existe;
	}



	public function add(Jeu $jeu)
	{
		// requete d'ajout dans la BD
		$req = "INSERT INTO jeu (`nom_jeu`, `nombre_joueurs`, `duree_jeu`, `regles`,`materiel`,`date_ajout`, `pseudo`, `nom_categorie`, `photo`, `valide`) VALUES (?,?,?,?,?,?,?,?,?,0)";
		$stmt = $this->_db->prepare($req);
		$jeu = $stmt->execute(array($jeu->nom_jeu(), $jeu->nombre_joueurs(), $jeu->duree_jeu(), $jeu->regles(), $jeu->materiel(), date("Y-m-d"), $jeu->pseudo(), $jeu->nom_categorie(), $jeu->photo()));


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $jeu;
	}

	/**
	 * nombre d'jeunéraires dans la base de données
	 * @return int le nb d'jeunéraires
	 */
	public function count()
	{
		$stmt = $this->_db->prepare('SELECT COUNT(*) FROM jeu');
		$stmt->execute();
		return $stmt->fetchColumn();
	}








	// GESTION DE LA SUPPRESSION D'UN JEU PAR UN UTILISATEUR



	public function delete_note (jeu $jeu){

		$req = "DELETE FROM `noter` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($jeu->nom_jeu()));
		
		return $res;
	 }


	 public function delete_comm (jeu $jeu){

		$req = "DELETE FROM `commenter` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($jeu->nom_jeu()));

		return $res;
	 }


	public function delete(jeu $jeu)
	{

		$req = "DELETE FROM `jeu` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($jeu->nom_jeu()));
		
		return $res;


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

	}





	// RECHERCHE TOUTES LES INFORMATIONS SUR UN JEU EN FONCTION DU NOM

	public function get($nom_jeu)
	{
		$req = 'SELECT nom_jeu,photo,nombre_joueurs,duree_jeu,regles,date_format(date_ajout,"%d-%m-%Y")as date_ajout,materiel,pseudo,nom_categorie FROM jeu WHERE nom_jeu=?';
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($nom_jeu));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		$jeu = new jeu($stmt->fetch());
		return $jeu;
	}








	// GESTION DES LISTES

	public function getList()
	{
		$jeu = array();
		$req = "SELECT nom_jeu, photo, nombre_joueurs, duree_jeu, pseudo, nom_categorie FROM jeu WHERE valide =0";
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch()) {
			$jeu[] = new jeu($donnees);
		};
		return $jeu;
	}


	public function getListvalide()
	{
		$jeu = array();
		$req = "SELECT nom_jeu, photo, nombre_joueurs, duree_jeu, pseudo, nom_categorie FROM jeu WHERE valide = 1";
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch()) {
			$jeu[] = new jeu($donnees);
		};
		return $jeu;
	}










	// GESTION DU BOUTON EN SAVOIR PLUS SUR CARD JEUX


	public function getDetail($info)
	{
		$detail = array();
		// print_r($info);
		$req = "SELECT `nom_jeu`, `photo`, `nombre_joueurs`, `duree_jeu`, `regles`, `materiel`, `pseudo`, `nom_categorie`,date_format(date_ajout,'%d-%m-%Y')as `date_ajout` FROM `jeu` WHERE nom_jeu LIKE ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch()) {
			$detail[] = new jeu($donnees);
		};
		return $detail;
	}









	// GESTION DE L'ADMINISTRATION

	public function valideJeu($info)
	{
		$validation = array();
		// print_r($info);
		$req = "UPDATE `jeu` SET `valide`='1' WHERE nom_jeu LIKE ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch()) {
			$validation = new jeu($donnees);
		};
		return $validation;
	}

	public function supprimeJeu($info)
	{
		$req = "DELETE FROM `jeu` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		return $res;


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
	}

	public function valideCommentaire($info)
	{
		$validation = array();
		$req = "UPDATE `commenter` SET `valide`='1' WHERE id LIKE ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch()) {
			$validation = new commentaire($donnees);
		};
		return $validation;
	}

	public function supprimeCommentaire($info)
	{
		$req = "DELETE FROM `commenter` WHERE `id` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;


	}

	public function suppressionUtilisateur($info){

		$req = "DELETE FROM `utilisateur` WHERE `pseudo` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;

	}

	public function suppressionUtilisateurCom($info){

		$req = "DELETE FROM `commenter` WHERE `pseudo` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;

	}

	public function suppressionUtilisateurNote($info){

		$req = "DELETE FROM `noter` WHERE `pseudo` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;

	}

	public function suppressionUtilisateurJeu($info){

		$req = "DELETE FROM `jeu` WHERE `pseudo` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;

	}

	
	public function delete_note_admin ($info){

		$req = "DELETE FROM `noter` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		return $res;
	 }


	 public function delete_comm_admin ($info){

		$req = "DELETE FROM `commenter` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));

		return $res;
	 }


	public function delete_admin($info)
	{

		$req = "DELETE FROM `jeu` WHERE `nom_jeu` LIKE ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($info));
		
		return $res;


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

	}



	// GESTION DES JEUX DU PROFIL




	public function getJeuprofil($info)
	{
		$jeuprofil = array();
		$req = "SELECT `nom_jeu`, `photo`, `nombre_joueurs`, `duree_jeu`, `regles`, `materiel`, `pseudo`, `nom_categorie`,date_format(date_ajout,'%d-%m-%Y')as `date_ajout` FROM `jeu` WHERE pseudo LIKE ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch()) {
			$jeuprofil[] = new jeu($donnees);
		};
		return $jeuprofil;
	}

	public function getJeuprofilvalide($info)
	{
		$jeuprofil = array();
		$req = "SELECT `nom_jeu`, `photo`, `nombre_joueurs`, `duree_jeu`, `regles`, `materiel`, `pseudo`, `nom_categorie`,date_format(date_ajout,'%d-%m-%Y')as `date_ajout` FROM `jeu` WHERE pseudo LIKE ? and valide = 1";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($info));

		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		while ($donnees = $stmt->fetch()) {
			$jeuprofil[] = new jeu($donnees);
		};
		return $jeuprofil;
	}







	// FONCTION SPECIFIQUES DE RECHERCHE


		// RECHERCHE DES UTILISATEURS

		public function getUtilisateur()
		{
			$jeu = array();
			$req = "SELECT pseudo FROM utilisateur";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();

			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}

			while ($donnees = $stmt->fetch()) {
				$jeu[] = new jeu($donnees);
			};
			return $jeu;
		}


		// RECHERCHE DU NOMBRE DE JOUEURS

		public function getNombreJoueurs()
		{
			$nbrjr = array();
			$req = "SELECT nombre_joueurs FROM jeu";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();

			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}

			while ($donnees = $stmt->fetch()) {
				$nbrjr[] = new jeu($donnees);
			};
			return $nbrjr;
		}

		// RECHERCHE DE TOUS LES COMMENTAIRES

		public function getCommentaire(){

			$commentaires = array();
			$req = "SELECT * FROM commenter WHERE valide=0";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();

			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}

			while ($donnees = $stmt->fetch()) {
				$commentaires[] = new Commentaire($donnees);
			};
			return $commentaires;
		}








	// GESTION DE LA RECHERCHE DE JEUX	

	public function search($nom_jeu, $nombre_joueurs, $nom_categorie, $pseudo, $duree_jeu)
	{

		$req = "SELECT `nom_jeu`, `photo`, `nombre_joueurs`, `duree_jeu`, `regles`, `materiel`, `pseudo`, `nom_categorie`, `date_ajout` FROM `jeu`";

		$cond = '';
		if ($nom_jeu <> "") {
			$cond = $cond . " nom_jeu like '%" . $nom_jeu . "%'";
		}
		if ($nombre_joueurs <> "") {
			if ($cond <> "") {
				$cond .= " AND ";
			}
			$cond = $cond . " nombre_joueurs <= " . $nombre_joueurs;
		}
		if ($pseudo <> "") {
			if ($cond <> "") {
				$cond .= " AND ";
			}
			$cond = $cond . " pseudo like '%" . $pseudo . "%'";
		}
		if ($nom_categorie <> "") {
			if ($cond <> "") {
				$cond .= " AND ";
			}
			$cond = $cond . " nom_categorie like '%" . $nom_categorie . "'";
		}
		if ($duree_jeu > 60) {
			if ($cond <> "") {
				$cond .= " AND ";
			}
			$cond = $cond . " duree_jeu BETWEEN 60 AND " . $duree_jeu;
		}
		if ($duree_jeu <> "") {
			if ($cond <> "") {
				$cond .= " AND ";
			}
			$cond = $cond . " duree_jeu <= " . $duree_jeu;
		}
		if ($cond <> "") {
			$req .= " WHERE " . $cond;
		}


		// execution de la requete				
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		$jeux = array();
		while ($donnees = $stmt->fetch()) {
			$jeux[] = new Jeu($donnees);
		}
		return $jeux;
	}

	// GESTION DE LA MODIFICATION DES JEUX	

	public function update(jeu $jeu)
	{
		$req = "UPDATE `jeu` SET `nom_jeu`= ?, `photo` = ?, `nombre_joueurs` = ?, `duree_jeu`= ?, `regles`= ?, `materiel`= ?, `nom_categorie`= ?, `date_ajout` =  ? WHERE `nom_jeu` = ?";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($jeu->nom_jeu(), $jeu->photo(), $jeu->nombre_joueurs(), $jeu->duree_jeu(), $jeu->regles(), $jeu->materiel(), $jeu->nom_categorie(), $jeu->date_ajout("Y-m-d"), $jeu->nom_jeu()));


		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}

		return $res;
	}
}

	// FONCTION CHANGEMENT FORMAT DE DATES
	// TANSFORMATION J/M/A EN A/M/J

function dateChgmtFormat($date)
{
	//echo "date:".$date;
	list($j, $m, $a) = explode("/", $date);
	return "$a/$m/$j";
}
