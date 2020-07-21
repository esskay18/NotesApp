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
	
    $result = mysqli_query($db->connect(), "SELECT username, password, userid FROM users WHERE username = '$username' AND password = '$password'");
	$number_rows = mysqli_num_rows($result);
	if (!$result) {
        $response["status"] = "Some error occurred";
 
        echo json_encode($response);

    die('Invalid query: ' . mysqli_error($db->connect()));
	
	}
	if($number_rows == 0){
        $response["status"] = "Username or password is wrong";
 
        echo json_encode($response);
	}
	else{
		$row = mysqli_fetch_row($result);
        $response["status"] = "success";
		$response["userid"] = $row[2];
 
        echo json_encode($response);
    }
} else {
    $response["status"] = "Required field(s) is missing";
 
    echo json_encode($response);
}
?>