<?php
require_once("./models/MainManager.model.php");

class UtilisateurManager extends MainManager
{

    private function getPasswordUser($email)
    {
        $req = "SELECT password FROM users WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat['password'];
    }

    public function isCombinaisonValide($email, $password)
    {
        $passwordBD = $this->getPasswordUser($email);
        return password_verify($password, $passwordBD);
    }

    public function estCompteActive($email)
    {
        $req = "SELECT est_valide FROM users WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return ((int)$resultat['est_valide'] === 1) ? true : false;
    }

    public function getUserInformation($email)
    {
        $req = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat;
    }
    
    public function bdCreerCompte($passwordCrypte, $email, $nom, $prenom, $pays, $telephone,$role)
    {
        $req = "INSERT INTO `users`(`nom`, `prenom`, `pays`, `telephone`, `email`, `est_valide`, `clef`, `password`, `role`, `image`)
        VALUES (:nom, :prenom, :pays, :telephone, :email, 0, 1, :password, :role, '')";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":password", $passwordCrypte, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
        $stmt->bindValue(":pays", $pays, PDO::PARAM_STR);
        $stmt->bindValue(":telephone", $telephone, PDO::PARAM_STR);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    public function bdModificationMailUser($id_users, $email)
    {
        $req = "UPDATE users set email = :email WHERE id_users= :id_users";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_users", $id_users, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }
    public function bdModificationPassword($email,$password){
        $req = "UPDATE users set password = :password WHERE email= :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $stmt->bindValue(":password",$password,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }
    public function bdSuppressionCompte($email){
        $req="DELETE FROM users WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }
    public function bdAjoutImage($email,$image){
        $req = "UPDATE users set image = :image WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    public function getImageUtilisateur($email){
        $req = "SELECT image FROM users WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat['image'];
    }
    public function verifLoginDisponible($email)
    {
        $utilisateur = $this->getUserInformation($email);
        return empty($utilisateur);
    }
}
