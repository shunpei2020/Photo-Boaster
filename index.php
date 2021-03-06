<?php
require_once(__DIR__ . '/env.php');

// 取得したデータを表示
$blogData = Blog::getAll();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="src/index.css">
  <title>PostList</title>
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
  <main class="pos-list">
    <h2>Photo List</h2>
    <?php foreach($blogData as $columns) : ?>
    <div class="post">
    <div class="user">
      <i class="fas fa-user"></i>
      <p><?php echo h($columns['user_name']) ?></p>
    </div>
      <div class="main">
      <img src="<?php echo $columns['file_path'] ?>" alt="">
      <div class="data">
      <h2>#<?php echo h($columns['title']) ?></h2>
      <p>Category: <?php echo h(UserLogic::setcategoryName($columns['category'])) ?></p>
      <p>Date: <?php echo h($columns['post_at']) ?></p>
      </div>
      </div>
      <div class="edit">
      <a href="detail.php?id=<?php echo $columns['id'] ?>">詳細</a>
      </div>
    </div>
    <?php endforeach ; ?>
  </main>
  <footer>
    <p><a href="index.php">Top</a></p>
  </footer>
</body>
</html>