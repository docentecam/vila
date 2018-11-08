<?php 
	$tbl_contactans="contactans";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo llistatContact($tbl_contactans);
	}
	function llistatContact($tbl_contactans){
		$mySql="SELECT `email`,`idContacte`,`nomContacte`, `cognomContacte`, `tipus`, `telf`, `nomEmpresa`, `txtContacte`, DATE_FORMAT(`dataContacte`,'%d/%m/%Y' ) AS 'dataContacte' FROM $tbl_contactans";
		// echo $mySql;
		$connexio=connect();
		$resultContact=mySqli_query($connexio,$mySql);
		disconnect($connexio);
		
		
		$rows = array();

		while ($r = mySqli_fetch_array($resultContact)) {
			$rows[] = $r;
			
		}
		for ($i=0; $i<sizeof($rows); $i++) { 
			$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			$rows[$i][3]=replaceFromBBDD($rows[$i][3]);
			$rows[$i][6]=replaceFromBBDD($rows[$i][6]);
			$rows[$i][7]=replaceFromBBDD($rows[$i][7]);
		}
		 return json_encode($rows);
	}

?>