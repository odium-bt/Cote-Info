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
        $this->tableName = "USER";
        parent::__construct();
    }

    public function registerUser($username, $email, $password){

        $this->save(['username', 'email', 'password'], [$username, $email, $password]);
    }
}
