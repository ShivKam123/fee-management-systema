<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("database.php");

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if student is selected
if (!isset($_SESSION['student_id'])) {
    echo "<p style='color:red; text-align:center;'>No student selected.</p>";
    exit;
}

$student_id = $_SESSION['student_id'];
$success = "";
$error_msg = "";

// Fetch student info
$studentQuery = "SELECT * FROM Student WHERE student_id='$student_id'";
$studentResult = mysqli_query($conn, $studentQuery);
if (!$studentResult) die("Query failed: " . mysqli_error($conn));

if (mysqli_num_rows($studentResult) > 0) {
    $student = mysqli_fetch_assoc($studentResult);
    $studentName = $student['first_name'] . " " . $student['last_name'];
} else {
    echo "<p style='color:red; text-align:center;'>No student found with ID: $student_id</p>";
    exit;
}

// Handle fee collection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['collect_fee'])) {
    $amount_to_pay = floatval($_POST['amount_to_pay']);

    // Fetch student fee data
    $feeQuery = "SELECT * FROM Student_fee WHERE student_id='$student_id'";
    $feeResult = mysqli_query($conn, $feeQuery);
    if (!$feeResult) die("Query failed: " . mysqli_error($conn));

    $feeData = mysqli_fetch_assoc($feeResult);
    $total_fee = $feeData['total_fee'];
    $amount_paid = $feeData['amount_paid'];
    $amount_left = $feeData['amount_left'];

    if ($amount_to_pay <= 0) {
        $error_msg = "Please enter a valid amount.";
    } elseif ($amount_to_pay > $amount_left) {
        $error_msg = "Cannot pay more than total remaining fee (₹$amount_left).";
    } else {
        // Calculate new values
        $new_amount_paid = $amount_paid + $amount_to_pay;
        $new_amount_left = $total_fee - $new_amount_paid;

        // Update Student_fee table using student_id ✅
        $updateFee = "UPDATE Student_fee 
                      SET amount_paid = '$new_amount_paid', amount_left = '$new_amount_left'
                      WHERE student_id = '$student_id'";
        if (!mysqli_query($conn, $updateFee)) {
            die("Update failed: " . mysqli_error($conn));
        }

        // Insert transaction record ✅
        $date_time = date('Y-m-d H:i:s');
        $stmt = mysqli_prepare($conn, "INSERT INTO Transaction (student_id, amount_paid, payment_date) VALUES (?, ?, ?)");
        if (!$stmt) die("Prepare failed: " . mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "ids", $student_id, $amount_to_pay, $date_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $success = "Fee collected successfully!";
    }
}

// Fetch updated fee record
$feeQuery = "SELECT * FROM Student_fee WHERE student_id='$student_id'";
$feeResult = mysqli_query($conn, $feeQuery);
if (!$feeResult) die("Query failed: " . mysqli_error($conn));
$feeData = mysqli_fetch_assoc($feeResult);

$total_fee = $feeData['total_fee'];
$amount_paid = $feeData['amount_paid'];
$amount_left = $feeData['amount_left'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Fee Details</title>
<style>
body { 
    font-family: 'Poppins', sans-serif; 
    background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover; 
    color: #fff; 
    min-height: 100vh; 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    padding-top: 30px; 
}
h2 { 
    color: #00d9ff; 
    text-shadow: 0 0 8px rgba(0,0,0,0.5); 
}
table { 
    border-collapse: collapse; 
    width: 90%; 
    max-width: 600px; 
    margin: 20px 0; 
    background: rgba(0,0,0,0.6); 
    border-radius: 8px; 
    overflow: hidden; 
}
table th, table td { 
    padding: 12px; 
    text-align: center; 
    border-bottom: 1px solid rgba(255,255,255,0.2); 
}
table th { 
    background-color: rgba(0,217,255,0.7); 
    color: #0f172a; 
}
.back-btn, .collect-btn { 
    margin-top: 20px; 
    display: inline-block; 
    color: #fff; 
    text-decoration: none; 
    background: linear-gradient(135deg, #00d9ff, #00bfe0); 
    padding: 10px 25px; 
    border-radius: 8px; 
}
.collect-form { 
    margin-top: 20px; 
    background: rgba(0,0,0,0.6); 
    padding: 15px; 
    border-radius: 8px; 
    width: 90%; 
    max-width: 400px; 
    text-align: center; 
}
.collect-form input[type="number"] { 
    width: 70%; 
    padding: 8px; 
    border-radius: 5px; 
    border: none; 
    margin-right: 10px; 
}
.collect-form button { 
    padding: 8px 15px; 
    border-radius: 5px; 
    border: none; 
    cursor: pointer; 
    background-color: #00d9ff; 
    color: #0f172a; 
    font-weight: 600; 
}
.success { 
    color: #4dff4d; 
    margin-top: 10px; 
}
.error { 
    color: #ff4d4d; 
    margin-top: 10px; 
}
</style>
</head>
<body>

<h2>Fee Details for: <?php echo $studentName; ?></h2>

<table>
    <thead>
        <tr>
            <th>Total Fee</th>
            <th>Amount Paid</th>
            <th>Fee Left</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $total_fee; ?></td>
            <td><?php echo $amount_paid; ?></td>
            <td><?php echo $amount_left; ?></td>
        </tr>
    </tbody>
</table>

<div class="collect-form">
    <?php if($success) echo "<p class='success'>$success</p>"; ?>
    <?php if($error_msg) echo "<p class='error'>$error_msg</p>"; ?>

    <?php if ($amount_left > 0): ?>
    <form method="POST">
        <input type="number" name="amount_to_pay" placeholder="Enter amount" min="1" max="<?php echo $amount_left; ?>" required>
        <button type="submit" name="collect_fee">Pay</button>
    </form>
    <?php else: ?>
        <p class="success">All fees are paid! 🎉</p>
    <?php endif; ?>
</div>

<a href="collect_fee.php" class="back-btn">← Back</a>

</body>
</html>
