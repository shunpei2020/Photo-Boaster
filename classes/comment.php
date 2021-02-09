<?php 
require_once(__DIR__ . '/../env.php');

// 二重送信防止
$token = filter_input(INPUT_POST, 'csrf_token');

if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);

$login_user = $_SESSION['login_user'];

$comments = $_POST;
$comment = Blog::comment($comments);
header('Location: ../index.php');
?>