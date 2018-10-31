<?php 	
	
	$tbl_vila="vila";
	
	require("../../inc/functions.php");
	
	session_start();	
	
		if(isset($_POST['acc'])&&$_POST['acc']=='log'){
			
		$mySql="SELECT `idVila`, `email`, `nom` FROM $tbl_vila WHERE `email` ='".$_POST['vila']."' AND `password`='".sha1(md5($_POST['contra']))."'";
		$connexio=connect();
		$resultUser=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		if((mySqli_num_rows($resultUser))!=0)
		{
				while($row=mySqli_fetch_array($resultUser)){
					$_SESSION['vila']['idVila']=$row['idVila'];
					$_SESSION['vila']['email']=$row['email'];
					$_SESSION['vila']['nom']=$row['nom'];	
				}
			echo '[{"message":"OK"}]';
		}
		else echo '[{"message":"Error al conectar"}]';
	}

	if(isset($_GET['acc'])&&$_GET['acc']=='logout'){
		unset($_SESSION['vila']['email']);

	}
	if(isset($_POST['acc'])&&$_POST['acc']=='favi'){
		$mySql="SELECT `logoVila` ,`logoBolsa` , `favIcon`  FROM $tbl_vila";
		$connexio=connect();
		$resultVila=mySqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array();
		while ($r = mysqli_fetch_array($resultVila)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
	}
?>