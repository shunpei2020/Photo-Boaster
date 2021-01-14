<?php 
require_once 'blog.php';

$result = Blog::delete($_GET['id']);
?>