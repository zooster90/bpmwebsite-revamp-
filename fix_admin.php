<?php
$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');

// Show all users
$users = $db->query('SELECT id, name, email FROM users')->fetchAll(PDO::FETCH_ASSOC);
echo "=== CURRENT USERS ===\n";
foreach ($users as $u) {
    echo $u['id'] . ' | ' . $u['name'] . ' | ' . $u['email'] . "\n";
}

// Reset password for ALL users to 'password'
$hash = password_hash('password', PASSWORD_BCRYPT);
$stmt = $db->prepare('UPDATE users SET password = ?');
$stmt->execute([$hash]);

echo "\n=== PASSWORD RESET DONE ===\n";
echo "All users can now log in with password: password\n";

// Verify
$users2 = $db->query('SELECT id, name, email FROM users')->fetchAll(PDO::FETCH_ASSOC);
foreach ($users2 as $u) {
    echo "Ready: " . $u['email'] . "\n";
}
