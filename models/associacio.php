<?php

require("../inc/functions.php");

$tbl_vila="vila";
$tbl_serveis="serveis";
$tbl_subserveis="subserveis";

if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$dades= '{"dadesVila": ';
		$dades.= mostrarQuisom($tbl_vila);
		$dades.= ',"dadesServeis":';	
		$dades.= mostrarServeis($tbl_serveis,$tbl_subserveis);

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
			$mySql2="SELECT `idSubservei`, `nomSubservei`, `txtSubservei`, `idServei` 
					FROM `$tbl_subserveis`
					WHERE idServei=".$r[0];
					$rowsSub = array(); 
					$resultSubServeis=mysqli_query($connexio,$mySql2); 
					while($rSub = mysqli_fetch_array($resultSubServeis)) 
					{
						$mySql2="SELECT `idSubservei`, `nomSubservei`, `txtSubservei`, `idServei` FROM `$tbl_subserveis` WHERE idServei=".$r[0];
						$rowsSub = array(); 
						$resultSubServeis=mysqli_query($connexio,$mySql2); 
						while($rSub = mysqli_fetch_array($resultSubServeis)) 
							{
								$rowsSub[] = $rSub; 
							}
								array_push($r, $rowsSub);
								$rows[] = $r; 	
					}
					array_push($r, $rowsSub);
			$rows[] = $r; 	
		} 
		disconnect($connexio);
		for ($i=0; $i < sizeof($rows); $i++) { 
			$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
		}		
		return json_encode($rows);
	}




	

?>