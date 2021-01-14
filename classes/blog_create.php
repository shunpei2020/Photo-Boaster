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
// ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err  = $file['error'];
$upload_dir = '../images/';
$save_filename = date('YmdHis') . $filename;
$save_path = $upload_dir . $save_filename;

Blog::blogValidate($blogs,$file,$filename,$tmp_path,$save_path);
Blog::blogCreate($blogs,$filename,$save_path,$login_user);
?>