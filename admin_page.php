<?php
session_start();
include 'connection.php';
if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
     $email = validate($_POST['email']);
	 $pass = validate($_POST['password']);
     $sql = "SELECT * FROM admin WHERE email='$email' AND password='$pass'";
     $result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email  && $row['password'] === $pass) {
            	$_SESSION['email'] = $row['email'];
            	header("Location:products.php");
		        exit();
            }
            }else{
				header("Location:index.php?error=Incorect email or password");
		        exit();
			}          
}
?>