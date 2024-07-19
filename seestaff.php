<!DOCTYPE html>
<html>
<head>
    <title>View Teachers and Their Classes</title>
    <link rel="stylesheet" href="styles.css">
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
    <h2 class="centered-heading">Teacher and Class Records</h2>

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

    // SQL to fetch teacher and class records using JOIN
    $sql = "SELECT Teachers.TeacherID, Teachers.Name as Teacher_Name, Teachers.Address as Teacher_Address, 
                   Teachers.PhoneNumber, Teachers.AnnualSalary, Classes.ClassID, Classes.ClassName 
            FROM Teachers 
            JOIN Classes ON Teachers.ClassID = Classes.ClassID";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='centered-table'>";
        echo "<tr><th>TeacherID</th><th>Teacher Name</th><th>Teacher Address</th><th>Phone Number</th><th>Annual Salary</th><th>Class Name</th></tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["TeacherID"] . "</td>";
            echo "<td>" . $row["Teacher_Name"] . "</td>";
            echo "<td>" . $row["Teacher_Address"] . "</td>";
            echo "<td>" . $row["PhoneNumber"] . "</td>";
            echo "<td>" . $row["AnnualSalary"] . "</td>";
            echo "<td>" . $row["ClassName"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='centered-message error'>No records found</p>";
    }

    // Close connection
    $link->close();
    ?>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <h6>About</h6>
                    <p class="text-justify">Rishton Academy Management System is a comprehensive platform designed to efficiently manage student, parent, and staff information. It streamlines administrative processes, ensuring accurate and up-to-date records for all stakeholders in the academy.</p>
                </div>

                <div class="col-sm-12 col-xs-6 col-md-3">
                    <h6></h6>
                    <ul class="footer-links">
                    
                    </ul>
                </div>

                <div class="col-sm-12 col-xs-6 col-md-3">
                    <h6></h6>
                    <ul class="social-icons">
                        
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
