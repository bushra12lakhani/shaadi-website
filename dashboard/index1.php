<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}

$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id='$uid' LIMIT 1");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Shaadi Lite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #8e44ad, #3498db);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .welcome-card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 40px 60px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    h1 {
      font-weight: 600;
      margin-bottom: 10px;
    }
    p {
      font-size: 18px;
      color: #f1f1f1;
    }
    .btn-gradient {
      background: linear-gradient(45deg, #3498db, #8e44ad);
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      color: #fff;
      font-weight: 500;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(142,68,173,0.3);
    }
  </style>
</head>
<body>
  <div class="welcome-card">
    <h1>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h1>
    <p>Your dashboard is ready.</p>
    <a href="../users/list.php" class="btn-gradient">View Members</a>
    <a href="../auth/logout.php" class="btn-gradient">Logout</a>
  </div>
</body>
</html>
