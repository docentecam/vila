<?php 
	require("../../inc/functions.php");
	$tbl_serveis="serveis";
	$tbl_subserveis="subserveis";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo serveis($tbl_serveis, $tbl_subserveis);
	}
	
	if(isset($_POST['acc'])&&$_POST['acc']=='Editar'){
		if(isset($_POST['nomServei']))
		{
		$mySql="UPDATE $tbl_serveis 
			SET `nomServei`='".replaceFromHtml($_POST['nomServei'])."', 
				`txtServei`='".replaceFromHtml($_POST['txtServei'])."'	
			WHERE idServei='".$_POST['idServei']."'";
		}
		else if(isset($_POST['nomSubservei']))
		{	
		$mySql="UPDATE $tbl_subserveis 
			SET `nomSubservei`='".replaceFromHtml($_POST['nomSubservei'])."', 
				`txtSubservei`='".replaceFromHtml($_POST['txtSubservei'])."'	
			WHERE idSubservei='".$_POST['idSubservei']."'";
		echo $mySql;
		}
		$connexio=connect();	
		$resultServei=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		echo serveis($tbl_serveis, $tbl_subserveis);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Afegir'){
		if(isset($_POST['nomServei']))
		{
		$mySql="INSERT INTO $tbl_serveis (`idServei`,`nomServei`, `txtServei`) VALUES (NULL,'".replaceFromHtml($_POST['nomServei'])."','".replaceFromHtml($_POST['txtServei'])."')";
		}else if(isset($_POST['nomSubservei']))
		{
		$mySql="INSERT INTO $tbl_subserveis (`idSubservei`,`nomSubservei`, `txtSubservei`, `idServei`) VALUES (NULL,'".replaceFromHtml($_POST['nomSubservei'])."','".replaceFromHtml($_POST['txtSubservei'])."','".$_POST['idServei']."')";
		}
		$connexio=connect();
		$resultServei=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		
	echo serveis($tbl_serveis, $tbl_subserveis);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='delSer'){
		$mySql="DELETE FROM $tbl_subserveis 
				WHERE `idServei`=".$_POST['idServei'];
		$mySql2="DELETE FROM $tbl_serveis 
				WHERE `idServei`=".$_POST['idServei'];
	
	$connexio=connect();
	$resultServei2=mysqli_query($connexio,$mySql);
	$resultServei=mysqli_query($connexio,$mySql2);
	disconnect($connexio);
	echo serveis($tbl_serveis, $tbl_subserveis);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='delSubser'){
		$mySql="DELETE FROM $tbl_subserveis 
				WHERE `idSubservei`=".$_POST['idSubservei'];
	
	$connexio=connect();
	$resultSubervei=mysqli_query($connexio,$mySql);
	disconnect($connexio);
	echo serveis($tbl_serveis, $tbl_subserveis);
	}
	function serveis($tbl_serveis, $tbl_subserveis){
		$mySql="SELECT `idServei`,`nomServei`,`txtServei`
				FROM $tbl_serveis";
		$connexio=connect();
		$resultServeis=mysqli_query($connexio,$mySql); 

		$rows = array();
		while($r = mysqli_fetch_array($resultServeis)) 
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
		disconnect($connexio);
		for ($i=0; $i < sizeof($rows); $i++) { 
			$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
		}
		return json_encode($rows);
	}
?>