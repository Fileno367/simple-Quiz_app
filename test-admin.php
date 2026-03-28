<?php
require_once 'config/database.php';

echo "<h2>Database Connection Test</h2>";

$stmt = $pdo->query("SELECT * FROM admins WHERE username = 'admin'");
$admin = $stmt->fetch();

if ($admin) {
    echo "<pre>";
    print_r($admin);
    echo "</pre>";
    
    echo "<br>Password hash in DB: " . $admin['password'];
    echo "<br><br>Now try to verify password 'admin123':<br>";
    
    if (password_verify('admin123', $admin['password'])) {
        echo "<span style='color:green;font-size:20px'>✅ Password verification SUCCESS!</span>";
    } else {
        echo "<span style='color:red;font-size:20px'>❌ Password verification FAILED</span>";
    }
} else {
    echo "No admin user found!";
}
?>