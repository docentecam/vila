<?php

require("../inc/functions.php");

$tbl_vila="vila";
$tbl_serveis="serveis";
$tbl_subserveis="subserveis";

if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$dades= '{"dadesVila": ';
		$dades.= mostrarQuisom($tbl_vila);
		$dades.= ',"dadesServeis":';	
		$dades.= mostrarServeis($tbl_serveis);

		$dades.="}";

		echo $dades;
	}

function mostrarQuisom($tbl_vila){
		$mySql="SELECT `quiSom`,`equip`	FROM $tbl_vila";
		$connexio=connect();
		$resultQuisom=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 

		while($r = mysqli_fetch_array($resultQuisom)) 
		{
			$rows[] = $r; 
		} 
				
		return json_encode($rows);
	}
function mostrarServeis($tbl_serveis,$tbl_subserveis){
		$mySql="SELECT `idServei`,`nomServei`,`txtServei`	FROM $tbl_serveis";
		$connexio=connect();
		$resultServeis=mysqli_query($connexio,$mySql); 
		
		$rows = array(); 
		
		while($r = mysqli_fetch_array($resultServeis)) 
		{
			$mySql="SELECT `idSubservei`, `nomSubservei`, `txtSubservei`, `idServei` 
					FROM `$tbl_subserveis`
					WHERE idServei=".$r[0];
					$rowsSub = array(); 
		
					while($rSub = mysqli_fetch_array($resultServeis)) 
					{
						$rowsSub[] = $rSub; 
					}
					array_push($r, $rowsSub);
			$rows[] = $r; 	
		} 
		disconnect($connexio);		
		return json_encode($rows);
	}

?>