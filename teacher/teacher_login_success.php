<?php
ob_start();
session_start();
$teacher_id = $_SESSION['teacher_user_id'];

$class_teacher_class;
$class_teacher_section;
$class_teacher_subject;

if(!$teacher_id) {
	echo ("You are not logged in, please go to login page and provide credentials");
	return 0;
}
echo nl2br("\n <h4 align=\"right\">  click here to <a href=\"/~vaibhav/schooter/teacher/teacher_logout.php\">LogOut</a> </h4>");

echo nl2br("\n <h3 align=\"center\"> <font color=\"green\">!!!! We are coming up with something awesome here !!!!</h4>");


$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
        echo nl2br("\n Connection to database successfull !!");
}

function take_attendance($mysqli, $teacher_id, $class, $section) {
echo nl2br("<html><body><form action=\"/~vaibhav/schooter/student_attendance/student_attendance.php\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"store_variable\">
Month: <select name=\"month\">
  <option value=\"january\">january</option>
  <option value=\"february\">february</option>
  <option value=\"march\">march</option>
  <option value=\"april\">april</option>
  <option value=\"may\">may</option>
  <option value=\"june\">june</option>
  <option value=\"july\">july</option>
  <option value=\"august\">august</option>
  <option value=\"september\">september</option>
  <option value=\"october\">october</option>
  <option value=\"november\">november</option>
  <option value=\"december\">december</option>
</select>
Date: <select type=\"text\" name=\"date\">
  <option value=\"1\">1</option>
  <option value=\"2\">2</option>
  <option value=\"3\">3</option>
  <option value=\"4\">4</option>
  <option value=\"5\">5</option>
  <option value=\"6\">6</option>
  <option value=\"7\">7</option>
  <option value=\"8\">8</option>
  <option value=\"9\">9</option>
  <option value=\"10\">10</option>
  <option value=\"11\">11</option>
  <option value=\"12\">12</option>
  <option value=\"13\">13</option>
  <option value=\"14\">14</option>
  <option value=\"15\">15</option>
  <option value=\"16\">16</option>
  <option value=\"17\">17</option>
  <option value=\"18\">18</option>
  <option value=\"19\">19</option>
  <option value=\"20\">20</option>
  <option value=\"21\">21</option>
  <option value=\"22\">22</option>
  <option value=\"23\">23</option>
  <option value=\"24\">24</option>
  <option value=\"25\">25</option>
  <option value=\"26\">26</option>
  <option value=\"27\">27</option>
<option value=\"28\">28</option>
  <option value=\"29\">29</option>
  <option value=\"30\">30</option>
  <option value=\"31\">31</option>
</select>
Class: <input type=\"text\" name=\"class\" value = $class readonly>
Section: <input type=\"text\" name=\"section\" value = $section readonly>
<input type=\"submit\" id=\"submit-form\" class=\"hidden\" /><br>
</form></body></html>");
}

function submit_marks($mysqli, $teacher_id, $class, $section){
echo nl2br("<html><body><form action=\"/~vaibhav/schooter/student_marks/student_marks.php\" method=\"post\">
<input type=\"hidden\" name=\"action\" value=\"store_variable\">
Class: <input type=\"text\" name=\"class\" value = $class readonly>
Section: <input type=\"text\" name=\"section\" value = $section readonly>
<input type=\"submit\" id=\"submit-form\" class=\"hidden\" /><br>
</form></body></html>");
}

function other_class_info($mysqli, $teacher_id) {
	$sql = "select * from sch_xaviers_bhopal_teacher_class_info where teacher_id='$teacher_id' and class_teacher='no'";
	$result = $mysqli->query($sql);
	$class_info = mysqli_fetch_all($result,MYSQLI_ASSOC);
	//print_r($class_info);
	for($i=0; $i<4; $i++) {
		$x = $class_info[$i]['class'];
		$y = $class_info[$i]['section'];
		$z = $class_info[$i]['subject'];
		if(!$x) {
			break;
		}
		echo nl2br("<h4 align=\"left\">  Take Attedance </h4>");
		take_attendance($mysqli,$teacher_id,$x,$y);
		echo nl2br("<h4 align=\"left\">  Submitt Marks </h4>");
		submit_marks($mysqli, $teacher_id, $x,$y);
	}
}

function class_teacher_info($mysqli, $teacher_id) {
	$sql = "select * from sch_xaviers_bhopal_teacher_class_info where teacher_id='$teacher_id' and class_teacher='yes'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$class_teacher_class = $row['class'];
	$class_teacher_section = $row['section'];
	$class_teacher_subject = $row['subject'];
	
	echo nl2br("<h4 align=\"left\">  Take Attedance </h4>");
	take_attendance($mysqli, $teacher_id, $class_teacher_class, $class_teacher_section);
	echo nl2br("<h4 align=\"left\">  Submitt Marks </h4>");
	submit_marks($mysqli, $teacher_id, $class_teacher_class, $class_teacher_section);
}
echo nl2br("<h2 align=\"left\">  Class teacher info</h2>");
class_teacher_info($mysqli, $teacher_id);
echo nl2br("<h2 align=\"left\">  Other class info</h2>");
other_class_info($mysqli, $teacher_id);
?>
