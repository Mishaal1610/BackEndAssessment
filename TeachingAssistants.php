<!DOCTYPE html>
<html>
<head>
    <title>Add Teaching Assistant</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm(event) {
            var backgroundCheck = document.getElementById("background_check").value;
            var phoneNumber = document.getElementById("phone_number").value;
            
            // Check background check status
            if (backgroundCheck === "0") {
                alert("A background check must be done before adding a teaching assistant.");
                event.preventDefault();
            }
            
            // Check phone number length
            if (phoneNumber.length > 10) {
                alert("Phone number must not exceed 10 digits.");
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
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
            
    <br><br>
    <h2 class="centered-heading">Add New Teaching Assistant</h2>

    <form id="teachingAssistantForm" method="post" action="TeachingAssistants.php" onsubmit="validateForm(event)">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>
        
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required pattern="\d{10}" title="Please enter a valid phone number (10 digits)." maxlength="10"><br><br>
        
        <label for="annual_salary">Annual Salary:</label>
        <input type="text" id="annual_salary" name="annual_salary" required><br><br>
        
        <label for="background_check">Background Check:</label>
        <select id="background_check" name="background_check" required>
            <option value="1">Checked</option>
            <option value="0">Not Checked</option>
        </select><br><br>
        
        <label for="class_id">Class ID:</label>
        <select id="class_id" name="class_id">
            <?php
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

            // SQL to fetch classes for the dropdown
            $sql = "SELECT ClassID, ClassName FROM Classes";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
                }
            } else {
                echo "<option value=''>No classes available</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" name="submit" value="Add Teaching Assistant">
    </form>

    <?php
    // Create database if it does not exist
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($link->query($sql) === TRUE) {
        echo '<p class="centered-message success">Database created successfully or already exists.</p><br>';
    } else {
        echo '<p class="centered-message error">Error creating database: ' . $link->error . '</p><br>';
    }

    // SQL to create the TeachingAssistants table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS TeachingAssistants (
        AssistantID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(100) NOT NULL,
        Address VARCHAR(255) NOT NULL,
        PhoneNumber VARCHAR(20) NOT NULL,
        AnnualSalary DECIMAL(10, 2) NOT NULL,
        BackgroundCheck BOOLEAN NOT NULL,
        ClassID INT UNIQUE,
        FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
    )";

    if ($link->query($sql) === TRUE) {
        echo '<p class="centered-message success">Table TeachingAssistants created successfully or already exists.</p><br>';
    } else {
        echo '<p class="centered-message error">Error creating table: ' . $link->error . '</p><br>';
    }

    // Handle form submission for adding a new teaching assistant
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];
        $annual_salary = $_POST['annual_salary'];
        $background_check = $_POST['background_check'];
        $class_id = $_POST['class_id'];

        // Check if the selected class already has a teaching assistant assigned
        $check_sql = "SELECT * FROM TeachingAssistants WHERE ClassID = '$class_id'";
        $check_result = $link->query($check_sql);

        if ($check_result->num_rows > 0) {
            echo '<p class="centered-message error">Error: A teaching assistant is already assigned to this class.</p>';
        } else {
            // SQL Insert Query to add a new teaching assistant
            $sql = "INSERT INTO TeachingAssistants (Name, Address, PhoneNumber, AnnualSalary, BackgroundCheck, ClassID) 
                    VALUES ('$name', '$address', '$phone_number', '$annual_salary', '$background_check', '$class_id')";
            if ($link->query($sql) === TRUE) {
                echo '<p class="centered-message success">New teaching assistant added successfully</p>';
            } else {
                echo '<p class="centered-message error">Error adding record: ' . $link->error . '</p>';
            }
        }
    }

    // Close the database connection
    $link->close();
    ?>
</body>
<br><br><br><br><br><br><br><br>
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

            <div class="quick-links-container col-xs-6 col-md-3">
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
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
                </ul>
            </div>
        </div>
    </div>
</footer>

</html>
