<?php 
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduQuiz - Learn Better</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 18px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav h1 {
            font-size: 28px;
            font-weight: bold;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 30px;
            margin: 40px auto;
            max-width: 480px;
        }
        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 17px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }
        input[type="text"], 
        input[type="email"], 
        input[type="password"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.15);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container nav">
            <h1>EduQuiz</h1>
            
            <?php if (isset($_SESSION['admin_id'])): ?>
                <div style="display:flex; align-items:center; gap:15px;">
                    <span>Welcome, Admin</span>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                </div>
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <div style="display:flex; align-items:center; gap:15px;">
                    <span>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Student') ?></span>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container"></div>