<?php

include "Modules/jeu.php";
include "Modules/categorie.php";
include "Modules/commenter.php";
include "Modules/noter.php";
include "Models/jeuManager.php";
include "Models/commenterManager.php";
include "Models/categorieManager.php";
include "Models/noterManager.php";
/**
 * Définition d'une classe permettant de gérer les opération sur les itinéraires 
 *   
 */
class JeuController
{

	private $jeuManager; // instance du manager
	private $utilisateurManager;
	private $categorieManager;
	private $commenterManager;
	private $noterManager;

	/**
	 * Constructeur = initialisation de la connexion vers le SGBD
	 */
	public function __construct($db, $twig)
	{
		//$this->_db=$db;
		$this->twig = $twig;
		$this->jeuManager = new JeuManager($db);
		$this->utilisateurManager = new UtilisateurManager($db);
		$this->categorieManager = new CategorieManager($db);
		$this->commenterManager = new CommenterManager($db);
		$this->noterManager = new NoterManager($db);
	}





	// GESTION DES LISTES DE JEUX

	public function listejeu()
	{
		$jeux = $this->jeuManager->getList();
		echo $this->twig->render('jeux/list.html.twig', ['jeux' => $jeux]);
	}

	public function listejeuvalide()
	{

		$connecte = $_SESSION["acces"];
		$admin = $_SESSION["admin"];
		$nomutili = $_SESSION["nom_utilisateur"];

		$jeux = $this->jeuManager->getListvalide();
		echo $this->twig->render('jeux/listvalide.html.twig', ['jeux' => $jeux, "connecte" => $connecte, "admin" => $admin, "nomutili" => $nomutili]);
	}





	// GESTION DES FORMS

	public function formAjoutjeu()
	{
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($_SESSION['nom_utilisateur']);
		$categories = $this->categorieManager->getCategorie();
		echo $this->twig->render('jeux/add.html.twig', ['pseudos' => $pseudos, 'categories' => $categories]);
	}

	public function formRechercheJeu()
	{

		$pseudos = $this->utilisateurManager->getUtilisateur();
		$nb_joueurs = $this->jeuManager->getNombreJoueurs();
		$categories = $this->categorieManager->getCategorie();
		echo $this->twig->render('jeux/formrech.html.twig', ['pseudos' => $pseudos, 'nombre_joueurs' => $nb_joueurs, 'categories' => $categories]);
	}

