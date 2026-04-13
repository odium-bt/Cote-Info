<?php

namespace CoteInfo\Controller;
/*
 * Classe Policy
 * Gère la page Politique de Confidentialité
 */

class Policy
{
    public function __construct()
    {
        require ROOT . "/app/View/policy_view.php";
        require ROOT . "/app/View/footer_view.php";
    }
}
