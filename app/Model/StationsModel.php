<?php

namespace CoteInfo\Model;

use PDOException;
use CoteInfo\Model\UserModel;
use CoteInfo\Model\NotesModel;

/*
 * Classe StationModel
 * Gère les requêtes BDD pour les stations balnéaires
 */

class StationsModel extends Model
{
    protected $id;
    public function __construct($id = null)
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
        if (empty($mediaIDs)) {
            return [];
        }

        $values = array_column($mediaIDs, 'id_media');
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        return $this->dbRequestAll(
            "SELECT * FROM media WHERE id_media IN ($placeholders)",
            $values
        );
    }

    /*
     * Fonction getArticlePreviews
     * paramètre : /
     * résultat : tableau contenant un preview des articles associés à la station
     */
    public function getArticlePreviews()
    {
        // Cherche les ID des articles de news associés à la station

        $newsIDs = $this->dbRequestAll(
            "SELECT id_news FROM news_station WHERE id_station = ?",
            [$this->id]
        );

        if (empty($newsIDs)) {
            return [];
        }

        $articleIDs = array_column($newsIDs, 'id_news');
        if (empty($articleIDs)) {
            return [];
        }

        // Va chercher les infos dans la table news
        $newsModel = new NewsModel;
        $articles = $newsModel->getBeachPreviews($articleIDs);

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
        unset($article);

        return $articles;
    }

    /*
     * Fonction getCommentsWithAuthorsAndNotes
     * paramètre : /
     * résultat : commentaires de la page avec les auteurs et les notes associées
     */
    public function getCommentsWithAuthorsAndNotes()
    {
        // Appelle CommentsModel pour récupérer les commentaires associés à la page
        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getCommentsByStation($this->id) ?? [];
        if (empty($comments)) {
            return [];
        }

        // $comments = {[0]=>{["id_comment"]=>int["content"]=>string["date"]=>string["id_station"]=>int["id_user"]=>int} [1]=>{etc}}


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
        unset($comment);

        // Ajoute la note donnée à la station par les utilisateurs
        if (!isset($notesModel)) {
            $notesModel = new NotesModel();
        }
        $notes = $notesModel->getNoteForComments($comments);
        $comments = $notesModel->linkNotes($comments, $notes);

        return $comments;
    }

    /*
     * Fonction getStationsByRegion
     * paramètre : id de la région
     * résultat : tableau des stations de la région
     */
    public function getStationsByRegion(int $regionId)
    {
        return $this->dbRequestAll(
            "SELECT id_station, label FROM " . $this->tableName . " WHERE id_region = ?",
            [$regionId]
        );
    }
}
