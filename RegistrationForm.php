<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Registration and Login</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/registration.css">
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="brand-wrapper">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h2>Student Registration Form</h2>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" placeholder="John Dustin" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" id="surname" placeholder="Santos" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="middleinitial">Middle Initial</label>
                            <input type="text" name="middleinitial" id="middleinitial" placeholder="Y" maxlength="5" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="studentnumber">Student Number</label>
                            <input type="text" name="studentnumber" id="studentnumber" placeholder="2021-00000-ML-0" pattern=".{15}" title="Please enter your exact student number" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="course">Course</label>
                            <select name="course" id="course" required></select><br><br>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="birthmonth">Birth Month</label>
                            <select name="birthmonth" id="birthmonth" required></select><br><br>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="birthdate">Birth Date</label>
                            <select name="birthdate" id="birthdate" required></select><br><br>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="birthyear">Birth Year</label>
                            <select name="birthyear" id="birthyear" required></select><br><br>
                        </div>
                    </div>

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="New Password" id="password1" required><br><br>
                    <p class="help-text">Minimum of 8 characters, upper and lowercase, a number, and a symbol.</p>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" placeholder="Re-enter your password" id="password" required><br><br>

                    <!-- Password strength alert -->
                    <div class="alert alert-danger mt-2" role="alert" id="password-strength-alert" style="display: none;">
                        Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one symbol.
                    </div>

                    <input type="submit" value="Register" class="btn btn-block login-btn mb-4">
                    <p class="login-card-footer-text">Already have an account? <a href="loginform.php" class="register-text">Login Here</a></p>
                </form>
            </div>
    </main>
    <script src="css/login.js"></script>
    <script async data-id="9184694353" id="chatling-embed-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
</body>

<?php

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

    public function insertData($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Data inserted succesfully")</script>';
        } else {
            // Check if the error is due to duplicate entry (error code 1062)
            if ($this->conn->errno === 1062) {
                echo '<script>alert("Student number has already been registered. Try contacting the admin if you think this is a mistake.")</script>';
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }
    }
}
$database = new Database('localhost', 'root', '', 'sample_sis');

//connect to the database
$database->connect();
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $surname = $_POST['surname'];
    $firstname = $_POST['firstname'];
    $middleinitial = $_POST['middleinitial'];
    $studentnumber = $_POST['studentnumber'];
    $course = $_POST['course'];
    $birthmonth = $_POST['birthmonth'];
    $birthdate = $_POST['birthdate'];
    $birthyear = $_POST['birthyear'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $symbol = preg_match('@[\W]@', $password);
    $length = strlen($password) >= 8;

    if (!$uppercase || !$lowercase || !$number || !$symbol || !$length) {
        // Password does not meet the required strength criteria
        echo '<script>alert("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one symbol.")</script>';
    } else {
        //insert data into the database
        $data = array(
            'surname' => $surname,
            'firstname' => $firstname,
            'middleinitial' => $middleinitial,
            'studentnumber' => $studentnumber,
            'course' => $course,
            'birthmonth' => $birthmonth,
            'birthdate' => $birthdate,
            'birthyear' => $birthyear,
            'password' => $password
        );
        $database->insertData('students', $data);
        echo '<script>window.location.href = "loginform.php";</script>';
        exit(); // Make sure to exit after redirect
        session_destroy();
    }
}
?>

</html>