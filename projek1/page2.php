<?php
	session_start();
?>

<html>
<body>
	<?php	
		$servername = "localhost";
		$username = "root";
		$password = "N_1g2157391998";
		$leng = $_SESSION['amount'];
		$quantum = $_POST["quantum"];
		$l =0;
		$ttt;$twt;$trt;
		$key = true;
		$upload = 0;

		echo"<br>";
		for($i=0;$i<$leng;$i++){
			$p[$i] = array($_POST["num$i"],$_POST["arrivalTime$i"],$_POST["burstTime$i"]);
			$end += $_POST["burstTime$i"];
		}

		/*for($i=0;$i<$leng;$i++){
			for($j=0;$j<$leng;$j++){
					echo $p[$i][$j];
			}
		echo"<br>";
		}*/
	
#__________________________________________Dividing up data________________________________________
		for($i=0;$i<$leng;$i++){
				$sort[$i] = $p[$i][1];	
		}
		sort($sort);
		
		for($i=0;$i<$leng;$i++){
			for($j=0;$j<$leng;$j++){
				if($sort[$i] == $p[$j][1]){
					$order[] = $p[$j][0];
				}
			}
		}
		for($i=0;$i<$leng;$i++){
			for($j=0;$j<$leng;$j++){
				if($sort[$i] == $p[$j][1]){
					$rec[] = $p[$j][2];
					$burst[] = $p[$j][2];		
				}
			}
		}
#_________________________________________________________________________________________________
echo "<u>Round Robin</u><br>";
		for($time=0 ;$time<$end;$time++){
			
			if($time % $quantum ==0 and $time != 0){
				echo "-"."<u>$time</u>"."-";
			}else{
				echo "-".$time."-";
			}	
		}
		
		$arrlen = $leng -1;
		echo "<br>";
		for($time=0;$time<$end;$time++){
			$bEnd = $end -1;
			if($rec[$l] == 0)
			{
				$waiting[$l] =$time;
			}
			$check1 = $burst[$l]-1;
			if($rec[$l] == $check1){
				$start[$l] = $time-1;
			}
			
			if($time % $quantum ==0 and $time != 0 or $rec[$l] == 0){
				$key =true;
				if($l == $arrlen){	
					$l = 0;
					while($rec[$l] == 0){
						$l = $l+1;
					}
				}
				else{		
					$l = $l + 1;
					while($rec[$l] == 0){
						$l = $l+1;
					}
				}
				echo "-".$order[$l]."-";
				$rec[$l] = $rec[$l] -1;
			}
			else if($sort[$l] <= $time)
			{
				echo "-".$order[$l]."-";
				$rec[$l] = $rec[$l] -1;
			}
			
			else{
				echo "-"."L"."-";
			}
			
			if($time == $bEnd){
				$waiting[$l] = $end;
			}	
		}
		
		echo "<br>";
		echo "----------------------------------------------------------------------";
		for($i=0;$i<$leng;$i++)
		{
			$tt[$i] = $waiting[$i] - $sort[$i];
			$wt[$i] = $tt[$i] - $burst[$i];
			$rt[$i] = $start[$i] - $sort[$i];;

			$ttt += $tt[$i];
			$twt += $wt[$i];
			$trt += $rt[$i];
		}
		echo"<br>";
		$avtt = $ttt/$leng;
		echo "Avg Turn-Around-Time: ".$avtt."<br>";
		$avwt = $twt/$leng;
		echo "Avg Waiting time: ".$avwt."<br>";
		$avrt = $trt/$leng;
		echo"Avg reaction time: ".$avrt."<br>";
		echo "----------------------------------------------------------------------";
		echo "<br><br>";
	
		#writing data to database		
		$conn = new mysqli($servername,$username,$password);

		if($conn->connect_error){
			die("Connection failure".$conn->connect_error);
		}else{
			echo "Successfully connected with database<br>";
		}
		for($i=0;$i<$leng;$i++){
			$a = $order[$i];
			$b = $sort[$i];
			$c = $burst[$i];
			$d = $tt[$i];
			$e = $wt[$i];
			$f = $rt[$i];
			$sql = "INSERT INTO test.Processes (ID,Arrival_Time,Burst_Time,TurnAround_Time,Wait_Time,Reaction_Time) VALUES ('$a','$b','$c','$d','$e','$f')";

			if($conn->query($sql) == TRUE){
				$upload = $upload + 1 ;
			}else{
				echo "<br>Error:<br>".$conn->error;
			}
		}
		$conn->close();
		echo "<br>Succesfully Uploaded ".$upload. " instances of Data";
	?>
</body>
</html>
