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
     * résultat : tableau contenant l'id, le titre, la date et l'id thumbnail des articles demandés, avec une limite de 6, par ordre décroissant de nouveauté
     */
    public function getPreviews($ids)
    {
        // Cherche les articles dont les ID sont associés à la station
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));

        return $this->dbRequestAll(
            "SELECT `id_news`,`title`,`date_`,`id_thumbnail` FROM news WHERE id_news IN ($placeholders) ORDER BY date_ DESC LIMIT 6",
            $ids
        ) ?? [];
    }

    /*
     * Fonction getPreviews
     * paramètre : tableau d'ids
     * résultat : tableau contenant l'id, le titre, la date et l'id thumbnail des articles demandés
     */
    public function getThumbnails($articles)
    {
        $thumbnailIDs = array_column($articles, 'id_thumbnail');
        if (empty($thumbnailIDs)) {
            return $articles;
        }

        // Va chercher les infos dans la table media
        $mediaModel = new MediaModel;
        $thumbnails = $mediaModel->getMedias($thumbnailIDs);

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
