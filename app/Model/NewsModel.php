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
     * paramètre : tableau d'IDs d'articles
     * résultat : tableau contenant l'id, le titre, la date et l'id thumbnail des articles demandés, avec une limite de 6, par ordre décroissant de nouveauté
     */
    public function getPreviews(array $ids)
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
    public function getThumbnails(array $articles)
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

    /*
     * Fonction newArticle
     * paramètre : titre, contenu, userID, thumbnailID
     * résultat : créé un nouvel article dans la base de données et retourne son ID
     */
    public function newArticle(string $title, string $content, int $id_user, int $id_thumbnail)
    {
        $fields = [`title`, `content`, `id_user`, `id_thumbnail`];
        $values = [$title, $content, $id_user, $id_thumbnail];

        return $this->save($fields, $values);
    }

    /*
     * Fonction connect
     * paramètre : ID des stations liées à l'article, ID de l'article
     * résultat : insère les connexions entre l'article et les stations associées dans la table news_station
     */
    public function connect(array $stationIDs, int $articleID)
    {
        $fields = [`id_station`, `id_news`];
        $values = [];
        foreach ($stationIDs as $value) {
            array_push($values, array($value, $articleID));
        };

        $this->save($fields, $values);
    }
}
