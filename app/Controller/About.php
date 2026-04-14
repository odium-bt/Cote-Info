<?php

namespace CoteInfo\Controller;
/*
 * Classe About
 * Gère la page A propos
 */

class About
{
    public function __construct()
    {
        require ROOT . "/app/View/about_view.php";
    }
}
