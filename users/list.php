<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); }

$uid = $_SESSION['user_id'];

// Logged-in user ka gender nikal lo
$userRes = mysqli_query($conn, "SELECT gender FROM users WHERE id='$uid' LIMIT 1");
$userData = mysqli_fetch_assoc($userRes);
$gender = $userData['gender'];

// Opposite gender ke profiles show karo
$res = mysqli_query($conn, "
SELECT u.id as user_id, u.full_name, p.city, p.education, p.occupation, p.photo 
FROM users u 
LEFT JOIN profiles p ON u.id = p.user_id 
WHERE u.id != '$uid' 
AND LOWER(u.gender) != LOWER('$gender')
ORDER BY u.id DESC LIMIT 50
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Members | Shaadi Lite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #8e44ad, #3498db);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: #2c3e50;
      padding-bottom: 60px;
    }
    .navbar {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(6px);
      padding: 12px 0;
      box-shadow: 0 3px 15px rgba(0,0,0,0.2);
    }
    .navbar-brand {
      color: #fff;
      font-weight: 600;
      font-size: 20px;
      letter-spacing: 0.5px;
    }
    .nav-btn {
      background: linear-gradient(45deg, #3498db, #8e44ad);
      color: #fff !important;
      border: none;
      border-radius: 8px;
      padding: 8px 18px;
      font-weight: 500;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-decoration: none;
      margin-left: 8px;
    }
    .nav-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3);
    }
    h2 {
      text-align: center;
      color: #fff;
      margin-top: 30px;
      margin-bottom: 35px;
      font-weight: 600;
      text-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    .member-card {
      background: rgba(255,255,255,0.9);
      border-radius: 14px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      overflow: hidden;
      animation: fadeIn 0.7s ease;
    }
    .member-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(142, 68, 173, 0.3);
    }
    .member-photo {
      height: 160px;
      width: 100%;
      object-fit: cover;
      border-top-left-radius: 14px;
      border-top-right-radius: 14px;
    }
    .placeholder {
      height: 160px;
      background: #f1f1f1;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #7f8c8d;
      border-top-left-radius: 14px;
      border-top-right-radius: 14px;
    }
    .card-body {
      padding: 18px;
      text-align: center;
    }
    .member-card h5 {
      color: #8e44ad;
      font-weight: 600;
      margin-top: 10px;
      margin-bottom: 5px;
    }
    .member-card p {
      margin: 0;
      color: #34495e;
    }
    .view-btn {
      display: inline-block;
      background: linear-gradient(45deg, #3498db, #8e44ad);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 500;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      margin-top: 10px;
    }
    .view-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3);
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="../dashboard/index.php">Shaadi Lite</a>
    <div>
      <a href="../dashboard/index1.php" class="nav-btn">Dashboard</a>
      <a href="../auth/logout.php" class="nav-btn">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
  <h2>Members</h2>
  <div class="row">
    <?php while($row = mysqli_fetch_assoc($res)): ?>
      <div class="col-md-4 mb-4">
        <div class="member-card h-100">
          <?php if(!empty($row['photo'])): ?>
            <img src="../assets/uploads/<?= htmlspecialchars($row['photo']) ?>" class="member-photo">
          <?php else: ?>
            <div class="placeholder">No Photo</div>
          <?php endif; ?>
          <div class="card-body">
            <h5><?= htmlspecialchars($row['full_name']) ?></h5>
            <p><?= htmlspecialchars($row['city'] ?? '') ?></p>
            <p class="small"><?= htmlspecialchars($row['education'] ?? '') ?> • <?= htmlspecialchars($row['occupation'] ?? '') ?></p>
            <a href="profile_detail.php?uid=<?= $row['user_id'] ?>" class="view-btn">View Full Profile</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
