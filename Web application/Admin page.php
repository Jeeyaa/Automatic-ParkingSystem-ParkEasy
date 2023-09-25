<?php  
error_reporting(E_ERROR);
 $connect = mysqli_connect("localhost", "root", "", "db2");  
 
session_start();
$a=$_SESSION['aname'];

 $sql = "SELECT DISTINCT LEN.license_plate
,	LEN.entry_time
,	LEX.exit_time
,	TIMESTAMPDIFF(MINUTE,LEN.entry_time, LEX.exit_time) as vehicletime 
FROM lpdb_entry LEN
INNER JOIN lpdb_exit LEX ON LEN.license_plate = LEX.license_plate WHERE TIMESTAMPDIFF(MINUTE,LEN.entry_time, LEX.exit_time)>0 && TIMESTAMPDIFF(MINUTE,LEN.entry_time, LEX.exit_time)<200";  
$result = mysqli_query($connect, $sql); 

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		   
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

.topnav a.active {
  
  color: white;
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
.container .abc {
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
  border-bottom: 2px solid #ffffff;
}
	
</style>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
      </head>   
	  <body data-offset="0" style= "background-color:black;" data-target=".navbar">  
	       <div class="topnav">
               <a class="active" href="homepage.php" style="font-family: Montserrat, sans-serif;">parkeasy</a>
 
            </div>
           <br />  
		   <br>
           <div class="container" style="width:500px;">  
                        <p style="color:#fff; font-size:210%;"><center style="color:#fff; font-size:210%;"><b> VEHICLE RECORD </b></center></p>     
                <br> 
				<p style="color:#f4b41e;font-size:15px;">Type something in the input field to search the table for license plate or time:</p>  
  <input class="abc" id="myInput" type="text" placeholder="Search..">
  <br> <br>
  <br>
				<div class="table-responsive">  
                     <table class="table">  
                          <tr style="color:#fff;font-size:120%; font-family:Montserrat, sans-serif; ">
                               <th>License Plate</th>  
                               <th>Entry time</th>  
							   <th>Exit time</th>
							   <th>Time</th>
                          </tr>  
                          <?php  
                          if(mysqli_num_rows($result) > 0)  
                          {  
                               while($row = mysqli_fetch_array($result))  
                               {  
                          ?>  
						 
						      
							<tbody id="myTable">	  
                          <tr style="color:#f4b41e; font-family:Montserrat, sans-serif; font-size:110%;">  
                               <td><?php echo $row["license_plate"];?></td>  
                               <td><?php echo $row["entry_time"]; ?></td> 
							   <td><?php echo $row["exit_time"]; ?></td> 
							   <td><?php echo $row["vehicletime"]; ?></td> 
							   
                          </tr>  
							  
						   
                          <?php  
								$custs[$row["license_plate"]] = $custs[$row["license_plate"]] + $row["vehicletime"] * 2;// here is 2 is price
                               }  
                          }  
                          ?>  
						  </tbody>
                     </table>  
                </div>  
           </div>  
           <br /> 
		   <br>
		   <br>
<footer>
      <p style="font-size:25px; text-align:center">CONTACT US </p>
      <p><span class="glyphicon glyphicon-map-marker" ></span> Mumbai, India</p>
      <p><span class="glyphicon glyphicon-phone"></span> +911234568</p>
      <p><span class="glyphicon glyphicon-envelope"></span> Parkeasy3@gmail.com</p>
   
</footer>		   
      </body>  
 </html>  

 

	
	
