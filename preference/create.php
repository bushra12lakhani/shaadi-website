<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['user_id'];
    $age_range = $_POST['age_range'];
    $marital_status = $_POST['marital_status'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $education = $_POST['education'];
    $occupation = $_POST['occupation'];
    $city = $_POST['city'];
    $height_range = $_POST['height_range'];
    $about_partner = $_POST['about_partner'];

    $q = "INSERT INTO partner_preferences (user_id, age_range, marital_status, religion, caste, education, occupation, city, height_range, about_partner)
          VALUES ('$uid','$age_range','$marital_status','$religion','$caste','$education','$occupation','$city','$height_range','$about_partner')";
    mysqli_query($conn, $q);
    header("Location: ../profile/view.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create Preference</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-4">
  <h2 class="mb-4 text-center">Partner Preference</h2>
  <form method="POST" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3"><label>Preferred Age Range</label><input name="age_range" class="form-control"></div>
    <div class="mb-3"><label>Marital Status</label><input name="marital_status" class="form-control"></div>
    <div class="mb-3"><label>Religion</label><input name="religion" class="form-control"></div>
    <div class="mb-3"><label>Caste</label><input name="caste" class="form-control"></div>
    <div class="mb-3"><label>Education</label><input name="education" class="form-control"></div>
    <div class="mb-3"><label>Occupation</label><input name="occupation" class="form-control"></div>
    <div class="mb-3"><label>City (preferred)</label><input name="city" class="form-control"></div>
    <div class="mb-3"><label>Height Range</label><input name="height_range" class="form-control"></div>
    <div class="mb-3"><label>About Preferred Partner</label><textarea name="about_partner" class="form-control"></textarea></div>
    <button class="btn btn-light w-100">Save Preference</button>
  </form>
</div>
</body>
</html>
