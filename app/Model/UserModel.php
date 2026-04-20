<?php

namespace CoteInfo\Model;

use PDOException;

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
     * Fonction isAdmin
     * paramètres : id utilisateur
     * résultat : true si admin, false si pas admin
     */
    public function isAdmin(int $id)
    {
        $result = $this->dbRequest(
            "SELECT `is_admin` FROM `users` WHERE id_user = ?",
            [$id]
        );

        return is_array($result) && isset($result['is_admin']) ? (bool)$result['is_admin'] : false;
    }

    /*
     * Fonction isCurrentAdmin
     * paramètre : /
     * résultat : check le statut admin de l'utilisateur actif
     */
    public function isCurrentAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $isAdmin = $this->isAdmin($_SESSION['user_id']);
        if ($isAdmin === true) {
            $_SESSION['is_admin'] = true;
        } else {
            $_SESSION['is_admin'] = false;
        }
        return $isAdmin;
    }


    /*
     * Fonction getIdByEmail
     * paramètres : email
     * résultat : donne l'id de l'utilisateur
     */
    public function getIdByEmail(string $email)
    {
        $result = $this->dbRequest(
            "SELECT `" . $this->idName . "` FROM `" . $this->tableName . "` WHERE email = ?",
            [$email]
        );

        return is_array($result) && isset($result[$this->idName]) ? (int)$result[$this->idName] : null;
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
     * Fonction getPasswordByEmail
     * paramètres : email
     * résultat : mot de passe lié à l'email
     */
    public function getPasswordByEmail(string $email)
    {
        return $this->dbRequest(
            "SELECT password FROM " . $this->tableName . " WHERE email = ?",
            [$email]
        ) ?? null;
    }
    /*
     * Fonction loginCheck
     * paramètres : l'email et le mot de passe entrés par l'utilisateur
     * résultat : true - si l'email et le mot de passe correspondent à un compte existant
     *            false - si l'email n'est pas trouvé ou si le mot de passe associé à l'email ne correspond pas
     */
    public function loginCheck(string $email, string $password)
    {
        // Cherche un mot de passe correspondant à l'email
        $user = $this->getPasswordByEmail($email);

        // Si rien n'est trouvé, retourne false
        if ($user === null) {
            return false;
        }

        // Le résultat doit être un tableau contenant la clé 'password'
        if (!is_array($user) || !isset($user['password'])) {
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

    /*
     * Fonction updateAvatar
     * paramètres : id utilisateur, nom du fichier avatar
     * résultat : true si mise à jour réussie, false sinon
     */
    public function updateAvatar(int $userId, string $fileName)
    {
        $this->dbRequest(
            "UPDATE " . $this->tableName . " SET avatar = ? WHERE " . $this->idName . " = ?",
            [$fileName, $userId]
        );
    }

    /*
     * Fonction getEmailByID
     * paramètres : id utilisateur
     * résultat : supprime le compte de l'utilisateur
     */
    public function getEmailByID(int $userID)
    {
        return $this->dbRequest(
            "SELECT email FROM " . $this->tableName . " WHERE id_user = ?",
            [$userID]
        );
    }

    /*
     * Fonction deleteAccount
     * paramètres : id utilisateur
     * résultat : supprime le compte de l'utilisateur
     */
    public function deleteAccount(int $userID)
    {
        try {
            $this->dbRequest(
                "DELETE FROM " . $this->tableName . " WHERE id_user = ?",
                [$userID]
            );
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
