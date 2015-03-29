<?php
require 'StudentDB.php';
$json_data = json_decode('{"first_name": "Dale",
"last_name": "Cooper",
"age": 35,
"enrolled": true,
"married": null,
"address":{
"street": "123 Main St",
"city": "Seattle",
"state": "WA"
},
"phone": [
{"type": "home",
"number": "4125551212"
},
{"type": "mobile",
"number": "4125552121"
}
]}');
echo '<pre>';
var_dump($json_data);
echo '</pre>';

class Address {
	public $street = "";
	public $city = "";
	public $state = "";

	function __construct($street, $city, $state) {
		$this -> street = $street;
		$this -> city = $city;
		$this -> state = $state;
	}

}

class Student {

	public $first_name = "";
	public $last_name = "";
	public $age = 0;
	public $enrolled = false;
	public $married = null;
	public $address;
	public $phone;

	function __construct($first_name, $last_name, $age, $enrolled, $married, $street, $city, $state, $ph_home, $ph_mobile) {

		$this -> first_name = $first_name;
		$this -> last_name = $last_name;
		$this -> age = $age;
		$this -> enrolled = $enrolled;
		$this -> married = $married;
		$this -> address = new Address($street, $city, $state);
		$this -> phone = array("home" => $ph_home, "mobile" => $ph_mobile);

	}

}

$dale = new Student("dale", "cooper", 34, "Y", "M", "123 elm street", "Elmington", "EL", "23232", "5454");

echo "<br /><br />";

$dale_data = json_encode($dale);

echo '<hr/><pre>';
var_dump($dale_data);
echo '</pre>';

require_once ("dbconn.php");

if (mysqli_connect_error()) {
	print("Connect failed");
	exit();
}

$query = "SELECT * from students where student_id in (1,2)";
$student_array = array();
if ($result = $dbc -> query($query)) {
	while ($obj = $result -> fetch_object()) {

		printf("%s %s %s %s %s %s %s %s %s %s %s %s %s <br />", $obj -> first_name, $obj -> last_name, $obj -> email, $obj -> street, $obj -> city, $obj -> state, $obj -> zip, $obj -> phone, $obj -> birth_date, $obj -> sex, $obj -> date_entered, $obj -> lunch_cost, $obj -> student_id);

		$temp_student = new StudentDB($obj -> first_name, $obj -> last_name, $obj -> email, $obj -> street, $obj -> city, $obj -> state, $obj -> zip, $obj -> phone, $obj -> birth_date, $obj -> sex, $obj -> date_entered, $obj -> lunch_cost, $obj -> studentid);

		$student_array[] = $temp_student;

	}
	echo "<br /><br />";
	
	// Surround the student data
	echo '{"students":[';
	
	// Take data array created and convert into JSON
	$dale_data = json_encode($student_array[0]);
	echo $dale_data;
	
	// Seperate the results
	echo ',<br />';
	
	$dale_data = json_encode($student_array[1]);
	echo $dale_data . "<br />";
	
	// Close the JSON data
	echo ']}';

	// Close the database connection
	$result->close();
	$dbc->close();

}
