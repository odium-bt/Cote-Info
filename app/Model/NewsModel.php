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
}
