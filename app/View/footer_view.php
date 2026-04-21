<footer class="box">
    <div class="footernav">
        <div>
            <h3>Côte Info</h3>
            <p>Votre guide des stations balnéaires en France métropole.</p>
        </div>
        <div>
            <h3>Liens rapides</h3>
            <ul>
                <li><a href="?action=policy">
                        RGPD
                    </a></li>
                <li><a href="?action=contact">
                        Contact
                    </a></li>
            </ul>
        </div>
        <div>
            <h3>Communauté</h3>
            <ul>
                <li><a href="#">
                        Facebook
                    </a></li>
                <li><a href="#">
                        Twitter
                    </a></li>
                <li><a href="#">
                        Instagram
                    </a></li>
            </ul>
        </div>
    </div>
    <hr>
    <div>
        <p class="copyright padding-10">&copy; 2026 Côte Info. Tous droits réservés.</p>
    </div>
</footer>
<script src="./public/js/nav.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'home': ?>
            <script src="./public/js/map.js"></script>
        <?php
            break;
        case 'station':
        ?> <script>
                const pageData = {
                    latitude: "<?= $this->beach['latitude'] ?>",
                    longitude: "<?= $this->beach['longitude'] ?>",
                    note: "<?= $this->note ?>"
                };
            </script>
            <?php if (!empty($this->medias)) { ?>
                <script src="./public/js/slider.js"></script>
            <?php } ?>
            <script src="./public/js/weather.js"></script>
            <script src="./public/js/note.js"></script>
        <?php
            break;
        case 'write':
        ?> <script src="./public/js/station_request.js"></script>
    <?php
            break;
    }
} else { ?>
    <script src="./public/js/map.js"></script>
<?php
} ?>
</body>

</html>