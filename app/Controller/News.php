<?php
namespace CoteInfo\Controller;
/*
 * Classe News
 * Gère la page des actualités
 */
class News
{
    public function __construct()
    {
        require ROOT . "/app/View/news_view.php";
    }
}
