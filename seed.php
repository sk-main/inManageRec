<?php
require_once 'Database.php';

$db = new Database('localhost', 'inmanage', 'root', '');

// Fetch users from JSONPlaceholder
$usersJson = file_get_contents('https://jsonplaceholder.typicode.com/users');
$users = json_decode($usersJson, true);

foreach ($users as $user) {
    $db->insert('users', [
        'id'     => $user['id'],
        'name'   => $user['name'],
        'email'  => $user['email'],
        'active' => 1,
    ]);
}

// Fetch posts from JSONPlaceholder
$postsJson = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$posts = json_decode($postsJson, true);

foreach ($posts as $post) {
    $db->insert('posts', [
        'id'         => $post['id'],
        'user_id'    => $post['userId'],
        'title'      => $post['title'],
        'body'       => $post['body'],
        'created_at' => date('Y-m-d H:i:s'),
        'active'     => 1,
    ]);
}

echo "Seeding complete.\n";