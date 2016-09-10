<?php
session_start();
if(isset($_SESSION['usr_id']) == "") {
	header("Location: login.php");
}
include_once 'dbconnect.php';

$login_id = $_SESSION['usr_id'];
$erroroccured = 0;
$success = 0;
$error = "";
$successmsg = "";

if(count($_POST) > 0)
{
	$expensetype = mysqli_real_escape_string($con, $_POST['expensetype']);
	$amount = mysqli_real_escape_string($con, $_POST['amount']);

	if($expensetype == "" || $amount == "")
	{
		$erroroccured = 1;
		$error = "Please Enter Required Fields.";
	}

	if($erroroccured == 0)
	{


		$result = mysqli_query($con, "INSERT INTO expense(users_id,expensetype,amount) VALUES('" . $login_id . "', '" . $expensetype . "', '" . $amount . "')");
		if($result) 
		{
			$success = 1;
			$successmsg = "Expense Successfully Added";
		} 
		else 
		{
			$erroroccured = 1;
			$error = "Error adding expense...Please try again later!";
		}
	}

}


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
        <li class="active"><a href="index.php">Add Records</a></li>                
        <li><a href="view_record.php"> View Records</a></li>
      </ul>
    </div>

    
	<div class="col-md-4">
		<form action="" method="POST" role="form">
			<legend>Add Expenses</legend>	
		
			<div class="form-group">
				<label for="expensetype">Expense Type</label>
				<input type="text" class="form-control" id="expensetype" name="expensetype" placeholder="XYZ" REQUIRED>
			</div>
			<div class="form-group">
				<label for="amount">Amount</label>
				<input type="text" class="form-control" id="amount" name="amount" placeholder="100..." pattern="[0-9]{3}" title="Please Enter Only Numbers (1-1000)" REQUIRED>
			</div>
					
			<button type="submit" class="btn btn-primary">Submit</button>
			<button type="reset" class="btn btn-warning">Reset</button>			
		</form>		<br/>

	<?php
		if($erroroccured == 1)
		{
	?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong><?php echo $error;?></strong>
		</div>

	<?php
		}
		if($success == 1)
		{
	?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong><?php echo $successmsg;?></strong>
		</div>
	<?php
		}
	?>
		

	</div>
    


<!-- side bar ends -->

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

