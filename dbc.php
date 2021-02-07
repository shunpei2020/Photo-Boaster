<?php
require_once(__DIR__ . '/env.php');

// データベース接続
function dbconnect() 
{
  $host   = DB_HOST;
  $dbname = DB_NAME;
  $user   = DB_USER;
  $pass   = DB_PASS;
  $dsn    = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
  try{
    $dbh = new PDO($dsn, $user, $pass,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  } catch(PDOException $e) {
    echo '接続失敗'. $e->getMessage();
    exit();
  };

  return $dbh;
}

?>
