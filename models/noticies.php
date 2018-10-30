<?php
		$tbl_noticies="noticies";
		require("../inc/functions.php");
		if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			$mySqlNoticies="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%Y-%m-%d') AS `dataAng`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia`FROM $tbl_noticies";
			
			$connexio=connect();
			$resultNoticies=mysqli_query($connexio,$mySqlNoticies);
			disconnect($connexio);
			
			$rows = array(); 
			while($r = mysqli_fetch_array($resultNoticies)) 
			{
				$rows[] = $r; 
			}
			
			$dataNoticies=json_encode($rows);
			echo $dataNoticies;	
	}
?>