<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['username']) and isset($_POST['password'])){
		$db = new DbOperations(); 

		$result = $db->studentLogin($_POST['username'], $_POST['password']);
		if($result == 1){
			$student = $db->getStudentByUsername($_POST['username']);
			$response['error'] = false; 
			$response['id'] = $student['id'];
			$response['name'] = $student['name']; 
			$response['email'] = $student['email']; 
			$response['username'] = $student['username']; 

		}else{
			$response['error'] = true; 
			$response['message'] = "Invalid username or password!";			
		}

	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}else {
	$response['error'] = true; 
	$response['message'] = "Invalid Request";
	
}

echo json_encode($response);
?>