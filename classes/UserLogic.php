<?php 
require_once dirname(__FILE__) . '/../dbc.php';

class UserLogic
{
  // ユーザー登録
  public static function createUser($userData)
  {
    $result = false;

    $sql = 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)';

    // ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $userData['username'];
    $arr[] = $userData['email'];
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

    try {
      $stmt = dbconnect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch(\Exception $e) {
      $e->getMessage();
      return $result;
    }
  }
  // ログイン処理
  public static function login($email, $password)
  {
    $result = false;
    // ユーザをemailから検索して取得
    $user = self::getUserByEmail($email);

    if (!$user) {
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;
    }

    // パスワードの照会
    if (password_verify($password, $user['password'])) {
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }

    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
  }

  // emailからユーザを取得
  public static function getUserByEmail($email)
  {
    $sql = 'SELECT * FROM users WHERE email = ?';
    $arr = [];
    $arr[] = $email;
    try {
      $stmt = dbconnect()->prepare($sql);
      $stmt->execute($arr);
      $user = $stmt->fetch();
      return $user;
    } catch(\Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }

  // ログインチェック
  public static function checkLogin()
  {
    $result = false;

    if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
      return $result = true;
    }

    return $result;
  }

  // ログアウト
  public static function logout()
  {
    $_SESSION = array();
    session_destroy();
  }

  // ユーザ情報を取得
  public static function getUserData($login_user)
  {
    $result = false;

    $sql = "SELECT * FROM 
            users AS T1 JOIN blog AS T2 
            ON T1.id = T2.user_id
            AND T1.id = ?";
    $arr= [];
    $arr[] = $login_user['id'];
    try {
      $dbh = dbconnect();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($arr);
      $result = $stmt->fetchAll();
      return $result;
    } catch(PDOException $e) {
      $e->getMessage();
      return $result;
    }
  }

  // カテゴリー名を表示
  public static function setcategoryName($category)
  {
    if ($category === '1') {
      return '日常';
    } elseif($category === '2') {
      return '趣味';
    } else {
      return 'その他';
    }
  }
}

?>