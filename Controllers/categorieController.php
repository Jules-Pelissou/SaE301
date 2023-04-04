<?php

/**
 * Définition d'une classe permettant de gérer les opération sur les itinéraires 
 *   
 */
class categorieController
{

    private $noterManager; // instance du manager
    private $utilisateurManager;
    private $categorieManager;
    private $commenterManager;
    private $jeuManager;

    /**
     * Constructeur = initialisation de la connexion vers le SGBD
     */
    public function __construct($db, $twig)
    {
        //$this->_db=$db;
        $this->twig = $twig;
        $this->noterManager = new NoterManager($db);
        $this->utilisateurManager = new UtilisateurManager($db);
        $this->categorieManager = new CategorieManager($db);
        $this->commenterManager = new CommenterManager($db);
        $this->jeuManager = new JeuManager($db);
    }

    public function ajout_categorie(){

        $categorie = new Categorie($_POST);
        $this->categorieManager->add($categorie);

    }

    public function supprimer_categorie(){

        $categorie = $_POST["categorie"];
        $test = $this->categorieManager->search($categorie);
        foreach ($test as $value){
            $this->jeuManager->delete_comm($value);
            $this->jeuManager->delete_note($value);
        }
        $this->categorieManager->deleteJeucategorie($categorie);
        $this->categorieManager->delete($categorie);

    }

}