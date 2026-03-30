<?php
namespace CoteInfo\Controller;
/*
 * Classe Route
 * Gère le routage par la méthode $_GET["action"]
 */
class RouteCtl
{
    public $action;

    public function __construct()
    {
        // Récupère $_GET, sinon "accueil" quand vide
        $this->action = $_GET["action"] ?? "accueil";
    }

    public function redirigeVers()
    {
        switch ($this->action) {
            case "accueil":
                require __DIR__ . "/Controller/IntroCtl.php";
                break;
            case "page1":
                require __DIR__ . "/Controller/page1_ctl.php";
                break;
            default:
                // Si $_GET["action"] = action non reconnue
                require __DIR__ . "/Controller/404_ctl.php";
                break;
        }
    }
}