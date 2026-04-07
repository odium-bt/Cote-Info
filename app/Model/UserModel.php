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
        $this->idName = "id_user";
        parent::__construct();
    }

    /*
     * Fonction isEmailUsed
     * paramètres : un email
     * résultat : true - si l'email a été trouvé dans la base de données
     *            false - si l'email n'existe pas dans la base de données
     */
    public function isEmailUsed(string $email)
    {
        // Cherche l'utilisateur par email avec requête paramétrée
        $result = $this->dbRequest(
            "SELECT password FROM " . $this->tableName . " WHERE email = ?",
            [$email]
        );

        return ($result !== null) ? true : false;
    }

    /*
     * Fonction getIdByEmail
     * paramètres : email
     * résultat : donne l'id de l'utilisateur
     */
    public function getIdByEmail(string $email)
    {
        return $this->dbRequest(
            "SELECT " . $this->idName . " FROM `" . $this->tableName . "` WHERE email = ?",
            [$email]
        );
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
     * résultat : true - si l'email et le mot de passe correspondent à un compte existant
     *            false - si l'email n'est pas trouvé ou si le mot de passe associé à l'email ne correspond pas
     */
    public function loginCheck(string $email, string $password)
    {
        // Cherche l'utilisateur par email avec requête paramétrée (sécurité anti-injection)
        $user = $this->dbRequest(
            "SELECT password FROM " . $this->tableName . " WHERE email = ?",
            [$email]
        );

        // Si aucun utilisateur trouvé ou il n'y a pas de mot de passe, échec
        if ($user === null || !isset($user['password'])) {
            return false;
        }

        // Compare le mot de passe clair entré par l'utilisateur avec le hash en base
        if (password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    /*
     * Fonction getAuthors
     * paramètres : tableau d'id utilisateurs
     * résultat : tableau des autheurs avec les avatars et noms d'utilisateurs
     */
    public function getAuthors(array $userIds)
    {
        if (empty($userIds)) {
            return [];
        }

        $placeholders = implode(', ', array_fill(0, count($userIds), '?'));

        return $this->dbRequestAll(
            "SELECT id_user, username, avatar FROM " . $this->tableName . " WHERE id_user IN ($placeholders)",
            $userIds
        ) ?? [];
    }
}
