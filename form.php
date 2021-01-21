<?php
session_start();
require_once dirname(__FILE__) . '/classes/UserLogic.php';
require_once 'functions.php';

// ログインチェック
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください。';
  header('Location: login/login_form.php');
  return;
}

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="src/style.css">
  <title>Postform</title>
</head>
<body>
  <nav>
    <div class="logo">
      <a href="index.php"><h2>tanaBlog</h2></a>
    </div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="login/mypage.php">Mypage</a></li>
      <li><a href="form.php">Postform</a></li>
    </ul>
  </nav>
  <main class="form">
    <h2>Postform</h2>
    <form enctype="multipart/form-data" action="classes/blog_create.php" method="POST">
      <input type="hidden" name="user_id" value="<?php echo $login_user['id'] ?>">
      <input type="hidden" name="user_name" value="<?php echo $login_user['name'] ?>">
      <p class="f-title">Blog Title : <input type="text" name="title"></p>
      <?php if (isset($err['title'])) : ?>
          <p><?php echo $err['title']; ?>
        <?php endif; ?>
      <div class="file-up">
        <p class="photo">Photo</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
        <?php if (isset($err['file'])) : ?>
          <p><?php echo $err['file'] ?>
        <?php endif; ?>
      </div>
      <p class="f-content">Content</p>
      <textarea name="content" id="content" cols="60" rows="10"></textarea>
      <?php if (isset($err['content'])) : ?>
          <p><?php echo $err['content'] ?>
      <?php endif; ?>
      <br>
      <p class="f-category">Category : <select name="category">
        <option value=1>日常</option>
        <option value=2>趣味</option>
      </select></p>
      <?php if (isset($err['category'])) : ?>
          <p><?php echo $err['category'] ?>
      <?php endif; ?>
      <br>
      <input type="radio" name="publish_status" value=1 checked>公開
      <input type="radio" name="publish_status" value=2>非公開
      <?php if (isset($err['publish_at'])) : ?>
          <p><?php echo $err['publish_at'] ?>
      <?php endif; ?>
      <br>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <input class="posting" type="submit" value="POST">
    </form>
    <p class="top"><a href="./index.php">Cancel</a></p>
  </main>
</body>
</html>