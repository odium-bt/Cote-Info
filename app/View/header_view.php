<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Côte Info</title>
    <meta name="description"
        content="Guide des plages : trouvez les meilleures plages, consultez la météo, explorez les avis et préparez facilement vos sorties en bord de mer.">
    <link rel="stylesheet" href="./public/styles/style.css">
</head>

<body>
    <header class="box">

        <div class="logo">
            <a href="?action=home"><img src="./public/images/logo.webp" alt="Logo Côte Info"></a>
        </div>

        <i id="burger" class="fa-solid fa-bars box"></i>

        <nav id="header-nav">
            <ul>
                <li id="header-nav-map" class="<?= $_GET['action'] === 'home' ? 'active' : '' ?>"><a href="?action=home"><i class="fa-regular fa-map"></i>&nbsp;Carte</a></li>
                <li id="header-nav-news" class="<?= $_GET['action'] === 'news' ? 'active' : '' ?>"><a href="?action=news"><i class="fa-regular fa-newspaper"></i>&nbsp;Actualités</a></li>
                <li id="header-nav-about" class="<?= $_GET['action'] === 'about' ? 'active' : '' ?>"><a href="?action=about"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;A&nbsp;propos</a></li>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <li id="header-nav-login" class="<?= $_GET['action'] === 'login' ? 'active' : '' ?>"><a href="?action=login"><i class="fa-regular fa-circle-user"></i>&nbsp;Connexion</a></li>
                <?php } else { ?>
                    <li id="header-nav-profile" class="<?= $_GET['action'] === 'user' ? 'active' : '' ?>"><a id="profile" href="?action=user"><i class="fa-regular fa-circle-user"></i>&nbsp;Espace&nbsp;utilisateur</a></li>
                <?php } ?>
            </ul>
        </nav>
        <div class="searchbar">

            <input type="text">
        </div>
    </header>