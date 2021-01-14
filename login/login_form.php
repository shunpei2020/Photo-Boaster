<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';
$err = $_SESSION;

// セッションを消す
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../src/style.css">
  <title>Login</title>
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

  <main class="form">
    <h2>Login Form</h2>
        <?php if (isset($err['msg'])) : ?>
          <p><?php echo $err['msg']; ?></p>
        <?php endif; ?>
        <?php if (isset($login_err)) : ?>
          <p><?php echo $login_err; ?></p>
        <?php endif; ?>
    <form action="login.php" method="POST">
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
      <p>
      <input class="posting" type="submit" value="Login">
      </p>
    </form>
    <p class="log">登録がお済みでない方はこちら<a href="./signup_form.php">Sign Up</a></p>
  </main>
</body>
</html>