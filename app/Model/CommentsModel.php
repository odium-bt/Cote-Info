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
    public function getCommentsByStation($stationID)
    {
        if (empty($stationID)) {
            return [];
        }

        return $this->dbRequestAll(
            "SELECT * FROM comments WHERE id_station = ?",
            [$stationID]
        ) ?? [];
    }
}
