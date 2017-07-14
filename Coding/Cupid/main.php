<?php
 session_start();
// include("connect.php");
 
$host = "188.166.179.209";
$username = "team1";
$password = "QIw0VaXCAlBGdex5";
$dbname = "team1";
$mysqli = new MySQLI($host,$username,$password,$dbname);
$result = $mysqli->query(" select  * from userDetail  WHERE  id='$id' ") or die(mysqli_error());;   

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>บริษัท CUPID</title>
		
		<!-- Bootstrap Core CSS -->
        <link rel="shortcut icon" href="images/logo.png">
		<link href="css/bootstrap.css" rel="stylesheet">
        <!--<link href="css/bootstrap-toggle.min.css" rel="stylesheet">-->
        
		<!-- Custom CSS -->
		<link href="css/sb-admin-2.css" rel="stylesheet">
		<!-- Custom Fonts -->
        
		<!--<link href="js/bootstrap-toggle.min.js" rel="stylesheet">-->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		
		<!-- Custom Theme JavaScript -->
		
		<script src="js/jquery.form.js"></script>

		<script type="text/javascript">
		
		</script>
	</head>
	<body>
		<div id="wrapper" >
		  <nav class="label-default" role="navigation" >
				<div class="navbar-header"  >
				  
					<a class="navbar-b" href="<?php echo $_SERVER["REQUEST_URI"]; ?>"><img src="images/logo.png" width="75" height="90" /></a>
				  <h1>Welcome </h1>
					<user>[ <?php echo $result[firstName];?> - <?php echo $result[lastName];?> ]</user>
				</div>
				
			</nav>
			<!-- /navigation -->
			<div id="page-wrapper">
			  <table width="600" border="1" align="center" >
			    <tbody>
			      <tr>
			        <td width="125"><h3>ชื่อ</h3></td>
			        <td width="459"> <? echo $result[firstName]; ?></td>
		          </tr>
			      <tr>
			        <td><h3>นามสกุล</h3></td>
			        <td> <? echo $result[lastName]; ?></td>
		          </tr>
			      <tr>
			        <td><h3>ตำแหน่ง</h3></td>
			        <td> <? echo $result[position]; ?></td>
		          </tr>
			      <tr>
			        <td><h3>เบอร์โทร</h3></td>
			        <td> <? echo $result[tel]; ?></td>
		          </tr>
			      <tr>
			        <td><h3>e-mail</h3></td>
			        <td> <? echo $result[email]; ?></td>
		          </tr>
		        </tbody>
		      </table>
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->
        <footer>
		<p><img src="images/logo.png" width="20" height="20" /> &nbsp;Copyrights &copy; 2017   ส่วนวิเคราะห์และพัฒนาระบบสารสนเทศ 1 ศูนย์เทคโนโลยีสารสนเทศ สำนักงาน ป.ป.ส. กระทรวงยุติธรรม</p>
		</footer>
</body>
</html>