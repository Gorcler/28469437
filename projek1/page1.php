<?php 
	session_start();
?>

<html>
<body>
<form action="page2.php" method="post">
<?php
	$_SESSION['amount'] = $_POST["proAmnt"];
	echo "<h1>Enter Process Information</h1><br>";
	for($i = 0;$i < $_SESSION['amount'];$i++){
		echo"Process ".($i+1).":<br>";
		echo "Enter ID(number):";
		echo "<input type='text' name='num$i'><br>";
		echo "Enter Arrival Time:";
		echo "<input type='text' name='arrivalTime$i'><br>";
		echo "Enter Burst Time:";
		echo "<input type='text' name='burstTime$i'><br>";
		echo "<br><br>";
	}
?>
	Enter Time quantum:<br>
	<input type="text" name="quantum"><br>	
	<input type="submit" name="submit">
</form>
</body>
</html>

