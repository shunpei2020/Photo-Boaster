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

  // ブログのバリデーション
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
    if (empty($blogs['title'])) {
      exit('タイトルを入力してください。');
    }
    if (mb_strlen($blogs['title']) > 200) {
      exit('タイトルは200文字以内で入力してください。');
    }
    if (empty($blogs['content'])) {
      exit('テキストを入力してください。');
    }
    if (empty($blogs['category'])) {
      exit('カテゴリーを選択してください。');
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
}
?>
