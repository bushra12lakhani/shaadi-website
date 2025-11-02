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

<!-- <!DOCTYPE html>
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
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Shaadi</title>
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <style>
    body {
      /* background: linear-gradient(135deg, #2c3e50, #bdc3c7); */
       background: linear-gradient(135deg, #8e44ad, #3498db);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 360px;
      padding: 40px;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }
    .login-container h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      font-weight: 600;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: all 0.3s ease;
    }
    input:focus {
      border-color: #8e44ad;
      box-shadow: 0 0 8px rgba(142, 68, 173, 0.3);
      outline: none;
    }
    .btn-login {
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
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(142, 68, 173, 0.3);
    }
    p {
      margin-top: 15px;
      color: #555;
    }
    a {
      color: #8e44ad;
      text-decoration: none;
      font-weight: 500;
    }
    a:hover {
      text-decoration: underline;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Welcome Back</h2>
    <form action="login.php" method="POST">
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit" class="btn-login">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>

