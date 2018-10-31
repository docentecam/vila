<?php
require ("..functinos.php");
$tbl_vila="vila";
$tbl_serveis="serveis";
$tbl_subserveis="subserveis";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$mySqlDadesVila="SELECT `quiSom`, `equip` FROM $tbl_vila";
		$mySqlDadesServeis="SELECT `nomServei`, `txtServei`,`idServei` FROM $tbl_serveis";
		$mySqlDadesSubServeis="SELECT `nomSubservei`, `txtSubservei` FROM $tbl_subserveis WHERE `idServei`= ".$r['idServei'];
		$connexio=connect();
		$resultVila=mysqli_query($connexio,$mySqlDadesVila);
		disconnect($connexio);
			
		$dades = array(); 
		while($r = mysqli_fetch_array($resultVila)) 
		{
			$dades[] = $r; 
		}
		echo json_encode($dades);

		$datallistatServei='{"DadesServeis":';

		$i=0; 
		while ($row=mysqli_fetch_array($resultServeis)) {
			if ($i!=0) {
				$datallistatServei.=",";	
			}
			$i++;
			$datallistatServei.='{"nomServei":"'.$row['nomServei'].'","txtServei":"'.$row['txtServei'].'"}';
		}

		$datallistatServei.=',"DadesServeis":';
		$rows = array(); 
		while($row = mysqli_fetch_array($resultServeis)) 
		{
		$rows[] = $row; 
		} 
		$datallistatServei.=json_encode($rows);
		$datallistatServei.='}';
		echo $datallistatServei;
	}
?>