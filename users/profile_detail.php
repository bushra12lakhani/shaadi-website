<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); }

if (!isset($_GET['uid'])) {
  header("Location: list.php"); exit();
}

$uid = $_GET['uid'];

// user basic info
$userRes = mysqli_query($conn, "SELECT * FROM users WHERE id='$uid' LIMIT 1");
$user = mysqli_fetch_assoc($userRes);

// profile info
$profileRes = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id='$uid' LIMIT 1");
$profile = mysqli_fetch_assoc($profileRes);

// partner preference info
$prefRes = mysqli_query($conn, "SELECT * FROM partner_preferences WHERE user_id='$uid' LIMIT 1");
$pref = mysqli_fetch_assoc($prefRes);

if (!$user) {
  echo "<h3 class='text-center mt-5 text-danger'>User not found!</h3>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($user['full_name']) ?> - Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <style>
    /* Navbar override for gradient theme */
    .navbar {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(6px);
      padding: 12px 0;
      box-shadow: 0 3px 15px rgba(0,0,0,0.2);
    }
    .navbar-brand, .nav-btn {
      color: #fff !important;
    }
    .nav-btn {
      background: linear-gradient(45deg, #3498db, #8e44ad);
      border: none;
      border-radius: 8px;
      padding: 6px 16px;
      font-weight: 500;
      text-decoration: none;
      margin-left: 8px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .nav-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3);
    }

    /* Card styling like Members page */
    .member-card {
      background: rgba(255,255,255,0.9);
      border-radius: 14px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      overflow: hidden;
      margin-bottom: 20px;
    }
    .member-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(142, 68, 173, 0.3);
    }
    .member-photo {
      height: 200px;
      width: 100%;
      object-fit: cover;
      border-top-left-radius: 14px;
      border-top-right-radius: 14px;
    }
    .placeholder {
      height: 200px;
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
    .section-title {
      font-size: 22px;
      font-weight: 600;
      color: #8e44ad;
      margin-bottom: 15px;
      text-shadow: 0 3px 10px rgba(0,0,0,0.2);
       border-bottom: 2px solid #eee;
      padding-bottom: 8px;
    
      
    }
  </style>
</head>
<body style="background: linear-gradient(135deg, #8e44ad, #3498db); min-height:100vh; font-family:'Poppins',sans-serif; color:#fff;">

<nav class="navbar">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="list.php">Back to Members</a>
    <a href="../dashboard/index.php" class="nav-btn">Dashboard</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <!-- Left Column: Photo + Name -->
    <div class="col-md-4">
      <div class="member-card text-center">
        <?php if(!empty($profile['photo'])): ?>
          <img src="../assets/uploads/<?= htmlspecialchars($profile['photo']) ?>" class="member-photo">
        <?php else: ?>
          <div class="placeholder">No Photo</div>
        <?php endif; ?>
        <div class="card-body">
          <h5><?= htmlspecialchars($user['full_name']) ?></h5>
          <p><?= htmlspecialchars($profile['city'] ?? '') ?></p>
        </div>
      </div>
    </div>

    <!-- Right Column: Personal Info + Partner Preferences -->
    <div class="col-md-8">
      <div class="member-card">
        <div class="card-body">
          <div class="section-title">Personal Information</div>
          <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
          <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
          <p><strong>DOB:</strong> <?= htmlspecialchars($user['dob']) ?></p>
          <p><strong>Marital Status:</strong> <?= htmlspecialchars($profile['marital_status'] ?? '') ?></p>
          <p><strong>Religion:</strong> <?= htmlspecialchars($profile['religion'] ?? '') ?></p>
          <p><strong>Caste:</strong> <?= htmlspecialchars($profile['caste'] ?? '') ?></p>
          <p><strong>Education:</strong> <?= htmlspecialchars($profile['education'] ?? '') ?></p>
          <p><strong>Occupation:</strong> <?= htmlspecialchars($profile['occupation'] ?? '') ?></p>
          <p><strong>About Me:</strong> <?= nl2br(htmlspecialchars($profile['about_me'] ?? '')) ?></p>
        </div>
      </div>

      <?php if($pref): ?>
      <div class="member-card">
        <div class="card-body">
          <div class="section-title">Partner Preferences</div>
          <p><strong>Age Range:</strong> <?= htmlspecialchars($pref['age_range'] ?? '') ?></p>
          <p><strong>Marital Status:</strong> <?= htmlspecialchars($pref['marital_status'] ?? '') ?></p>
          <p><strong>Religion:</strong> <?= htmlspecialchars($pref['religion'] ?? '') ?></p>
          <p><strong>Caste:</strong> <?= htmlspecialchars($pref['caste'] ?? '') ?></p>
          <p><strong>Education:</strong> <?= htmlspecialchars($pref['education'] ?? '') ?></p>
          <p><strong>Occupation:</strong> <?= htmlspecialchars($pref['occupation'] ?? '') ?></p>
          <p><strong>City:</strong> <?= htmlspecialchars($pref['city'] ?? '') ?></p>
          <p><strong>Height Range:</strong> <?= htmlspecialchars($pref['height_range'] ?? '') ?></p>
          <p><strong>About Partner:</strong> <?= nl2br(htmlspecialchars($pref['about_partner'] ?? '')) ?></p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
