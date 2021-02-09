<?php
require_once(__DIR__ . '/env.php');

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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/reset.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Poppins:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="src/formss.css">
  <title>Updateform</title>
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
    <h2>Post Update</h2>
    <form enctype="multipart/form-data" action="./classes/blog_update.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <input type="hidden" name="user_id" value="<?php echo h($userid) ?>">
      <div class="form-group">
      <label for="title">Blog Title</label>
      <input type="text" name="title" class="form-control titles" id="title" value="<?php echo h($title) ?>">
      </div>
      <?php if (isset($err['username'])) : ?>
          <p><?php echo $err['username']; ?></p>
      <?php endif; ?>
      <img class="f-img" src="<?php echo $file_path ?>" alt="">
      <div class="form-group">
      <label for="content">Content</label>
      <textarea class="form-control texts" name="content" id="content" rows="3"><?php echo h($content) ?></textarea>
      </div>
      <div class="form-group">
      <label for="category">Category</label>
      <select class="form-control" id="category" name="category">
        <option value="1" <?php if($category === 1) echo "selected" ?>>日常</option>
        <option value="2" <?php if($category === 2) echo "selected" ?>>趣味</option>
      </select>
     </div>
     <p class="err-msgs"></p>
      <br>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <div class="posting">UPDATE</div>
    </form>
  </main>
  <footer>
    <p class="top"><a href="./index.php">Cancel</a></p>
  </footer>

  <script src="js/update.js"></script>
</body>
</html>