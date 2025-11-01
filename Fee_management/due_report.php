<?php
session_start();
include("database.php");

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Combined query: fetch Student ID, full name, and amount left
$query = "
    SELECT 
        s.student_id,
        CONCAT(s.first_name, ' ', s.last_name) AS student_name,
        f.amount_left
    FROM Student s
    LEFT JOIN Student_fee f ON s.student_id = f.student_id
    WHERE f.amount_left != 0
    ORDER BY s.student_id ASC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Due Report — Fee Management System</title>
  <style>
    :root {
      --card-bg: rgba(0, 0, 0, 0.5);
      --accent: #ff6b6b;
      --text: #e0e1dd;
      --table-bg: rgba(255,255,255,0.1);
      --table-hover: rgba(255,107,107,0.2);
    }

    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding-top: 50px;
      color: var(--text);
    }

    .container {
      width: 90%;
      max-width: 900px;
      background: var(--card-bg);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(255, 107, 107, 0.25);
      backdrop-filter: blur(8px);
      position: relative;
    }

    h1 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 15px;
      font-size: 1.8rem;
    }

    /* Back button at top-left */
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      padding: 8px 15px;
      background-color: var(--accent);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background 0.3s;
    }
    .back-btn:hover {
      background-color: #e03e3e;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: var(--table-bg);
      border-radius: 10px;
      overflow: hidden;
      margin-top: 50px;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
    }

    th {
      background-color: var(--accent);
      color: #fff;
    }

    tr {
      border-bottom: 1px solid rgba(255,255,255,0.2);
      transition: background 0.3s;
    }

    tr:hover {
      background-color: var(--table-hover);
    }

    .note {
      text-align: center;
      margin-top: 15px;
      font-size: 0.85rem;
      color: #adb5bd;
    }
  </style>
</head>
<body>
  <div class="container">
    <a class="back-btn" href="main_menu.php">← Back</a>
    <h1>Due Report</h1>
    <table>
      <thead>
        <tr>
          <th>Student ID</th>
          <th>Student Name</th>
          <th>Pending Amount (₹)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['student_id'] ?? '0') . "</td>";
                echo "<td>" . htmlspecialchars($row['student_name'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($row['amount_left'] ?? '0') . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' style='text-align:center;'>No students with pending fees found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
    <p class="note">This table lists students who still have pending fees.</p>
  </div>
</body>
</html>
