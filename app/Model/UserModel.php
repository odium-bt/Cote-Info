<?php

namespace CoteInfo\Model;
/*
 * Classe UserModel
 * Gère les requêtes DBB sur la table users
 */

class UserModel extends Model
{
    public function __construct()
    {
        $this->tableName = "users";
        parent::__construct();
    }


    public function isEmailUsed(string $email)
    {
        if (null !== (
            $this->dbRequest(
                "SELECT email FROM " . $this->tableName . " WHERE email = '$email'",
            )
        )) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Fonction registerUser
     * paramètres : le nom d'utilisateur, email et mot de passe donnés par l'utilisateur
     * résultat : /
     */
    public function registerUser(string $username, string $email, string $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->save(['username', 'email', 'password'], [$username, $email, $hash]);
    }

    /*
     * Fonction loginCheck
     * paramètres : l'email et le mot de passe entrés par l'utilisateur
     * résultat : booléen (email et mot de passe correspondent à un compte existant = true)
     */
    public function loginCheck($email, $password)
    {
        if (null !== ($this->dbRequest("SELECT email FROM " . $this->tableName . " WHERE email = '$email'"))) {
            $hash = $this->dbRequest("SELECT password FROM" . $this->tableName . "WHERE email = '$email'");
            if (password_verify($password, $hash) === true) {
                return true;
            } else {
                return false;
            }
        }
    }
}
