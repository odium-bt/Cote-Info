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

    /*
     * Fonction getMediaID
     * paramètre : nom du fichier
     * résultat : ID du fichier en base
     */
    public function getMediaID($filename)
    {
        return $this->dbRequest(
            "SELECT `id_media` FROM `media` WHERE `path` = ?",
            [$filename]
        );
    }

    /*
     * Fonction getThumbnails
     * paramètre : tableau d'ids
     * résultat : tableau contenant l'id, le nom de fichier, l'alt et la légende des articles et les range dans le tableau articles
     */
    public function getThumbnails(array $articles)
    {
        $thumbnailIDs = array_column($articles, 'id_thumbnail');
        if (empty($thumbnailIDs)) {
            return $articles;
        }

        // Va chercher les infos dans la table media
        $thumbnails = $this->getMedias($thumbnailIDs);

        // Range les thumbnails par leur IDs dans $thumbnailsByID
        $thumbnailsByID = [];
        foreach ($thumbnails as $thumbnail) {
            $thumbnailsByID[$thumbnail['id_media']] = $thumbnail;
        }
        // Range les thumbnails dans leurs articles
        foreach ($articles as &$article) {
            $article['thumbnail'] = $thumbnailsByID[$article['id_thumbnail']] ?? null;
        }

        return $articles;
    }
}
