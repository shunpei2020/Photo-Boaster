<?php
require_once(__DIR__ . '/../env.php');

$err = [];

// 二重送信防止
$token = filter_input(INPUT_POST, 'csrf_token');

if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);

// バリデーション
if(!$username = filter_input(INPUT_POST, 'username')) {
  $err['username'] = 'ユーザ名を記入してください。';
}
if(!$email = filter_input(INPUT_POST, 'email')) {
  $err['email'] = 'メールアドレスを記入してください。';
}
$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
  $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if ($password !== $password_conf) {
  $err['password_conf'] = '確認ようパスワードと異なっています。';
}
if (count($err) > 0) {
  // エラーがあった場合戻す
    $_SESSION = $err;
    header('Location: signup_form.php');
    return;
}
// ユーザを登録する処理
$hasCreated = UserLogic::createUser($_POST);

if(!$hasCreated) {
  header('Location: signup_form.php');
  $err[] = '登録に失敗しました。';
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

  <main class="form">
    <h4>新規登録完了しました！</h4>
    <p class="posting"><a href="login_form.php">ログインする</a></p>
  </main>
</body>
</html>