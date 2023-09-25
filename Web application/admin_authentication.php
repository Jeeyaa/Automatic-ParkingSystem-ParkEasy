<?php  
/*error_reporting(E_ERROR);*/
 $connect = mysqli_connect("localhost", "root"," ", "db2"); 
 $username=$_POST['user'];
 $password=$_POST['pass'];
 


$sql="select * from user_details where username='$username' and password='$password'" ;
$result= mysqli_query ($connect,$sql);
$row= mysqli_fetch_array($result);

 if ($row['username']==$username && $row['password']==$password)
{
	 session_start();
	 $_SESSION['uname']=$username;
	 $_SESSION['passw']=$password;
	 header("Location: status_page.php");
	 exit();
}
 
 else 
{
	 echo '<script>alert("Invalid Credentials")</script>';
	 echo '<script>window.location.replace("website_trial2.php");</script>';
}
 
$sql1="select * from admin_details where username='$username' and pass='$password'" ;
$result1 = mysqli_query ($connect,$sql1);
$row1 = mysqli_fetch_array($result1);

  if ($row1['username']==$username && $row1['pass']==$password)
{
	 session_start();
	 $_SESSION['aname']=$username;
	 $_SESSION['apass']=$password;
	 header("Location: Admin page.php");
	 exit();
}

  else 
{
	 echo '<script>alert("Invalid Credentials")</script>';
	 echo '<script>window.location.replace("homepage.php");</script>';
}

 ?> 
 
