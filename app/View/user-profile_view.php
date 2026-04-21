 <h2 class="margin-bottom-30">Mon profil</h2>
 <?php if (!empty($this->errors['avatar'])) { ?>
     <p class="error"><?= $this->errors['avatar'] ?></p>
 <?php } ?>

 <div class="padding-30 flex column">
     <div class="flex">
         <img class="user_avatar margin-20" src="./public/images/avatars/<?= $this->user['avatar'] ?>" alt="Ton avatar" onerror="this.onerror=null; this.src='./public/images/avatars/default.png';">
         <form action="?action=user" class="flex column" enctype="multipart/form-data" method="post">
             <label class="margin-overunder-3" for="new-avatar">Modification de votre photo de profil : </label>
             <input class="margin-overunder-3" name="new-avatar" type="file">
             <input class="margin-overunder-3 button" type="submit">
         </form>
     </div>
     <h3 class="username margin-side-20"><?= $this->user['username'] ?></h3>
 </div>

 <a class="margin-overunder-3" href="?action=logout">
     <div class="button">Déconnexion</div>
 </a>