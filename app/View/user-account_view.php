 <h2 class="margin-bottom-30">Mon compte</h2>
 <div class="padding-30 flex column">
     <div class="flex align-center">
         <img class="avatar margin-20" src="./public/images/avatars/<?= $this->user['avatar'] ?>" alt="Ton avatar" onerror="this.onerror=null; this.src='./public/images/avatars/default.png';">
         <h3 class="username margin-side-20"><?= $this->user['username'] ?></h3>
     </div>
 </div>

 <p class="margin-overunder-3">Date de création du compte : <?= $this->user['date_'] ?></p>
 <a class="margin-overunder-3" href="?action=deletion">
     <div id="delete-btn" class="button">Suppression du compte</div>
 </a>