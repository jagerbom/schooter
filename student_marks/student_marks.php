<?php
echo nl2br("<h1> <font color=\"red\">Welcome to Schooter. Drive your child to successfull career </h1>");
echo nl2br("<h2><font color=\"blue\">Student marks upload page</h2>");
$action		= $_POST["action"];

if ($action == "store_variable") {
	$class 		= $_POST["class"];
	$section 	= $_POST["section"];
	echo nl2br("\n You are uploading marks for class $class $section \n");
	echo nl2br("\n class = $class");
	echo nl2br("\n section = $section");

	$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n Connection to database successfull !!");
		}   
		echo nl2br("<form action=\"student_marks.php\" method=\"post\">\n");
		echo nl2br("<input type=\"hidden\" name=\"action\" value=\"loaddb\">");
		echo nl2br("<input type=\"hidden\" name=\"class\" value=\"$class\">");
		echo nl2br("<input type=\"hidden\" name=\"section\" value=\"$section\">");
		
		$sql = "select student_id from sch_xaviers_bhopal_student_info where student_class='$class' and student_section='$section'";
		$result = $mysqli->query($sql);
		echo "<br>" . "STUDENT ID: <select name='id'>";
		while ($row = $result->fetch_assoc()) {
			unset($id, $name);
			$name = $row['student_id']; 
			echo '<option value="'.$name.'">'.$name.'</option>';

		}   
		echo "</select>" . "<br>" ;
		echo nl2br("Term: <select name=\"term\">\n
				<option value=\"first\">first</option>\n
				<option value=\"second\">second</option>\n
				<option value=\"third\">third</option>\n
				</select> <br>");
		echo nl2br("Subject: <select name=\"subject\">\n
				<option value=\"english\">english</option>\n
				<option value=\"hindi\">hindi</option>\n
				<option value=\"maths\">maths</option>\n
				<option value=\"science\">science</option>\n
				<option value=\"social\">social</option>\n
				</select>");
		echo nl2br("Paper type: <select name=\"paper_type\">\n
				<option value=\"theory\">theory</option>\n
				<option value=\"practical\">practical</option>\n
				</select><br>");
		echo nl2br("Mark type: <select name=\"mark_type\">\n
				<option value=\"grade\">grade</option>\n
				<option value=\"number\">number</option>\n
				</select><br><br>");
		echo nl2br("Maximum marks:
				<input type=\"text\" name=\"maximum_marks\"><br>
				Marks obtained:
				<input type=\"text\" name=\"marks_obtained\"><br>	
				<input type=\"submit\">\n
				</form>\n");
	}
}
if ($action=="loaddb") {
	$DEBUG		= 1;
	$class 			= $_POST["class"];
	$section 		= $_POST["section"];
	$student_id		= $_POST["id"];
	$term			= $_POST["term"];
	$subject		= $_POST["subject"];
	$paper_type		= $_POST["paper_type"];
	$mark_type		= $_POST["mark_type"];
	$maximum_marks		= $_POST["maximum_marks"];
	$marks_obtained		= $_POST["marks_obtained"];
	
	echo nl2br("\n action = $action");
	echo nl2br("\n class = $class");
	echo nl2br("\n section = $section");
	echo nl2br("\n student_id = $student_id");
	echo nl2br("\n term = $term");
	echo nl2br("\n subject = $subject");
	echo nl2br("\n paper_type = $paper_type");
	echo nl2br("\n mark_type = $mark_type");
	echo nl2br("\n marks_obtained = $marks_obtained");
	echo nl2br("\n maximum_marks = $maximum_marks");

	$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n Connection to database successfull !!");
		}   
	}

	if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_student_mark_info (student_id varchar(50), student_class varchar(10), student_section varchar(10), term varchar(10), subject varchar(50), paper_type varchar(10), mark_type varchar(10), marks_obtained varchar(10), maximum_marks varchar(10))"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n parent_info table created successfully !!");
		}   
	}

	$sql = "select marks_obtained from sch_xaviers_bhopal_student_mark_info where student_id='$student_id' and term='$term' and subject='$subject' and paper_type='$paper_type'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$cur_status = $row['marks_obtained'];
	echo nl2br("\n cur_status = $cur_status");
	if (!$cur_status) {	
		$sql = "INSERT INTO sch_xaviers_bhopal_student_mark_info (student_id, student_class, student_section, term, subject, paper_type, mark_type, marks_obtained, maximum_marks)
			VALUES ('$student_id', '$class', '$section', '$term', '$subject', '$paper_type', '$mark_type', '$marks_obtained', '$maximum_marks')";
		if ($mysqli->query($sql) === TRUE) {
			if ($DEBUG){
				echo nl2br(" \n New record created successfully");
			}   
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo nl2br("\n marks are already updated for this student");
	}
	$mysqli->close();
}
?>
