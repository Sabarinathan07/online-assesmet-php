<?php 

	class DbOperations{

		private $con; 

		function __construct(){

			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

		}

		public function studentUser($name , $email , $username, $password){
			if($this->isStudentUserExist($username)){
				return 0; 
			}else{
				//$password = md5($pass);
				$stmt = $this->con->prepare("INSERT INTO `student` (`id`, `name`, `email`, `username`, `password`) VALUES (NULL, ?, ?, ?, ?);");			
				//INSERT INTO `student` (`id`, `name`, `email`, `username`, `password`) VALUES (NULL, 'sabari', 'sabari@gmail.com', 'sabari', '1234');
				$stmt->bind_param("ssss",$name,$email,$username,$password);

				if($stmt->execute()){
					return 1; 
				}
				else{
					return 2; 
				}
			}
		}	
				
		public function createUser($username, $password){
			if($this->isUserExist($username)){
				return 0; 
			}else{
				
				$stmt = $this->con->prepare("INSERT INTO `teacher` (`id`, `username`, `password`) VALUES (NULL, ?, ?);");			
				//INSERT INTO `teacher` (`id`, `username`, `password`) VALUES ('2', 'sabari', 'sabar');
				$stmt->bind_param("ss",$username,$password);

				if($stmt->execute()){
					return 1; 
				}
				else{
					return 2; 
				}
			}
		}
		
		public function updateScore($quizid ,$username, $score, $date){

			$stmt = $this->con->prepare("INSERT INTO `scoreboard` (`id`, `quizid`, `username`, `score`, `date`) VALUES (NULL, ?, ?, ?, ?);");
			$stmt->bind_param("ssss",$quizid,$username,$score,$date);
			
			if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}

		public function userLogin($username, $password){
			//$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM teacher WHERE username = ? AND password = ?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		public function studentLogin($username, $password){
			//$password = md5(trim($pass));
			//echo $password.$pass;
			// $stmt = $this->con->prepare("SELECT id FROM student WHERE username = ? AND password = ?");
			// $stmt->bind_param("ss",$username,$password);
			// $stmt->execute();
			// $stmt->store_result(); 
			//$stmt->num_rows > 0; 
			$query = "SELECT id FROM student WHERE username = '$username' AND password = '$password'";
			$result = mysqli_query($this->con,$query);
			if(mysqli_num_rows($result)>0){
				return 1; 

			}else{
				return 2;
			}
			//return 1;
			// echo $stmt->num_rows;
			// if($stmt->num_rows > 0){
			
				
			// 	return 1; 
			// }
			// else{
			// 	return 2; 
			// }
		}
		

	
		public function getUserByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM teacher WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		public function getStudentByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM student WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		private function isUserExist($username){
			$stmt = $this->con->prepare("SELECT id FROM teacher WHERE username = ? ");
			$stmt->bind_param("s", $username);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		private function isStudentUserExist($username){
			$stmt = $this->con->prepare("SELECT id FROM student WHERE username = ? ");
			$stmt->bind_param("s", $username);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
			}

			public function getQuestions($quizid){
				$query = "SELECT * FROM questions WHERE quizid = '$quizid' ";
				//$query->bind_param("s",$quizid)
				$questionsArr= array();
				$result = mysqli_query($this->con, $query);
				if (mysqli_num_rows($result) > 0) {
					
					 while($row = mysqli_fetch_assoc($result)) {
					//   echo "id : " . $row["questionid"]. 
					//    "\n Name: " . $row["question"]. 
					//    "\n Option1: " . $row["choice1"]. 
					//    "\n Option2: " . $row["choice2"]. 
					//    "\n Option3: " . $row["choice3"]. 
					//  "\n <br>"  ;
					  array_push($questionsArr,$row);
					}
					echo json_encode($questionsArr);
				  } else {
					echo "0 results";
				  }
			}	

		// public function getQuestions(){
		// 	$query = "SELECT * FROM questions WHERE quizid = ";
		// 	$questionsArr= array();
		// 	$result = mysqli_query($this->con, $query);
		// 	if (mysqli_num_rows($result) > 0) {
				
		// 		 while($row = mysqli_fetch_assoc($result)) {
		// 		//   echo "id : " . $row["questionid"]. 
		// 		//    "\n Name: " . $row["question"]. 
		// 		//    "\n Option1: " . $row["choice1"]. 
		// 		//    "\n Option2: " . $row["choice2"]. 
		// 		//    "\n Option3: " . $row["choice3"]. 
		// 		//  "\n <br>"  ;
		// 		  array_push($questionsArr,$row);
		// 		}
		// 		echo json_encode($questionsArr);
		// 	  } else {
		// 		echo "0 results";
		// 	  }
		// }

		

		public function getTopics(){
			$query = "SELECT * FROM quiz " ;
			$topicsArr = array();
			$result = mysqli_query($this->con, $query);
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					array_push($topicsArr,$row);
					}
				echo json_encode($topicsArr);	
			}else{
				echo "0 results";
			}




		}





	}
	?>