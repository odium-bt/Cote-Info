<?php require ROOT . '/app/View/header_view.php'; ?>
<main class="content flex user">
    <aside id="user_nav" class="box">
        <nav>
            <ul>
                <li><a href="?action=user&tab=user"><i class="tab_icon fa-solid fa-user"></i><span class="tab_text">Profil</span>
                    </a>
                </li>
                <li><a href="?action=user&tab=account"><i class="tab_icon fa-solid fa-id-card"></i><span class="tab_text">Compte</span>
                    </a>
                </li>
                <li><a href="?action=user&tab=comments"><i class="tab_icon fa-solid fa-comments"></i><span class="tab_text">Mes&nbsp;commentaires</span>
                    </a>
                </li>
                <li><a href="?action=user&tab=notes"><i class="tab_icon fa-solid fa-star"></i><span class="tab_text">Mes&nbsp;notes</span>
                    </a>
                </li>
                <li><a href="?action=user&tab=settings "><i class="tab_icon fa-solid fa-gear"></i><span class="tab_text">Préférences</span>
                    </a>
                </li>
                <?php if ($this->isAdmin === true) {
                ?>
                    <li><a href="?action=user&tab=articles"><i class="tab_icon fa-solid fa-newspaper"></i><span class="tab_text">Mes&nbsp;articles</span>
                        </a>
                    </li>
                    <li><a href="?action=user&tab=reports"><i class="tab_icon fa-solid fa-flag"></i><span class="tab_text">Commentaires&nbsp;signalés</span>
                        </a>
                    </li>
                <?php
                } ?>
            </ul>
        </nav>
    </aside>

    <div id="user_box" class="box padding-50">
        <?php
        if (isset($_GET['tab'])) {
            switch ($_GET['tab']) {
                case 'user':
                    require ROOT . '/app/View/user-profile_view.php';
                    break;
                case 'account':
                    require ROOT . '/app/View/user-account_view.php';
                    break;
                case 'comments':
                    require ROOT . '/app/View/user-comments_view.php';
                    break;
                case 'notes':
                    require ROOT . '/app/View/user-notes_view.php';
                    break;
                case 'settings':
                    require ROOT . '/app/View/user-settings_view.php';
                    break;
                case 'articles':
                    if ($this->isAdmin === true) {
                        require ROOT . '/app/View/user-articles_view.php';
                    } else {
                        require ROOT . '/app/View/user-profile_view.php';
                    }
                    break;
                case 'reports':
                    if ($this->isAdmin === true) {
                        require ROOT . '/app/View/user-reports_view.php';
                    } else {
                        require ROOT . '/app/View/user-profile_view.php';
                    }
                    break;
                default:
                    require ROOT . '/app/View/user-profile_view.php';
            }
        } else {
            require ROOT . '/app/View/user-profile_view.php';
        }
        ?>
    </div>


</main>
<?php require ROOT . '/app/View/footer_view.php'; ?>