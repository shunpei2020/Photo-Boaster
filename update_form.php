<?php
session_start();
require_once './classes/UserLogic.php';
require_once './classes/blog.php';
require_once './functions.php';

// ログインチェック
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください。';
  header('Location: login/login_form.php');
  return;
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$result = blog::getById($id);

$id = $result['id'];
$userid = $result['user_id'];
$title = $result['title'];
$file_path = $result['file_path'];
$content = $result['content'];
$category = (int)$result['category'];
$publish_status = (int)$result['publish_status'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="src/style.css">
  <title>Updateform</title>
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
    <h2>Post Update</h2>
    <form enctype="multipart/form-data" action="./classes/blog_update.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <input type="hidden" name="user_id" value="<?php echo h($userid) ?>">
      <p class="f-title">Blog Title : <input type="text" name="title" value="<?php echo h($title) ?>"></p>
      <?php if (isset($err['username'])) : ?>
          <p><?php echo $err['username']; ?></p>
      <?php endif; ?>
      <img class="f-img" src="<?php echo $file_path ?>" alt="">
      <p class="f-content">Content</p>
      <textarea name="content" id="content" cols="60" rows="10"><?php echo h($content) ?></textarea>
      <br>
      <p class="f-category">Category : <select name="category">
        <option value="1" <?php if($category === 1) echo "selected" ?>>日常</option>
        <option value="2" <?php if($category === 2) echo "selected" ?>>趣味</option>
      </select></p>
      <br>
      <input type="radio" name="publish_status" value="1" <?php if($publish_status === 1) echo "checked" ?>>公開
      <input type="radio" name="publish_status" value="2" <?php if($publish_status === 2) echo "checked" ?>>非公開
      <br>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <input class="posting" type="submit" value="UPDATE">
    </form>
    <p class="top"><a href="./index.php">Cancel</a></p>
  </main>
</body>
</html>