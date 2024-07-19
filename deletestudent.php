<!DOCTYPE html>
<html>
<head>
    <title>Delete or Update Student</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Center the table */
        .centered-table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%; /* Adjust as necessary */
        }

        .centered-table th, .centered-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .centered-table th {
            background-color: #f2f2f2;
        }

        /* Center the heading */
        .centered-heading {
            text-align: center;
        }

        /* Center the navbar */
        .navbar {
            display: flex;
            justify-content: center;
        }

        .navbar ul {
            list-style-type: none;
        }

        .navbar li {
            display: inline;
            margin: 0 10px;
        }

        .navbar a {
            text-decoration: none;
        }

        /* Center the message */
        .centered-message {
            text-align: center;
            font-weight: bold;
        }

        .centered-message.error {
            color: red;
        }
    </style>
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
    <h2 class="centered-heading">Delete Student & Parent</h2>
    
    <form method="post" action="deletestudent.php">
        <label for="student_id">Select Student:</label>
        <select id="student_id" name="student_id">
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

            // SQL to fetch students for the dropdown
            $sql = "SELECT StudentID, Name FROM Students";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['StudentID'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "<option value=''>No students available</option>";
            }

            ?>
        </select><br><br>

        <input type="submit" name="delete_student" value="Delete Student">
    </form>

    <br><br>
    <h2 class="centered-heading">Update Student Details</h2>

    <form method="post" action="deletestudent.php">
        <label for="student_id_update">Select Student:</label>
        <select id="student_id_update" name="student_id_update">
            <?php
            // SQL to fetch students for the dropdown
            $sql = "SELECT StudentID, Name FROM Students";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['StudentID'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "<option value=''>No students available</option>";
            }

            ?>
        </select><br><br>

        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" required><br><br>

        <label for="new_class">New Class:</label>
        <select id="new_class" name="new_class">
            <?php
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

        <input type="submit" name="update_student" value="Update Details">
    </form>

    <br><br>
    <h2 class="centered-heading">Delete Teacher</h2>
    
    <form method="post" action="deletestudent.php">
        <label for="teacher_id">Select Teacher:</label>
        <select id="teacher_id" name="teacher_id">
            <?php
            // SQL to fetch teachers for the dropdown
            $sql = "SELECT TeacherID, Name FROM Teachers";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['TeacherID'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "<option value=''>No teachers available</option>";
            }

            ?>
        </select><br><br>

        <input type="submit" name="delete_teacher" value="Delete Teacher">
    </form>

    <br><br>
    <h2 class="centered-heading">Update Teacher Class</h2>

    <form method="post" action="deletestudent.php">
        <label for="teacher_id_update">Select Teacher:</label>
        <select id="teacher_id_update" name="teacher_id_update">
            <?php
            // SQL to fetch teachers for the dropdown
            $sql = "SELECT TeacherID, Name FROM Teachers";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['TeacherID'] . "'>" . $row['Name'] . "</option>";
                }
            } else {
                echo "<option value=''>No teachers available</option>";
            }
            ?>
        </select><br><br>

        <label for="new_teacher_class">New Class:</label>
        <select id="new_teacher_class" name="new_teacher_class">
            <?php
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

        <input type="submit" name="update_teacher_class" value="Update Class">
    </form>

    <?php
    // Handle form submission for deleting a student
    if (isset($_POST['delete_student'])) {
        $student_id = $_POST['student_id'];

        // Start a transaction
        $link->begin_transaction();

        try {
            // SQL Delete Query to remove the student from Parent_Student table
            $sql = "DELETE FROM Parent_Student WHERE StudentID='$student_id'";
            if (!mysqli_query($link, $sql)) {
                throw new Exception("Error deleting from Parent_Student: " . mysqli_error($link));
            }

            // SQL Delete Query to remove the student from Students table
            $sql = "DELETE FROM Students WHERE StudentID='$student_id'";
            if (!mysqli_query($link, $sql)) {
                throw new Exception("Error deleting from Students: " . mysqli_error($link));
            }

            // SQL to find orphaned parents
            $sql = "SELECT ParentID FROM Parents WHERE ParentID NOT IN (SELECT ParentID FROM Parent_Student)";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $parent_id = $row['ParentID'];

                    // SQL Delete Query to remove the orphaned parent from Parents table
                    $sql = "DELETE FROM Parents WHERE ParentID='$parent_id'";
                    if (!mysqli_query($link, $sql)) {
                        throw new Exception("Error deleting from Parents: " . mysqli_error($link));
                    }
                }
            }

            // Commit the transaction
            $link->commit();
            echo '<p class="centered-message">Student and parent deleted successfully</p>';
        } catch (Exception $e) {
            // Rollback the transaction on error
            $link->rollback();
            echo '<p class="centered-message error">' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }

    // Handle form submission for updating a student's details
    if (isset($_POST['update_student'])) {
        $student_id = $_POST['student_id_update'];
        $new_name = $_POST['new_name'];
        $new_class = $_POST['new_class'];

        // SQL Update Query to change a student's name and class
        $sql = "UPDATE Students SET Name='$new_name', ClassID='$new_class' WHERE StudentID='$student_id'";
        if (mysqli_query($link, $sql)) {
            echo '<p class="centered-message">Student details updated successfully</p>';
        } else {
            echo '<p class="centered-message error">Error updating record: ' . mysqli_error($link) . '</p>';
        }
    }

    // Handle form submission for deleting a teacher
    if (isset($_POST['delete_teacher'])) {
        $teacher_id = $_POST['teacher_id'];

        // Start a transaction
        $link->begin_transaction();

        try {
            // SQL Delete Query to remove the teacher from Teachers table
            $sql = "DELETE FROM Teachers WHERE TeacherID='$teacher_id'";
            if (!mysqli_query($link, $sql)) {
                throw new Exception("Error deleting from Teachers: " . mysqli_error($link));
            }

            // Commit the transaction
            $link->commit();
            echo '<p class="centered-message">Teacher deleted successfully</p>';
        } catch (Exception $e) {
            // Rollback the transaction on error
            $link->rollback();
            echo '<p class="centered-message error">' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }

    // Handle form submission for updating a teacher's class
    if (isset($_POST['update_teacher_class'])) {
        $teacher_id = $_POST['teacher_id_update'];
        $new_class = $_POST['new_teacher_class'];

        // SQL Update Query to change a teacher's class
        $sql = "UPDATE Teachers SET ClassID='$new_class' WHERE TeacherID='$teacher_id'";
        if (mysqli_query($link, $sql)) {
            echo '<p class="centered-message">Teacher class updated successfully</p>';
        } else {
            echo '<p class="centered-message error">Error updating record: ' . mysqli_error($link) . '</p>';
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
