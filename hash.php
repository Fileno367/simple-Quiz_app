<?php
// generate-hash.php - Run this once
$plain_password = 'admin123';
$hash = password_hash($plain_password, PASSWORD_DEFAULT);

echo "<h2>New Password Hash Generated</h2>";
echo "<p><strong>Plain Password:</strong> admin123</p>";
echo "<p><strong>Generated Hash:</strong><br>" . $hash . "</p>";
echo "<hr>";
echo "<p>Copy the hash below and use it in the next step:</p>";
echo "<pre style='background:#f4f4f4;padding:15px;'>" . $hash . "</pre>";
?>