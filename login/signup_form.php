<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';

$err = $_SESSION;

// セッションを消す
$_SESSION = array();

$result = UserLogic::checkLogin();
if ($result) {
  header('Location: mypage.php');
}
 
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../src/style.css">
  <title>Signup</title>
</head>
<body>
  <nav>
    <div class="logo">
      <a href="../index.php"><h2>tanaBlog</h2></a>
    </div>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../form.php">Postform</a></li>
    </ul>
  </nav>

  <main class="form signup">
    <h2>Sign Up Form</h2>
      <?php if (isset($login_err)) : ?>
          <p><?php echo $login_err; ?></p>
      <?php endif; ?>
    <form action="register.php" method="POST">
      <p class="sign">
        <label for="username">ユーザー名：</label>
        <input type="text" name="username">
        <?php if (isset($err['username'])) : ?>
          <p><?php echo $err['username']; ?></p>
        <?php endif; ?>
      </p>
      <p class="sign">
        <label for="email">メールアドレス：</label>
        <input type="email" name="email">
        <?php if (isset($err['email'])) : ?>
          <p><?php echo $err['email']; ?></p>
        <?php endif; ?>
      </p>
      <p class="sign">
        <label for="password">パスワード：</label>
        <input type="password" name="password">
        <?php if (isset($err['password'])) : ?>
          <p><?php echo $err['password']; ?></p>
        <?php endif; ?>
      </p>
      <p class="sign">
        <label for="password_conf">パスワード確認：</label>
        <input type="password" name="password_conf">
        <?php if (isset($err['password_conf'])) : ?>
          <p><?php echo $err['password_conf']; ?></p>
        <?php endif; ?>
      </p>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <p>
      <input class="posting" type="submit" value="Sign Up">
      </p>
    </form>
    <p class="log">登録済みの方はこちら<a href="login_form.php">Login</a></p>
  </main>
  
</body>
</html>