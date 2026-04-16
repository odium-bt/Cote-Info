<?php

namespace CoteInfo\Controller;
/*
 * Classe Route
 * Gère le routage par la méthode $_GET["action"]
*/

class Route
{
    public string $action;

    public function __construct()
    {
        // Récupère $_GET, sinon "accueil" quand vide
        $this->action = $_GET["action"] ?? "home";
        $this->redirigeVers();
    }

    public function redirigeVers()
    {
        // Ferme la session de l'utilisateur si cela fait trop longtemps depuis la dernière activité
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
            session_destroy();
        }
        $_SESSION['last_activity'] = time();

        switch ($this->action) {
            case "home":
                new Home;
                break;
            case "news":
                if (isset($_GET["id"])) {
                    new NewsArticle;
                } else {
                    new News;
                }
                break;
            case "about":
                new About;
                break;
            case "login":
                new Login;
                break;
            case "register":
                new Register;
                break;
            case "user":
                if (isset($_SESSION["user_id"])) {
                    new Profile;
                } else {
                    new Login;
                }
                break;
            case "logout":
                unset($_SESSION["user_id"]);
                unset($_SESSION["is_admin"]);
                new Home;
                break;
            case "station":
                // Si aucun ID station est trouvé, affiche la page 404
                if (isset($_GET["id"])) {
                    new Station;
                } else {
                    new PageNotFound;
                }
                break;
            case "contact":
                new Contact;
                break;
            case "policy":
                new Policy;
                break;
            case "write":
                new NewsWrite;
                break;
            default:
                // Si $_GET["action"] = action non reconnue
                new PageNotFound;
                break;
        }
    }
}
