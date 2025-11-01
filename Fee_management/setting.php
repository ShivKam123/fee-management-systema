<?php
session_start();
include("database.php");

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_SESSION['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "❌ New passwords do not match.";
    } else {
        // Check if current password is correct
        $query = "SELECT password FROM User WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            if ($current_password === $stored_password) {
                // Update password directly (plain text)
                $update = "UPDATE User SET password = ? WHERE username = ?";
                $stmt_update = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($stmt_update, "ss", $new_password, $username);
                mysqli_stmt_execute($stmt_update);

                if (mysqli_stmt_affected_rows($stmt_update) > 0) {
                    $message = "✅ Password updated successfully!";
                } else {
                    $message = "⚠️ No changes made.";
                }
            } else {
                $message = "❌ Incorrect current password.";
            }
        } else {
            $message = "❌ User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password — Fee Management System</title>
  <style>
    :root {
      --card-bg: rgba(0, 0, 0, 0.6);
      --accent: #00b4d8;
      --accent-hover: #0096c7;
      --text: #e0e1dd;
    }

    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: var(--text);
    }

    .container {
      width: 400px;
      background: var(--card-bg);
      padding: 35px;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0, 180, 216, 0.25);
      backdrop-filter: blur(8px);
      position: relative;
    }

.back-btn {
    position: fixed;   /* Fix the button on screen */
    top: 20px;         /* Distance from top */
    left: 20px;        /* Distance from left */
    z-index: 999;      /* Make sure it stays above other elements */
      /* margin-top: 20px; */
      background: linear-gradient(135deg, #06b6d4, #3b82f6);
      border: none;
      color: #fff;
      padding: 12px 25px;
      font-size: 16px;
      border-radius: var(--radius);
      cursor: pointer;
      transition: 0.3s ease;
      text-decoration: none;
      border-radius: 12px;
    }

    .back-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    h1 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 25px;
      font-size: 1.6rem;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: 500;
      font-size: 0.95rem;
    }

    input {
      padding: 10px;
      border: none;
      border-radius: 10px;
      background-color: #e0e1dd;
      font-size: 0.9rem;
      color: #000;
    }

    button {
      margin-top: 10px;
      padding: 12px;
      font-size: 15px;
      background-color: var(--accent);
      border: none;
      border-radius: 12px;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: var(--accent-hover);
    }

    .message {
      text-align: center;
      margin-top: 15px;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .note {
      text-align: center;
      font-size: 0.85rem;
      margin-top: 10px;
      color: #adb5bd;
    }
  </style>
</head>
<body>
  <a href="main_menu.php" class="back-btn">← Back</a>
  <div class="container">

    <h1>Change Password</h1>

    <form method="POST" autocomplete="off">
      <label for="currentPassword">Current Password:</label>
      <input type="password" id="currentPassword" name="current_password" placeholder="Enter current password" required>

      <label for="newPassword">New Password:</label>
      <input type="password" id="newPassword" name="new_password" placeholder="Enter new password" required>

      <label for="confirmPassword">Confirm New Password:</label>
      <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm new password" required>

      <button type="submit">Change Password</button>
    </form>

    <?php if (!empty($message)): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <p class="note">Ensure your new password is strong and secure.</p>
  </div>
</body>
</html>
