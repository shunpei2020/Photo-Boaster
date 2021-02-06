<?php
session_start();
require_once '../classes/UserLogic.php';

$err = [];
// バリデーション
if(!$email = filter_input(INPUT_POST, 'email')) {
  $err['email'] = 'メールアドレスを記入してください。';
}
if(!$password = filter_input(INPUT_POST, 'password')) {
  $err['password'] = 'パスワードを記入してください。';
}
if (count($err) > 0) {
// エラーがあった場合戻す
  $_SESSION = $err;
  header('Location: login_form.php');
  return;
}
// ログイン成功時
$result = UserLogic::login($email,$password);
// ログイン失敗時
if (!$result) {
  header('Location: login_form.php');
  return;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../src/login.css">
  <title>Login</title>
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
    <h4>ログイン完了</h4>
    <p class="posting"><a href="./mypage.php">Mypage</a></p>
  </main>
</body>
</html>