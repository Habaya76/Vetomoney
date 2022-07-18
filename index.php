
<?php
session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));

require_once("./controllers/Toolbox.class.php");
require_once("./controllers/Securite.class.php");
require_once("./controllers/Visiteur/Visiteur.controller.php");
require_once("./controllers/Utilisateur/Utilisateur.controller.php");
require_once("./controllers/Administrateur/Administrateur.controller.php");
$visiteurController = new VisiteurController();
$utilisateurController = new UtilisateurController();
$administrateurController = new AdministrateurController();

try {
    if (empty($_GET['page'])) {
        $page = "accueil";
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        $page = $url[0];
    }

    switch ($page) {
        case "accueil":
            $visiteurController->accueil();
            break;
            
        case "login":
            $visiteurController->login();
            break;


        case "validation_login":
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = Securite::secureHTML($_POST['email']);
                $password = Securite::secureHTML($_POST['password']);
                $utilisateurController->validation_login($email, $password);
            } else {
                Toolbox::ajouterMessageAlerte("email ou mot de passe non renseigné", Toolbox::COULEUR_ROUGE);
                header('Location: ' . URL . "login");
            }
            break;



        case "creerCompte":
            $visiteurController->creerCompte();
            break;

        

            // je verifie est ce que ces information auron soumisent si une de ces informations non pas soumisent alors je refuse la validation du compte et on demande a l'utilisateur de recreer un compte
        case "validation_creerCompte":
            if (
                !empty($_POST['email']) && !empty($_POST['password'])
                && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pays']) && !empty($_POST['telephone'])
            ) {
                $email = Securite::secureHTML($_POST['email']);
                $password = Securite::secureHTML($_POST['password']);
                $nom = Securite::secureHTML($_POST['nom']);
                $prenom = Securite::secureHTML($_POST['prenom']);
                $pays = Securite::secureHTML($_POST['pays']);
                $telephone = Securite::secureHTML($_POST['telephone']);
                $utilisateurController->validation_creerCompte($email, $password, $nom, $prenom, $pays, $telephone);
            } else {
                Toolbox::ajouterMessageAlerte("Les informations sont obligatoires !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "creerCompte");
            }
            break;


        case "compte":
            //  verification si l'utilisateur est connecter ou non
            if (!Securite::estConnecte()) {
                Toolbox::ajouterMessageAlerte("veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
                header('Location: ' . URL . "login");
            } else {
                switch ($url[1]) {
                    case "profil":
                        $utilisateurController->profil();
                        break;
                        // la deconnexion 
                    case "deconnexion":
                        $utilisateurController->deconnexion();
                        break;
                        
                    case "validation_modificationMail":
                        $utilisateurController->validation_modificationMail(Securite::secureHTML($_POST['email']));
                        break;


                    case "modificationPassword":
                        $utilisateurController->modificationPassword();
                        break;
                    case "validation_modificationPassword":
                        // je verifie si l'ancien password est rensegner est ce que le nouveau password est rensegné et confirmation aussi
                        if (!empty($_POST['ancienPassword']) && !empty($_POST['nouveauPassword']) && !empty($_POST['confirmNouveauPassword'])) {
                            $ancienPassword = Securite::secureHTML($_POST['ancienPassword']);
                            $nouveauPassword = Securite::secureHTML($_POST['nouveauPassword']);
                            $confirmationNouveauPassword = Securite::secureHTML($_POST['confirmNouveauPassword']);
                            $utilisateurController->validation_modificationPassword($ancienPassword, $nouveauPassword, $confirmationNouveauPassword);
                        } else {
                            Toolbox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "compte/modificationPassword");
                        }
                        break;


                    case "suppressionCompte":
                        $utilisateurController->suppressionCompte();
                        break;
                    case "validation_modificationImage":
                        if ($_FILES['image']['size'] > 0) {
                            $utilisateurController->validation_modificationImage($_FILES['image']);
                        } else {
                            Toolbox::ajouterMessageAlerte("Vous n'avez pas modifié l'image", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "compte/profil");
                        }
                        break;
                    default:
                        throw new Exception("La page n'existe pas");
                }
            }

            break;


        case "administration":
            if (!Securite::estConnecte()) {
                Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "Login");
            } elseif (!Securite::estAdministrateur()) {
                Toolbox::ajouterMessageAlerte("Vous n'avez le droit d'être ici", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "accueil");
            } else {
                switch ($url[1]) {
                    case "droits":
                        $administrateurController->droits();
                        break;
                    case "validation_modificationRole":
                        $administrateurController->validation_modificationRole($_POST['email'], $_POST['role']);
                        break;
                    default:
                        throw new Exception("La page n'existe pas");
                }
            }
            break;
        default:
            throw new Exception("La page n'existe pas");
    }
} catch (Exception $e) {
    $visiteurController->pageErreur($e->getMessage());
}
