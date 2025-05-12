<?php 
header("Content-Type: application/json"); 
echo json_encode([ "method" => $_SERVER['REQUEST_METHOD'], "post_data" => $_GET, "raw_input" => file_get_contents("php://input") ]);
?>
