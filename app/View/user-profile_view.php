 <h2 class="titre">Mon profil</h2>
 <div class="profil">
     <div class="flex">
         <img src="<?= ROOT . "/public/images/avatars/" . $this->user['avatar'] ?>" alt="Ton avatar" onerror="this.onerror=null; this.src='./public/images/avatars/default.png';">
         <form action="?action=user">
             <label for="new-avatar">Modification de votre photo de profil : </label><input name="new-avatar" type="file">
             <input class="button" type="submit">
         </form>
     </div>
     <h3><?= $this->user['username'] ?></h3>
 </div>

 <p>Date de création du compte : <?= $this->user['date_'] ?></p>
 <a href="?action=logout">
     <div class="button red">Déconnexion</div>
 </a>
 <div class="button red">Suppression du compte</div>