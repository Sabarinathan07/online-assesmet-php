
<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(
        isset($_POST['quizid']) and
        isset($_POST['username']) and
        isset($_POST['score']) and
        isset($_POST['date'])  )
    {

            $db = new DbOperations(); 

        $result =   $db->updateScore(
                $_POST['quizid'],
                $_POST['username'],
                $_POST['score'],
                $_POST['date'] 
        );

        if($result==1)
		{
			$response['error'] = false; 
			$response['message'] = "Score updated successfully";
		}else if($result ==2) {
			$response['error'] = true; 
			$response['message'] = "Some error occurred please try again";			
		}else{
            $response['error'] = true; 
			$response['message'] = "Try again later";
        }

        
    


     }


}else {
        $response['error'] = true; 
		$response['message'] = "Invalid Request";
}



echo json_encode($response);

?>