
<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(
        isset($_POST['name']) and 
        isset($_POST['email']) and 
        isset($_POST['username']) and 
        isset($_POST['password'])  )
		{
		 

		$db = new DbOperations(); 

		$result = $db->studentUser(
                                        $_POST['name'],
                                        $_POST['email'],
                                        $_POST['username'],
										$_POST['password']							
									);
		if($result==1)
		{
			$response['error'] = false; 
			$response['message'] = "User registered successfully";
		}else if($result ==2) {
			$response['error'] = true; 
			$response['message'] = "Some error occurred please try again";			
		}else if($result == 0){
			$response['error'] = true; 
			$response['message'] = " Username is already registered! Please try a different name";		
		}
	
	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}else{
	$response['error'] = true; 
	$response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
