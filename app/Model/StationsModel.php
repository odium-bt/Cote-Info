<?php

namespace CoteInfo\Model;

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
        // Cherche les ID des articles de news associés à la station
        $newsIDs = $this->dbRequestAll(
            "SELECT id_news FROM news_station WHERE id_station = ?",
            [$this->id]
        );

        if ($newsIDs === null) {
            return [];
        }

        $articleIDs = array_column($newsIDs, 'id_news');
        if (empty($articleIDs)) {
            return [];
        }

        // Va chercher les infos dans la table news
        $newsModel = new NewsModel;
        $articles = $newsModel->getPreviews($articleIDs);

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
     * Fonction getCommentsWithAuthors
     * paramètre : /
     * résultat : commentaires de la page avec les auteurs associés
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

        // Ajoute la note donnée à la station par les utilisateurs
        $notesModel = new NotesModel();
        foreach ($comments as &$comment) {
            $noteID = $notesModel->getNoteByUserAndStation($comment['id_user'], $comment['id_station']);
            if ($noteID !== null) {
                $note = $notesModel->getNote($noteID);
                $comment['note'] = $note['value_'] ?? null;
            } else {
                $comment['note'] = null;
            }
        }

        return $comments;
    }
}
