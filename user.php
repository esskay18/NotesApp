<?php
$response = array();
 
if (isset($_POST['username']) && isset($_POST['password'])) {
 
	$username = $_POST['username'];
	$key = "passkey";
	$ciphering = "AES-128-CTR"; 
  
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0; 
  
	$encryption_iv = '1098765432101234'; 
	$password = openssl_encrypt(
		$_POST['password'],
		$ciphering,
		$key,
		$options,
		$encryption_iv
	);
	
    require_once __DIR__ . '\db_connect.php';
 
    $db = new DB_CONNECT();
	$result = mysqli_query($db->connect(), "SELECT username FROM users WHERE username = '$username'");
	$number_rows = mysqli_num_rows($result);	
	if($number_rows == 0){
		$checkvalid = False;
		while(!$checkvalid){
			$userid = rand(1000, 9999);
			$result = mysqli_query($db->connect(), "SELECT userid FROM users WHERE username = '$userid'");
			if(mysqli_num_rows($result) == 0){
				$checkvalid = True;
			}
		}
		
		$result = mysqli_query($db->connect(), "INSERT INTO users(username, password, userid) values ('$username', '$password', '$userid')");
		if($result){
			$response["status"] = "account created";
				
			echo json_encode($response);
		}
		else{
			$response["status"] = "account not created";
				
			echo json_encode($response);
		}
	}
} else {
    $response["status"] = "Required field(s) is missing";
 
    echo json_encode($response);
}
?>