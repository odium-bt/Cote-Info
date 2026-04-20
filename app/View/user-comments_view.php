 <h2 class="margin-bottom-30">Mes commentaires</h2>


 <?php
    $comments = $this->getComments();
    if (empty($comments)) {
    ?> <p class="padding-30">Vous n'avez pas encore posté de commentaires, commencez par poster un commentaire et il apparaîtra ici.</p>
 <?php }
    foreach ($comments as $comment) {
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
                    if ($comment['note'] !== null) {
                        for ($i = 1; $i <= 5; $i++):
                    ?>
                         <i class="<?= ($i <= $comment['note']) ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                 <?php
                        endfor;
                    };
                    ?>
             </div>
             <p class="padding-10"><?= $comment['date_'] ?></p>
             <?php if (isset($_SESSION['user_id'])) { ?>
                 <div>
                     <?php if ($comment['id_user'] === $_SESSION['user_id'] || $_SESSION['is_admin'] === true) { ?>
                         <a href="?action=station&id=<?= $this->id ?>&delete=<?= $comment['id_comment'] ?>"><button id="delete"><i class="fa-solid fa-trash"></i></button></a>
                     <?php }; ?>
                 </div>
             <?php } ?>
         </div>
         <div class="comment__content padding-10">
             <p><?= $comment['content'] ?></p>
         </div>
     </div>
 <?php }
    ?>