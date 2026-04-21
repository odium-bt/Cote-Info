<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="padding-50 box">
        <h1>Rédaction d'article</h1>
        <form class="flex column" id="article_write" action="?action=write" method="post" enctype="multipart/form-data">

            <label for="region_select">Choisis une région<span class="red">*</span> : </label>
            <select name="region" id="region_select" required>
                <option value="">-- Choisissez une région --</option>
                <option value="1">Bretagne</option>
                <option value="2">Normandie</option>
                <option value="3">Nouvelle-Aquitaine</option>
                <option value="4">Occitanie</option>
                <option value="5">Provence-Alpes-Côtes-d'Azur</option>
                <option value="6">Hauts-de-France</option>
                <option value="7">Pays-de-la-Loire</option>
            </select>
            <p><?php if (isset($this->errors['selectedRegion'])) echo ("<span class='error'>" . $this->errors['selectedRegion'] . "</span>"); ?></p>

            <div class="hide flex column" id="station_container">
                <!-- Apparaît quand une région a été choisie -->
                <p>Stations concernées :</p>

                <div id="station_list"></div>
            </div>
            <p><?php if (isset($this->errors['selectedStations'])) echo ("<span class='error'>" . $this->errors['selectedStations'] . "</span>"); ?></p>

            <label for="write-title">Titre<span class="red">*</span> : </label>
            <input name="title" id="write-title" type="text" required>
            <p><?php if (isset($this->errors['title'])) echo ("<span class='error'>" . $this->errors['title'] . "</span>"); ?></p>


            <label for="write-area">Contenu<span class="red">*</span> :</label>
            <textarea name="content" id="write-area" cols="90" rows="20" maxlength="10000" required></textarea>
            <p><?php if (isset($this->errors['content'])) echo ("<span class='error'>" . $this->errors['content'] . "</span>"); ?></p>


            <label for="thumbnail">Ajoutez un thumbnail<span class="red">*</span> : </label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" required>
            <p><?php if (isset($this->errors['thumbnail'])) echo ("<span class='error'>" . $this->errors['thumbnail'] . "</span>"); ?></p>


            <input class="button" type="submit">
        </form>

    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>