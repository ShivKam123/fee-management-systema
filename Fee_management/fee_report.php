<?php
session_start();
include("database.php"); // Make sure this connects to your MySQL DB

// Redirect if not logged in (optional)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch all transaction details with student names
$query = "
    SELECT 
        t.transaction_id,
        t.student_id,
        CONCAT(s.first_name, ' ', s.last_name) AS student_name,
        t.amount_paid,
        t.payment_date
    FROM Transaction t
    LEFT JOIN Student s ON s.student_id = t.student_id
    ORDER BY t.payment_date DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fee Report — Fee Management System</title>
  <style>
    :root {
      --card-bg: rgba(0, 0, 0, 0.5);
      --accent: #00b4d8;
      --text: #e0e1dd;
      --table-bg: rgba(255,255,255,0.1);
      --table-hover: rgba(0,180,216,0.2);
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
      box-shadow: 0 0 15px rgba(0, 180, 216, 0.25);
      backdrop-filter: blur(8px);
    }
    h1 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 15px;
      font-size: 1.8rem;
    }
    .back-btn {
      display: inline-block;
      margin-bottom: 20px;
      padding: 8px 15px;
      background-color: var(--accent);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background 0.3s;
    }
    .back-btn:hover {
      background-color: #0096c7;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: var(--table-bg);
      border-radius: 10px;
      overflow: hidden;
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
    <h1>Fee Report</h1>
    <table>
      <thead>
        <tr>
          <th>Payment ID</th>
          <th>Student ID</th>
          <th>Student Name</th>
          <th>Amount (₹)</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['transaction_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['amount_paid']) . "</td>";
                echo "<td>" . date('d M Y', strtotime($row['payment_date'])) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No transactions found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
    <p class="note">This table is dynamically populated from the Transaction database.</p>
  </div>
</body>
</html>
