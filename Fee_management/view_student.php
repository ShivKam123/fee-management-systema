<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include("database.php"); // DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Students — Fee Management System</title>
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
      align-items: center;
      backdrop-filter: blur(5px);
    }

    h1 {
      text-align: center;
      margin-top: 40px;
      color: #00d9ff;
      letter-spacing: 1px;
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    table {
      width: 90%;
      margin: 40px auto;
      border-collapse: collapse;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    th, td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    th {
      background-color: rgba(0, 217, 255, 0.2);
      color: #00d9ff;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transition: background 0.3s ease;
    }

    .no-data {
      text-align: center;
      color: #eee;
      font-size: 1.1em;
      margin-top: 30px;
      text-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
    }

    .back-btn {
    position: fixed;   /* Fix the button on screen */
    top: 20px;         /* Distance from top */
    left: 20px;        /* Distance from left */
    z-index: 999;      /* Make sure it stays above other elements */
      /* margin-top: 20px; */
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

  <h1>All Students</h1>

  <?php
  // If class column stores numbers (1, 2, 3...):
  $query = "SELECT * FROM Student ORDER BY CAST(class AS UNSIGNED) ASC";

  // If class column stores text like "Nursery", "LKG", "1st":
  // $query = "SELECT * FROM Student ORDER BY class ASC";

  $result = mysqli_query($conn, $query);

  if (!$result) {
      echo "<p class='no-data'>Error fetching students: " . mysqli_error($conn) . "</p>";
      exit;
  }

  if (mysqli_num_rows($result) > 0) {
      echo "<table>";
      echo "<tr>
              <th>Student ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Date of Birth</th>
              <th>Class</th>
              <th>Contact Number</th>
              <th>Address</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Admission Date</th>
            </tr>";

      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['student_id']}</td>
                  <td>{$row['first_name']}</td>
                  <td>{$row['last_name']}</td>
                  <td>{$row['dob']}</td>
                  <td>{$row['class']}</td>
                  <td>{$row['contact_number']}</td>
                  <td>{$row['address']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['gender']}</td>
                  <td>{$row['created_at']}</td>
                </tr>";
      }

      echo "</table>";
  } else {
      echo "<p class='no-data'>No students found.</p>";
  }
?>

  <a href="student.php" class="back-btn">← Back</a>

</body>
</html>
