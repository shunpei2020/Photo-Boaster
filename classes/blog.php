<?php
require_once(__DIR__ . '/../env.php');

Class Blog
{
  // ブログを作成
  public static function blogCreate($blogs,$filename,$save_path,$login_user)
  {
    $sql = "INSERT INTO 
              blog(user_id, user_name, title, file_name, file_path,content, category) 
          VALUES 
              (:user_id, :user_name, :title, :file_name, :file_path, :content, :category)";

    $dbh = dbconnect();
    $dbh->beginTransaction();

    try {
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':user_id', $login_user['id'], PDO::PARAM_INT);
      $stmt->bindValue(':user_name', $login_user['name'], PDO::PARAM_STR);
      $stmt->bindValue(':title', $blogs['title'], PDO::PARAM_STR);
      $stmt->bindValue(':file_name', $filename, PDO::PARAM_STR);
      $stmt->bindValue(':file_path', $save_path, PDO::PARAM_STR);
      $stmt->bindValue(':content', $blogs['content'], PDO::PARAM_STR);
      $stmt->bindValue(':category', $blogs['category'], PDO::PARAM_INT);
      $stmt->execute();
      $dbh->commit();
      header('Location: ../index.php');
    } catch(PDOException $e) {
      $dbh->rollback();
      exit($e->getMessage());
    }
  }

  // ブログ編集
  public static function blogUpdate($blogs) 
  {
    $sql = "UPDATE blog SET
              title = :title, content = :content, category = :category
            WHERE 
              id = :id";

    $dbh = dbconnect();
    $dbh->beginTransaction();

    try {
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':title', $blogs['title'], PDO::PARAM_STR);
      $stmt->bindValue(':content', $blogs['content'], PDO::PARAM_STR);
      $stmt->bindValue(':category', $blogs['category'], PDO::PARAM_INT);
      $stmt->bindValue(':id', $blogs['id'], PDO::PARAM_INT);
      $stmt->execute();
      $dbh->commit();
      header('Location: ../index.php');
    } catch(PDOException $e) {
      $dbh->rollback();
      exit($e->getMessage());
    }
  }

  // 画像のバリデーション
  public static function blogValidate($blogs,$file,$filename,$tmp_path,$save_path) 
  {
    if ($file['size'] > 1048576 || $file['error'] === 2) {
      exit('ファイルサイズは1MB未満にしてください。');
    }
    // 拡張子は画像形式か
    $allow_ext = ['jpg', 'jpeg', 'png'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($file_ext), $allow_ext)) {
      exit('画像ファイルを添付してください。');
    }
    if (!move_uploaded_file($tmp_path, $save_path)) {
      exit('画像を選択してください。');
    }
  }

  // データベースからデータを取得
  public static function getAll()
  {
    $dbh = dbconnect();
    $sql = "SELECT * FROM blog ORDER BY id DESC";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchall();
    return $result;
    $dbh = null;
  }

  public static function getById($id)
  {
    if(empty($id)) {
      exit('IDが不正です');
    }

    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT * FROM blog Where id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();

    if(!$result) {
      exit('ブログがありません');
    }

    return $result;
  }

  // 投稿削除機能
  public static function delete($id)
  {
    if(empty($id)) {
      exit('IDが不正です');
    }

    $dbh = dbconnect();
    $stmt = $dbh->prepare("DELETE FROM blog Where id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $result = $stmt->execute();
    if ($result) {
      header('Location: /');
    }
  }
  public static function comment($comments)
  {
    $sql = 'INSERT INTO 
            comments (post_id, text, comment_user)
            VALUES
            (:post_id, :text, :comment_user)';
    $dbh = dbconnect();
    $dbh->beginTransaction();
    
    try{
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':post_id', $comments['post_id'], PDO::PARAM_INT);
      $stmt->bindValue(':comment_user', $comments['comment_user'], PDO::PARAM_STR);
      $stmt->bindValue(':text', $comments['text'], PDO::PARAM_STR);
      $stmt->execute();
      $dbh->commit();
    }catch(PDOException $e) {
      $dbh->rollback();
      exit($e->getMessage());
    }
  }
  // コメントを表示
  public static function getComment($id)
  {
    if(empty($id)) {
      exit('IDが不正です');
    }

    $sql = 'SELECT comments.* FROM comments JOIN blog ON comments.post_id = blog.id AND comments.post_id = :id';

    $dbh = dbconnect();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $comment = $stmt->fetchAll();
    return $comment;
    $dbh = null; 
  }
}
?>
