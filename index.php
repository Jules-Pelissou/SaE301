<?php
// GESTION DES SESSIONS INSALLAH CA FONCTIONNE

session_start();  // utilisation des sessions

$message = "";

if (!isset($_SESSION['acces'])) {
  $_SESSION['acces'] = "non";
}

if (!isset($_SESSION['nom_utilisateur'])) {
  $_SESSION['nom_utilisateur'] = "";
}

if (!isset($_SESSION['admin'])) {
  $_SESSION['admin'] = "non";
}


require "moteurtemplate.php";
include "connect.php";
include "Controllers/jeuController.php";
include "Controllers/utilisateurController.php";
include "Controllers/noterController.php";
include "Controllers/categorieController.php";

$jeuController = new JeuController($bdd, $twig);
$utilisateurController = new UtilisateurController($bdd, $twig);
$noterController = new NoterController($bdd, $twig);
$categorieController = new CategorieController($bdd, $twig);

$connecte = $_SESSION["acces"];
$admin = $_SESSION["admin"];
$nomutili = $_SESSION["nom_utilisateur"];

echo $twig->render('index.html.twig', ["connecte" => $connecte, "admin" => $admin, "nomutili" => $nomutili]);

// formulaire de connexion
if (isset($_GET["action"])  && $_GET["action"] == "admin" && ($_SESSION['admin']=="oui")) {

  $jeuController->jeuAdmin();
}

// Ajout d'une note sur le jeu
if (isset($_POST["ajout_categorie"])) {
  $categorieController->ajout_categorie();
}

// Ajout d'une note sur le jeu
if (isset($_POST["supprimer_categorie"])) {
  $categorieController->supprimer_categorie();
}

// Ajout d'une note sur le jeu
if (isset($_POST["ajout_commentaire"])) {
  $noterController->ajout_commentaire();
}

if (isset($_POST["ajout_note"])) {
  $noterController->verif_note();
}

// formulaire de connexion
if (isset($_GET["action"])  && $_GET["action"] == "login") {
  $utilisateurController->utilisateurFormulaire();
}

// deconnexion : click sur le bouton deconnexion
if (isset($_GET["action"]) && $_GET['action'] == "logout") {
  $utilisateurController->utilisateurDeconnexion();
}

// Connexion de l'utilisateur

if (isset($_POST["connexion"])) {
  $utilisateurController->utilisateurConnexion($_POST);
}

// formulaire d'inscription
if (isset($_GET["action"])  && $_GET["action"] == "register") {
  $utilisateurController->utilisateurAddForm();
}

// liste des acts dans un tableau HTML
//  https://.../index/php?action=liste
if (isset($_GET["action"]) && $_GET["action"] == "liste") {
  $jeuController->listejeuvalide();
}

if (isset($_GET["action"]) && $_GET["action"] == "moi") {
  $jeuController->jeuProfilconnecte($_SESSION['nom_utilisateur']);
}

// Get le nom du jeu et donne les infos pour le valider
if (isset($_GET["nom_jeu"])  && $_GET["action"] == "valider") {
  $jeuController->validerJeu($_GET['nom_jeu']);
}

// Get le nom du jeu et donne les infos pour le supprimer
if (isset($_GET["nom_jeu"])  && $_GET["action"] == "supprimerjeuadmin") {
  $jeuController->suppJeuadmin($_GET['nom_jeu']);
}

// Get le nom du jeu et donne les infos pour le supprimer
if (isset($_GET["nom_jeu"])  && $_GET["action"] == "supprimer") {
  $jeuController->supprimerJeu($_GET['nom_jeu']);
}

// Get le nom du jeu et donne les infos pour le supprimer
if (isset($_GET["id"])  && $_GET["action"] == "valider_commentaire") {
  $jeuController->validerCommentaire($_GET['id']);
}

// Get le nom du jeu et donne les infos pour le supprimer
if (isset($_GET["id"])  && $_GET["action"] == "supprimer_commentaire") {
  $jeuController->supprimerCommentaire($_GET['id']);
}

if (isset($_POST["supprimer_utilisateur"])) {
  $jeuController->supprimerUtilisateur();
}

// Get le nom du jeu et donne les infos
if (isset($_GET["nom_jeu"])  && $_GET["action"] == "detail") {
  $jeuController->detailJeu($_GET['nom_jeu']);
}

// Get le nom de l'utilisateur et donne les infos
if (isset($_GET["pseudo"])  && $_GET["action"] == "profil") {
  $jeuController->jeuProfil($_GET['pseudo']);
}

// formulaire ajout d'un Acteurice : saisie des caractéristiques à ajouter dans la BD
//  https://.../index/php?action=ajout
// version 0 : l'Acteurice est rattaché automatiquement à un membre déjà présent dans la BD
if (isset($_GET["action"]) && $_GET["action"] == "ajout") {
  $jeuController->formAjoutjeu();
}

// ajout de l'Acteurice dans la base
// --> au clic sur le bouton "valider_ajout" du form précédent
if (isset($_POST["valider_ajout"])) {
  $jeuController->ajoutjeu();
}

// ajout de l'Acteurice dans la base
// --> au clic sur le bouton "valider_ajout" du form précédent
if (isset($_POST["valider_ajout_utilisateur"])) {
  $utilisateurController->ajoutUtilisateur();
}

// suppression d'un Acteurice : choix de l'Acteurice
//  https://.../index/php?action=suppr
if (isset($_GET["action"]) && $_GET["action"] == "suppr") {
  $jeuController->choixSuppJeu();
}

// supression d'un jeu dans la base
// --> au clic sur le bouton "valider_supp" du form précédent
if (isset($_POST["valider_supp"])) {
  $jeuController->suppJeu();
}

// modification d'un Acteurice : choix de l'Acteurice
//  https://.../index/php?action=modif
if (isset($_GET["action"]) && $_GET["action"] == "modif") {
  $jeuController->choixModJeu();
}

// modification d'un Acteurice : saisie des nouvelles valeurs
// --> au clic sur le bouton "saisie modif" du form précédent
//  ==> version 0 : pas modif de l'idact ni de l'idmembre
if (isset($_POST["saisie_modif"])) {
  $jeuController->saisieModJeu();
}

//modification d'un Acteurice : enregistrement dans la bd
// --> au clic sur le bouton "valider_modif" du form précédent
if (isset($_POST["valider_modif"])) {
  $jeuController->modJeu();
}


// recherche d'Acteurice : saisie des critres de recherche dans un formulaire
//  https://.../index/php?action=recherc
if (isset($_GET["action"]) && $_GET["action"] == "recher") {
  $jeuController->formRechercheJeu();
}

// recherche des Acteurices : construction de la requete SQL en fonction des critères 
// de recherche et affichage du résultat dans un tableau HTML 
// --> au clic sur le bouton "valider_recher" du form précédent
if (isset($_POST["valider_recher"])) {
  $jeuController->rechercheJeu();
}

?>
<!-- </div>
  <footer> Copyright &copy; <a href="index.php">MMI Castres</a> - Tous droits réservés</footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html> -->