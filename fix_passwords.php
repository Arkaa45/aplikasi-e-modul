<?php
/**
 * Fix Passwords Script
 * Run this in browser: http://localhost/e-modul/fix_passwords.php
 * This will update password hashes in the database
 */

// Load CodeIgniter
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');
define('ENVIRONMENT', 'development');
define('FCPATH', __DIR__ . '/');

// Database config
$db = new mysqli('localhost', 'root', '', 'e_modul_praktikum');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Password hashes
$passwords = [
    ['email' => 'admin@lab.ac.id', 'password' => 'admin123'],
    ['email' => 'laboran@lab.ac.id', 'password' => 'laboran123'],
    ['email' => 'mhs@student.ac.id', 'password' => 'mhs123'],
    ['email' => 'siti@student.ac.id', 'password' => 'mhs123'],
    ['email' => 'rizki@student.ac.id', 'password' => 'mhs123'],
];

echo "<h1>E-Modul Praktikum - Fix Passwords</h1>";
echo "<pre>";

foreach ($passwords as $user) {
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $email = $db->real_escape_string($user['email']);

    $sql = "UPDATE users SET password = '$hash' WHERE email = '$email'";

    if ($db->query($sql)) {
        echo "✅ Updated: {$user['email']} (password: {$user['password']})\n";
        echo "   Hash: $hash\n\n";
    } else {
        echo "❌ Failed: {$user['email']} - " . $db->error . "\n\n";
    }
}

echo "</pre>";
echo "<h2>Done! Now you can login with:</h2>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@lab.ac.id / admin123</li>";
echo "<li><strong>Laboran:</strong> laboran@lab.ac.id / laboran123</li>";
echo "<li><strong>Mahasiswa:</strong> mhs@student.ac.id / mhs123</li>";
echo "</ul>";
echo "<p><a href='" . (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] . '/e-modul/' : '/e-modul/') . "'>Klik di sini untuk ke halaman login</a></p>";

$db->close();
?>