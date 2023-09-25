<?php  
$conn = mysqli_connect("localhost", "root","", "db2");  

session_start();
$n=$_SESSION['uname'];


$sql5="select license_plate from user_details where username='$n'";
$result5= mysqli_query ($conn,$sql5);
$result_set5 = mysqli_fetch_row($result5);
/*print_r($result_set5);*/
$entry_arr = array();
$j = 0;
$ins_query = "select entry_time from lpdb_entry where license_plate='$result_set5[0]'";
$res = mysqli_query($conn,$ins_query);	
while($entry_r = mysqli_fetch_assoc($res)){
	$entry_arr[$j] = $entry_r['entry_time'];
	$j++;
}
//print_r($entry_arr);exit;

$exit_arr = array();
$i = 0;
$ins_query4 = "select exit_time from lpdb_exit where license_plate='$result_set5[0]'";
$res4 = mysqli_query($conn,$ins_query4);
while($exit_r = mysqli_fetch_assoc($res4)){
	$exit_arr[$i] = $exit_r['exit_time'];
	$i++;
}
//print_r($exit_arr);exit;




$s1 = "SELECT * FROM lpdb_entry";
$result1 = mysqli_query($conn,$s1);
$count1 = mysqli_num_rows($result1);

$s2 = "SELECT * FROM lpdb_exit";
$result2 = mysqli_query($conn,$s2);
$count2 = mysqli_num_rows($result2);

$total_count = 50;
$x = $count1 - $count2;
$avail = $total_count - $x;

 ?> 
 <!DOCTYPE html>  
 <html>  
      <head>  
         <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1">   
      
	  <style>
	  @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap');
@import url("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
  @import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap');

body {
  margin: 0;
  font-family: Montserrat, sans-serif;
}
 td,th {
	 border-bottom:0.5px solid #fff;
 }
.topnav {
  overflow: hidden;
  background-color: #f4b41e;
  margin-top: 0px;
  
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 20px;
  padding-left:45px;
  letter-spacing: 5px;
	font-size:18px;
    line-height: 2.42857143;
    
    font-family: Montserrat, sans-serif;
  
}

.avail {
	border:2px solid white;
    width:490px;
    padding:30px;
    margin: 20px;
	text-align: center;
	font-size:34px;
}
.topnav a.active {
  
  color: white;
}

.center{
	margin-left:auto;
	margin-right:auto;
	align:center;
}
footer {
  text-align: center;
  padding: 6px;
  background-color: #f4b41e;
  color: white;
  font-size: 14px;
  margin-bottom:0px;
  bottom:0px;
}
input[type=text] {
  position: relative;
  width: 90%;
  padding: 10px;
  background: black;
  color: #f4b41e;
  border: none;
  outline: none;
  box-shadow: none;
  margin: 8px 0;
  font-size: 14px;
  letter-spacing: 1px;
  font-weight: 300;
  border-bottom: 1.5px solid #ffffff;
}

input[type='submit'] {
  
  background: #f4b41e;
  color: black;
  cursor: pointer;
  padding: 10px;
  font-size: 16px;
  font-weight: 300;
  letter-spacing: 1px;
  border:none;
  font-family: Montserrat, sans-serif;
}

</style>
	  </head>  
	  
      <body data-offset="0" style= "background-color:black;" data-target=".navbar">  
	       <div class="topnav">
               <a class="active" href="homepage.php" style="font-family: Montserrat, sans-serif;">parkeasy</a>
 
            </div>
	  
           <br>  
           <div class="container" style="width:500px; font-size:150%; color:#f4b41e; font-family:Montserrat, sans-serif;">  
				 <div class="avail" style="color:#f4b41e;"> Available Parking Space: <b style="color:#fff;"><?php echo $avail; ?> </b></div><br>
				 Welcome <?php echo $n; ?>! <br>
				 Your license plate number is  <b style="color:#fff;"><?php echo $result_set5[0];?> </b>           
                <br>
				<br>
				HISTORY: <br><br>
				<div class="table-responsive">  
                     <table class="table">  
                          <tr style="color:#fff;font-size:90%; font-family:Montserrat, sans-serif; ">  
							
                               <th>Entry time</th>  
							   <th>Exit time</th>
							   <th>Time Spent</th>
							   
                          </tr>  
                          <?php 
							$i = 0;
							$sbt = 0;
							foreach($entry_arr as $k=>$v){
								$datetime1 = strtotime($v);//start time
								$datetime2 = strtotime($exit_arr[$i]);//end time
								$timespent= ($datetime2-$datetime1)/60;
								$price = $timespent*2;
								$sbt = $sbt + $price;
						  ?>
                          <tr style="color:#f4b41e; font-family:Montserrat, sans-serif; font-size:95%;">  
                              
                               <td><?php echo $v; ?></td> 
							   <td><?php echo $exit_arr[$i]; ?></td>
							  <td style="align:centre;"><?php echo (floor($timespent)); ?> minutes</td>
							   
							   
                          </tr>   
							<?php $i++; } ?>
                            
                     </table>  
                </div>  
           </div>  
		   
		   <?php  
        
		$ins_query3 = "update customer_details set balance= total_amount - '$sbt' where customer_nump='$result_set5[0]'";
		$res3 = mysqli_query($conn,$ins_query3);	
		
		$ins_query8 = "select balance from customer_details where customer_nump='$result_set5[0]'";
		$res8 = mysqli_query($conn,$ins_query8);
		$result_set8 = mysqli_fetch_row($res8);
           ?> 
		<br>
		<br>
		<div class="container" style="width:500px; font-size:150%; color:#f4b41e; font-family:Montserrat, sans-serif;"> 
		
		
		TRANSACTION DETAILS: <br> <br>
		<div class="table-responsive">
		
		<table class="table">  
                          <tr style="color:#fff;font-size:90%; font-family:Montserrat, sans-serif;">  
							
                               <th>Date of payment</th>  
							   <th>Price</th>
							   
                          </tr>  
                          <?php 
							$i = 0;
							$sbt = 0;
							foreach($entry_arr as $k=>$v){
								$datetime1 = strtotime($v);//start time
								$datetime2 = strtotime($exit_arr[$i]);//end time
								$timespent= ($datetime2-$datetime1)/60;
								$price = $timespent*2;
								$sbt = $sbt + $price;
						  ?>
                          <tr style="color:#f4b41e; font-family:Montserrat, sans-serif; font-size:95%;">  
                              
                               <td><?php echo $v; ?></td> 
							   <td><?php echo floor($price); ?></td> 
                          </tr>   
							<?php $i++; } ?>
                            
                     </table>  
                   					 
		</div> <br>
		<br>
		<p style="font-size:100%;"> ADD MONEY TO YOUR PARKEASY WALLET :  </p>
		<h4 style="color:#fff;">Your available balance is :<?php echo  $result_set8[0]; ?> </h4>
		<form action="update_balance.php" method="POST"> <br>
<input type="text" placeholder="Enter your balance" name="updated_value" >
<input type="hidden" name="customer_nump" value=<?=$result_set5[0]?> > 
<br>
<input type="submit" name="submit" value="Update Balance"> 
</form>

		</div>
		<br> <br>
		<br>
		
        		   
		<footer>
      <p style="font-size:25px; text-align:center">CONTACT US </p>
      <p><span class="glyphicon glyphicon-map-marker" ></span> Mumbai, India</p>
      <p><span class="glyphicon glyphicon-phone"></span> +911234568</p>
      <p><span class="glyphicon glyphicon-envelope"></span> Parkeasy3@gmail.com</p>
   
</footer>
      </body>  
 </html>  
 


 