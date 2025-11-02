<?php
include('../db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    // 🔹 STEP 1: Calculate age from DOB
    $dobDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($dobDate)->y;

    // 🔸 STEP 2: Check if under 18
    if ($age < 18) {
        echo "<script>alert('Sorry! You must be 18 years or older to register.'); window.history.back();</script>";
        exit();
    }

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

<!-- <!DOCTYPE html>
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
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Shaadi</title>
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <style>
    body {
      background: linear-gradient(135deg, #8e44ad, #3498db);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 14px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 420px;
      padding: 40px;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }
    .register-container h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      font-weight: 600;
    }
    input, select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: all 0.3s ease;
    }
    input:focus, select:focus {
      border-color: #3498db;
      box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
      outline: none;
    }
    .btn-register {
      width: 100%;
      background: linear-gradient(45deg, #8e44ad, #3498db);
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
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

     select {
  width: 100%;
  box-sizing: border-box;
  -webkit-appearance: none; 
  -moz-appearance: none;    
  appearance: none;
}

select {
  background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='16' viewBox='0 0 24 24' width='16' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 14px;
  padding-right: 30px;
} 

  </style>
</head>
<body>
  <div class="register-container">
    <h2>Create Account</h2>
    <form action="register.php" method="POST">
      <input type="text" name="full_name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <select name="gender" required>
        <option value="" disabled selected>Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
      <input type="date" name="dob" required>
      <button type="submit" class="btn-register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>

