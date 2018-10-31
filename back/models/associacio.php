<?php 
	require("../../inc/functions.php");
	$tbl_vila="vila";
	// $tbl_serveis="serveis";
	// $tbl_subserveis="subserveis";

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo dadesVila($tbl_vila);
	}

	// if(isset($_POST['acc'])&&$_POST['acc']==''){
	//     $cantImatge=$_POST['cantImatge']+1;
	//     $j=0;
	//     while($j<$cantImatge)
	//     {
	//     	$numUp='uploadedFile'.$j;
	//     	$file = $_FILES[$numUp]["name"];
	// 		move_uploaded_file($_FILES[$numUp]["tmp_name"], $file);
	// 		unlink($_POST['logoDelete']);
	// 		$j++;
	//     }
	// }
	// if(isset($_POST['acc'])&&$_POST['acc']=='subeFichero'){
	//     $cantImatge=$_POST['cantImatge']+1;
	//     $j=0;
	//     while($j<$cantImatge)
	//     {
	//     	$numUp='uploadedFile'.$j;
	//     	$file = $_FILES[$numUp]["name"];
	// 		move_uploaded_file($_FILES[$numUp]["tmp_name"], $file);
	// 		unlink($_POST['logoDelete']);
	// 		$j++;
	//     }
	// }
	if(isset($_POST['acc'])&&$_POST['acc']=='updateMedia'){
		$fileEx =explode('.',$_FILES["logoUpdate"]["name"]);
		$file =  date("dmYhisv").'.'.$fileEx[count($fileEx)-1];
		$mySql="UPDATE $tbl_vila SET `".$_POST['nomCamp']."`='".$file."'";
		$connexio=connect();
		mysqli_query($connexio,$mySql);
		disconnect($connexio);
		 
		move_uploaded_file($_FILES["logoUpdate"]["tmp_name"], "../../img/".$file);
		unlink('../../img/'.$_POST['logoOld']);
		
		echo $file;
	 }
	 // if(isset($_POST['acc'])&&$_POST['acc']=='updateVila'){
	 // 	$mySql="UPDATE $tbl_vila SET `email`='".$_POST['email']."', `pasMail`='".$_POST['pasMail']."', `logoVila`='".$_POST['logoVila']."', `facebook`='".$_POST['facebook']."', `keyApi`='".replaceFromHtml($_POST['keyApi'])."', `password`='".$_POST['password']."',`logoBolsa`='".$_POST['logoBolsa']."',`favIcon`='".$_POST['favIcon']."',`telf`='".$_POST['telf']."',`horari`='".replaceFromHtml($_POST['horari'])."',`nom`='".replaceFromHtml($_POST['nom'])."',`quiSom`='".replaceFromHtml($_POST['quiSom'])."',`equip`='".replaceFromHtml($_POST['equip'])."',`latitud`='".$_POST['latitud']."',`longitud`='".$_POST['longitud']."',`LGPD`='".replaceFromHtml($_POST['LGPD'])."',`URLWeb`='".$_POST['URLWeb']."'"
	 // }
	 
	function dadesVila($tbl_vila){
		$mySql="SELECT `idVila`, `email`,  `pasMail`,  `logoVila`,  `facebook`,  `keyApi`,  `password`,  `logoBolsa`,  `favIcon`,  `telf`,  `horari`,  `nom`,  `quiSom`,  `equip`,  `latitud`,  `longitud`,  `LGPD`,  `URLWeb`
			FROM `$tbl_vila`";
		$connexio=connect();
		$resultVila=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		//$dadesVila=mysqli_fetch_row($resultVila);
		//return json_encode($dadesVila);
		$rows = array(); 
		while($r = mysqli_fetch_array($resultVila)) 
		{
			$rows[] = $r; 
		}
		return json_encode($rows);
	}
?>
