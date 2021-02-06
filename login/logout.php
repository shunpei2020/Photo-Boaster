<?php
session_start();
require_once '../classes/UserLogic.php';

if (!$logout = filter_input(INPUT_POST, 'logout')) {
  exit('不正なリクエスト');
}

$result = UserLogic::checkLogin();

if (!$result) {
  exit('セッションが切れたので、ログインし直してください。');
}

UserLogic::logout();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../src/login.css">
  <title>Logout</title>
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

  <main class="form">
    <h4>ログアウト完了</h4>
    <p class="posting"><a href="login_form.php">Login</a></p>
  </main>
</body>
</html>