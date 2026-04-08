<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Côte Info</title>
    <link rel="stylesheet" href="./public/styles/style.css">
</head>

<body>
    <header class="box">

        <div class="logo">
            <a href="?action=home"><img src="./public/images/logo1.png" alt="Logo Côte Info"></a>
        </div>
        <i id="burger-menu" class="fa-solid fa-bars"></i>
        <nav>
            <ul>
                <a href="?action=home">
                    <li id="map" class="active"><i class="fa-regular fa-map"></i>&nbsp;Carte</li>
                </a>
                <a href="?action=news">
                    <li id="news"><i class="fa-regular fa-newspaper"></i>&nbsp;Actualités</li>
                </a>
                <a href="?action=about">
                    <li id="about"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;A&nbsp;propos</li>
                </a>
                <a href="?action=login">
                    <li id="login"><i class="fa-regular fa-circle-user"></i>&nbsp;Connexion</li>
                </a>
            </ul>
        </nav>
        <div class="searchbar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text">
        </div>
    </header>