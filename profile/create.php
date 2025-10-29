<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['user_id'];
    $marital = $_POST['marital_status'];
    $city = $_POST['city'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $education = $_POST['education'];
    $occupation = $_POST['occupation'];
    $about = $_POST['about_me'];

    $photo = "";
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/uploads/" . $photo);
    }

    $q = "INSERT INTO profiles (user_id, marital_status, city, religion, caste, education, occupation, about_me, photo)
          VALUES ('$uid', '$marital', '$city', '$religion', '$caste', '$education', '$occupation', '$about', '$photo')";
    mysqli_query($conn, $q);
    header("Location: ../preference/create.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-4">
  <h2 class="text-center mb-4">Create Your Profile</h2>
  <form method="POST" enctype="multipart/form-data" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3"><label>Marital Status</label><input type="text" name="marital_status" class="form-control"></div>
    <div class="mb-3"><label>City</label><input type="text" name="city" class="form-control"></div>
    <div class="mb-3"><label>Religion</label><input type="text" name="religion" class="form-control"></div>
    <div class="mb-3"><label>Caste</label><input type="text" name="caste" class="form-control"></div>
    <div class="mb-3"><label>Education</label><input type="text" name="education" class="form-control"></div>
    <div class="mb-3"><label>Occupation</label><input type="text" name="occupation" class="form-control"></div>
    <div class="mb-3"><label>About Me</label><textarea name="about_me" class="form-control"></textarea></div>
    <div class="mb-3"><label>Profile Photo</label><input type="file" name="photo" class="form-control"></div>
    <button class="btn btn-light w-100">Save & Continue</button>
  </form>
</div>
</body>
</html>
