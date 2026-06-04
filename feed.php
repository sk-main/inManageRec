<?php
require_once 'Database.php';

$db = new Database('localhost', 'inmanage', 'root', '');

$rows = $db->select("
    SELECT u.id, u.name, u.email, p.title, p.body, p.created_at
    FROM users u
    JOIN posts p ON p.user_id = u.id
    WHERE u.active = 1 AND p.active = 1
    ORDER BY u.id, p.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Social Feed</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; }
        .post { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .user { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .user img { width: 48px; height: 48px; border-radius: 50%; }
        .user strong { font-size: 16px; }
        .user span { color: #888; font-size: 13px; }
        h3 { margin: 0 0 6px; }
        p { margin: 0; color: #444; }
    </style>
</head>
<body>
    <h1>Feed</h1>
    <?php foreach ($rows as $row): ?>
    <div class="post">
        <div class="user">
            <img src="avatar.jpg" alt="avatar">
            <div>
                <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                <span><?= htmlspecialchars($row['email']) ?></span>
            </div>
        </div>
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['body']) ?></p>
        <small><?= $row['created_at'] ?></small>
    </div>
    <?php endforeach; ?>
</body>
</html>