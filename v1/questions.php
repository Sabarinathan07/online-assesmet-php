<?php
require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(
        isset($_POST['quizid'])){

            $db = new DbOperations(); 

            $db->getQuestions($_POST['quizid']);
            

        }
}



?>