<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php"); exit();
}
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM partner_preferences WHERE user_id='$uid' LIMIT 1");
$pref = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age_range = $_POST['age_range'];
    $marital_status = $_POST['marital_status'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $education = $_POST['education'];
    $occupation = $_POST['occupation'];
    $city = $_POST['city'];
    $height_range = $_POST['height_range'];
    $about_partner = $_POST['about_partner'];

    $q = "UPDATE partner_preferences SET age_range='$age_range', marital_status='$marital_status', religion='$religion', caste='$caste', education='$education', occupation='$occupation', city='$city', height_range='$height_range', about_partner='$about_partner' WHERE user_id='$uid'";
    mysqli_query($conn, $q);
    header("Location: ../profile/view.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Preference</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-4">
  <h2 class="mb-4 text-center">Edit Partner Preference</h2>
  <form method="POST" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3"><label>Preferred Age Range</label><input name="age_range" value="<?= htmlspecialchars($pref['age_range'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Marital Status</label><input name="marital_status" value="<?= htmlspecialchars($pref['marital_status'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Religion</label><input name="religion" value="<?= htmlspecialchars($pref['religion'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Caste</label><input name="caste" value="<?= htmlspecialchars($pref['caste'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Education</label><input name="education" value="<?= htmlspecialchars($pref['education'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Occupation</label><input name="occupation" value="<?= htmlspecialchars($pref['occupation'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>City (preferred)</label><input name="city" value="<?= htmlspecialchars($pref['city'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Height Range</label><input name="height_range" value="<?= htmlspecialchars($pref['height_range'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>About Preferred Partner</label><textarea name="about_partner" class="form-control"><?= htmlspecialchars($pref['about_partner'] ?? '') ?></textarea></div>
    <button class="btn btn-light w-100">Update</button>
  </form>
</div>
</body>
</html>
