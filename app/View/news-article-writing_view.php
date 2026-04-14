<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content">
    <div class="flex center">

        <div class="padding-50 box">
            <h1>Rédaction d'article</h1>
            <form id="article_write" action="?action=write">

                <label for="region_select">Choisis une région : </label>
                <select name="region" id="region_select" required>
                    <option value="1">Bretagne</option>
                    <option value="2">Normandie</option>
                    <option value="3">Nouvelle-Aquitaine</option>
                    <option value="4">Occitanie</option>
                    <option value="5">Provence-Alpes-Côtes-d'Azur</option>
                    <option value="6">Hauts-de-France</option>
                    <option value="7">Pays-de-la-Loire</option>
                </select>

                <div class="hide">
                    <!-- Apparaît quand une région a été choisie -->
                    <label for="station_select">Choisis les stations : </label>
                    <select name="stations" id="station_select" required>
                        <?php
                        // Stations
                        ?>
                    </select>
                </div>

                <label for="write-title">Titre : </label>
                <input name="title" id="write-title" type="text" required>

                <label for="write-area">Contenu :</label>
                <textarea name="content" id="write-area" cols="90" rows="20" maxlength="10000" required></textarea>
                <p id="counter">0 / 10000</p>

                <script>
                    const textarea = document.getElementById('content');
                    const counter = document.getElementById('counter');

                    textarea.addEventListener('input', () => {
                        counter.textContent = `${textarea.value.length} / 10000`;
                    });
                </script>

                <label for="thumbnail">Ajoutez un thumbnail : </label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" required>

                <input class="button" type="submit">
            </form>

        </div>

    </div>
</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>