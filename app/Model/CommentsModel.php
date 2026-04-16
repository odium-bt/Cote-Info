<?php

namespace CoteInfo\Model;
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
            "SELECT * FROM comments WHERE id_station = ?",
            [$stationID]
        ) ?? [];
    }

    /*
     * Fonction saveComment
     * paramètre : id utilisateur
     * résultat : enregistre un nouveau commentaire
     */
    public function saveComment(string $content, int $idStation, int $idUser)
    {
        $fields = ['content', 'id_station', 'id_user'];
        $values = [$content, $idStation, $idUser];

        return $this->save($fields, $values);
    }

    /*
     * Fonction setDeleted
     * paramètre : id utilisateur
     * résultat : enregistre un nouveau commentaire
     */
    public function setDeleted(int $idComment, int $idUser)
    {
        $comment = $this->getById($idComment);

        if ($idUser === $comment["id_user" || $_SESSION["is_admin" === true]]) { // Vérifie que l'utilisateur à l'origine de la requête soit l'auteur du commentaire OU est admin
            // Marque le commentaire comme supprimé
            $this->dbRequest(
                "UPDATE `comments` SET `is_deleted` = 1 WHERE `id_comment` = ?",
                [$idComment]
            );
            return true;
        } else {
            return false;
        }
    }

    /*
     * Fonction setNotDeleted
     * paramètre : id utilisateur
     * résultat : enregistre un nouveau commentaire
     */
    public function setNotDeleted(int $idComment, int $idUser)
    {
        $comment = $this->getById($idComment);

        if ($idUser === $comment["id_user"] || $_SESSION["is_admin" === true]) { // Vérifie que l'utilisateur à l'origine de la requête soit l'auteur du commentaire OU est admin
            // Marque le commentaire comme non supprimé
            $this->dbRequest(
                "UPDATE `comments` SET `is_deleted` = 1 WHERE `id_comment` = ?",
                [$idComment]
            );
            return true;
        } else {
            return false;
        }
    }
}
