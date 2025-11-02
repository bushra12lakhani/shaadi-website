<?php
session_start();
include('../db/connection.php');
if (!isset($_SESSION['user_id'])) { 
  header("Location: ../auth/login.php"); 
  exit(); 
}

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

    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/uploads/" . $photo);
        $photo_sql = ", photo='$photo'";
    } else {
        $photo_sql = "";
    }

    if ($profile) {
        $q = "UPDATE profiles 
              SET marital_status='$marital', city='$city', religion='$religion', caste='$caste', 
                  education='$education', occupation='$occupation', about_me='$about' $photo_sql 
              WHERE user_id='$uid'";
    } else {
        $q = "INSERT INTO profiles 
              (user_id, marital_status, city, religion, caste, education, occupation, about_me, photo) 
              VALUES ('$uid','$marital','$city','$religion','$caste','$education','$occupation','$about','".($photo ?? "")."')";
    }

    mysqli_query($conn, $q);
    header("Location: view.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile | Shaadi</title>
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
    .profile-container {
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
    .btn-save {
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
    .btn-save:hover {
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
  <div class="profile-container">
    <h2>Edit Your Profile</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Marital Status</label>
      <input type="text" name="marital_status" value="<?= htmlspecialchars($profile['marital_status'] ?? '') ?>" required>

      <label>City</label>
      <input type="text" name="city" value="<?= htmlspecialchars($profile['city'] ?? '') ?>" required>

      <label>Religion</label>
      <input type="text" name="religion" value="<?= htmlspecialchars($profile['religion'] ?? '') ?>" required>

      <label>Caste</label>
      <input type="text" name="caste" value="<?= htmlspecialchars($profile['caste'] ?? '') ?>">

      <label>Education</label>
      <input type="text" name="education" value="<?= htmlspecialchars($profile['education'] ?? '') ?>">

      <label>Occupation</label>
      <input type="text" name="occupation" value="<?= htmlspecialchars($profile['occupation'] ?? '') ?>">

      <label>About Me</label>
      <textarea name="about_me"><?= htmlspecialchars($profile['about_me'] ?? '') ?></textarea>

      <label>Profile Photo</label>
      <input type="file" name="photo" accept="image/*">

      <button type="submit" class="btn-save">Save Changes</button>
    </form>
  </div>
</body>
</html>
