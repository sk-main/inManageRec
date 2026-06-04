<?php
require_once 'Database.php';

$db = new Database('localhost', 'inmanage', 'root', '');

$rows = $db->select("
    SELECT u.id, u.name, u.email, u.birthday, p.title, p.body, p.created_at
    FROM users u
    JOIN posts p ON p.user_id = u.id
    WHERE MONTH(u.birthday) = MONTH(CURDATE())
      AND p.id = (
          SELECT p2.id FROM posts p2
          WHERE p2.user_id = u.id
          ORDER BY p2.created_at DESC
          LIMIT 1
      )
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Birthday Posts</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; }
        .post { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .user { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .user img { width: 48px; height: 48px; border-radius: 50%; }
        .birthday { color: #e67e22; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🎂 Birthday Posts This Month</h1>
    <?php if (empty($rows)): ?>
        <p>No birthdays this month.</p>
    <?php else: ?>
        <?php foreach ($rows as $row): ?>
        <div class="post">
            <div class="user">
                <img src="avatar.jpg" alt="avatar">
                <div>
                    <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                    <span class="birthday">🎂 Birthday: <?= $row['birthday'] ?></span>
                </div>
            </div>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['body']) ?></p>
            <small><?= $row['created_at'] ?></small>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>