<?php

namespace CoteInfo\Controller;
/*
 * Classe PermissionDenied
 * Gère la page 404
 */

class PermissionDenied
{
    public function __construct()
    {
        require ROOT . "/app/View/denied_view.php";
    }
}
