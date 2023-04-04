<?php

/**
 * Définition d'une classe permettant de gérer les opération sur les itinéraires 
 *   
 */
class NoterController
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


    public function ajout_commentaire()
    {

        $commentaire = new Commentaire($_POST);
        
        $ko = $this->commenterManager->search($commentaire);

        $ok = "";
        
        $pseudo_jeu = $_POST['pseudo_jeu'];

        // NE PEUT PAS ENVOYER 2 COMMENTAIRES

        if ($ko !=true){

        // NE PEUT PAS S'AUTO ENVOYER DES COMMENTAIRES

        if ($commentaire->pseudo() == $pseudo_jeu) {
            echo ("Pourquoi commenter son jeu ?");
        } else {
            
            // NE PEUT PAS ENVOYER DES COMMENTAIRES VIDES 
            
            if ($commentaire->pseudo() !== $pseudo_jeu) {
                if ($commentaire->commentaire() == "") {
                    echo ("Merci de mettre un commentaire.");
                } else {
                    $ok = $this->commenterManager->add($commentaire);
                }
            }
        }

            if ($ok) "commentaire ajouté";
            else echo " Probleme lors de l'ajout";
        }else{
            echo ("Vous ne pouvez pas commenter 2 fois");
        }
    }

    public function verif_note(){


        $note = new Note($_POST);
        $ok = $this->noterManager->search($note);
        $pseudo_jeu = $_POST['pseudo_jeu'];
        
        // NE PEUT PAS COMMENTER 2 FOIS

        if ($ok !=true){
            if ($note->pseudo() == $pseudo_jeu) {
                echo ("Vous ne pouvez pas noter votre propre jeu");
            } else {
                $ok = $this->noterManager->add($note);
    
                if ($ok) "note ajoutée";
                else echo "probleme lors de l'ajout";
            }
        }else{
            echo ("Vous ne pouvez pas noter 2 fois un même jeu");
        }
    }

}
