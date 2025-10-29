<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php"); exit();
}
$uid = $_SESSION['user_id'];
$userRes = mysqli_query($conn, "SELECT * FROM users WHERE id='$uid' LIMIT 1");
$user = mysqli_fetch_assoc($userRes);
$profileRes = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id='$uid' LIMIT 1");
$profile = mysqli_fetch_assoc($profileRes);
$prefRes = mysqli_query($conn, "SELECT * FROM partner_preferences WHERE user_id='$uid' LIMIT 1");
$pref = mysqli_fetch_assoc($prefRes);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-light">
<nav class="navbar navbar-dark bg-secondary">
  <div class="container">
    <a class="navbar-brand" href="#">Shaadi Lite</a>
    <div>
      <a class="btn btn-sm btn-outline-light" href="../users/list.php">View Others</a>
      <a class="btn btn-sm btn-outline-light" href="../auth/logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-4">
      <div class="card bg-secondary text-white mb-3">
        <div class="card-body text-center">
          <?php if(!empty($profile['photo'])): ?>
            <img src="../assets/uploads/<?= htmlspecialchars($profile['photo']) ?>" class="img-fluid rounded mb-2" style="max-height:200px;">
          <?php else: ?>
            <div class="placeholder rounded mb-2" style="height:200px;display:flex;align-items:center;justify-content:center;">No Photo</div>
          <?php endif; ?>
          <h5><?= htmlspecialchars($user['full_name']) ?></h5>
          <p class="mb-0"><?= htmlspecialchars($profile['city'] ?? '') ?></p>
        </div>
      </div>
      <div class="d-grid gap-2">
        <a href="edit.php" class="btn btn-light">Edit Profile</a>
        <a href="../preference/edit.php" class="btn btn-outline-light">Edit Partner Preference</a>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card bg-secondary text-white mb-3">
        <div class="card-header">Personal Details</div>
        <div class="card-body">
          <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
          <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
          <p><strong>DOB:</strong> <?= htmlspecialchars($user['dob']) ?></p>
          <p><strong>Marital Status:</strong> <?= htmlspecialchars($profile['marital_status'] ?? '') ?></p>
          <p><strong>Education:</strong> <?= htmlspecialchars($profile['education'] ?? '') ?></p>
          <p><strong>Occupation:</strong> <?= htmlspecialchars($profile['occupation'] ?? '') ?></p>
          <p><strong>About Me:</strong> <?= nl2br(htmlspecialchars($profile['about_me'] ?? '')) ?></p>
        </div>
      </div>

      <!-- Partner Preference Details -->
      <div class="card bg-secondary text-white mb-3">
        <div class="card-header">Partner Preferences</div>
        <div class="card-body">
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
</div>

</body>
</html>
