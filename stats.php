<?php
require_once 'Database.php';

$db = new Database('localhost', 'inmanage', 'root', '');

$rows = $db->select("
    SELECT 
        DATE(created_at) AS date,
        HOUR(created_at) AS hour,
        COUNT(*) AS post_count
    FROM posts
    GROUP BY DATE(created_at), HOUR(created_at)
    ORDER BY date, hour
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts Stats</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Posts Per Hour</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Hour</th>
                <th>Post Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row['date'] ?></td>
                <td><?= $row['hour'] ?>:00</td>
                <td><?= $row['post_count'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>