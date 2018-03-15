<?php
ob_start();
session_start();
$parent_id = $_SESSION['user_id'];
if(!$parent_id) {
	echo ("You are not logged in, please go to login page and provide credentials");
	return 0;
}
echo nl2br("\n <h4 align=\"right\">  click here to <a href=\"parent_logout.php\">LogOut</a> </h4>");

//******** Connect to MYSQL database ********//
$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
        if ($DEBUG) {
                echo nl2br("\n Connection to database successfull !!");
        }   
}

$sql = "select * from sch_xaviers_bhopal_student_info where student_parent_id='$parent_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$student_id = $row['student_id'];
$student_name = $row['student_name'];
$student_class   = $row['student_class'];    
$student_section  = $row['student_section'];    
$student_age   = $row['student_age'];   
$student_sex   = $row['student_sex']; 

echo nl2br("\n authentication successfull!!! Welcome  $parent_id \n\n\n your child details are 
                Id: $student_id
                Name: $student_name
                Class: $student_class
                Section: $student_section
                Age: $student_age
                Sex: $student_sex");
echo nl2br("\n<h3 align=\"center\">  Marks info</h3> 
<h4 align=\"left\">  Term1</h4>");

function check_if_marks_are_uploaded($student_id, $mysqli, $term) {
	$sql = "select * from sch_xaviers_bhopal_student_mark_info where student_id='$student_id' and term='$term'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	if(!$row) {
		echo "No results uploaded yet" . "<br>";
		return 1;
	}

}

function assign_marks($student_id, $mysqli, $term){

	if (check_if_marks_are_uploaded($student_id, $mysqli, $term)) {
		return 0;
	}
		
	//English
	$row = fetch_subject_marks_sql(english, theory, $term, $student_id, $mysqli);
	$english_term1 = $row['subject'];
	$english_maximum_marks = $row['maximum_marks'];
	$english_marks_obtained = $row['marks_obtained'];
	echo nl2br("$english_term1 \n Maximum marks = $english_maximum_marks \n Marks obtained = $english_marks_obtained \n\n");
	
	//Hindi
	$row = fetch_subject_marks_sql(hindi, theory, $term, $student_id, $mysqli);
	$hindi_term1 = $row['subject'];
	$hindi_maximum_marks = $row['maximum_marks'];
	$hindi_marks_obtained = $row['marks_obtained'];
	echo nl2br("$hindi_term1 \n Maximum marks = $hindi_maximum_marks \n Marks obtained = $hindi_marks_obtained \n\n");
	
	//Maths
	$row = fetch_subject_marks_sql(maths, theory, $term, $student_id, $mysqli);
	$maths_term1 = $row['subject'];
	$maths_maximum_marks = $row['maximum_marks'];
	$maths_marks_obtained = $row['marks_obtained'];
	echo nl2br("$maths_term1 \n Maximum marks = $maths_maximum_marks \n Marks obtained = $maths_marks_obtained \n\n");
	
	//Science
	$row = fetch_subject_marks_sql(science, theory, $term, $student_id, $mysqli);
	$science_term1 = $row['subject'];
	$science_maximum_marks = $row['maximum_marks'];
	$science_marks_obtained = $row['marks_obtained'];
	echo nl2br("$science_term1 \n Maximum marks = $science_maximum_marks \n Marks obtained = $science_marks_obtained \n\n");
	
	//Science_practical
	$row = fetch_subject_marks_sql(science, practical, $term, $student_id, $mysqli);
	$science_term1 = $row['subject'];
	$science_maximum_marks_p = $row['maximum_marks'];
	$science_marks_obtained_p = $row['marks_obtained'];
	echo nl2br("$science_term1 \n Paper_type = Practical \n Maximum marks = $science_maximum_marks_p \n Marks obtained = $science_marks_obtained_p \n\n");
	
	//Social
	$row = fetch_subject_marks_sql(social, theory, $term, $student_id, $mysqli);
	$social_term1 = $row['subject'];
	$social_maximum_marks = $row['maximum_marks'];
	$social_marks_obtained = $row['marks_obtained'];
	echo nl2br("$social_term1 \n Maximum marks = $social_maximum_marks \n Marks obtained = $social_marks_obtained \n\n");
}

function fetch_subject_marks_sql($subject, $paper_type, $term, $student_id, $mysqli) {
	$sql = "select * from sch_xaviers_bhopal_student_mark_info where student_id='$student_id' and subject='$subject' and term='$term' and paper_type='$paper_type'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	return $row;
}
assign_marks($student_id, $mysqli, first);
echo nl2br("\n<h4 align=\"left\">  Term2</h4>");
assign_marks($student_id, $mysqli, second);
echo nl2br("\n<h4 align=\"left\">  Term3</h4>");
assign_marks($student_id, $mysqli, third);

echo nl2br("\n<h3 align=\"center\">  Attendance info</h3> \n");
function attendance_info($student_id, $mysqli, $month){

	$sql = "select * from sch_xaviers_bhopal_student_attendance_info where student_id='$student_id' and month='$month'";
	//echo "$sql" . "<br>";
	$result = $mysqli->query($sql);
	$row = mysqli_fetch_all($result,MYSQLI_ASSOC);

	for($x=0; $x<31; $x++) {
		//echo "<br>" . "hello";
		if (!$row[$index]['status']) {
			if (!$row[$x]['date']) {
				break;
			}
			$cur_status = $row[$x]['status'];
			$cur_date = $row[$x]['date'];
			echo nl2br("\n $cur_date/$month     status = $cur_status");
		}
	}	
	//print_r($row);
}

attendance_info($student_id, $mysqli, january);
attendance_info($student_id, $mysqli, feburary);
attendance_info($student_id, $mysqli, march);
attendance_info($student_id, $mysqli, april);
attendance_info($student_id, $mysqli, may);
attendance_info($student_id, $mysqli, june);
attendance_info($student_id, $mysqli, july);
attendance_info($student_id, $mysqli, august);
attendance_info($student_id, $mysqli, september);
attendance_info($student_id, $mysqli, october);
attendance_info($student_id, $mysqli, november);
attendance_info($student_id, $mysqli, december);
?>
