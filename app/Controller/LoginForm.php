<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Contrôle de qualité du formulaire de connexion
 * Filtre les champs avant de refuser ou valider une connexion utilisateur
 */

class LoginForm
{
    public $errors = [];
    protected string $email;
    protected string $password;
    protected int $counter = 0;

    public function __construct()
    {
        // Contrôle de qualité (trouve les erreurs et ajoute les messages dans le tableau $errors)
        if (!empty($_POST)) {
            foreach ($_POST as $key => $post_element) {
                switch ($key) {
                    case 'email':
                        $this->email = htmlspecialchars(trim($_POST['email'])) ?? null;
                        break;
                    case 'password':
                        $this->password = htmlspecialchars(trim($_POST['password'])) ?? null;
                        break;
                }
            }

            // Email
            if (!$this->email) {
                $this->errors['email'] = "Requis";
            }
            // Mot de passe
            if (!$this->password) {
                $this->errors['password'] = "Requis";
            }

            $user = new UserModel;

            $user->loginCheck($this->email, $this->password);


            // ============ Sortie
            // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
            if (empty($_POST) || !empty($this->errors)) {
                require ROOT . '/vue/connexion_succes_vue.php'; // affiche page succès
            } else {

                $this->errors['email'] = "Cette adresse existe déjà";
                require ROOT . '/app/View/connexion_view.php'; // Retour au formulaire
            }
            // Email


            // Mot de passe


        }


        // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
        if (empty($_POST) || !empty($this->errors)) {
            require ROOT . '/app/View/connexion_view.php';
        }
        // Sinon $_POST est rempli sans erreurs
        else {
        }
        // ============
    }
}
