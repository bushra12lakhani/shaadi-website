<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit(); }
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id='$uid' LIMIT 1");
$profile = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marital = $_POST['marital_status'];
    $city = $_POST['city'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $education = $_POST['education'];
    $occupation = $_POST['occupation'];
    $about = $_POST['about_me'];

    // Photo handling
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/uploads/" . $photo);
        $photo_sql = ", photo='$photo'";
    } else {
        $photo_sql = "";
    }

    if ($profile) {
        $q = "UPDATE profiles SET marital_status='$marital', city='$city', religion='$religion', caste='$caste', education='$education', occupation='$occupation', about_me='$about' $photo_sql WHERE user_id='$uid'";
    } else {
        $q = "INSERT INTO profiles (user_id, marital_status, city, religion, caste, education, occupation, about_me, photo) VALUES ('$uid','$marital','$city','$religion','$caste','$education','$occupation','$about','".($photo ?? "")."')";
    }
    mysqli_query($conn, $q);
    header("Location: view.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-dark text-light">
<div class="container mt-4">
  <h2 class="mb-4 text-center">Edit Profile</h2>
  <form method="POST" enctype="multipart/form-data" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3"><label>Marital Status</label><input name="marital_status" value="<?= htmlspecialchars($profile['marital_status'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>City</label><input name="city" value="<?= htmlspecialchars($profile['city'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Religion</label><input name="religion" value="<?= htmlspecialchars($profile['religion'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Caste</label><input name="caste" value="<?= htmlspecialchars($profile['caste'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Education</label><input name="education" value="<?= htmlspecialchars($profile['education'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>Occupation</label><input name="occupation" value="<?= htmlspecialchars($profile['occupation'] ?? '') ?>" class="form-control"></div>
    <div class="mb-3"><label>About Me</label><textarea name="about_me" class="form-control"><?= htmlspecialchars($profile['about_me'] ?? '') ?></textarea></div>
    <div class="mb-3"><label>Profile Photo</label><input type="file" name="photo" class="form-control"></div>
    <button class="btn btn-light w-100">Save</button>
  </form>
</div>
</body>
</html>
