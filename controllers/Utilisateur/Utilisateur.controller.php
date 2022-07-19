<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Utilisateur/Utilisateur.model.php");

class UtilisateurController extends MainController
{
    private $utilisateurManager;

    public function __construct()
    {
        $this->utilisateurManager = new UtilisateurManager();
    }

    public function validation_login($email, $password)
    {
        if ($this->utilisateurManager->isCombinaisonValide($email, $password)) {
                Toolbox::ajouterMessageAlerte("Bon retour sur le site " . $email . " !", Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    "email" => $email,
                ];
                header("location: " . URL . "compte/profil");
          
        } else {
            Toolbox::ajouterMessageAlerte("Combinaison email / Mot de passe non valide", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "login");
        }
    }

    public function profil()
    {
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['email']);
        $_SESSION['profil']["id_users"] = $datas['id_users'];

        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page de profil",
            "utilisateur" => $datas,
            "page_javascript" => ['profil.js'],
            "view" => "views/Utilisateur/profil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    
    //fonction deconnexion j'ai supprimer le contenue de la variable globale $_session 
    public function deconnexion()
    {

        Toolbox::ajouterMessageAlerte("La deconnexion est effectuée", Toolbox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        header("Location: " . URL . "accueil");
    }
    
    // dans cette fonction je verifier si le email soumis n'est pas en basse de données 
    public function validation_creerCompte($email, $password, $nom, $prenom, $pays, $telephone)
    {
        if ($this->utilisateurManager->verifLoginDisponible($email)) {
            $passwordCrypte = password_hash($password, PASSWORD_DEFAULT);
            if ($this->utilisateurManager->bdCreerCompte($passwordCrypte, $email, $nom, $prenom, $pays, $telephone,"utilisateur")) {

                Toolbox::ajouterMessageAlerte("La compte a été créé!", Toolbox::COULEUR_VERTE);
                header("Location: " . URL . "login");
            } else {
                Toolbox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencez !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "creerCompte");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "creerCompte");
        }
    }

    public function validation_modificationMail($email)
    {
        if ($this->utilisateurManager->bdModificationMailUser($_SESSION['profil']["id_users"],$email)) {
            
            Toolbox::ajouterMessageAlerte("La modification est effectuée", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("Aucune modification effectuée", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "compte/profil");
    }


    public function modificationPassword(){
        $data_page = [
            "page_description" => "Page de modification mot de passe",
            "page_title" => "Page de modification mot de passe",
            "page_javascript" =>["modificationPassword.js"],
            "view" => "views/Utilisateur/modificationPassword.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function validation_modificationPassword($ancienPassword,$nouveauPassword,$confirmationNouveauPassword){
        if($nouveauPassword === $confirmationNouveauPassword){
            var_dump($_SESSION);
            if($this->utilisateurManager->isCombinaisonValide($_SESSION['profil']['email'],$ancienPassword)){
                $passwordCrypte = password_hash($nouveauPassword,PASSWORD_DEFAULT);
                if($this->utilisateurManager->bdModificationPassword($_SESSION['profil']['email'],$passwordCrypte)){
                    Toolbox::ajouterMessageAlerte("La modification du mot de passe a été effectuée", Toolbox::COULEUR_VERTE);
                    header("Location: ".URL."compte/profil");
                } else {
                    Toolbox::ajouterMessageAlerte("La modification a échouée", Toolbox::COULEUR_ROUGE);
                    header("Location: ".URL."compte/modificationPassword");
                }
            } else {
                Toolbox::ajouterMessageAlerte("La combinaison login / ancien password ne correspond pas", Toolbox::COULEUR_ROUGE);
                // header("Location: ".URL."compte/modificationPassword");
            }            
        } else {
            Toolbox::ajouterMessageAlerte("Les passwords ne correspondent pas", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."compte/modificationPassword");
        }
    }

    
    
    public function suppressionCompte(){
        $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['email']);
        rmdir("public/Assets/images/profils/".$_SESSION['profil']['email']);

        if($this->utilisateurManager->bdSuppressionCompte($_SESSION['profil']['email'])) {
            Toolbox::ajouterMessageAlerte("La suppression du compte est effectuée", Toolbox::COULEUR_VERTE);
            $this->deconnexion();
        } else {
            Toolbox::ajouterMessageAlerte("La suppression n'a pas été effectuée. Contactez l'administrateur",Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."compte/profil");
        }
    }


    public function validation_modificationImage($file){
        try{
            $repertoire = "public/Assets/images/profils/".$_SESSION['profil']['email']."/";
            $nomImage = Toolbox::ajoutImage($file,$repertoire);//ajout image dans le répertoire
            //Supression de l'ancienne image
            $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['email']);
            //Ajout de la nouvelle image dans la BD
            $nomImageBD = "profils/".$_SESSION['profil']['email']."/".$nomImage;
            if($this->utilisateurManager->bdAjoutImage($_SESSION['profil']['email'],$nomImageBD)){
                Toolbox::ajouterMessageAlerte("La modification de l'image est effectuée", Toolbox::COULEUR_VERTE);
            } else {
                Toolbox::ajouterMessageAlerte("La modification de l'image n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
            }
        } catch(Exception $e){
            Toolbox::ajouterMessageAlerte($e->getMessage(), Toolbox::COULEUR_ROUGE);
        }
      
        header("Location: ".URL."compte/profil");
    }

    private function dossierSuppressionImageUtilisateur($email){
        $ancienneImage = $this->utilisateurManager->getImageUtilisateur($_SESSION['profil']['email']);
        if($ancienneImage !== "profils/profil.png"){
            unlink("public/Assets/images/".$ancienneImage);
        }
    }



    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}
