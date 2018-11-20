<?php 
	require("../../inc/functions.php");
	$tbl_noticies="noticies";
	

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$dades= '{"dadesNoticies": ';
		$dades.= noticies($tbl_noticies);
		$dades.= ',"cantNoticiesPrincipal":';	
		$dades.= cantPrinc($tbl_noticies);
		$dades.="}";

		echo $dades;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Editar'){
		$mySql="UPDATE $tbl_noticies 
			SET `titolNoticia`='".replaceFromHtml($_POST['titolNoticia'])."', 
				`dataNoticia`='".$_POST['dataNoticia']."',
				`txtNoticia`='".replaceFromHtml($_POST['txtNoticia'])."', 
				`principal`='".$_POST['principal']."'	
			WHERE idNoticia='".$_POST['idNoticia']."'";

		$connexio=connect();
		$resultNoti=mysqli_query($connexio,$mySql);
		disconnect($connexio);


		if (isset($_FILES['fotoNoticia'])&&$_FILES['fotoNoticia']!=""){
			$file = date("YmdHis").$_FILES['fotoNoticia']["name"];
			$mySql="UPDATE $tbl_noticies
			SET `fotoNoticia`='".$file."'
			WHERE idNoticia=".$_POST['idNoticia'];
			$connexio=connect();
			$resultNoti=mysqli_query($connexio,$mySql);
			disconnect($connexio);
			move_uploaded_file($_FILES["fotoNoticia"]["tmp_name"], "../../img/noticies/".$file);
			if (isset($_POST['fotoNoticiaOld'])&&$_POST['fotoNoticiaOld']!="")
			{
				unlink("../../img/noticies/".$_POST['fotoNoticiaOld']);
			}	
		}
		echo noticies($tbl_noticies);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Afegir'){
	
		$mySql="INSERT INTO $tbl_noticies (`idNoticia`,`titolNoticia`, `dataNoticia`, `txtNoticia`,`principal`) VALUES (NULL,'".replaceFromHtml($_POST['titolNoticia'])."','".$_POST['dataNoticia']."','".replaceFromHtml($_POST['txtNoticia'])."','".$_POST['principal']."')";
			$connexio=connect();
			$resultNoti=mysqli_query($connexio,$mySql); 
			$idNoticiaInsert=mysqli_insert_id($connexio);
			disconnect($connexio);
		if (isset($_FILES['fotoNoticia'])&&$_FILES['fotoNoticia']!=""){
			$file = date("YmdHis").$_FILES['fotoNoticia']["name"];
			$mySql="UPDATE $tbl_noticies
			SET `fotoNoticia`='".$file."'
			WHERE idNoticia=$idNoticiaInsert";
			$connexio=connect();
			$resultNoti=mysqli_query($connexio,$mySql);
			disconnect($connexio);
			move_uploaded_file($_FILES["fotoNoticia"]["tmp_name"], "../../img/noticies/".$file);
		}
		echo noticies($tbl_noticies);
 	}	
	if(isset($_POST['acc'])&&$_POST['acc']=='delNot'){
		$mySql="DELETE FROM $tbl_noticies 
				WHERE `idNoticia`=".$_POST['idNoticia'];
		$connexio=connect();
		$resultNoti=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		if(isset($_POST['fotoNoticia'])&&$_POST['fotoNoticia']!='')
		{
			unlink("../../img/noticies/".$_POST['fotoNoticia']);
		
		}
		
		echo noticies($tbl_noticies);
	} 

	if(isset($_POST['acc'])&&$_POST['acc']=='updatePrincipal'){

		$mySql="UPDATE $tbl_noticies SET `principal` = '".$_POST['principal']."' WHERE `idNoticia`='".$_POST['idNoticia']."'";
		$connexio=connect();
		$resultNoti=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		$dades= '{"dadesNoticies": ';
		$dades.= noticies($tbl_noticies);
		$dades.= ',"cantNoticiesPrincipal":';	
		$dades.= cantPrinc($tbl_noticies);
		$dades.="}";

		echo $dades;
	}
	function noticies($tbl_noticies){
		$mySql="SELECT `idNoticia`,`titolNoticia`,`dataNoticia`,`txtNoticia`,`fotoNoticia`,`principal`
				FROM $tbl_noticies ORDER BY dataNoticia DESC";
		$connexio=connect();
		$resultNoti=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultNoti)) 
			{
				$rows[] = $row; 
			} 
		for ($i=0; $i < sizeof($rows); $i++) { 
			$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			$rows[$i][3]=replaceFromBBDD($rows[$i][3]);
		}
		return json_encode($rows);
	}
	function cantPrinc($tbl_noticies){
		$mySql="SELECT COUNT(principal) AS 'cantidad' FROM `noticies` WHERE `principal`='S'";
		$connexio=connect();
		$resultNoti=mysqli_query($connexio,$mySql);
		$row=mysqli_fetch_row($resultNoti); 
		disconnect($connexio);
		return $row[0];
	}
?>