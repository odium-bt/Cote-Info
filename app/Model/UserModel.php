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


    public function isEmailUsed($email)
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

    public function registerUser($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->save(['username', 'email', 'password'], [$username, $email, $hash]);
    }
}
