<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);
    $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

    if ($select_admin->rowCount() > 0) {
        // Admin yetki değerini kontrol et
        if ($fetch_admin['admin_yetki'] == 0) {
            // Yetki seviyesi 0 olan yönetici
            session_start();
            $_SESSION['admin_id'] = $fetch_admin['id'];
            header('Location: dashboard.php');
            exit;
        } else if ($fetch_admin['admin_yetki'] == 1) {
            // Yetki seviyesi 1 olan yönetici
            session_start();
            $_SESSION['admin_id'] = $fetch_admin['id'];
            header('Location: ../admin_max/dashboard.php');
            exit;
        }
    } else {
        // Kullanıcı bulunamadı
        $message[] = 'Kullanıcı adı veya şifre hatalı!';
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0 !important;">

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

<!-- admin login form section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>giriş yap</h3>
      <p>deneme admin kullanıcısı = <span>admin</span> & şifre = <span>111</span></p>
      <input type="text" name="name" maxlength="20" required placeholder="kullanıcı adını gir" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="şifreni gir" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="giriş yap" name="submit" class="btn">
   </form>

</section>

<!-- admin login form section ends -->











</body>
</html>