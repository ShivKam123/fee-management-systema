<?php
session_start();
include("database.php");

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get student ID from URL
if (!isset($_GET['id'])) {
    echo "<p style='color:red; text-align:center;'>Invalid request. No student selected.</p>";
    exit;
}

$student_id = $_GET['id'];

// Fetch student data
$query = "SELECT * FROM Student WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p style='color:red; text-align:center;'>Student not found!</p>";
    exit;
}

$student = mysqli_fetch_assoc($result);

// Delete student from both tables
$deleted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Delete related records from Student_fee first
    $delete_fee = "DELETE FROM Student_fee WHERE student_id = '$student_id'";
    mysqli_query($conn, $delete_fee);

    // Then delete student record
    $delete_student = "DELETE FROM Student WHERE student_id = '$student_id'";
    if (mysqli_query($conn, $delete_student)) {
        $deleted = true;
        // Redirect after 3 seconds
        header("refresh:1;url=student.php");
    } else {
        echo "<p style='color:red; text-align:center;'>Error deleting student: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Student</title>
<style>
:root {
    --accent: #ff6b6b;
    --accent-2: #3b82f6;
    --muted: #f3f4f6;
    --radius: 12px;
    font-family: 'Poppins', system-ui, sans-serif;
}
body {
    font-family: 'Poppins', sans-serif;
    background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

.edit-container {
    background-color: rgba(255, 255, 255, 0.9);
    width: 80%;
    max-width: 600px;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

form input, 
form select, 
form textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f7f7f7;
    pointer-events: none;
}

button {
    margin-top: 20px;
    width: 100%;
    padding: 10px;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    background-color: #e74c3c;
}

button:hover {
    background-color: #c0392b;
}

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
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}

.back-btn:hover {
    background-color: #e03e3e;
}

.success-msg {
    color: green;
    font-weight: bold;
    text-align: center;
    margin-top: 20px;
}
</style>
</head>
<body>

<a href="student.php" class="back-btn">← Back</a>
<div class="edit-container">
    <?php if ($deleted): ?>
        <p class="success-msg">Student deleted successfully! Redirecting to Student List...</p>
    <?php else: ?>
        <h2>Delete Student Record</h2>

        <form method="POST">
            <label>First Name:</label>
            <input type="text" value="<?php echo $student['first_name']; ?>" readonly>

            <label>Last Name:</label>
            <input type="text" value="<?php echo $student['last_name']; ?>" readonly>

            <label>Date of Birth:</label>
            <input type="date" value="<?php echo $student['dob']; ?>" readonly>

            <label>Class:</label>
            <input type="text" value="<?php echo $student['class']; ?>" readonly>

            <label>Contact Number:</label>
            <input type="text" value="<?php echo $student['contact_number']; ?>" readonly>

            <label>Address:</label>
            <textarea rows="3" readonly><?php echo $student['address']; ?></textarea>

            <label>Email:</label>
            <input type="email" value="<?php echo $student['email']; ?>" readonly>

            <label>Gender:</label>
            <input type="text" value="<?php echo $student['gender']; ?>" readonly>

            <button type="submit" name="delete">Delete Student</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
