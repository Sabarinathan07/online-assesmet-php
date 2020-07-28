<?php
require_once '../includes/DbOperations.php';

$response = array(); 

$db = new DbOperations(); 

$db->getTopics();

?>