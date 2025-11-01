<?php
session_start();
include("database.php");

$error = ""; // variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        $sql = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION["username"] = $username;
            header("Location: main_menu.php");
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Fee Management - Login</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
    body { background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover; height:100vh; display:flex; justify-content:center; align-items:center; }
    .overlay { position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,60,130,0.6); z-index:1; }
    .login-container { position: relative; z-index:2; background: rgba(255,255,255,0.95); padding:40px 35px; border-radius:15px; box-shadow:0 8px 25px rgba(0,0,0,0.3); width:350px; text-align:center; }
    .login-container h2 { margin-bottom: 25px; color:#003c82; font-size:22px; }
    .input-group { margin-bottom:20px; text-align:left; }
    .input-group label { display:block; margin-bottom:5px; color:#333; font-weight:500; }
    .input-group input { width:100%; padding:10px; border:1px solid #ccc; border-radius:8px; outline:none; transition:border 0.3s; }
    .input-group input:focus { border-color:#003c82; }
    .btn { width:100%; padding:10px; background:#003c82; color:#fff; font-size:16px; border:none; border-radius:8px; cursor:pointer; transition:background 0.3s; }
    .btn:hover { background:#0051b4; }
    .error-msg { color:red; font-size:14px; margin-bottom:15px; }
    @media (max-width:480px) { .login-container { width:90%; padding:30px 20px; } .login-container h2 { font-size:20px; } }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="login-container">
    <h2>Student Fee Management</h2>

    <?php if(!empty($error)) { ?>
      <div class="error-msg"><?php echo $error; ?></div>
    <?php } ?>

    <form action="" method="post" autocomplete="off">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off" placeholder="Enter your username">
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="new-password" placeholder="Enter your password">
      </div>

      <button type="submit" class="btn">Login</button>
    </form>

  </div>
</body>
</html>
