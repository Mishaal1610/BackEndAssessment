<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Parent and Student</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    // JavaScript function to toggle visibility of new parent fields
    function toggleParentFields() {
        var parentDropdown = document.getElementById("parent_id");
        var newParentFields = document.getElementById("new_parent_fields");

        if (parentDropdown.value !== "") {
            // Existing parent selected, hide new parent fields
            newParentFields.style.display = "none";
        } else {
            // New parent selected, show new parent fields
            newParentFields.style.display = "block";
        }
    }
    </script>
</head>
<body onload="toggleParentFields()">

<h2 class="centered-heading">Welcome to Rishton Academy Management System</h2>

<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li> |
        <li><a href="addparentandstudent.php">Registration</a></li> |
        <li><a href="TeachingAssistants.php">Add a Teaching Assistant</a></li> |
        <li><a href="Teachers.php">Add a Teacher</a></li> |
        <li><a href="seeparent.php">View Student Records</a></li> |
        <li><a href="deletestudent.php">Delete/Update</a></li>
        <li><a href="seestaff.php">View Staff Records</a></li>
    </ul>
</nav>

<h2 class="centered-heading">Add New Parent and Student</h2>

<?php
session_start();

// Generate a CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "rishton";

// Create connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Fetch existing parents for the dropdown
$sql_parents = "SELECT ParentID, Parent_Name FROM Parents";
$parent_result = $link->query($sql_parents);

echo '<form method="post" action="addparentandstudent.php">
    <h3>Parent Information</h3>';

// If parents exist, show dropdown to select existing parent
if ($parent_result->num_rows > 0) {
    echo '<label for="parent_id">Select Parent:</label>
    <select id="parent_id" name="parent_id" onchange="toggleParentFields()">
        <option value="">-- Select Existing Parent --</option>';

    while ($parent_row = $parent_result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($parent_row['ParentID']) . '">' . htmlspecialchars($parent_row['Parent_Name']) . '</option>';
    }

    echo '</select><br><br>';
}

echo '<div id="new_parent_fields">
    <label for="new_parent_name">New Parent Name:</label>
    <input type="text" id="new_parent_name" name="new_parent_name" pattern="[A-Za-z ]+" title="Only letters and spaces allowed"><br><br>

    <label for="address">Parent Address:</label>
    <input type="text" id="address" name="address"><br><br>

    <label for="email">Parent Email:</label>
    <input type="email" id="email" name="email"><br><br>

    <label for="telephone">Parent Telephone:</label>
    <input type="tel" id="telephone" name="telephone" pattern="[0-9]{10}" title="Ten digits required" maxlength="10" required><br><br>
</div>

<h3>Student Information</h3>
<label for="student_name">Student Name:</label>
<input type="text" id="student_name" name="student_name" required pattern="[A-Za-z ]+" title="Only letters and spaces allowed"><br><br>

<label for="student_address">Student Address:</label>
<input type="text" id="student_address" name="student_address" required><br><br>

<label for="date_of_birth">Date of Birth:</label>
<input type="date" id="date_of_birth" name="date_of_birth" required><br><br>

<label for="medical_information">Medical Information:</label>
<textarea id="medical_information" name="medical_information" required></textarea><br><br>

<label for="class_id">Class:</label>
<select id="class_id" name="class_id" required>';

// Fetch existing classes for the dropdown
$sql_classes = "SELECT ClassID, ClassName FROM Classes";
$class_result = $link->query($sql_classes);

if ($class_result->num_rows > 0) {
    while ($class_row = $class_result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($class_row['ClassID']) . '">' . htmlspecialchars($class_row['ClassName']) . '</option>';
    }
}

