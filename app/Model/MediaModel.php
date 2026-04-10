<?php

namespace CoteInfo\Model;
/*
 * Classe MediaModel
 * Gère les requêtes BDD pour les médias
 */

class MediaModel extends Model
{
    public function __construct()
    {
        $this->tableName = "media";
        $this->idName = 'id_media';
        parent::__construct();
    }

    /*
     * Fonction getArticlePreviews
     * paramètre : tableau d'IDs
     * résultat : tableau contenant l'id, le filename, l'alt et la légende des thumbnails demandés
     */
    public function getMedias($ids)
    {
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));
        return $this->dbRequestAll(
            "SELECT `id_media`,`path`,`alt`,`legend` FROM media WHERE id_media IN ($placeholders)",
            $ids
        ) ?? [];
    }
}
