<?php 
session_start();
require_once './classes/blog.php';
require_once 'functions.php';
require_once dirname(__FILE__) . '/classes/UserLogic.php';

// ログインチェック
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください。';
  header('Location: login/login_form.php');
  return;
}

$id = $_GET['id'];
$result = Blog::getById($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="src/style.css">
  <title>Detail</title>
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

  <main class="detail">
    <h2>Detail</h2>
    <div class="detail-post">
      <img src="<?php echo h($result['file_path']) ?>" alt="">
      <div class="detail-data">
        <h3>Title: <?php echo h($result['title']) ?></h3>
        <hr>
        <p class="content"><span>Content: </span><?php echo h($result['content']) ?></p>
        <p class="category"><span>Category: <?php echo h(UserLogic::setCategoryName($result['category'])) ?></span></p>
        <p class="date"><span>Date: <?php echo h($result['post_at']) ?></span></p>
      </div>
    </div>
    <p class="back"><a href="index.php">Back</a></p>
  </main>
</body>
</html>