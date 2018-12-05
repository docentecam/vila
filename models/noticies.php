<?php
		$tbl_noticies="noticies";
		require("../inc/functions.php");
		if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			$mySqlNoticies="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%Y-%m-%d') AS `dataAng`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia` FROM $tbl_noticies";
			if(isset($_POST['idNoticia']))
			{
				$mySqlNoticies.=" WHERE `idNoticia`='".$_POST['idNoticia']."'";
			}
			
			$connexio=connect();
			$resultNoticies=mysqli_query($connexio,$mySqlNoticies);
			disconnect($connexio);
			//echo json_encode(mysqli_fetch_row($resultNoticies));
			 $rows = array(); 
			while($r = mysqli_fetch_array($resultNoticies)) 
			{
				$rows[] = $r; 
			} 
			echo json_encode($rows);
	}
?>