<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); }
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT u.id as user_id, u.full_name, p.city, p.education, p.occupation, p.photo FROM users u LEFT JOIN profiles p ON u.id = p.user_id WHERE u.id != '$uid' ORDER BY u.id DESC LIMIT 50");
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Members</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-light">
<div class="container mt-4">
  <h2 class="mb-4">Members</h2>
  <div class="row">
    <?php while($row = mysqli_fetch_assoc($res)): ?>
      <div class="col-md-4 mb-3">
        <div class="card bg-secondary text-white h-100">
          <div class="card-body text-center">
            <?php if(!empty($row['photo'])): ?>
              <img src="../assets/uploads/<?= htmlspecialchars($row['photo']) ?>" style="height:120px;" class="rounded mb-2">
            <?php else: ?>
              <div class="placeholder rounded mb-2" style="height:120px;display:flex;align-items:center;justify-content:center;">No Photo</div>
            <?php endif; ?>
            <h5><?= htmlspecialchars($row['full_name']) ?></h5>
            <p class="mb-0"><?= htmlspecialchars($row['city'] ?? '') ?></p>
            <p class="small mb-2"><?= htmlspecialchars($row['education'] ?? '') ?> • <?= htmlspecialchars($row['occupation'] ?? '') ?></p>
            <a href="profile_detail.php?uid=<?= $row['user_id'] ?>" class="btn btn-sm btn-light">View Full Profile</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
