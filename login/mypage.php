<?php
session_start();
require_once dirname(__FILE__) .'/../classes/blog.php';
require_once dirname(__FILE__) . '/../classes/UserLogic.php';
require_once dirname(__FILE__) . '/../functions.php';

// ログインチェック
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください。';
  header('Location: login_form.php');
  return;
}

$login_user = $_SESSION['login_user'];

// ユーザーの投稿一覧
$userBlog = UserLogic::getUserData($login_user);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../src/mypage.css">
  <title>Mypage</title>
</head>
<body>
  <nav>
    <div class="logo">
      <a href="../index.php"><h2>Photo Boaster</h2></a>
    </div>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../form.php">Postform</a></li>
      <li><form action="logout.php" method="POST">
      <input type="submit" name="logout" value="Logout"/>
      </form></li>
    </ul>
  </nav>

  <main class="mypage">
    <div class="user-data">
      <h2>ようこそ <?php echo h($login_user['name']) ; ?> さん!</h2>
      <p>Username: <?php echo h($login_user['name']) ; ?></p>
      <p>Email: <?php echo h($login_user['email']) ; ?></p>
    </div>
    <div class="title">
      <h2>Your Post</h2>
      <p><a href="../form.php">投稿する</a></p>
    </div>
      <?php if(!$userBlog) : ?>
        <p class="msg">投稿がありません。</p>
      <?php endif ; ?>
    <?php foreach($userBlog as $column) : ?>
    <div class="post">
      <div class="main">
        <img src="<?php echo h($column['file_path']) ?>" alt="">
        <div class="data">
          <h2>#<?php echo h($column['title']) ?></h2>
          <p>Category: <?php echo h(UserLogic::setCategoryName($column['category'])) ?></p>
          <p>Date: <?php echo h($column['post_at']) ?></p>
        </div>
      </div>
      <div class="edit">
      <a href="../detail.php?id=<?php echo $column['id'] ?>">詳細</a>
      <a href="../update_form.php?id=<?php echo $column['id'] ?>">編集</a>
      <a href="../classes/blog_delete.php?id=<?php echo $column['id'] ?>">削除</a>
      </div>
    </div>
    <?php endforeach; ?>
  </main>

  <footer>
    <p><a href="../index.php">Top</a></p>
  </footer>
</body>
</html>