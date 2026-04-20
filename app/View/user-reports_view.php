 <h2 class="margin-bottom-30">Commentaires signalés</h2>


 <?php
    $userModel->isCurrentAdmin();

    if (isset($this->reportDeleteStatus) && $this->reportDeleteStatus === true) {
        echo "<p>" . "Commentaire supprimé." . "</p>";
    } else if (isset($this->reportDeleteStatus) && $this->reportDeleteStatus === false) {
        echo "<p>" . "Le commentaire n'a pas été supprimé. Vérifiez que vous ayez la permission ou que le commentaire que vous essayez de supprimer soit bien signalé." . "</p>";
    }
    if (empty($this->reports)) {
    ?> <p class="padding-30">Aucun commentaire signalé.</p>
 <?php }
    foreach ($this->reportedComments as $report) {
    ?>
     <!-- section -->
     <div class="comment box padding-10">
         <!-- avatar, nom, date, contenu, note -->
         <div class="comment__info">
             <div class="comment__info__author">
                 <img class="avatar padding-10" src="./public/images/avatars/<?= $this->user['avatar'] ?>" onerror="this.onerror=null; this.src='./public/images/avatars/default.png';">
                 <p class="padding-10"><?= $this->user['username'] ?></p>
             </div>
             <div class="comment__info__note">
                 <?php
                    // Si l'utilisateur a mis une note, affiche des étoiles remplies ou non selon sa note
                    if ($report['note'] !== null) {
                        for ($i = 1; $i <= 5; $i++):
                    ?>
                         <i class="<?= ($i <= $report['note']) ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                 <?php
                        endfor;
                    };
                    ?>
             </div>
             <p class="padding-10"><?= $report['date_'] ?></p>

             <div>
                 <?php
                    if ($_SESSION['is_admin'] === true) { ?>
                     <a href="?action=user&tab=reports&delete=<?= $report['id_comment'] ?>"><button title="Supprimer le commentaire" id="delete"><i class="fa-solid fa-trash"></i></button></a>
                     <a href="?action=user&tab=reports&remove=<?= $report['id_comment'] ?>"><button title="Retirer des signalements" id="delete"><i class="fa-solid fa-x"></i></button></a>
                 <?php }; ?>
             </div>

         </div>
         <div class="comment__content padding-10">
             <p><?= $report['content'] ?></p>
         </div>
     </div>
 <?php }
    ?>