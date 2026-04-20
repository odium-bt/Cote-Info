<?php

namespace CoteInfo\Model;

use CoteInfo\Model\NotesModel;
/*
 * Classe CommentsModel
 * Gère les requêtes BDD pour les commentaires
 */

class CommentsModel extends Model
{
    public function __construct()
    {
        $this->tableName = "comments";
        $this->idName = 'id_comment';
        parent::__construct();
    }


    /*
     * Fonction getCommentsByStation
     * paramètre : id de la station
     * résultat : commentaires associés à la station
     */
    public function getCommentsByStation(int $stationID)
    {
        if (empty($stationID)) {
            return [];
        }

        return $this->dbRequestAll(
            "SELECT * FROM comments WHERE id_station = ? AND is_deleted = 0",
            [$stationID]
        ) ?? [];
    }

    /*
     * Fonction getCommentsByUser
     * paramètre : id de l'utilisateur
     * résultat : commentaires postés par l'utilisateur
     */
    public function getCommentsByUser(int $userID)
    {
        if (empty($userID)) {
            return [];
        }

        return $this->dbRequestAll(
            "SELECT * FROM comments WHERE id_user = ? AND is_deleted = 0",
            [$userID]
        ) ?? [];
    }

    /*
     * Fonction saveComment
     * paramètre : id utilisateur
     * résultat : enregistre un nouveau commentaire
     */
    public function saveComment(string $content, int $stationID, int $IDuser)
    {
        $fields = ['content', 'id_station', 'id_user'];
        $values = [$content, $stationID, $IDuser];

        return $this->save($fields, $values);
    }

    /*
     * Fonction setDeleted
     * paramètre : ID commentaire et ID utilisateur
     * résultat : Marque le commentaire comme supprimé
     */
    public function setDeleted(int $IDcomment, int $IDuser)
    {
        $comment = $this->getById($IDcomment);
        if ($IDuser === $comment["id_user"] || $_SESSION["is_admin"] === true) { // Vérifie que l'utilisateur à l'origine de la requête soit l'auteur du commentaire OU est admin
            $this->dbRequest(
                "UPDATE `comments` SET `is_deleted` = 1 WHERE `id_comment` = ?",
                [$IDcomment]
            );
            return true;
        } else {
            return false;
        }
    }

    /*
     * Fonction setNotDeleted
     * paramètre : ID commentaire et ID utilisateur
     * résultat : Marque le commentaire comme non supprimé
     */
    public function setNotDeleted(int $IDcomment, int $IDuser)
    {
        $comment = $this->getById($IDcomment);

        if ($IDuser === $comment["id_user"] || $_SESSION["is_admin"] === true) { // Vérifie que l'utilisateur à l'origine de la requête soit l'auteur du commentaire OU est admin
            $this->dbRequest(
                "UPDATE `comments` SET `is_deleted` = 0 WHERE `id_comment` = ?",
                [$IDcomment]
            );
            return true;
        } else {
            return false;
        }
    }
}
