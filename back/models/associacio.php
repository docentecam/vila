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
