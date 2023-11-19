<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    // Şifre uzunluğunu kontrol et
    if (strlen($pass) < 10) {
        echo '<script>alert("Şifreniz en az 10 karakter olmalıdır!");</script>';
    } else {
        // E-posta uzantısını kontrol et
        if (strpos($email, '@gmail.com') === false) {
            echo '<script>alert("Lütfen geçerli bir Gmail e-posta adresi giriniz!");</script>';
        } else {
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_user->execute([$email]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            if ($select_user->rowCount() > 0) {
                echo '<script>alert("Bu e-posta zaten var!");</script>';
            } else {
                if ($pass != $cpass) {
                    echo '<script>alert("Şifreler aynı değil!");</script>';
                } else {
                    $hashed_password = sha1($pass); // Not: Daha güvenli bir hashleme yöntemi kullanmayı düşünün (örneğin, bcrypt)
                    $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
                    $insert_user->execute([$name, $email, $hashed_password]);

                    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
                    $select_user->execute([$email, $hashed_password]);
                    $row = $select_user->fetch(PDO::FETCH_ASSOC);

                    if ($select_user->rowCount() > 0) {
                        $_SESSION['user_id'] = $row['id'];
                        echo '<script>alert("Kayıt başarılı. Hoş geldiniz!"); window.location.href="home.php";</script>';
                        exit;
                    }
                }
            }
        }
    }
}

?>
 

 


 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>üye ol</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>ŞİMDİ <br>ÜYE OL</h3>
   
      <input type="text" name="name" required placeholder=" name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder=" email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Şifrenizi lütven 10 karakter giriniz" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="şifreni tekrar gir" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p>üye misin? <a href="login.php">giriş yap</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>


<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>