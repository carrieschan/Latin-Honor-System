<?php
error_reporting(0); // Turn off error reporting
ini_set('display_errors', 0); // Hide error messages
session_start();
// Database configuration
$host = 'localhost';
$dbname = 'sample_sis';
$username = 'root';
$password = '';

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    echo "Connection failed: " . $e->getMessage();
}
?>

<?php
// Function to delete a student and their corresponding grades
function deleteStudent($studentId)
{
    global $pdo;

    // Delete the student from the "students" table
    $deleteStudentQuery = "DELETE FROM students WHERE studentnumber = :studentnumber";
    $deleteStudentStmt = $pdo->prepare($deleteStudentQuery);
    $deleteStudentStmt->bindParam(':studentnumber', $studentId);
    $deleteStudentStmt->execute();

    // Delete the student's grades from the "student_grades" table
    $deleteGradesQuery = "DELETE FROM student_grades WHERE studentnumber1 = :studentnumber";
    $deleteGradesStmt = $pdo->prepare($deleteGradesQuery);
    $deleteGradesStmt->bindParam(':studentnumber', $studentId);
    $deleteGradesStmt->execute();

    // Delete the student's grades from the "student_grade_dit" table
    $deleteDitGradesQuery = "DELETE FROM student_grades_dit WHERE studentnumber2 = :studentnumber";
    $deleteDitGradesStmt = $pdo->prepare($deleteDitGradesQuery);
    $deleteDitGradesStmt->bindParam(':studentnumber', $studentId);
    $deleteDitGradesStmt->execute();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Destroy the session
        session_unset();
        session_destroy();
        // Redirect to the login page (admin.php in this case)
        header("Location: loginform.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<script>
    /* JavaScript to prevent browser back button after logout */
    window.history.forward();

    function noBack() {
        window.history.forward();
    }

    // Function to check if the user is logged in
    function checkLoggedIn() {
        if (!sessionStorage.getItem('loggedIn')) {
            window.location.href = "admin.php";
        }
    }
</script>

<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>Add Admin Account</h2>
        <div id="addAdminForm" style="display: none;">
            <form method="POST" action="">
                <label>Username:</label>
                <input type="text" name="new_admin_username" required><br>
                <label>Password:</label>
                <input type="password" name="new_admin_password" required><br>
                <button type="submit" name="add_admin">Add Admin</button>
            </form>
        </div>

        <button id="toggleAddAdminForm">ADD NEW ADMINS</button>

        <script>
            document.getElementById("toggleAddAdminForm").addEventListener("click", function() {
                var formDiv = document.getElementById("addAdminForm");
                formDiv.style.display = formDiv.style.display === "none" ? "block" : "none";
            });
        </script>
        <table>
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Middle Initial</th>
                    <th>Course</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch students' information from the "students" table
                $selectStudentsQuery = "SELECT * FROM students";
                $selectStudentsStmt = $pdo->prepare($selectStudentsQuery);
                $selectStudentsStmt->execute();
                $students = $selectStudentsStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($students as $student) : ?>
                    <tr>
                        <td><?php echo $student['studentnumber']; ?></td>
                        <td><?php echo strtoupper($student['surname']); ?></td>
                        <td><?php echo strtoupper($student['firstname']); ?></td>
                        <td><?php echo strtoupper($student['middleinitial']); ?></td>
                        <td><?php echo $student['course']; ?></td>
                        <td><?php echo $student['password']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="studentnumber" value="<?php echo $student['studentnumber']; ?>">
                                <input type="hidden" name="course" value="<?php echo $student['course']; ?>">
                                <button type="submit" name="delete_student">Delete</button>
                                <button type="submit" name="view_grade">View Grade</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
                <h2>Admin Information</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Username</th>
                            <th>Admin Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch admin information from the "admins" table
                        $selectAdminQuery = "SELECT * FROM admins";
                        $selectAdminStmt = $pdo->prepare($selectAdminQuery);
                        $selectAdminStmt->execute();
                        $admins = $selectAdminStmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($admins as $admin) : ?>
                            <tr>
                                <td><?php echo $admin['id']; ?></td>
                                <td><?php echo $admin['admin']; ?></td>
                                <td><?php echo $admin['password']; ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                        <input type="hidden" name="admin_username" value="<?php echo $admin['admin']; ?>">
                                        <input type="hidden" name="admin_password" value="<?php echo $admin['password']; ?>">
                                        <button type="submit" name="edit_admin">Edit</button>
                                        <button type="submit" name="delete_admin">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </tbody>
        </table>

</body>
</html>

<?php

// Database configuration
$host = 'localhost';
$dbname = 'sample_sis';
$username = 'root';
$password = '';

try {
    // Establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    echo "Connection failed: " . $e->getMessage();
}

// Handle the form submission for editing admins
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_admin'])) {
        // Retrieve the admin information for editing
        $adminIdToEdit = $_POST['admin_id'];
        $adminUsername = $_POST['admin_username'];
        $adminPassword = $_POST['admin_password'];

        // Display input fields for editing the admin information
        echo '<h2>Edit Admin</h2>';
        echo '<form method="POST" action="">';
        echo '<input type="hidden" name="admin_id" value="' . $adminIdToEdit . '">';
        echo 'Username: <input type="text" name="admin_username" value="' . $adminUsername . '"><br>';
        echo 'Password: <input type="password" name="admin_password" value="' . $adminPassword . '"><br>';
        echo '<button type="submit" name="save_admin_changes">Save Changes</button>';
        echo '</form>';
    } elseif (isset($_POST['save_admin_changes'])) {
        // Handle the update logic when the "Save Changes" button is clicked
        $adminIdToUpdate = $_POST['admin_id'];
        $newUsername = $_POST['admin_username'];
        $newPassword = $_POST['admin_password'];

        // Update the admin information in the "admins" table
        $updateAdminQuery = "UPDATE admins SET admin = :admin, password = :password WHERE id = :admin_id";
        $updateAdminStmt = $pdo->prepare($updateAdminQuery);
        $updateAdminStmt->bindParam(':admin', $newUsername);
        $updateAdminStmt->bindParam(':password', $newPassword);
        $updateAdminStmt->bindParam(':admin_id', $adminIdToUpdate);
        $updateAdminStmt->execute();

        // Refresh the page after updating
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['delete_admin'])) {
        // Handle the deletion of the admin
        $adminIdToDelete = $_POST['admin_id'];

        // Delete the admin from the "admins" table
        $deleteAdminQuery = "DELETE FROM admins WHERE id = :admin_id";
        $deleteAdminStmt = $pdo->prepare($deleteAdminQuery);
        $deleteAdminStmt->bindParam(':admin_id', $adminIdToDelete);
        $deleteAdminStmt->execute();

        // Refresh the page after deletion
        header("Location: admin.php");
        exit;
    }
}
?>
<?php




// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_student'])) {
        $studentIdToDelete = $_POST['studentnumber'];

        // Call the deleteStudent function to delete the student and their grades
        deleteStudent($studentIdToDelete);

        // Refresh the page after deletion
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['view_grade'])) {
        $studentIdToViewGrades = $_POST['studentnumber'];
        $studentCourseToViewGrades = $_POST['course'];
        // Function to get student grades from the appropriate table based on the course
        function getStudentGrades($studentCourseToViewGrades, $studentNumber)
        {
            global $pdo;
            $table_name = ($studentCourseToViewGrades === 'BSIT') ? 'student_grades' : 'student_grades_dit';
            $query = "SELECT * FROM $table_name WHERE studentnumber" . (($studentCourseToViewGrades === 'BSIT') ? '1' : '2') . " = :studentnumber";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':studentnumber', $studentNumber);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Fetch student's grades based on the course
        $studentGrades = getStudentGrades($studentCourseToViewGrades, $studentIdToViewGrades);
        $selectStudentInfoQuery = "SELECT * FROM students WHERE studentnumber = :studentnumber";
        $selectStudentInfoStmt = $pdo->prepare($selectStudentInfoQuery);
        $selectStudentInfoStmt->bindParam(':studentnumber', $studentIdToViewGrades);
        $selectStudentInfoStmt->execute();
        $student = $selectStudentInfoStmt->fetch(PDO::FETCH_ASSOC);


        if ($studentGrades) {
            // Display the grades in detail
            echo '<h2>Student Grades</h2>';
            echo '<p>';
            echo 'NAME: ' . strtoupper($student['surname'] . ', ' . $student['firstname'] . ' ' . $student['middleinitial']) . '<br>';
            echo 'COURSE: ' . $student['course'] . '<br>';
            echo 'STUDENTNUMBER: ' . $studentIdToViewGrades . '<br>';
            echo '</p>';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>YR</th>';
            echo '<th>1ST SEM</th>';
            echo '<th>2ND SEM</th>';
            echo '<th>FINAL AVE</th>';

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Fill in the rows with student's grades

            // Determine the number of loops based on the student's course
            $loopCount = ($student['course'] === 'DICT') ? 3 : 4;

            // Add rows for each year
            for ($year = 1; $year <= $loopCount; $year++) {
                echo '<tr>';
                echo '<td>' . $year . '</td>';
                echo '<td>' . $studentGrades['first_sem_avg_' . $year] . '</td>';
                echo '<td>' . $studentGrades['second_sem_avg_' . $year] . '</td>';
                echo '<td>' . $studentGrades['yr_' . $year . '_final_ave'] . '</td>';
                echo '</tr>';
            }
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>SUMMER OVERALL AVERAGE</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<td>' . $studentGrades['summer_avg'] . '</td>' . '<br>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>OVERALL STUDENT AVERAGE</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<td>' . $studentGrades['final_average'] . '</td>' . '<br>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>STUDENT ACADEMIC DISTINCTION</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<td>' . $studentGrades['academicDistinction'] . '</td>' . '<br>';
            echo '</tbody>';
            echo '</table>';

            echo '<form method="POST" action="">';
            echo '<input type="hidden" name="studentnumber" value="' . $studentIdToViewGrades . '">';
            echo '<button type="submit" name="close_view">Close</button>';
            echo '</form>';
        } else {
            // Handle the case when grades are not found for the student
            echo "<p>No grades found for the selected student.</p>";
        }
    }
}
?>

<?php

// Handle form submission for adding a new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_admin'])) {
        $newAdminUsername = $_POST['new_admin_username'];
        $newAdminPassword = $_POST['new_admin_password'];

        // Insert new admin account into the "admins" table
        $insertAdminQuery = "INSERT INTO admins (admin, password) VALUES (:admin, :password)";
        $insertAdminStmt = $pdo->prepare($insertAdminQuery);
        $insertAdminStmt->bindParam(':admin', $newAdminUsername);
        $insertAdminStmt->bindParam(':password', $newAdminPassword);
        $insertAdminStmt->execute();

        // Refresh the page after adding a new admin
        header("Location: admin.php");
        exit;
    }
}
?>