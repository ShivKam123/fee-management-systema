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

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $update = "UPDATE Student 
               SET first_name='$first_name', last_name='$last_name', dob='$dob', class='$class',
                   contact_number='$contact_number', address='$address', email='$email', gender='$gender'
               WHERE student_id='$student_id'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Student details updated successfully!'); window.location='search_student.php';</script>";
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Error updating student: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Student</title>
<style>
:root {
      --accent:#06b6d4;
      --accent-2:#3b82f6;
      --muted:#f3f4f6;
      --radius:12px;
      font-family: 'Poppins', system-ui, sans-serif;
    }

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b') no-repeat center center/cover;
    color: #fff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    backdrop-filter: blur(5px);
}

/* Form Container */
.admission-form {
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    padding: 30px;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
    margin-top: 80px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
}

.admission-form h2 {
    text-align: center;
    color: #00d9ff;
    margin-bottom: 25px;
    letter-spacing: 1px;
    text-shadow: 0 0 10px rgba(0,0,0,0.5);
}

.admission-form label {
    display: block;
    margin: 10px 0 5px;
    color: #00d9ff;
    font-weight: 500;
}

.admission-form input, 
.admission-form select, 
.admission-form textarea {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    background: rgba(255,255,255,0.1);
    color: #fff;
    font-size: 15px;
    outline: none;
}

.admission-form input::placeholder,
.admission-form textarea::placeholder {
    color: #ccc;
}

.admission-form select option {
    background-color: #0f172a;
    color: #fff;
}

.admission-form button {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background-color: #00d9ff;
    border: none;
    color: #0f172a;
    font-size: 17px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 0 10px rgba(0,217,255,0.6);
}

.admission-form button:hover {
    background-color: #00bfe0;
    box-shadow: 0 0 15px rgba(0,217,255,0.8);
}

/* Back Button */
.back-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 999;
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

/* Success Tick */
.tick {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #00d9ff;
    color: #0f172a;
    padding: 15px;
    border-radius: 50%;
    font-size: 30px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,217,255,0.7);
    animation: pop 0.5s ease forwards;
}

.tick.show {
    display: block;
}

@keyframes pop {
    0% { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
</head>
<body>

<a href="student.php" class="back-btn">← Back</a>

<div class="admission-form">
    <h2>Edit Student Details</h2>
    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required>

        <label>Class:</label>
        <select name="class" required>
            <?php
            $classes = ['Nursery','KG','1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th','11th','12th'];
            foreach ($classes as $cls) {
                $selected = ($cls == $student['class']) ? 'selected' : '';
                echo "<option value='$cls' $selected>$cls</option>";
            }
            ?>
        </select>

        <label>Contact Number:</label>
        <input type="tel" name="contact_number" pattern="[0-9]{10}" value="<?php echo $student['contact_number']; ?>" required>

        <label>Address:</label>
        <textarea name="address" rows="3" required><?php echo $student['address']; ?></textarea>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $student['email']; ?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="">--Select--</option>
            <option value="Male" <?php echo ($student['gender']=='Male')?'selected':''; ?>>Male</option>
            <option value="Female" <?php echo ($student['gender']=='Female')?'selected':''; ?>>Female</option>
            <option value="Other" <?php echo ($student['gender']=='Other')?'selected':''; ?>>Other</option>
        </select>

        <button type="submit">Update Student</button>
    </form>
</div>

</body>
</html>
