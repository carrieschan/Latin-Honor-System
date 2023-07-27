<?php

require('fpdf185/fpdf.php');

// Retrieve the academic distinction, final average, and year averages from the $_POST superglobal
if (isset($_POST['academic_distinction']) && isset($_POST['final_average']) &&
    isset($_POST['studentNumber']) &&
    isset($_POST['firstname']) &&
    isset($_POST['middleinitial']) &&
    isset($_POST['yr_1_final_ave']) &&
    isset($_POST['yr_2_final_ave']) &&
    isset($_POST['yr_3_final_ave']) &&
    isset($_POST['yr_4_final_ave']) &&
    isset($_POST['first_sem_avg_1']) &&
    isset($_POST['first_sem_avg_2']) &&
    isset($_POST['second_sem_avg_1']) &&
    isset($_POST['second_sem_avg_2']) &&
    isset($_POST['first_sem_avg_3']) &&
    isset($_POST['second_sem_avg_3']) &&
    isset($_POST['first_sem_avg_4']) &&
    isset($_POST['second_sem_avg_4']) &&
    isset($_POST['summer_avg'])) {

    $academicDistinction = $_POST['academic_distinction'];
    $studentNumber= $_POST['studentNumber'];
    $firstname=$_POST['firstname'];
    $middleinitial = $_POST['middleinitial'];
    $finalAverage = $_POST['final_average'];
    $yr1FinalAverage = $_POST['yr_1_final_ave'];
    $yr2FinalAverage = $_POST['yr_2_final_ave'];
    $yr3FinalAverage = $_POST['yr_3_final_ave'];
    $yr4FinalAverage = $_POST['yr_4_final_ave'];
    $firstSemesterAvg1 = $_POST['first_sem_avg_1'];
    $firstSemesterAvg2 = $_POST['first_sem_avg_2'];
    $secondSemesterAvg1 = $_POST['second_sem_avg_1'];
    $secondSemesterAvg2 = $_POST['second_sem_avg_2'];
    $firstSemesterAvg3 = $_POST['first_sem_avg_3'];
    $secondSemesterAvg3 = $_POST['second_sem_avg_3'];
    $firstSemesterAvg4 = $_POST['first_sem_avg_4'];
    $secondSemesterAvg4 = $_POST['second_sem_avg_4'];
    $summerAverage = $_POST['summer_avg'];
    $course = $_POST['course'];
    $surname = $_POST['surname']; 
    $course = $_POST['course'];

    // Generate the PDF using FPDF library
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    // Retrieve student information
  
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Student Information', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    
    $pdf->SetFillColor(128, 0, 0); // Maroon color
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(70, 10, 'Student Number:', 1, 0, 'C', true);
    $pdf->SetTextColor(0); // White text color
    $pdf->Cell(120, 10, $studentNumber, 1, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(70, 10, 'Name:', 1, 0, 'C', true);
    $pdf->SetTextColor(0); // White text color

    $pdf->Cell(120, 10 ,$surname .', ' .$firstname . ' ' . $middleinitial ,1, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetFillColor(128, 0, 0); // Maroon color
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(40, 10, 'Course:', 1, 0, 'C', true);
    $pdf->SetTextColor(0); // White text color
    $pdf->Cell(120, 10, $course, 1, 1, 'L');

    $pdf->Ln(10);

    // Set the font and font size
    $pdf->SetFont('Arial', 'B', 14);
    
    // Output the year averages table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(128, 0, 0); // Maroon color
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(50, 10, 'Year', 1, 0, 'C', true);
    $pdf->Cell(40, 10, '1st Sem', 1, 0, 'C', true);
    $pdf->Cell(40, 10, '2nd Sem', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Final Avg', 1, 1, 'C', true);
    
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255);
    $pdf->SetTextColor(0);
    $years = ['Year 1', 'Year 2', 'Year 3', 'Year 4'];
    foreach ($years as $index => $year) {
        $pdf->Cell(50, 10, $year, 1, 0, 'C', true);
        $pdf->Cell(40, 10, ${'firstSemesterAvg' . ($index + 1)}, 1, 0, 'C', true);
        $pdf->Cell(40, 10, ${'secondSemesterAvg' . ($index + 1)}, 1, 0, 'C', true);
        $pdf->Cell(60, 10, ${'yr' . ($index + 1) . 'FinalAverage'}, 1, 1, 'C', true);
    }

    $pdf->Ln(10);
    // Output the academic distinction
    $pdf->SetFillColor(128, 0, 0); // Maroon color
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(0, 10, 'Summmer Term', 1, 1, 'C', true);
    $pdf->SetFillColor(255); // White color
    $pdf->SetTextColor(0); // Black text color
    $pdf->Cell(0, 10,  $summerAverage, 1, 1, 'C', true);
    $pdf->Ln(10);

     // Output the academic distinction
     $pdf->SetFillColor(128, 0, 0); // Maroon color
     $pdf->SetTextColor(255); // White text color
     $pdf->Cell(0, 10, 'Final Average', 1, 1, 'C', true);
     $pdf->SetFillColor(255); // White color
     $pdf->SetTextColor(0); // Black text color
     $pdf->Cell(0, 10,  $finalAverage, 1, 1, 'C', true);
     $pdf->Ln(10);
    
    $pdf->SetFillColor(128, 0, 0); // Maroon color
    $pdf->SetTextColor(255); // White text color
    $pdf->Cell(0, 10, 'Academic Distinctions', 1, 1, 'C', true);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255);
    $pdf->SetTextColor(0);
    $pdf->Cell(0, 10, $academicDistinction , 1, 1, 'C', true);
     
    // Output the PDF as a download
    $pdf->Output('student_report_card.pdf', 'D');
    
}
