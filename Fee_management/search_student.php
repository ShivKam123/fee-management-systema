<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include("database.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    // Check if student exists
    $check = "SELECT * FROM Student WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $check);

    if ($result && mysqli_num_rows($result) > 0) {
        header("Location: edit_student.php?id=$student_id");
        exit;
    } else {
        $error = "No student found with ID: $student_id";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Find Student — Fee Management System</title>
<style>
:root {
      --accent:#06b6d4;
      --accent-2:#3b82f6;
      --muted:#f3f4f6;
      --radius:12px;
      font-family: 'Poppins', system-ui, sans-serif;
    }
body {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
  background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
  color: #fff;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(5px);
}

.find-box {
  width: 400px;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(8px);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  text-align: center;
}

.find-box h2 {
  color: #00d9ff;
  margin-bottom: 20px;
  text-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
}

.find-box input[type="text"] {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border-radius: 8px;
  border: none;
  margin-top: 10px;
  margin-bottom: 15px;
  outline: none;
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
}

.find-box input::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.find-box button {
  width: 100%;
  padding: 12px;
  background-color: #00d9ff;
  border: none;
  color: #0f172a;
  font-size: 16px;
  border-radius: 8px;
  font-weight: 600;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: background 0.3s, box-shadow 0.3s;
  box-shadow: 0 0 10px rgba(0, 217, 255, 0.6);
}

.find-box button:hover {
  background-color: #00bfe0;
  box-shadow: 0 0 15px rgba(0, 217, 255, 0.8);
}

.error {
  color: #ff4d4d;
  margin-top: 15px;
  font-size: 0.95em;
  text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
}

/* Back Button Below Search Box */
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
</style>
</head>
<body>

<div class="find-box">
  <h2>Find Student</h2>
  <form method="POST" autocomplete="off">
    <input type="text" name="student_id" placeholder="Enter Student ID" required>
    <button type="submit">Search</button>
  </form>

  <?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
  <?php endif; ?>
</div>

<!-- Back Button (separate from box) -->
<a href="student.php" class="back-btn">← Back</a>

</body>
</html>
