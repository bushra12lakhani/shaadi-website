<?php
session_start();
include('../db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        // check if profile exists
        $profile_check = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id = {$user['id']}");
        if (mysqli_num_rows($profile_check) == 0) {
            header("Location: ../profile/create.php");
        } else {
            header("Location: ../profile/view.php");
        }
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">Login</h2>
  <form method="POST" class="bg-secondary p-4 rounded shadow">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <button type="submit" class="btn btn-light w-100">Login</button>
  </form>
  <p class="text-center mt-3">New user? <a href="register.php">Register</a></p>
</div>
</body>
</html>
