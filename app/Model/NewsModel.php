<?php

namespace CoteInfo\Model;

use PDOException;
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
     * Fonction getArticleIDsByUser
     * paramètre : ID utilisateur
     * résultat : tableau contenant l'ID des articles de l'utilisateur
     */
    public function getArticleIDsByUser(int $userID)
    {
        return $this->dbRequestAll(
            "SELECT `id_news` FROM news WHERE id_user = ?",
            [$userID]
        ) ?? [];
    }

    /*
     * Fonction getPreviews
     * paramètre : tableau d'IDs d'articles, limite d'articles (optionelle)
     * résultat : tableau contenant l'id, le titre, la date et l'id thumbnail des articles demandés
     *            rangés par ordre décroissant de nouveauté
     *            ajoute une limite si choisie
     */
    public function getPreviews(array $ids, int $limit = 0)
    {
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));

        if ($limit !== 0) {
            return $this->dbRequestAll(
                "SELECT `id_news`,`title`,`date_`,`id_thumbnail` FROM news WHERE id_news IN ($placeholders) ORDER BY date_ DESC LIMIT $limit",
                $ids
            ) ?? [];
        } else {
            return $this->dbRequestAll(
                "SELECT `id_news`,`title`,`date_`,`id_thumbnail` FROM news WHERE id_news IN ($placeholders) ORDER BY date_ DESC",
                $ids
            ) ?? [];
        }
    }

    /*
     * Fonction newArticle
     * paramètre : titre, contenu, userID, thumbnailID
     * résultat : créé un nouvel article dans la base de données et retourne son ID
     */
    public function newArticle(string $title, string $content, int $id_user, int $id_thumbnail)
    {
        $fields = ['title', 'content', 'id_user', 'id_thumbnail'];
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
        foreach ($stationIDs as $stationID) {
            $this->dbRequest(
                "INSERT INTO news_station (id_station, id_news) VALUES (?, ?)",
                [intval($stationID), $articleID]
            );
        }
    }

    /*
     * Fonction deleteArticle
     * paramètre : ID de l'article
     * résultat : supprime l'article et ses connections
     *            true si succès, false sinon
     */
    public function delete(int $articleID)
    {
        try {
            $this->dbConnector->beginTransaction();

            $this->dbRequest(
                "DELETE FROM news_images WHERE id_news = ?",
                [intval($articleID)]
            );

            $this->dbRequest(
                "DELETE FROM news_station WHERE id_news = ?",
                [intval($articleID)]
            );

            $this->dbRequest(
                "DELETE FROM news WHERE id_news = ?",
                [intval($articleID)]
            );

            $this->dbConnector->commit();

            return true;
        } catch (PDOException $e) {
            $this->dbConnector->rollBack();
            error_log($e->getMessage());

            return false;
        }
    }
}
