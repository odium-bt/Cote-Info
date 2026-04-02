<?php

namespace CoteInfo\Controller;

use CoteInfo\Model\UserModel;
/*
 * Contrôle de qualité du formulaire d'inscription
 * Filtre tous les champs avant de refuser ou valider l'inscription d'un nouvel utilisateur
 */

class RegisterForm
{
    public $errors = [];
    protected string $username;
    protected string $email;
    protected string $emailConfirm;
    protected string $password;
    protected string $passwordConfirm;

    public function __construct()
    {
        // Contrôle de qualité (trouve les erreurs et ajoute les messages dans le tableau $errors)
        if (!empty($_POST)) {
            foreach ($_POST as $key => $post_element) {
                switch ($key) {
                    case 'username':
                        $this->username = htmlspecialchars(trim($_POST['username'])) ?? null;
                        break;
                    case 'email':
                        $this->email = htmlspecialchars(trim($_POST['email'])) ?? null;
                        break;
                    case 'email-confirm':
                        $this->emailConfirm = htmlspecialchars(trim($_POST['email-confirm'])) ?? null;
                    case 'password':
                        $this->password = htmlspecialchars(trim($_POST['password'])) ?? null;
                        break;
                    case 'password-confirm':
                        $this->passwordConfirm = htmlspecialchars(trim($_POST['password-confirm'])) ?? null;
                }
            }

            // Nom d'utilisateur
            if (!$this->username) {
                $this->errors['username'] = "Requis";
            } else  if (strlen($this->username) < 3) {
                $this->errors['username'] = "Au moins 3 caractères";
            } else if (strlen($this->username) > 100) {
                $this->errors['username'] = "Moins de 100 caractères";
            }
            // Email
            if (!$this->email) {
                $this->errors['email'] = "Requis";
            } else if (strlen(($this->email)) > 254) {
                $this->errors['email'] = "L'adresse entrée est trop longue";
            } else if ($this->checkEmail() == false) {
                $this->errors['email'] = "Veuillez entrer une adresse email valide";
            }
            // Confirmation d'email
            if (!$this->emailConfirm) {
                $this->errors['email-confirm'] = "Requis";
            } else if ($this->email != $this->emailConfirm) {
                $this->errors['email-confirm'] = "Les email entrés ne sont pas identiques";
            }
            // Mot de passe
            if (!$this->password) {
                $this->errors['password'] = "Requis";
            } else if (strlen($this->password) <= 12) {
                $this->errors['password'] = "Veuillez choisir un mot de passe de plus de 12 caractères";
            } else if (strlen($this->password) >= 128) {
                $this->errors['password'] = "Veuillez choisir un mot de passe de moins de 128 caractères";
            }
            // Confirmation du mot de passe
            if (!$this->passwordConfirm) {
                $this->errors['password-confirm'] = "Requis";
            } else if ($this->password != $this->passwordConfirm) {
                $this->errors['password-confirm'] = "Les mots de passe entrés ne sont pas identiques";
            }
        }

        // ============ Sortie
        // Si $_POST est vide (début) ou qu'il y a des erreurs, affiche le formulaire
        if (empty($_POST) || !empty($this->errors)) {
            require ROOT . '/app/View/inscription_view.php';
        }
        // Sinon $_POST est rempli sans erreurs, appelle le fichier d'enregistrement de produit
        else {
            $newUser = new UserModel;
            if ($newUser->isEmailUsed($this->email) === false) {
                $newUser->registerUser($this->username, $this->email, $this->password); // envoie les infos utilisateur sur le modèle
                require ROOT . '/vue/inscription_succes_vue.php'; // affiche page succès
            } else {
                // Affiche une erreur dans le formulaire d'inscription
                $this->errors['email'] = "Cette adresse existe déjà";
                require ROOT . '/app/View/inscription_view.php'; // Retour au formulaire
            }
        }
        // ============
    }

    /*
     * Fonction checkEmail :
     * Regarde si l'email de l'utilisateur est une adresse email conforme
     * Résultat : booléen (adresse conforme = true)
     */
    private function checkEmail()
    {
        $arobaz = explode('@', $this->email) ?? null; // sépare selon le ou les arobaz @
        if (count($arobaz) > 1) {
            $domain = explode('.', $arobaz[1]) ?? null;   // sépare la partie après le premier arobaz @
            $name = explode('.', $arobaz[0]) ?? null;     // sépare la première partie de l'email si il y a un (des) points

            if (
                count($arobaz) == 2 && strlen($arobaz[1]) >= 6 && count($domain) == 2 && (strlen($domain[1]) >= 2 && strlen($domain[1]) <= 4) &&
                (count($name) == 1 && strlen($name[0]) >= 3 || count($name) == 2 && $name[0] != "" && strlen($name[1]) >= 3)
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
