<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Known Loop</a>

      <form action="search.php" method="POST" class="search-form">
         <input type="text" name="search_box" class="box" maxlength="100" placeholder="ARAMA YAP" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <nav class="navbar">
         <a href="home.php"> <i class="fas fa-angle-right"></i> ana sayfa</a>
         <a href="posts.php"> <i class="fas fa-angle-right"></i> gönderiler</a>
         <a href="all_category.php"> <i class="fas fa-angle-right"></i> katagoriler</a>
         <a href="authors.php"> <i class="fas fa-angle-right"></i> yazarlar</a>
         <a href="login.php"> <i class="fas fa-angle-right"></i> giriş yap</a>
         <a href="register.php"> <i class="fas fa-angle-right"></i> üye ol</a>
      </nav>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <a href="update.php" class="btn">profili güncelle</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">giriş yap</a>
            <a href="register.php" class="option-btn">üye ol</a>
         </div> 
         <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">çıkış yap</a>
         <?php
            }else{
         ?>
            <p class="name">Lütven önce giriş yap</p>
            <a href="login.php" class="option-btn">giriş yap</a>
         <?php
            }
         ?>
      </div>

   </section>

</header>