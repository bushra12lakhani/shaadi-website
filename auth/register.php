<?php
include('../db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $query = "INSERT INTO users (full_name, email, password, gender, dob)
              VALUES ('$full_name', '$email', '$password', '$gender', '$dob')";

    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">Create Account</h2>
  <form method="POST" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3">
      <label>Full Name</label>
      <input type="text" name="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Gender</label>
      <select name="gender" class="form-select">
        <option>Female</option>
        <option>Male</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Date of Birth</label>
      <input type="date" name="dob" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-light w-100">Register</button>
  </form>
  <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
