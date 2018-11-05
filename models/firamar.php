<?php 

	$tbl_galeriafiramar="galeriafiramar";
	
	require("../inc/functions.php");
	
	session_start();
	
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo formGaleria($tbl_galeriafiramar);
	}
	
	function formGaleria($tbl_galeriafiramar){
		$mySql="SELECT `idGaleriaFiramar`, `fotoFiramar`, `dataFiramar` FROM $tbl_galeriafiramar ORDER BY `dataFiramar` DESC";
		$connexio=connect();
		$resultGaleria=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		$i=0;
		$dataFiramar='{"dadesGaleries":[';
		while($row=mySqli_fetch_array($resultGaleria)){
			if($i!=0){
		 		$dataFiramar.=",";
		 	}	
		 	$i++;
			$dataFiramar.='{"idGaleriaFiramar":"'.$row['idGaleriaFiramar'].'","fotoFiramar":"'.$row['fotoFiramar'].'","dataFiramar":"'.$row['dataFiramar'].'"}';

		}
		$dataFiramar.="]}";
		return $dataFiramar;
	}
?>