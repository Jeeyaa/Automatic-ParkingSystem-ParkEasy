<?php
 $connect = mysqli_connect("localhost", "root", "", "db1"); 
	//print_r($_POST);exit;
	$updated_value = $_POST['updated_value'];
	$customer_nump = $_POST['customer_nump'];
	$sqlq="update customer_details set balance= balance + '$updated_value',total_amount = total_amount + '$updated_value' where customer_nump='$customer_nump'" ;
	$resultq= mysqli_query ($connect,$sqlq);
	header('Location: status_page.php');
	?>
