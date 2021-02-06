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
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/reset.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="src/form.css">
  <title>Postform</title>
</head>
<body>
  <nav>
    <div class="logo">
      <a href="index.php"><h2>Photo Boaster</h2></a>
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
      <div class="form-group">
      <label for="title">Blog Title</label>
      <input type="text" class="form-control" name="title" id="title">
      </div>
      <?php if (isset($err['title'])) : ?>
          <p class="err"><?php echo $err['title']; ?>
        <?php endif; ?>
      <div class="file-up">
        <p class="photo">Photo</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
        <p>※2MB未満で選択してください。</p>
        <?php if (isset($err['file'])) : ?>
          <p><?php echo $err['file'] ?>
        <?php endif; ?>
      </div>
      <div class="form-group">
      <label for="content">Content</label>
       <textarea class="form-control" name="content" id="content" rows="3"></textarea>
      </div>
      <?php if (isset($err['content'])) : ?>
          <p><?php echo $err['content'] ?>
      <?php endif; ?>
      <br>
      <div class="form-group">
      <label for="category">Category</label>
      <select class="form-control" id="category" name="category">
        <option value="1" <?php if($category === 1) echo "selected" ?>>日常</option>
        <option value="2" <?php if($category === 2) echo "selected" ?>>趣味</option>
      </select>
     </div>
      <?php if (isset($err['category'])) : ?>
          <p><?php echo $err['category'] ?>
      <?php endif; ?>
      <br>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <input class="posting" type="submit" value="POST">
    </form>
  </main>
  <footer>
    <p class="top"><a href="./index.php">Cancel</a></p>
  </footer>
</body>
</html>