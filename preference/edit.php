<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Partner Preference | Shaadi</title>
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <style>
    body {
      /* background: linear-gradient(135deg, #2c3e50, #bdc3c7); */
       background: linear-gradient(135deg, #8e44ad, #3498db);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
       padding: 40px 0;
    }
    .pref-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 420px;
      padding: 35px;
      animation: fadeIn 0.8s ease;
    }
    h2 {
      color: #2c3e50;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
    }
    label {
      font-weight: 500;
      color: #2c3e50;
      display: block;
      margin-bottom: 5px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: all 0.3s ease;
    }
    input:focus, textarea:focus {
      border-color: #8e44ad;
      box-shadow: 0 0 8px rgba(142, 68, 173, 0.3);
      outline: none;
    }
    textarea {
      resize: none;
      height: 80px;
    }
    .btn-update {
      width: 100%;
      background: linear-gradient(45deg, #3498db, #8e44ad);
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-update:hover {
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
  <div class="pref-container">
    <h2>Edit Partner Preference</h2>
    <form method="POST">
      <label>Preferred Age Range</label>
      <input type="text" name="age_range" value="<?= htmlspecialchars($pref['age_range'] ?? '') ?>">

      <label>Marital Status</label>
      <input type="text" name="marital_status" value="<?= htmlspecialchars($pref['marital_status'] ?? '') ?>">

      <label>Religion</label>
      <input type="text" name="religion" value="<?= htmlspecialchars($pref['religion'] ?? '') ?>">

      <label>Caste</label>
      <input type="text" name="caste" value="<?= htmlspecialchars($pref['caste'] ?? '') ?>">

      <label>Education</label>
      <input type="text" name="education" value="<?= htmlspecialchars($pref['education'] ?? '') ?>">

      <label>Occupation</label>
      <input type="text" name="occupation" value="<?= htmlspecialchars($pref['occupation'] ?? '') ?>">

      <label>City (Preferred)</label>
      <input type="text" name="city" value="<?= htmlspecialchars($pref['city'] ?? '') ?>">

      <label>Height Range</label>
      <input type="text" name="height_range" value="<?= htmlspecialchars($pref['height_range'] ?? '') ?>">

      <label>About Preferred Partner</label>
      <textarea name="about_partner"><?= htmlspecialchars($pref['about_partner'] ?? '') ?></textarea>

      <button type="submit" class="btn-update">Update Preference</button>
    </form>
  </div>
</body>
</html>
