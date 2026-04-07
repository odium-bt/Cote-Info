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
        return $this->getById($this->id);
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
     * Fonction getArticles
     * paramètre : /
     * résultat : tableau contenant les articles (id, contenu, date, auteur, id thumbnail) associés à la station
     */
    public function getArticles()
    {
        // Cherche les ID news associés à la station
        $newsIDs = $this->dbRequestAll(
            "SELECT id_news FROM rubrique WHERE id_station = ?",
            [$this->id]
        );

        if ($newsIDs === null) {
            return [];
        }

        // Cherche les articles dont les ID sont associés à la station
        $values = array_column($newsIDs, 'id_news');
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        return $this->dbRequestAll(
            "SELECT * FROM news WHERE id_news IN ($placeholders)",
            $values
        ) ?? [];
    }

    /*
     * Fonction getThumbnails
     * paramètre : /
     * résultat : tableau contenant les articles (id, contenu, date, auteur, id thumbnail) associés à la station
     */
    public function getThumbnails($articles)
    {
        if (empty($articles)) {
            return [];
        }
        // Cherche les ID news associés à la station
        $thumbnailIDs = array_column($articles, 'id_thumbnail');


        $placeholders = implode(', ', array_fill(0, count($thumbnailIDs), '?'));

        return $this->dbRequestAll(
            "SELECT * FROM media WHERE id_media IN ($placeholders)",
            $thumbnailIDs
        ) ?? [];
    }

    /*
     * Fonction getCommentsFromStation
     * paramètre : /
     * résultat : commentaires associés à la station
     */
    public function getComments()
    {
        return $this->dbRequestAll(
            "SELECT * FROM comments WHERE id_station = ?",
            [$this->id]
        ) ?? [];
    }

    /*
     * Fonction getCommentsWithAuthors
     * paramètre : /
     * résultat : commentaires avec les auteurs associés
     */
    public function getCommentsWithAuthors()
    {
        $comments = $this->getComments();
        if (empty($comments)) {
            return [];
        }

        $userIds = array_column($comments, 'id_user');
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
