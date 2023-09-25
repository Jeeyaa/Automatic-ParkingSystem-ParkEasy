<?php
error_reporting(E_ERROR);
$errors = array();
 $connect = mysqli_connect("localhost", "root", "", "db1"); 
 $firstname=$_POST['fname'];
 $lastname=$_POST['lname'];
 $license=$_POST['lp'];
$usern=$_POST['user'];
$emailid=$_POST['email'];
$passwd=$_POST['pass'];

  	// first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM user_details WHERE username='$usern' OR email='$emailid' LIMIT 1";
  $result = mysqli_query($connect, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $usern) {
      array_push($errors, "Username already exists");
	  echo "Username already exists";
    }

    if ($user['email'] === $emailid) {
      array_push($errors, "email already exists");
	  echo "Email already exists";
	}
  }
if (count($errors) == 0) {
  	
$sqlq="insert into user_details(username,first_name,last_name,password,email,license_plate) values ('$usern','$firstname','$lastname','$passwd','$emailid','$license')" ;
$resultq= mysqli_query ($connect,$sqlq);
$sqlq2="insert into customer_details(customer_un,customer_nump,total_amount,balance) values ('$usern','$license','0','0')" ;
$resultq2= mysqli_query ($connect,$sqlq2);
echo "REGISTERED SUCCESSFULLY";
}
?>


