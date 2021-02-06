<?php
session_start();
require_once 'blog.php';

// 二重送信防止
$token = filter_input(INPUT_POST, 'csrf_token');

if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);

$login_user = $_SESSION['login_user'];

$blogs = $_POST;

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

Blog::blogUpdate($blogs);
?>
