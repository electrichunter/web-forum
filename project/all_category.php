<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

   <!--İLK DEFA DENİYOM font awesome  link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section BAŞI  -->
<?php include 'components/user_header.php'; ?>
<!-- header section SONU -->




<section class="categories">

   <h1 class="heading">BÜTÜN KATAGORİLER</h1>

   <div class="box-container">
      <div class="box"><span>01</span><a href="category.php?category=nature">doğa</a></div>
      <div class="box"><span>02</span><a href="category.php?category=eduction">eğitim</a></div>
      <div class="box"><span>03</span><a href="category.php?category=pets and animals">evcil hayvanlar veya vahşi hayvanlar</a></div>
      <div class="box"><span>04</span><a href="category.php?category=technology">teknoloji</a></div>
      <div class="box"><span>05</span><a href="category.php?category=fashion">moda</a></div>
      <div class="box"><span>06</span><a href="category.php?category=entertainment">eğlence</a></div>
      <div class="box"><span>07</span><a href="category.php?category=movies">filmler</a></div>
      <div class="box"><span>08</span><a href="category.php?category=gaming">oyunlar</a></div>
      <div class="box"><span>09</span><a href="category.php?category=music">müzik</a></div>
      <div class="box"><span>10</span><a href="category.php?category=sports">spor</a></div>
      <div class="box"><span>11</span><a href="category.php?category=news">yeni</a></div>
      <div class="box"><span>12</span><a href="category.php?category=travel">seyahat</a></div>
      <div class="box"><span>13</span><a href="category.php?category=comedy">komedi</a></div>
      <div class="box"><span>14</span><a href="category.php?category=design and development">tasarım veya kodlama</a></div>
      <div class="box"><span>15</span><a href="category.php?category=food and drinks">yiyecek içecek</a></div>
      <div class="box"><span>16</span><a href="category.php?category=lifestyle">yaşam tarzı</a></div>
      <div class="box"><span>17</span><a href="category.php?category=health and fitness">saglıklı yaşam</a></div>
      <div class="box"><span>18</span><a href="category.php?category=business">işletme</a></div>
      <div class="box"><span>19</span><a href="category.php?category=shopping">alışveriş</a></div>
      <div class="box"><span>20</span><a href="category.php?category=animations">animasyon</a></div>
   </div>

</section>










<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>