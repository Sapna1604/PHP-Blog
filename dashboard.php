<?php
session_start();
require_once 'config.php'; // Include your database configuration

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit; 
}

$user_id = $_SESSION['user_id'];
// Fetch user details
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch posts created by the user
$sql_posts = "SELECT * FROM blog_posts WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt_posts = $pdo->prepare($sql_posts);
$stmt_posts->execute(['user_id' => $user_id]);
$posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);

// Handle post deletion
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $sql_delete = "DELETE FROM blog_posts WHERE id = :id AND user_id = :user_id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute(['id' => $post_id, 'user_id' => $user_id]);

    header("Location: dashboard.php"); // Redirect back to the dashboard
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e7f3fe;
            border: 1px solid #bee3f8;
            border-radius: 4px;
        }

        .post {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .post:last-child {
            border: none; /* Remove border for the last post */
        }

        .button {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .action-button {
            margin-left: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color: #28a745;
            color: white;
        }

        .edit-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .button {
                width: 100%;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column; /* Stack buttons on smaller screens */
            }

            .action-button {
                margin-left: 0;
                margin-bottom: 5px; /* Add margin below each button */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>

        <!-- Display user information -->
        <div class="user-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <a href="edit_profile.php" class="button">Edit Profile</a> <!-- Edit Profile Button -->
        <a href="create_post.php" class="button">Create Post</a>
        <h2>Your Posts</h2>

        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small>
                    <div class="action-buttons">
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="action-button edit-button">Edit</a>
                        <a href="?delete=<?php echo $post['id']; ?>" class="action-button delete-button" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
