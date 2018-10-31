<?php 
	$tbl_solicitutsoc="solicitutssocis";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo llistatSocis($tbl_solicitutsoc);
	}
	function llistatSocis($tbl_solicitutsoc){
		$mySql="SELECT `email`,`idSolicitut`,`nomComercial`, `sectorComercial`, `adreca`, `telf`, `personaContacte`, `horari`, DATE_FORMAT(`dataSolicitut`,'%d/%m/%Y' ) AS 'dataSolicitut' FROM $tbl_solicitutsoc";
		// echo $mySql;
		$connexio=connect();
		$resultSolicit=mySqli_query($connexio,$mySql);
		disconnect($connexio);
		
		
		$rows = array();

		while ($r = mySqli_fetch_array($resultSolicit)) {
			$rows[] = $r;
			
		}
		for ($i=0; $i<sizeof($rows); $i++) { 
			$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			$rows[$i][3]=replaceFromBBDD($rows[$i][3]);
			$rows[$i][4]=replaceFromBBDD($rows[$i][4]);
			$rows[$i][6]=replaceFromBBDD($rows[$i][6]);
			$rows[$i][7]=replaceFromBBDD($rows[$i][7]);
		}
		 return json_encode($rows);
	}

?>