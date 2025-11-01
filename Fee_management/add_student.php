<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$showTick = false; // Flag to show tick
include("database.php"); // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Insert into Student table
    $sqlStudent = "INSERT INTO Student (first_name, last_name, dob, class, contact_number, address, email, gender)
                   VALUES ('$first_name', '$last_name', '$dob', '$class', '$contact_number', '$address', '$email', '$gender')";

    if ($conn->query($sqlStudent) === TRUE) {
        $student_id = mysqli_insert_id($conn); // Get inserted student ID

        // Get fee for this class
        $sqlFee = "SELECT amount FROM Fee WHERE class = '$class' LIMIT 1";
        $resultFee = $conn->query($sqlFee);

        if ($resultFee && $resultFee->num_rows > 0) {
            $row = $resultFee->fetch_assoc();
            $amount = $row['amount'];

            // Insert into Student_fee table
            $sqlStudentFee = "INSERT INTO Student_fee (total_fee, amount_left)
                              VALUES ('$amount', '$amount')";
            $conn->query($sqlStudentFee);
        }

        $showTick = true; // Show tick on successful insertion
    } else {
        echo "Error inserting student: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Admission Form</title>
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

/* Back Button - Top Left Corner */
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

/* Tick Sticker */
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

<!-- Back Button (fixed at top-left corner) -->
<a href="student.php" class="back-btn">← Back</a>

<div class="admission-form">
    <h2>Student Admission Form</h2>
    <form action="" method="post" autocomplete="off">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <option value="">--Select Class--</option>
            <option value="Nursery">Nursery</option>
            <option value="KG">KG</option>
            <option value="1st">1st</option>
            <option value="2nd">2nd</option>
            <option value="3rd">3rd</option>
            <option value="4th">4th</option>
            <option value="5th">5th</option>
            <option value="6th">6th</option>
            <option value="7th">7th</option>
            <option value="8th">8th</option>
            <option value="9th">9th</option>
            <option value="10th">10th</option>
            <option value="11th">11th</option>
            <option value="12th">12th</option>
        </select>

        <label for="contact_number">Contact Number:</label>
        <input type="tel" id="contact_number" name="contact_number" pattern="[0-9]{10}" required placeholder="10-digit number">

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="3" placeholder="Enter full address" required></textarea>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="example@email.com">

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">--Select--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <button type="submit">Submit Admission</button>
    </form>
</div>

<!-- Tick Sticker -->
<div class="tick <?php echo $showTick ? 'show' : ''; ?>">&#10004;</div>

<script>
window.addEventListener('DOMContentLoaded', () => {
    const tick = document.querySelector('.tick');
    if (tick.classList.contains('show')) {
        setTimeout(() => {
            tick.classList.remove('show');
        }, 3000);
    }
});
</script>

</body>
</html>
