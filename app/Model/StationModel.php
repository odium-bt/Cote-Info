<?php

namespace CoteInfo\Model;

use CoteInfo\Model\UserModel;

/*
 * Classe StationModel
 * Gère les requêtes BDD pour les articles stations balnéaires
 */

class StationModel extends Model
{
    protected $id;
    public function __construct($id)
    {
        $this->tableName = "beaches";
        $this->idName = 'id_station';
        $this->id = $id;
        parent::__construct();
    }


    /*
     * Fonction getBeach
     * paramètre : /
     * résultat : propriétés de la station
     */
    public function getBeach()
    {
        return $this->getById($this->id) ?? [];
    }

    /*
     * Fonction getMedia
     * paramètre : /
     * résultat : tableau contenant les médias (id, chemin, alt, légende, id région) associés à la station
     */
    public function getMedia()
    {
        // Cherche les ID médias associés à la station
        $mediaIDs = $this->dbRequestAll(
            "SELECT id_media FROM station_images WHERE id_station = ?",
            [$this->id]
        );

        if ($mediaIDs === null) {
            return [];
        }

        $values = array_column($mediaIDs, 'id_media');
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        return $this->dbRequestAll(
            "SELECT * FROM media WHERE id_media IN ($placeholders)",
            $values
        ) ?? [];
    }

    /*
     * Fonction getArticlePreviews
     * paramètre : /
     * résultat : tableau contenant un preview des articles associés à la station
     */
    public function getArticlePreviews()
    {
        // Cherche les ID news associés à la station
        $newsIDs = $this->dbRequestAll(
            "SELECT id_news FROM rubrique WHERE id_station = ?",
            [$this->id]
        );

        if ($newsIDs === null) {
            return [];
        }

        $articleIDs = array_column($newsIDs, 'id_news');
        if (empty($articleIDs)) {
            return [];
        }

        // Cherche les articles dont les ID sont associés à la station
        $placeholders = implode(', ', array_fill(0, count($articleIDs), '?'));
        $articles = $this->dbRequestAll(
            "SELECT `id_news`,`title`,`date_`,`id_thumbnail` FROM news WHERE id_news IN ($placeholders)",
            $articleIDs
        );
        if ($articles === null) {
            return [];
        }

        $thumbnailIDs = array_column($articles, 'id_thumbnail');
        if (empty($thumbnailIDs)) {
            return $articles;
        }
        // Va chercher les données des images thumbnails sur la table media
        $thumbPlaceholders = implode(', ', array_fill(0, count($thumbnailIDs), '?'));
        $thumbnails = $this->dbRequestAll(
            "SELECT `id_media`,`path`,`alt`,`legend` FROM media WHERE id_media IN ($thumbPlaceholders)",
            $thumbnailIDs
        );

        if ($thumbnails === null) {
            $thumbnails = [];
        }


        $thumbnailsById = [];
        foreach ($thumbnails as $thumbnail) {
            $thumbnailsById[$thumbnail['id_media']] = $thumbnail;
        }
        // Range les thumbnails dans leurs articles
        foreach ($articles as &$article) {
            $article['thumbnail'] = $thumbnailsById[$article['id_thumbnail']] ?? null;
        }

        return $articles;
    }

    /*
     * Fonction getCommentsWithAuthors
     * paramètre : /
     * résultat : commentaires de la page avec les auteurs associés
     */
    public function getCommentsWithAuthors()
    {
        // Appelle CommentsModel pour récupérer les commentaires associés à la page
        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getCommentsByStation($this->id) ?? [];
        if (empty($comments)) {
            return [];
        }

        // $comments = array (?){[0]=> {["id_news"]=>(2)["title"]=>(9)} [1]=>{etc}}

        // Assigne une variable avec les id des auteurs
        $userIds = array_column($comments, 'id_user');
        // Appelle UserModel pour récupérer les noms et avatars des auteurs des commentaires
        $userModel = new UserModel();
        $authors = $userModel->getAuthors($userIds);

        // Indexe les utilisateurs par leur id
        $authorsById = [];
        foreach ($authors as $author) {
            $authorsById[$author['id_user']] = $author;
        }

        // Fustionne les données des auteurs avec leurs commentaires
        foreach ($comments as &$comment) {
            $comment['author'] = $authorsById[$comment['id_user']] ?? null;
        }

        return $comments;
    }
}
