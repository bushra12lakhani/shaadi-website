<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}

$uid = $_SESSION['user_id'];
$userRes = mysqli_query($conn, "SELECT * FROM users WHERE id='$uid' LIMIT 1");
$user = mysqli_fetch_assoc($userRes);
$profileRes = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id='$uid' LIMIT 1");
$profile = mysqli_fetch_assoc($profileRes);
$prefRes = mysqli_query($conn, "SELECT * FROM partner_preferences WHERE user_id='$uid' LIMIT 1");
$pref = mysqli_fetch_assoc($prefRes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Shaadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #8e44ad, #3498db);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: #2c3e50;
      padding: 40px 0;
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

    .dashboard-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 90%;
      max-width: 1100px;
      margin: auto;
      padding: 35px;
      animation: fadeIn 0.8s ease;
    }
    .profile-photo {
      max-height: 200px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
      margin-bottom: 10px;
    }
    .info-card {
      background: rgba(255,255,255,0.9);
      border-radius: 12px;
      padding: 20px 25px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      margin-bottom: 25px;
      color: #2c3e50;
    }
    .info-card h4 {
      color: #8e44ad;
      border-bottom: 2px solid #eee;
      padding-bottom: 8px;
      margin-bottom: 15px;
      font-weight: 600;
    }
    .info-card p strong {
      color: #34495e;
    }
    .btn-custom {
      display: block;
      width: 100%;
      background: linear-gradient(45deg, #3498db, #8e44ad);
      border: none;
      color: #fff;
      border-radius: 8px;
      padding: 10px;
      font-weight: 600;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-align: center;
      text-decoration: none;
    }
    .btn-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(142, 68, 173, 0.3);
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
    <a class="navbar-brand" href="#">Shaadi Lite</a>
    <div>
      <a href="../users/list.php" class="nav-btn">View Others</a>
      <a href="../auth/logout.php" class="nav-btn">Logout</a>
    </div>
  </div>
</nav>

<div class="dashboard-container mt-4">
  <div class="row">
    <div class="col-md-4 text-center">
      <?php if(!empty($profile['photo'])): ?>
        <img src="../assets/uploads/<?= htmlspecialchars($profile['photo']) ?>" class="profile-photo img-fluid">
      <?php else: ?>
        <div style="height:200px;display:flex;align-items:center;justify-content:center;background:#f1f1f1;border-radius:10px;color:#7f8c8d;">No Photo</div>
      <?php endif; ?>
      <h5 class="mt-3 mb-1"><?= htmlspecialchars($user['full_name']) ?></h5>
      <p class="text-muted"><?= htmlspecialchars($profile['city'] ?? '') ?></p>

      <div class="mt-3">
        <a href="edit.php" class="btn-custom mb-2">Edit Profile</a>
        <a href="../preference/edit.php" class="btn-custom">Edit Partner Preference</a>
      </div>
    </div>

    <div class="col-md-8">
      <div class="info-card">
        <h4>Personal Details</h4>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
        <p><strong>DOB:</strong> <?= htmlspecialchars($user['dob']) ?></p>
        <p><strong>Marital Status:</strong> <?= htmlspecialchars($profile['marital_status'] ?? '') ?></p>
        <p><strong>Education:</strong> <?= htmlspecialchars($profile['education'] ?? '') ?></p>
        <p><strong>Occupation:</strong> <?= htmlspecialchars($profile['occupation'] ?? '') ?></p>
        <p><strong>About Me:</strong> <?= nl2br(htmlspecialchars($profile['about_me'] ?? '')) ?></p>
      </div>

      <div class="info-card">
        <h4>Partner Preferences</h4>
        <p><strong>Preferred Age Range:</strong> <?= htmlspecialchars($pref['age_range'] ?? '') ?></p>
        <p><strong>Preferred Marital Status:</strong> <?= htmlspecialchars($pref['marital_status'] ?? '') ?></p>
        <p><strong>Religion:</strong> <?= htmlspecialchars($pref['religion'] ?? '') ?></p>
        <p><strong>Caste:</strong> <?= htmlspecialchars($pref['caste'] ?? '') ?></p>
        <p><strong>Education:</strong> <?= htmlspecialchars($pref['education'] ?? '') ?></p>
        <p><strong>Occupation:</strong> <?= htmlspecialchars($pref['occupation'] ?? '') ?></p>
        <p><strong>City Preference:</strong> <?= htmlspecialchars($pref['city'] ?? '') ?></p>
        <p><strong>Height Range:</strong> <?= htmlspecialchars($pref['height_range'] ?? '') ?></p>
        <p><strong>About Partner:</strong> <?= nl2br(htmlspecialchars($pref['about_partner'] ?? '')) ?></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
