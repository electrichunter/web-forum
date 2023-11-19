<?php

// Veritabanı bağlantısını içe aktar
include '../components/connect.php';

// Oturumu başlat
session_start();

// Oturumdan yönetici ID'sini al
$admin_id = $_SESSION['admin_id'];

// Eğer yönetici ID'si ayarlanmamışsa, yönetici giriş sayfasına yönlendir
if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Eğer 'delete' POST isteği varsa
if(isset($_POST['delete'])){

   // POST isteğinden gönderi ID'sini al ve temizle
   $p_id = $_POST['post_id'];
   $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

   // Gönderinin resmini almak için veritabanı sorgusu hazırla ve çalıştır
   $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
   $delete_image->execute([$p_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

   // Eğer gönderinin bir resmi varsa, resmi sil
   if($fetch_delete_image['image'] != ''){
      unlink('../uploaded_img/'.$fetch_delete_image['image']);
   }

   // Gönderiyi silmek için veritabanı sorgusu hazırla ve çalıştır
   $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
   $delete_post->execute([$p_id]);

   // Gönderinin yorumlarını silmek için veritabanı sorgusu hazırla ve çalıştır
   $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$p_id]);

   // Başarılı mesajını ayarla
   $message[] = 'post deleted successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>gönderiler</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="show-posts">

   <h1 class="heading">senin göndrilerin</h1>

   <div class="box-container">

      <?php
         // Tüm gönderileri almak için veritabanı sorgusu hazırla ve çalıştır
         $select_posts = $conn->prepare("SELECT * FROM `posts`");
         $select_posts->execute();

         // Eğer gönderi varsa
         if($select_posts->rowCount() > 0){
            // Her gönderi için
            while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
               $post_id = $fetch_posts['id'];

               // Gönderinin yorum sayısını almak için veritabanı sorgusu hazırla ve çalıştır
               $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
               $count_post_comments->execute([$post_id]);
               $total_post_comments = $count_post_comments->rowCount();

               // Gönderinin beğeni sayısını almak için veritabanı sorgusu hazırla ve çalıştır
               $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
               $count_post_likes->execute([$post_id]);
               $total_post_likes = $count_post_likes->rowCount();

      ?>
      <form method="post" class="box">
         <input type="hidden" name="post_id" value="<?= $post_id; ?>">
         <?php if($fetch_posts['image'] != ''){ ?>
            <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
         <?php } ?>
         <div class="status" style="background-color:<?php if($fetch_posts['status'] == 'active'){echo 'limegreen'; }else{echo 'coral';}; ?>;"><?= $fetch_posts['status']; ?></div>
            <div class="title"><?= $fetch_posts['title']; ?></div>
         <div class="posts-content"><?= $fetch_posts['content']; ?></div>
         <div class="icons">
            <div class="likes"><i class="fas fa-heart"></i><span><?= $total_post_likes; ?></span></div>
            <div class="comments"><i class="fas fa-comment"></i><span><?= $total_post_comments; ?></span></div>
         </div>
         <div class="flex-btn">
            <a href="edit_post.php?id=<?= $post_id; ?>" class="option-btn">düzenle</a>
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('delete this post?');">sil</button>
         </div>
         <a href="read_post.php?post_id=<?= $post_id; ?>" class="btn">gönderiyi gör</a>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no posts added yet! <a href="add_posts.php" class="btn" style="margin-top:1.5rem;">add post</a></p>';
         }
      ?>

   </div>


</section>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