echo '</select><br><br>
<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">
<input type="submit" name="submit" value="Add Parent and Student">
</form>';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $parent_id = filter_input(INPUT_POST, 'parent_id', FILTER_SANITIZE_NUMBER_INT);
    $student_name = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_STRING);
    $student_address = filter_input(INPUT_POST, 'student_address', FILTER_SANITIZE_STRING);
    $date_of_birth = filter_input(INPUT_POST, 'date_of_birth', FILTER_SANITIZE_STRING);
    $medical_information = filter_input(INPUT_POST, 'medical_information', FILTER_SANITIZE_STRING);
    $class_id = filter_input(INPUT_POST, 'class_id', FILTER_SANITIZE_NUMBER_INT);

    // Check if the student already exists
    $sql_check_student = "SELECT StudentID, ClassID FROM Students WHERE Name = ? AND Address = ?";
    $stmt = $link->prepare($sql_check_student);
    $stmt->bind_param("ss", $student_name, $student_address);
    $stmt->execute();
    $student_result = $stmt->get_result();

    if ($student_result->num_rows > 0) {
        $student_row = $student_result->fetch_assoc();
        $student_id = $student_row['StudentID'];

        // Check if the student is already enrolled in a class
        if ($student_row['ClassID'] != $class_id) {
            echo '<p style="text-align: center;">This student is already enrolled in another class.</p>';
            exit;
        }
    } else {
        // Insert new student
        $sql_insert_student = "INSERT INTO Students (Name, Address, DateOfBirth, MedicalInformation, ClassID) 
                               VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql_insert_student);
        $stmt->bind_param("ssssi", $student_name, $student_address, $date_of_birth, $medical_information, $class_id);
        
        if ($stmt->execute() === TRUE) {
            $student_id = $stmt->insert_id;
        } else {
            echo "Error adding student: " . $link->error;
            exit;
        }
    }

    // Check the number of parents already linked to this student
    $sql_check_parents = "SELECT COUNT(*) AS ParentCount FROM Parent_Student WHERE StudentID = ?";
    $stmt = $link->prepare($sql_check_parents);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $check_result = $stmt->get_result();
    $parent_count = $check_result->fetch_assoc()['ParentCount'];

    if ($parent_count >= 2) {
        echo '<p style="text-align: center;">This student already has two parents linked.</p>';
        exit;
    }

    // Check if an existing parent is selected or a new parent to be added
    if (!empty($parent_id)) {
        // Existing parent selected
        $parent_id = filter_input(INPUT_POST, 'parent_id', FILTER_SANITIZE_NUMBER_INT);
    } else {
        // Insert new parent
        $new_parent_name = filter_input(INPUT_POST, 'new_parent_name', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);

        if (empty($new_parent_name) || empty($address) || empty($email) || empty($telephone)) {
            echo "All parent fields are required.";
            exit;
        }

        $sql_insert_parent = "INSERT INTO Parents (Parent_Name, Address, Email, Telephone) 
                              VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($sql_insert_parent);
        $stmt->bind_param("ssss", $new_parent_name, $address, $email, $telephone);

        if ($stmt->execute() === TRUE) {
            $parent_id = $stmt->insert_id;
        } else {
            echo "Error adding new parent: " . $link->error;
            exit;
        }
    }

    // Link parent and student in Parent_Student table
    $sql_insert_parent_student = "INSERT INTO Parent_Student (ParentID, StudentID) 
                                  VALUES (?, ?)";
    $stmt = $link->prepare($sql_insert_parent_student);
    $stmt->bind_param("ii", $parent_id, $student_id);

    if ($stmt->execute() === TRUE) {
        echo '<p class="centered-message success">New parent and student added successfully and linked.</p>';
    } else {
        echo "Error linking parent and student: " . $link->error;
    }
}

// Close the database connection
$link->close();
?>

<!-- Site footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h6>About</h6>
                <p class="text-justify">Rishton Academy Management System is a comprehensive platform designed to efficiently manage student, parent, and staff information. It streamlines administrative processes, ensuring accurate and up-to-date records for all stakeholders in the academy.</p>
            </div>
            <div class="col-xs-6 col-md-3">
                <h6></h6>
                <ul class="footer-links">
                    
                </ul>
            </div>
            <div class="col-xs-6 col-md-3">
                <h6></h6>
                <ul class="footer-links">
                
                </ul>
            </div>
        </div>
        <hr>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12">
                <p class="copyright-text">Copyright &copy; 2024 All Rights Reserved by 
                    <a href="#">Mohamed Mishaal Khan</a>.
                </p>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <ul class="social-icons">
                      
                </ul>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
