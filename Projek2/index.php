<?php
session_start();
?>

<html>
<head></head>
<body>
<h1><u>Projek 2</u></h1>
	<form action = "index.php" method = "post">
		Enter Word:<br>
		<input type ="text" name="inpWord">
		<input type ="submit" name = "submit">
	</form> 
<?php
$word =$_POST["inpWord"];
$_SESSION['ses_array'] = [" "];

if(empty($word)){
	echo "Please enter a word";
}
else
{
	echo "Succesfully written: $word<br><br>";
	echo "<u><h3>Data from data3.txt file</h3></u>";
	$file1con = file_get_contents("/var/www/html/data1.txt");
	$file1arr = explode(" ",$file1con);
	$file1size = sizeof($file1arr);	

	$file2con = file_get_contents("/var/www/html/data2.txt");
	$file2arr = explode(" ",$file2con);
	$file2size = sizeof($file2arr);

	if($file1size>$file2size){
		$size = $file1size;
		$small = $file2size;	
	}else{
		$size = $file2size;
		$small = $file1size;
	}


	for($i = 0;$i <= $size;$i++)
	{
		array_push($_SESSION['ses_array'],"$file1arr[$i] ");
		array_push($_SESSION['ses_array'],"$file2arr[$i] ");
		$wordend = $size -2;
		if($i <= $wordend){
			array_push($_SESSION['ses_array'],"$word ");
		}
	}
	
	$session_data = session_encode();
	try{
		$_SESSION['file3'] = fopen("data3.txt","w");
		fwrite($_SESSION['file3'],"$session_data ");
	}catch(Exception $e){
		echo "Message:".$e->getMessage();
	}
	fclose($file3);	

	try{
		$filehandle = fopen ('/var/www/html/data3.txt', 'r'); 
	      	$sessiondata = fread ($filehandle, 4096);
	}catch(Exception $e){
		echo "Message:".$e->getMessage();
	}	
      	fclose ($filehandle);

      	session_decode($sessiondata); 
	
	$sizearr = count($_SESSION['ses_array']);
	for($i=0;$i<=$sizearr;$i++){
		echo $_SESSION['ses_array'][$i];
	}
}

?>


</body>
</html>
