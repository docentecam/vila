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

		$datallistatGegants='{"dadesColla":';

		$i=0; 
		while ($row=mysqli_fetch_array($resultGegants)) {
			if ($i!=0) {
				$datallistatGegants.=",";	
			}
			$i++;
			$datallistatGegants.='{"urlgegants":"'.$row['urlgegants'].'","llibrepdf":"'.$row['llibrepdf'].'"}';
		}

		$datallistatGegants.=',"dadesGegants":';
	
	}
?>