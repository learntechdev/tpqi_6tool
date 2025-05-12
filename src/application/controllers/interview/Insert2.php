<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Prepare the data from GET parameters 
	$data = $_GET; // Convert the GET request to a POST request 
	$ch = curl_init("https://asm_uat.mylearntime.com/interview/InterviewTool/insert"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); 
	$response = curl_exec($ch); 
	curl_close($ch); 
	echo "Response from POST request: " . $response; 
} else { 
	echo "This is already a POST request."; 
} 
?>
