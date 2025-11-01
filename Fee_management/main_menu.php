<?php
session_start();

// Prevent browser caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Logout logic
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Fee Management System — Main Menu</title>
  <style>
    :root{
      --accent:#06b6d4;
      --accent-2:#3b82f6;
      --muted:#f3f4f6;
      --radius:12px;
      font-family: 'Poppins', system-ui, sans-serif;
    }

    *{box-sizing:border-box;margin:0;padding:0;}
    body{
      background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
      color:#e5e7eb;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      flex-direction:column;
    }

    h1{
      font-size:50px;
      margin-bottom:40px;
      color:var(--accent);
      text-align:center;
      text-shadow: 1px 1px 6px rgba(0,0,0,0.7);
    }

    ul.menu{
      list-style:none;
      background:rgba(0,0,0,0.5);
      padding:30px 30px;
      border-radius:var(--radius);
      box-shadow:0 6px 20px rgba(0,0,0,0.6);
      width:400px;
      max-width:90%;
      text-align: center;
    }

    ul.menu li{
      margin:18px 0;
    }

    /* Links and buttons inside menu */
    ul.menu a,
    ul.menu button{
      color:#e5e7eb;
      text-decoration:none;
      font-size:20px;
      font-weight:500;
      display:block;
      padding:14px 20px;
      border-radius:var(--radius);
      transition: all 0.3s ease, transform 0.2s ease;
      background: none;
      border: none;
      cursor: pointer;
      width: 100%;
      text-align: center;
    }

    /* Hover effect for links and buttons */
    ul.menu li:hover a,
    ul.menu li:hover button{
      background:linear-gradient(135deg, var(--accent), var(--accent-2));
      color:#fff;
      transform: scale(1.05);
    }

    footer{
      margin-top:50px;
      font-size:14px;
      color:var(--muted);
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
  <h1>Fee Management System</h1>
  <ul class="menu">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="student.php">Students</a></li>
    <li><a href="collect_fee.php">Collect Fee</a></li>
    <li><a href="fee_report.php">Fee Report</a></li>
    <li><a href="due_report.php">Due Report</a></li>
    <li><a href="setting.php">Settings</a></li>
    <li>
      <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
      </form>
    </li>
  </ul>
  <footer>© 2025 Fee Management System</footer>
</body>
</html>
