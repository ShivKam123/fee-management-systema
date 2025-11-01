<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include("database.php");

// Overview of Students
$sql = "SELECT COUNT(*) AS total_students FROM Student";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);

// Fees Collected
$sql = "SELECT SUM(amount_paid) AS total_paid FROM Student_fee";
$result_collected = $conn->query($sql);

// Fees Unpaid
$sql = "SELECT SUM(total_fee) AS total_unpaid FROM Student_fee";
$result_unpaid = $conn->query($sql);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Fee Management System</title>
  <style>
    :root {
      --bg:#0b1120;
      --surface:#111827;
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
      text-shadow: 1px 1px 5px rgba(0,0,0,0.6);
    }

    ul.dashboard {
      list-style:none;
      background: rgba(0,0,0,0.5);
      padding: 30px 40px;
      border-radius: var(--radius);
      width: 400px;
      max-width: 90%;
    }

    ul.dashboard li {
      margin: 18px 0;
      padding: 20px;
      background: rgba(255,255,255,0.05);
      border-radius: var(--radius);
      transition: all 0.3s ease;
      text-align: center;
    }

    ul.dashboard li:hover {
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: #fff;
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    ul.dashboard li h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    ul.dashboard li p {
      font-size: 18px;
      color: var(--muted);
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
  <h1>Dashboard</h1>
  <ul class="dashboard">
    <li>
      <h2>Overview of Students</h2>
      <p>Total students enrolled: <?php echo $row1['total_students']; ?> </p>
    </li>
    <li>
      <h2>Fees Collected</h2>
      <p>Total collected this month: 
        <?php 
        if ($result_collected) {
            $row = $result_collected->fetch_assoc();
            $totalPaid = $row['total_paid'] ?? 0; // If NULL, set to 0
            echo $totalPaid;
        } else {
            echo "Error: " . $conn->error;
        } 
        ?> 
      </p>
    </li>
    <li>
      <h2>Dues</h2>
      <p>Total pending dues:
        <?php
        if ($result_unpaid) {
            $row = $result_unpaid->fetch_assoc();
            $totalUnpaid = $row['total_unpaid'] ?? 0; // If NULL, set to 0
            echo $totalUnpaid - $totalPaid;  
        } else {
            echo "Error: " . $conn->error;
        }
        ?>
      </p>
    </li>
  </ul>

  <button class="back-btn" onclick="history.back()">← Back</button>

  <footer>© 2025 Fee Management System</footer>
</body>
</html>
