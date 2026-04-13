<footer class="box">
    <div class="footernav">
        <div>
            <h5>Côte Info</h5>
            <p>Votre guide des stations balnéaires en France métropole.</p>
        </div>
        <div>
            <h5>Liens rapides</h5>
            <ul>
                <a href="?action=policy">
                    <li>RGPD</li>
                </a>
                <a href="?action=contact">
                    <li>Contact</li>
                </a>
            </ul>
        </div>
        <div>
            <h5>Communauté</h5>
            <ul>
                <a href="#">
                    <li>Facebook</li>
                </a>
                <a href="#">
                    <li>Twitter</li>
                </a>
                <a href="#">
                    <li>Instagram</li>
                </a>
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
<?php if (!isset($_GET['action']) || $_GET['action'] === 'home') { ?>
    <script src="./public/js/map.js"></script>
<?php } ?>
<?php if (isset($_GET['action']) && $_GET['action'] === 'station') { ?>
    <script>
        const pageData = {
            latitude: "<?= $this->beach['latitude'] ?>",
            longitude: "<?= $this->beach['longitude'] ?>"
        };
    </script>
    <script src="./public/js/slider.js"></script>
    <script src="./public/js/weather.js"></script>
<?php } ?>
</body>

</html>