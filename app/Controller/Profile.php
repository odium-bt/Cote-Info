<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Classe Profile
 * Gère la page du profil utilisateur
 * Requête à la base de données :
 */

class Profile
{
    protected int $userID;
    protected bool $isAdmin;

    protected array $user;

    public function __construct()
    {
        $userModel = new UserModel;

        $this->userID = $_SESSION['user_id'] ?? null;
        $this->isAdmin = $userModel->isAdmin($this->userID) ?? false;

        $this->user = $userModel->getById($this->userID);

        require ROOT . "/app/View/user_view.php";
    }
}
