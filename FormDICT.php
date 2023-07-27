<!DOCTYPE html>
<html>
<head>
  <title>Student Grades</title>
  <link rel="stylesheet" type="text/css" href="css/formbsit.css">
  <script async data-id="9184694353" id="chatling-embed-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="css/formdict.js"></script>
</head>
<?php
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
    $surname = $result['surname'];
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
  } else {
    echo "<p>You are not logged in.</p>";
  }
}

?>

<body>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table>
      <tr>
        <th>Year</th>
        <th>1st Sem General Average</th>
        <th>2nd Sem General Average</th>
      </tr>
      <tr>
        <td>Year 1</td>

        <td><input type='number' step='0.01' name='first_sem_avg_1' id='first_sem_avg_1' required></td>
        <td><input type='number' step='0.01' name='second_sem_avg_1' id='second_sem_avg_1' required></td>
      </tr>
      <tr>
        <td>Year 2</td>
        <td><input type='number' step='0.01' name='first_sem_avg_2' id='first_sem_avg_2' required></td>
        <td><input type='number' step='0.01' name='second_sem_avg_2' id='second_sem_avg_2' required></td>
      </tr>
      <tr>
        <td>Year 3</td>
        <td><input type='number' step='0.01' name='first_sem_avg_3' id='first_sem_avg_3' required></td>
        <td><input type='number' step='0.01' name='second_sem_avg_3' id='second_sem_avg_3' required></td>
      </tr>
    </table>
    <table class="summer-term">
      <tr>
        <td>Summer Term</td>
        <td><input type='number' step='0.01' name='summer_avg' id='summer_avg' required></td>
      </tr>
    </table>
    <!-- Temporary confirmation button -->
    <button type="button" id="confirmBtn" onclick="showComputeButton(); return confirm('Are you sure you want to proceed?')">Confirm</button>

    <!-- Compute final average button -->

    <input type="submit" name="compute" id="computeBtn" value="Compute Final Average">
  </form>

  <!-- Countdown Popup Modal -->
  <div class="modal fade" id="countdownModal" tabindex="-1" role="dialog" aria-labelledby="countdownModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="countdownModalLabel">Please wait to download your pdf copy</h5>
        </div>
        <div class="modal-body">
          <p>This page will automatically redirect in <span id="countdownTimer">5</span> seconds. Please wait.</p>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST['compute'])) {
    $totalGrades = 0;
    $firstSemAverages = [];
    $secondSemAverages = [];
    $finalAverage = 0;

    $yr_1_final_ave;
    $yr_2_final_ave;
    $yr_3_final_ave;

    for ($i = 1; $i <= 3; $i++) {
      $firstSemAvg = $_POST['first_sem_avg_' . $i];
      $secondSemAvg = $_POST['second_sem_avg_' . $i];
      $finalAvg = ($firstSemAvg + $secondSemAvg) / 2;
      $finalAverage += $finalAvg;
      $totalGrades++;

      ${"yr_" . $i . "_final_ave"} = $finalAvg; // Create variable names for each year's final average

      echo "<p>Year $i Final Average: $finalAvg</p>";

      $firstSemAverages[] = $firstSemAvg;
      $secondSemAverages[] = $secondSemAvg;
    }

    if (isset($_POST['compute']) && isset($_POST['summer_avg'])) {
      $summerAvg = $_POST['summer_avg'];
      $finalAverage += $summerAvg;
      $totalGrades++;
      echo "<p>Summer Term Average: $summerAvg</p>";
    }

    $yr_1_final_ave_hidden = $yr_1_final_ave;
    $yr_2_final_ave_hidden = $yr_2_final_ave;
    $yr_3_final_ave_hidden = $yr_3_final_ave;


    $finalAverage /= $totalGrades;
    echo "<h3>Overall Final Average: $finalAverage</h3>";

    // Determine academic distinction

    if ($finalAverage >= 1.0 && $finalAverage <= 1.2) {
      $academicDistinction = "Summa Cum Laude ";
    } elseif ($finalAverage > 1.2 && $finalAverage <= 1.45) {
      $academicDistinction = "Magna Cum Laude ";
    } elseif ($finalAverage > 1.45 && $finalAverage <= 1.75) {
      $academicDistinction = "Cum Laude";
    } else {
      $academicDistinction = "No Academic Distinction";
    }

    echo "<h3>Academic Distinction: $academicDistinction </h3>";

    $surnames = $result['surname'];
    // Add a download PDF button
    echo '<form action="PrintGradeDICT.php" method="post">';

    // echo '<input type="hidden" name="student_Number1" value="' .$studentNumber . '">';
    echo '<input type="hidden" name="studentNumber" value="' . $studentNumber . '">';
    echo '<input type="hidden" name="firstname" value="' . $firstname . '">';
    echo '<input type="hidden" name="middleinitial" value="' . $middleinitial . '">';
    echo '<input type="hidden" name="surname" value="' . $surname . '">';
    echo '<input type="hidden" name="course" value="' . $course . '">';

    for ($i = 0; $i < count($firstSemAverages); $i++) {
      echo '<input type="hidden" name="first_sem_avg_' . ($i + 1) . '" value="' . $firstSemAverages[$i] . '">';
    }
    for ($i = 0; $i < count($secondSemAverages); $i++) {
      echo '<input type="hidden" name="second_sem_avg_' . ($i + 1) . '" value="' . $secondSemAverages[$i] . '">';
    }
    echo '<input type="hidden" name="summer_avg" value="' . $summerAvg . '">';

    for ($i = 1; $i <= 3; $i++) {
      $year_average = ${"yr_" . $i . "_final_ave"};
      echo '<input type="hidden" name="yr_' . $i . '_final_ave" id="yr_' . $i . '_final_ave" value="' . $year_average . '">';
    }

    echo '<input type="hidden" name="academic_distinction" value="' . $academicDistinction . '">';
    echo '<input type="hidden" name="final_average" value="' . $finalAverage . '">';
    echo '<button type="submit" name="download_pdf">Download PDF</button>';
    echo '</form>';

    // Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sample_sis";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Prepare and execute an SQL query to insert the values into the database
      $stmt = $conn->prepare("INSERT INTO student_grades_dit (studentnumber2,first_sem_avg_1, first_sem_avg_2, first_sem_avg_3, second_sem_avg_1, second_sem_avg_2, second_sem_avg_3, summer_avg, yr_1_final_ave, yr_2_final_ave, yr_3_final_ave, final_average, academicDistinction) 
    VALUES (:student_Number1,:firstSemAvg1, :firstSemAvg2, :firstSemAvg3, :secondSemAvg1, :secondSemAvg2, :secondSemAvg3, :summerAvg, :yr1FinalAve, :yr2FinalAve, :yr3FinalAve, :finalAverage, :academicDistinction)");

      $stmt->bindParam(':student_Number1', $studentNumber);
      $stmt->bindParam(':firstSemAvg1', $firstSemAverages[0]);
      $stmt->bindParam(':firstSemAvg2', $firstSemAverages[1]);
      $stmt->bindParam(':firstSemAvg3', $firstSemAverages[2]);
      $stmt->bindParam(':secondSemAvg1', $secondSemAverages[0]);
      $stmt->bindParam(':secondSemAvg2', $secondSemAverages[1]);
      $stmt->bindParam(':secondSemAvg3', $secondSemAverages[2]);
      $stmt->bindParam(':summerAvg', $summerAvg);
      $stmt->bindParam(':yr1FinalAve', $yr_1_final_ave);
      $stmt->bindParam(':yr2FinalAve', $yr_2_final_ave);
      $stmt->bindParam(':yr3FinalAve', $yr_3_final_ave);
      $stmt->bindParam(':finalAverage', $finalAverage);
      $stmt->bindParam(':academicDistinction', $academicDistinction);
      $stmt->execute();

      echo '<script>alert("Data inserted successfully into the database.")</script>';
    } catch (PDOException $e) {
      if ($e->getCode() == '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
        echo '<script>alert("Error: Duplicate entry. Please students can only send one data.")</script>';
      } else {
        echo "Error: " . $e->getMessage();
      }
    }

    // Close the database connection
    $conn = null;
    // Add the session_destroy() function after the PDF download process
    if (isset($_POST['download_pdf'])) {
      session_destroy();

      header("location:loginform.php"); // Redirect to the login page after logout
      exit();
    }
  }
  ?>
</body>
</html>