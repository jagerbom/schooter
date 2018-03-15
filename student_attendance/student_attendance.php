<?php
echo nl2br("<h1> <font color=\"red\">Welcome to Schooter. Drive your child to successfull career </h1>");
echo nl2br("<h2><font color=\"blue\">Student attendance page</h2>");
$action		= $_POST["action"];

if ($action == "store_variable") {
	$class 		= $_POST["class"];
	$section 	= $_POST["section"];
	$month		= $_POST["month"];
	$date		= $_POST["date"];
	echo nl2br("\n You are marking attendance for $date $month for class $class $section \n");
	echo nl2br("\n class = $class");
	echo nl2br("\n section = $section");
	echo nl2br("\n month = $month");
	echo nl2br("\n date = $date");


	$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n Connection to database successfull !!");
		}   
		$sql = "select student_id from sch_xaviers_bhopal_student_info where student_class='$class' and student_section='$section'";
		$result = $mysqli->query($sql);
		echo nl2br("<form action=\"student_attendance.php\" method=\"post\">\n");
		echo nl2br("<input type=\"hidden\" name=\"action\" value=\"loaddb\">");
		echo nl2br("<input type=\"hidden\" name=\"class\" value=\"$class\">");
		echo nl2br("<input type=\"hidden\" name=\"section\" value=\"$section\">");
		echo nl2br("<input type=\"hidden\" name=\"date\" value=\"$date\">");
		echo nl2br("<input type=\"hidden\" name=\"month\" value=\"$month\">");
		echo "<br>" . "STUDENT ID: <select name='id'>";
		while ($row = $result->fetch_assoc()) {
			unset($id, $name);
			$name = $row['student_id']; 
			echo '<option value="'.$name.'">'.$name.'</option>';

		}   
		echo "</select>";
		echo nl2br("Status: <select name=\"status\">\n
				<option value=\"yes\">yes</option>\n
				<option value=\"no\">no</option>\n
				</select><br>
				<input type=\"submit\">\n
				</form>\n");
	}
}

if ($action=="loaddb") {
	$DEBUG		= 1;
	$class 		= $_POST["class"];
	$section 	= $_POST["section"];
	$month		= $_POST["month"];
	$date		= $_POST["date"];
	$student_id	= $_POST["id"];
	$status		= $_POST["status"];
	echo nl2br("\n class = $class");
	echo nl2br("\n section = $section");
	echo nl2br("\n month = $month");
	echo nl2br("\n date = $date");
	echo nl2br("\n student_id = $student_id");
	echo nl2br("\n status = $status");

	$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n Connection to database successfull !!");
		}   
	}

	//******** Create attendance_info table into the database ********//
	if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_student_attendance_info (student_name varchar(50), student_class varchar(10), student_section varchar(10), student_id varchar(50), month varchar(10), date varchar(10), status varchar(10))"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	} else {
		if ($DEBUG) {
			echo nl2br("\n parent_info table created successfully !!");
		}   
	}


	//******** Insert entries into parent_info table ********//
	$sql = "select status from sch_xaviers_bhopal_student_attendance_info where student_id='$student_id' and month='$month' and date='$date'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$cur_status = $row['status'];
	echo nl2br("\n cur_status = $cur_status");
	if (!$cur_status) {	
		$sql = "INSERT INTO sch_xaviers_bhopal_student_attendance_info (student_id, student_class, student_section, month, date, status)
			VALUES ('$student_id', '$class', '$section', '$month', '$date', '$status')";
		if ($mysqli->query($sql) === TRUE) {
			if ($DEBUG){
				echo nl2br(" \n New record created successfully");
			}   
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo nl2br("\n attancence is already updated for this student");
	}
	//******** Close the connection to database ********//
	$mysqli->close();

}
/*echo nl2br("<html>\n
<body>\n
<form action=\"\" method=\"post\">\n
Month: <select name=\"month\">\n
  <option value=\"january\">january</option>\n
  <option value=\"february\">february</option>\n
  <option value=\"march\">march</option>\n
  <option value=\"april\">april</option>\n
  <option value=\"may\">may</option>\n
  <option value=\"june\">june</option>\n
  <option value=\"july\">july</option>\n
  <option value=\"august\">august</option>\n
  <option value=\"september\">september</option>\n
  <option value=\"october\">october</option>\n
  <option value=\"november\">november</option>\n
  <option value=\"december\">december</option>\n
</select>
Date: <select type=\"text\" name=\"date\">\n
  <option value=\"1\">1</option>\n
  <option value=\"2\">2</option>\n
  <option value=\"3\">3</option>\n
  <option value=\"4\">4</option>\n
  <option value=\"5\">5</option>\n
  <option value=\"6\">6</option>\n
  <option value=\"7\">7</option>\n
  <option value=\"8\">8</option>\n
  <option value=\"9\">9</option>\n
  <option value=\"10\">10</option>\n
  <option value=\"11\">11</option>\n
  <option value=\"12\">12</option>\n
  <option value=\"13\">13</option>\n
  <option value=\"14\">14</option>\n
  <option value=\"15\">15</option>\n
  <option value=\"16\">16</option>\n
  <option value=\"17\">17</option>\n
  <option value=\"18\">18</option>\n
  <option value=\"19\">19</option>\n
  <option value=\"20\">20</option>\n
  <option value=\"21\">21</option>\n
  <option value=\"22\">22</option>\n
  <option value=\"23\">23</option>\n
  <option value=\"24\">24</option>\n
  <option value=\"25\">25</option>\n
  <option value=\"26\">26</option>\n
  <option value=\"27\">27</option>\n
  <option value=\"28\">28</option>\n
  <option value=\"29\">29</option>\n
  <option value=\"30\">30</option>\n
  <option value=\"31\">31</option>\n
</select>
Status: <select name=\"status\">\n
  <option value=\"yes\">yes</option>\n
  <option value=\"no\">no</option>\n
</select><br>
<input type=\"submit\">\n
</form>\n

</body>\n
</html>\n");*/
?>
