<!DOCTYPE html>
<html>
<head>
    <title>View Parents and Students</title>
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
    <h2 class="centered-heading">Parent and Student Records</h2>

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
    } else {
        echo ".<br>";
    }

    // SQL to fetch parent and student records using JOIN
    $sql = "SELECT Parents.ParentID, Parents.Parent_Name, Parents.Address as Parent_Address, 
                   Parents.Email, Parents.Telephone, Students.StudentID, 
                   Students.Name as Student_Name, Students.Address as Student_Address, 
                   Students.MedicalInformation, Classes.ClassName 
            FROM Parents 
            JOIN Parent_Student ON Parents.ParentID = Parent_Student.ParentID
            JOIN Students ON Parent_Student.StudentID = Students.StudentID
            JOIN Classes ON Students.ClassID = Classes.ClassID";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='centered-table'>";
        echo "<tr><th>ParentID</th><th>Parent Name</th><th>Parent Address</th><th>Email</th><th>Telephone</th><th>StudentID</th><th>Student Name</th><th>Student Address</th><th>Medical Information</th><th>Class Name</th></tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ParentID"] . "</td>";
            echo "<td>" . $row["Parent_Name"] . "</td>";
            echo "<td>" . $row["Parent_Address"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["Telephone"] . "</td>";
            echo "<td>" . $row["StudentID"] . "</td>";
            echo "<td>" . $row["Student_Name"] . "</td>";
            echo "<td>" . $row["Student_Address"] . "</td>";
            echo "<td>" . $row["MedicalInformation"] . "</td>";
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
                    <h6>Follow Us</h6>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
