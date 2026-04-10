<?php

namespace CoteInfo\Model;
/*
 * Classe NewsModel
 * Gère les requêtes BDD pour les articles d'actualités
 */

class NewsModel extends Model
{
    public function __construct()
    {
        $this->tableName = "news";
        $this->idName = 'id_news';
        parent::__construct();
    }


    /*
     * Fonction getPreviews
     * paramètre : tableau d'ids
     * résultat : tableau contenant l'id, le titre, la date et l'id thumbnail des articles demandés
     */
    public function getPreviews($ids)
    {
        // Cherche les articles dont les ID sont associés à la station
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));

        return $this->dbRequestAll(
            "SELECT `id_news`,`title`,`date_`,`id_thumbnail` FROM news WHERE id_news IN ($placeholders)",
            $ids
        ) ?? [];
    }
}
