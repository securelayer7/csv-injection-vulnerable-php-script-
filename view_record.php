<?php
session_start();
if(isset($_SESSION['usr_id']) == "") {
	header("Location: login.php");
}
include_once 'dbconnect.php';

$login_id = $_SESSION['usr_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Home</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?></p></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<!-- side bar -->

    <div class="col-lg-2">
      <ul class="navbar-default nav" style="height:650px">
        <li><a href="index.php">Add Records</a></li>                
        <li class="active"><a href="view_record.php"> View Records</a></li>
      </ul>
    </div>

    
	<div class="col-md-4">
	<?php
		$sql = "SELECT id, expensetype, amount FROM expense WHERE users_id = ".$login_id." ORDER BY id ASC";
		$result = mysqli_query($con, $sql);
		
		if ($result && $myrow = mysqli_fetch_array($result)) 
		{
	?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>Expense Type</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
					
				
	<?php
			$sr = 1;
			do
			{
	?>
					<tr>
						<td><?php echo $sr;?></td>
						<td><?php echo $myrow['expensetype'];?></td>
						<td><?php echo $myrow['amount'];?></td>						
					</tr>
	<?php
		    $sr++;
			}
			while($myrow = mysqli_fetch_array($result));
	?>
				</tbody>
			</table>
	<?php
		} 
		else 
		{
	?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>No Records Found.</strong>
			</div>
	<?php
		}
	?>

		<form method="post" action="excel.php" >  
              <input type="submit" name="export_excel" class="btn btn-success" value="Export to Excel" />  
         </form>  


	</div>
    


<!-- side bar ends -->

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

