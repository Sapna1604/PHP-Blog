<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the post id from URL
$post_id = $_GET['id'];

// Delete the blog post
$sql = "DELETE FROM blog_posts WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $post_id, 'user_id' => $_SESSION['user_id']]);

header("Location: dashboard.php");
exit;
