<?php 
	
	$tbl_vila="vila";
	$tbl_noticies="noticies";

	require("../inc/functions.php");

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$mySqlNoticies="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia` FROM $tbl_noticies ORDER BY `principal`, `dataNoticia` LIMIT 2";
		// echo $mySqlNoticies;
		$connexio=connect();
		
		$resultDadesNoticies=mysqli_query($connexio,$mySqlNoticies);
		disconnect($connexio);

		$rows = array();

		while ($r = mySqli_fetch_array($resultDadesNoticies)) {
			$rows[] = $r;
			
		}
		for ($i=0; $i<sizeof($rows); $i++) { 
			$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
		}
		echo json_encode($rows);
		// $i=0; 


		// $dataHome.='","noticiesDestacades":[';

		// $i=0; 
		// while ($row=mysqli_fetch_array($resultDadesNoticies)) {
		// 	if ($i!=0) {
		// 		$dataHome.=",";	
		// 	}
		// 	$i++;
		// 	$dataHome.='{"idNoticia":"'.$row['idNoticia'].'","dataNoticia":"'.$row['dataNoticia'].'","principal":"'.$row['principal'].'","titular":"'.replaceFromBBDD($row['titolNoticia']).'","descripcio":"'.replaceFromBBDD($row['txtNoticia']).'","fotoNoticia":"'.$row['fotoNoticia'].'"}';
		// }

		// $dataHome.=']}';
		// echo $dataHome;
	}
?>