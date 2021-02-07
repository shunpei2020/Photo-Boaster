<?php 
require_once(__DIR__ . '/../env.php');

$result = Blog::delete($_GET['id']);
?>