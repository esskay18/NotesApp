<?php
$response = array();

if (isset($_GET['user']) && isset($_POST['note'])) {
	$key = "abcde";
	$ciphering = "AES-128-CTR"; 
  
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0; 
  
	$encryption_iv = '1234567891011121'; 
	$note = openssl_encrypt(
		$_POST['note'],
		$ciphering,
		$key,
		$options,
		$encryption_iv
	);
	$userid = $_GET['user'];
	
    require_once __DIR__ . '\db_connect.php';
 
    $db = new DB_CONNECT();
	
	$result = mysqli_query($db->connect(), "INSERT INTO notes(userid, note) VALUES('$userid', '$note')");
 
    if ($result) {
        $response["status"] = "success";
 
        echo json_encode($response);
    } else {
        $response["status"] = "failure";
 
        echo json_encode($response);
    }
} else {
    $response["status"] = "failure";
 
    echo json_encode($response);
}
?>