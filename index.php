<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Form</title>
    <script async data-id="9184694353" id="chatling-embed-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
</head>
<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                        <img src="assets/pup.jpg" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="brand-wrapper">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <img src="assets/logo.png" alt="logo" class="logo">
                                    <p class="login-card-welcome">Welcome to Latin Honor System!</p>
                                </div>
                                <p class="login-card-description">Sign into your account</p>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="form-group">
                                        <label for="studentnumber" class="sr-only">Student Number</label>
                                        <input type="text" name="studentnumber" id="studentnumber" class="form-control" placeholder="Student Number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="sr-only">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <input type="submit" value="Login" class="btn btn-block login-btn mb-4">
                                </form>
                                <?php
                                // Disable caching
                                header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
                                header("Pragma: no-cache"); // HTTP 1.0
                                header("Expires: Sat, 01 Jan 2000 00:00:00 GMT"); // Date in the past

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
                                $database = new Database('localhost', 'root', '', 'sample_sis');

                                // Connect to the database
                                $database->connect();
                                session_start();
                                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                    if (isset($_POST['studentnumber']) && isset($_POST['password'])) {
                                        $studentNumber = $_POST['studentnumber'];
                                        $password = $_POST['password'];

                                        // Check if the student number and password match the records
                                        $condition = "studentnumber = '$studentNumber' AND password = '$password'";
                                        $result = $database->selectData('students', $condition);

                                        if ($result) {
                                            $surname = $result['surname'];
                                            $studentNumber = $result['studentnumber'];
                                            $course = $result['course'];
                                            $_SESSION['studentnumber'] = $studentNumber;
                                            $_SESSION['surname'] = $surname;

                                            // Check if the student has an academic distinction
                                            $conditionGrade = "studentnumber1 = '$studentNumber'";
                                            $conditionGrade1 = "studentnumber2 = '$studentNumber'";
                                            $resultGrade = $database->selectData('student_grades', $conditionGrade);
                                            $resultGrade1 = $database->selectData('student_grades_dit', $conditionGrade1);

                                            if ($resultGrade && $course === 'BSIT') {
                                                $redirectURL = "GradeTableBSIT.php?surname=$surname&studentnumber=$studentNumber";
                                            } elseif ($resultGrade1) {
                                                $redirectURL = "GradeTableDICT.php?surname=$surname&studentnumber=$studentNumber";
                                            } elseif ($course === 'DICT') {
                                                $redirectURL = "FormDICT.php?surname=$surname&studentnumber=$studentNumber";
                                            } elseif ($course === 'BSIT') {
                                                $redirectURL = "FormBSIT.php?surname=$surname&studentnumber=$studentNumber";
                                            } else {
                                                echo "Invalid student course.";
                                                exit();
                                            }

                                            header("Location: $redirectURL");
                                            exit();
                                        } else {
                                            // Student login failed, check admin credentials
                                            $conditionAdmin = "admin = '$studentNumber' AND password = '$password'";
                                            $resultAdmin = $database->selectData('admins', $conditionAdmin);

                                            if ($resultAdmin) {
                                                // Admin login successful
                                                $redirectURL = "admin.php?username=$studentNumber";
                                                header("Location: $redirectURL");
                                                exit();
                                            } else {
                                                // Both student and admin credentials are invalid
                                                echo '<div class="alert alert-danger mt-3" role="alert">';
                                                echo 'Invalid student number or password. Please try again.';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                                // Disconnect from the database
                                $database->disconnect();
                                ?>
                                <p class="login-card-footer-text">Don't have an account? <a href="RegistrationForm.php" class="register-text">Register here</a></p>
                                <nav class="login-card-footer-nav">
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script>
        // Wait for the DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            // Get the error message element
            var errorMessageElement = document.querySelector('.alert-danger');

            // Check if there is an error message to display
            if (typeof errorMessage !== 'undefined') {
                // Set the error message content
                errorMessageElement.textContent = errorMessage;

                // Show the error message
                errorMessageElement.style.display = 'block';

                // After 3 seconds, hide the error message
                setTimeout(function() {
                    errorMessageElement.style.display = 'none';
                }, 3000);
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>