<?php
$response = array();

if (isset($_GET['user'])){
	require_once __DIR__ . '\db_connect.php';
	$userid = $_GET['user'];

	$db = new DB_CONNECT();
	$key = "abcde";
	$key = "abcde";
	$ciphering = "AES-128-CTR"; 
  
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0; 
  
	$encryption_iv = '1234567891011121'; 
	$result = mysqli_query($db->connect(), "SELECT note FROM notes where userid = '$userid'") or die($db->mysqli_error());
	 
	if (mysqli_num_rows($result) > 0) {
		$response["notes"] = array();
	 
		while ($row = mysqli_fetch_array($result)) {
			$note = array();
			$note["note"] = openssl_decrypt(
				$row["note"],
				$ciphering,
				$key,
				$options,
				$encryption_iv
			);
			array_push($response["notes"], $note);
		}
	
		echo json_encode($response);
	} else {
		$response["status"] = "No notes found";
	 
		echo json_encode($response);
	}
} else{
    $response["status"] = "Required field(s) is missing";
 
    echo json_encode($response);
}
?>