	public function detailJeu($info)
	{
		$connecte = $_SESSION["acces"];
		$admin = $_SESSION["admin"];
		$nomutili = $_SESSION["nom_utilisateur"];


		$jeux = $this->jeuManager->getDetail($info);
		$commentaires = $this->commenterManager->getCommentaire($info);
		$notes = $this->noterManager->getNote($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($_SESSION['nom_utilisateur']);
		echo $this->twig->render('jeux/detail.html.twig', ['jeux' => $jeux, 'commentaires' => $commentaires, 'notes' => $notes, 'pseudos' => $pseudos, "connecte" => $connecte, "admin" => $admin, "nomutili" => $nomutili]);
	}








	// GESTION DES PROFILS

	public function jeuProfil($info)
	{
		$jeux = $this->jeuManager->getJeuprofilvalide($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($info);
		$commentaires = $this->commenterManager->getSpecificcommentaire($info);
		$notes = $this->noterManager->getSpecificnote($info);
		echo $this->twig->render('utilisateurs/profil.html.twig', ['jeux' => $jeux, 'pseudos' => $pseudos, 'commentaires' => $commentaires, 'notes' => $notes]);
	}

	public function jeuProfilconnecte($info)
	{
		$jeux = $this->jeuManager->getJeuprofil($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($info);
		$commentaires = $this->commenterManager->getSpecificcommentaire($info);
		$notes = $this->noterManager->getSpecificnote($info);
		echo $this->twig->render('utilisateurs/profilconnecte.html.twig', ['jeux' => $jeux, 'pseudos' => $pseudos, 'commentaires' => $commentaires, 'notes' => $notes]);
	}





	// GESTION AJOUT D'UN JEU

	public function ajoutjeu()
	{
		$_POST['photo'] = $_FILES["photo"]["name"];
		$jeu = new Jeu($_POST);
		

		if ($_FILES["photo"]["error"]==UPLOAD_ERR_OK) { // verif si pas d'erreur
			// verifier le type de fichier
	
			// déplacer le fichier temporaire sur un repertoire du serveur web
		$uploaddir = "./img/"; // chemin du dossier où ranger les fichiers
		$uploadfile = $uploaddir . basename($_FILES["photo"]["name"]); // nom initial du fichier
			// on déplace le fichier du dossier temporaire du serveur web
			// vers le dossier approprié du site web et on renomme le fichier
		if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadfile)) {
			echo "pb lors du telechargement";
		}
	   }
	   else {
			// traitement des erreurs
			echo "Aucune Image donnée,";
	   }

	   $ko = $this->jeuManager->searchadd($jeu);

	   if ($ko != true){

		$ok = $this->jeuManager->add($jeu);
		if ($ok) echo " Jeu ajouté, en attente de validation par l'admin";
		else echo "probleme lors de l'ajout";
	}else{
		echo " Jeu déjà ajouté";
		}

	}






	// GESTION SUPPRESSION DES JEUX

	public function choixSuppJeu()
	{
		$jeux = $this->jeuManager->getJeuprofil($_SESSION["nom_utilisateur"]);
		echo $this->twig->render('jeux/formchoixsupp.html.twig', ['jeux' => $jeux]);
	}

	public function suppJeu()
	{


		$jeu = new Jeu($_POST);

		$ko = $this->jeuManager->delete_comm($jeu);

		$kok = $this->jeuManager->delete_note($jeu);

		if ($kok) echo "Notes suprimées";
		else echo "Problème lors de la supression des notes";

		if ($ko) echo "Commentaires supprimés";
		else echo "Problème lors de la supression des commentaires";

		$ok = $this->jeuManager->delete($jeu);

		if ($ok) echo "itineraire supprimé";
		else echo "probleme lors de la supression";
	}

	public function suppJeuadmin($info)
	{

		$ko = $this->jeuManager->delete_comm_admin($info);

		$kok = $this->jeuManager->delete_note_admin($info);

		if ($kok) echo "Notes suprimées";
		else echo "Problème lors de la supression des notes ";

		if ($ko) echo "Commentaires supprimés";
		else echo "Problème lors de la supression des commentaires ";

		$ok = $this->jeuManager->delete_admin($info);

		if ($ok) echo "itineraire supprimé";
		else echo "probleme lors de la supression";
	}







	// ADMINISTRATION DES JEUX

	public function jeuAdmin()
	{
		$jeux = $this->jeuManager->getList();
		$pseudos = $this->jeuManager->getUtilisateur();
		$commentaires = $this->jeuManager->getcommentaire();
		$categories = $this->categorieManager->getCategorie();
		echo $this->twig->render('jeux/pageadmin.html.twig', ['jeux' => $jeux, 'pseudos' => $pseudos, 'commentaires' => $commentaires, 'categories' => $categories]);
	}

	// GESTION DES JEUX (ADMIN)

	public function validerJeu($info)
	{
		$jeux = $this->jeuManager->valideJeu($info);
		$commentaires = $this->commenterManager->getCommentaire($info);
		$notes = $this->noterManager->getNote($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($_SESSION['nom_utilisateur']);
		echo $this->twig->render('jeux/detail.html.twig', ['jeux' => $jeux, 'commentaires' => $commentaires, 'notes' => $notes, 'pseudos' => $pseudos]);
	}

	public function supprimerJeu($info)
	{
		$jeux = $this->jeuManager->supprimeJeu($info);
		$commentaires = $this->commenterManager->getCommentaire($info);
		$notes = $this->noterManager->getNote($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($_SESSION['nom_utilisateur']);
		echo $this->twig->render('jeux/detail.html.twig', ['jeux' => $jeux, 'commentaires' => $commentaires, 'notes' => $notes, 'pseudos' => $pseudos]);
	}

	// GESTION DES COMMENTAIRES (ADMIN)

	public function validerCommentaire($info)
	{
		$jeux = $this->jeuManager->valideCommentaire($info);
		if ($jeux) echo ('Commentaire mis en ligne');
		else echo ('ça fonctionne');
	}

	public function supprimerCommentaire($info)
	{
		$jeux = $this->jeuManager->supprimeCommentaire($info);
		$commentaires = $this->commenterManager->getCommentaire($info);
		$notes = $this->noterManager->getNote($info);
		$pseudos = $this->utilisateurManager->getSpecificutilisateur($_SESSION['nom_utilisateur']);
		echo $this->twig->render('jeux/detail.html.twig', ['jeux' => $jeux, 'commentaires' => $commentaires, 'notes' => $notes, 'pseudos' => $pseudos]);
	}

	// GESTION DES UTILISATEURS (ADMIN)


	public function supprimerUtilisateur()
	{

		$utilisateur = $_POST["pseudo"];

		$this->jeuManager->suppressionUtilisateurNote($utilisateur);
		$this->jeuManager->suppressionUtilisateurCom($utilisateur);
		$test = $this->jeuManager->getJeuprofil($utilisateur);
		foreach ($test as $value) {
			$this->jeuManager->delete_comm($value);
			$this->jeuManager->delete_note($value);
		}
		$this->jeuManager->suppressionUtilisateurJeu($utilisateur);
		$ok = $this->jeuManager->suppressionUtilisateur($utilisateur);

		if ($ok) echo "utilisateur supprimé";
		else echo "probleme lors de l'ajout";
	}





	// GESTION DE LA MODIFICATION DES JEUX

	public function choixModJeu()
	{
		$jeux = $this->jeuManager->getJeuprofil($_SESSION["nom_utilisateur"]);
		echo $this->twig->render('jeux/formchoix.html.twig', ['jeux' => $jeux]);
	}

	public function saisieModJeu()
	{

		$jeux =  $this->jeuManager->get($_POST["nom_jeu"]);
		$categories = $this->categorieManager->getCategorie();
		echo $this->twig->render('jeux/formmodif.html.twig', ['jeux' => $jeux, 'categories' => $categories]);
	}


	public function modJeu()
	{
		$jeu = new jeu($_POST);
		$ok = $this->jeuManager->update($jeu);
		if ($ok) echo "jeu modifié";
		else echo "probleme lors de la modification";
	}






	// GESTION DE LA RECHERCHE

	public function rechercheJeu()
	{
		$jeux = new Jeu($_POST);


		// TRUC MIEUX POUR FAIRE LE NOMBRE MIN ET MAX
		// FAIRE GAFFE AU NOM DOIT ETRE COMME LE FORM

		// $pseudo = $_POST["pseudo"];
		// $nom_jeu = $_POST["nom_jeu"];
		// $nombre_joueurmax = $_POST["nombre_joueurmax"];
		// $nombre_joueurs = $_POST["nombre_joueurmin"];
		// $nom_categorie = $_POST["nom_categorie"];
		// $duree_jeu = $_POST["duree"];



		$pseudo = $jeux->pseudo();
		$nom_jeu = $jeux->nom_jeu();
		$nom_categorie = $jeux->nom_categorie();
		$nombre_joueurs = $jeux->nombre_joueurs();
		$duree_jeu = $jeux->duree_jeu();

		$jeu = $this->jeuManager->search($nom_jeu, $nombre_joueurs, $nom_categorie, $pseudo, $duree_jeu);
		echo $this->twig->render('jeux/recherche.html.twig', ['jeux' => $jeu]);

		// if ($ok) echo "itineraire recherhcé" ;
		// else echo "Problème lors de la recherche";
	}
}
