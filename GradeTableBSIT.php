<!DOCTYPE html>
<html>
<head>
    <script async data-id="9184694353" id="chatling-embed-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
    <script>
        function showComputeButton() {
            // Show the compute button
            document.getElementById("computeBtn").style.display = "inline";

            // Hide the confirmation button
            document.getElementById("confirmBtn").style.display = "none";
        }
    </script>
    <script>
        /* JavaScript to prevent browser back button after logout */
        window.history.forward();

        function noBack() {
            window.history.forward();
        }

        // Function to check if the user is logged in
        function checkLoggedIn() {
            if (!sessionStorage.getItem('loggedIn')) {
                window.location.href = "LoginForm.php";
            }
        }
    </script>
    <link rel="stylesheet" type="text/css" href="css/formbsit.css">
</head>

<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    </form>

    <?php
    error_reporting(0); // Turn off error reporting
    ini_set('display_errors', 0); // Hide error messages
    // Disable caching
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: Sat, 01 Jan 2000 00:00:00 GMT"); // Date in the past
    session_start();

    class Database
    {
        private $host;
        private $username;
        private $password;
        private $database;
        public $conn;

        public function __construct($host, $username, $password, $database)
        {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        public function connect()
        {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->conn->connect_error) {
                die("Connection Failed: " . $this->conn->connect_error);
            }
        }

        public function disconnect()
        {
            $this->conn->close();
        }

        public function selectData($table, $condition)
        {
            $sql = "SELECT * FROM $table WHERE $condition";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return false;
            }
        }
    }
    if (isset($_SESSION['surname']) && isset($_SESSION['studentnumber'])) {
        $surname = $_SESSION['surname'];
        $studentNumber = $_SESSION['studentnumber'];

        // Database connection
        $database = new Database('localhost', 'root', '', 'sample_sis');
        $database->connect();

        // Retrieve student information
        $condition = "studentnumber = '$studentNumber'";
        $result = $database->selectData('students', $condition);

        if ($result) {
            $firstname = $result['firstname'];
            $middleinitial = $result['middleinitial'];
            $course = $result['course'];

            echo "<table>";
            echo "<tr>";
            echo "<th>Welcome to Latin Honor Sytstem, $firstname $middleinitial. $surname </th><th></th>";
            echo "<tr>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><strong>Student Number:</strong> $studentNumber</td>";
            echo "<td><strong>Course:</strong> $course</td>";
            echo "</tr>";
            echo "</table>";

            $condition1 = "studentnumber1 = '$studentNumber'";
            // Retrieve student grades
            $result = $database->selectData('student_grades', $condition1);

            if ($result) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Year</th>";
                echo "<th>1st Sem General Average</th>";
                echo "<th>2nd Sem General Average</th>";
                echo "<th>Final Average</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>1st Year</td>";
                echo "<td>" . $result['first_sem_avg_1'] . "</td>";
                echo "<td>" . $result['first_sem_avg_2'] . "</td>";
                echo "<td>" . $result['yr_1_final_ave'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>2nd Year</td>";
                echo "<td>" . $result['second_sem_avg_1'] . "</td>";
                echo "<td>" . $result['second_sem_avg_2'] . "</td>";
                echo "<td>" . $result['yr_2_final_ave'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>3rd Year</td>";
                echo "<td>" . $result['first_sem_avg_3'] . "</td>";
                echo "<td>" . $result['second_sem_avg_3'] . "</td>";
                echo "<td>" . $result['yr_3_final_ave'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>4th Year</td>";
                echo "<td>" . $result['first_sem_avg_4'] . "</td>";
                echo "<td>" . $result['second_sem_avg_4'] . "</td>";
                echo "<td>" . $result['yr_4_final_ave'] . "</td>";
                echo "</tr>";

                echo "<table>";
                echo "<tr>";
                echo "<th style='text-align: center;'>" . "Summer Term Final Average";
                echo "<tr>";
                echo "<td style='text-align: center;'>" . $result['summer_avg'] . "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table>";
                echo "<tr>";
                echo "<th style='text-align: center;'>" . "Overall Student Final";
                echo "<tr>";
                echo "<td style='text-align: center;'>" . $result['final_average'] . "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table>";
                echo "<tr>";
                echo "<th style='text-align: center;'>" . "Academic Distinction";
                echo "<tr>";
                echo "<td style='text-align: center;'>" . $result['academicDistinction'] . "</td>";
                echo "</tr>";
                echo "</table>";

                echo "</table>";
            } else {
                echo "<p>No grades found.</p>";
            }
        } else {
            echo "<p>No student information found.</p>";
        }

        // Disconnect from the database
        $database->disconnect();

        // Logout button
        echo '<form action="Logout.php" method="POST">';
        echo '<input type="submit" value="Logout">';
        echo '</form>';
    } else {
        header("location:loginform.php");
        echo "<script>You are not logged in.</script>";
    }
    $firstSemesterAvg1 = $result['first_sem_avg_1'];
    $firstSemesterAvg2 = $result['first_sem_avg_2'];
    $yr1FinalAverage = $result['yr_1_final_ave'];
    $secondSemesterAvg1 = $result['second_sem_avg_1'];
    $secondSemesterAvg2 = $result['second_sem_avg_2'];
    $yr2FinalAverage = $result['yr_2_final_ave'];
    $firstSemesterAvg3 = $result['first_sem_avg_3'];
    $secondSemesterAvg3 = $result['second_sem_avg_3'];
    $yr3FinalAverage = $result['yr_3_final_ave'];
    $firstSemesterAvg4 = $result['first_sem_avg_4'];
    $secondSemesterAvg4 = $result['second_sem_avg_4'];
    $yr4FinalAverage = $result['yr_4_final_ave'];
    $summerAverage = $result['summer_avg'];
    $academicDistinction = $result['academicDistinction'];
    $finalAverage = $result['final_average'];

    echo '<form action="PrintGradeBSIT.php" method="post">';
    echo '<br>' . '<button type="submit" name="download_pdf">Download PDF</button>';
    echo '<input type="hidden" name="studentNumber" value="' . $studentNumber . '">';
    echo '<input type="hidden" name="firstname" value="' . $firstname . '">';
    echo '<input type="hidden" name="middleinitial" value="' . $middleinitial . '">';
    echo '<input type="hidden" name="surname" value="' . $surname . '">';
    echo '<input type="hidden" name="course" value="' . $course . '">';
    echo '<input type="hidden" name="first_sem_avg_1" value="' . $firstSemesterAvg1 . '">';
    echo '<input type="hidden" name="first_sem_avg_2" value="' . $firstSemesterAvg2 . '">';
    echo '<input type="hidden" name="yr_1_final_ave" value="' . $yr1FinalAverage . '">';
    echo '<input type="hidden" name="second_sem_avg_1" value="' . $secondSemesterAvg1 . '">';
    echo '<input type="hidden" name="second_sem_avg_2" value="' . $secondSemesterAvg2 . '">';
    echo '<input type="hidden" name="yr_2_final_ave" value="' . $yr2FinalAverage . '">';
    echo '<input type="hidden" name="first_sem_avg_3" value="' . $firstSemesterAvg3 . '">';
    echo '<input type="hidden" name="second_sem_avg_3" value="' . $secondSemesterAvg3 . '">';
    echo '<input type="hidden" name="yr_3_final_ave" value="' . $yr3FinalAverage . '">';
    echo '<input type="hidden" name="first_sem_avg_4" value="' . $firstSemesterAvg4 . '">';
    echo '<input type="hidden" name="second_sem_avg_4" value="' . $secondSemesterAvg4 . '">';
    echo '<input type="hidden" name="yr_4_final_ave" value="' . $yr4FinalAverage . '">';
    echo '<input type="hidden" name="summer_avg" value="' . $summerAverage . '">';
    echo '<input type="hidden" name="academic_distinction" value="' . $academicDistinction . '">';
    echo '<input type="hidden" name="final_average" value="' . $finalAverage . '">';
    echo '</form>';
    ?>
</body>
</html>