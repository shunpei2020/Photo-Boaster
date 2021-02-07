<?php 
require_once(__DIR__ . '/env.php');

$id = $_GET['id'];
$result = Blog::getById($id);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="src/detail.css">
  <title>Detail</title>
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
  <main class="detail">
    <h2>Detail</h2>
    <div class="detail-post">
    <div class="user">
      <i class="fas fa-user"></i>
      <p><?php echo h($result['user_name']) ?></p>
    </div>
      <img src="<?php echo h($result['file_path']) ?>" alt="">
      <div class="detail-data">
        <h3>Title: <?php echo h($result['title']) ?></h3>
        <p class="content"><span>Content: </span><?php echo h($result['content']) ?></p>
        <div>
          <p class="category"><span>Category: <?php echo h(UserLogic::setCategoryName($result['category'])) ?></span></p>
          <p class="date"><span>Date: <?php echo h($result['post_at']) ?></span></p>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <p class="back"><a href="index.php">Back</a></p>
  </footer>
</body>
</html>