<?php
require_once(__DIR__ . '/../env.php');

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
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../src/login.css">
  <title>Signup</title>
</head>
<body>
  <nav>
    <div class="logo">
      <a href="../index.php"><h2>Photo Boaster</h2></a>
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
    <div class="form-group">
      <label for="username">username</label>
      <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
      <?php if (isset($err['username'])) : ?>
        <p class="msg"><?php echo $err['username']; ?></p>
      <?php endif; ?>
    </div>
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="email"  name="email" aria-describedby="emailHelp" placeholder="Enter email">
      <?php if (isset($err['email'])) : ?>
        <p class="msg"><?php echo $err['email']; ?></p>
      <?php endif; ?>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      <?php if (isset($err['password'])) : ?>
        <p class="msg"><?php echo $err['password']; ?></p>
      <?php endif; ?>
    </div>
    <div class="form-group">
      <label for="password_conf">Password_conf(確認)</label>
      <input type="password" class="form-control" id="password_conf" name="password_conf" placeholder="Password_conf">
      <?php if (isset($err['password_conf'])) : ?>
        <p class="msg"><?php echo $err['password_conf']; ?></p>
      <?php endif; ?>
    </div>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <p>
      <input class="posting" type="submit" value="Sign Up">
      </p>
    </form>
  </main>
  <footer>
    <p class="log">登録済みの方はこちら<br><a href="login_form.php">Login</a></p>
  </footer>
  
</body>
</html>