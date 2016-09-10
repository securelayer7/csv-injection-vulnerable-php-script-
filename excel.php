<?php
session_start();
if(isset($_SESSION['usr_id']) == "") {
	header("Location: login.php");
}
include_once 'dbconnect.php';

$login_id = $_SESSION['usr_id'];
if(count($_POST) > 0 && isset($_POST["export_excel"]))
{
	
	$output = "";
	$sql = "SELECT id, expensetype, amount FROM expense WHERE users_id = ".$login_id." ORDER BY id ASC";
	$result = mysqli_query($con, $sql);

		if ($result && $myrow = mysqli_fetch_array($result)) 
		{
	
			$output .= '  <table class="table" bordered="1">
							<thead>
								<tr>
									<th>Sr No.</th>
									<th>Expense Type</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>';	
			$sr = 1;
			do
			{
				$output .= '
					<tr>
						<td>'.$sr.'</td>
						<td>'.$myrow['expensetype'].'</td>
						<td>'.$myrow['amount'].'</td>						
					</tr>';
	
		    $sr++;
			}
			while($myrow = mysqli_fetch_array($result));
	
			 $output .= '	</tbody>
						</table>';
		
			header("Content-Type: application/xls");   
           	header("Content-Disposition: attachment; filename=download.xls");  
           	echo $output;  
		} 		
}
?>