<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students Management — Fee Management System</title>
  <style>
    :root {
      --accent:#06b6d4;
      --accent-2:#3b82f6;
      --muted:#f3f4f6;
      --radius:12px;
      font-family: 'Poppins', system-ui, sans-serif;
    }

    * { box-sizing:border-box; margin:0; padding:0; }

    body {
      background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
      color: #e5e7eb;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    h1 {
      font-size: 50px;
      color: var(--accent);
      margin-bottom: 40px;
      text-align: center;
      text-shadow: 1px 1px 6px rgba(0,0,0,0.7);
    }

    .menu {
      list-style: none;
      background: rgba(0,0,0,0.5);
      padding: 30px 40px;
      border-radius: var(--radius);
      width: 400px;
      max-width: 90%;
    }

    .menu li {
      margin: 18px 0;
      padding: 20px;
      background: rgba(255,255,255,0.05);
      border-radius: var(--radius);
      transition: all 0.3s ease;
      text-align: center;
    }

    .menu li:hover {
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: #fff;
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    .menu li a {
      text-decoration: none;
      color: inherit;
      font-size: 20px;
      font-weight: 500;
      display: block;
    }

    .back-btn {
      margin-top: 30px;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      border: none;
      color: #fff;
      padding: 12px 25px;
      font-size: 16px;
      border-radius: var(--radius);
      cursor: pointer;
      transition: 0.3s ease;
      text-decoration: none;
    }

    .back-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    footer {
      margin-top: 50px;
      font-size: 14px;
      color: var(--muted);
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
  <h1>Students Management</h1>
  <ul class="menu">
    <li><a href="add_student.php">Add Student</a></li>
    <li><a href="view_student.php">View Students</a></li>
    <li><a href="search_student.php">Edit Student</a></li>
    <li><a href="delete_search_student.php">Delete Student</a></li>
  </ul>

  <a href="main_menu.php" class="back-btn">← Back</a>

  <footer>© 2025 Fee Management System</footer>
</body>
</html>
