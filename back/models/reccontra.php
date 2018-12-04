<?php 
$tbl_vila="vila";
require("../../inc/functions.php");

if(isset($_POST['acc'])&&$_POST['acc']=='rec'){
	$mySql="SELECT `recContra` FROM $tbl_vila WHERE `recContra`='".sha1(md5($_POST['recupera']))."'";
	$connexio=connect();
	$resultRecup=mysqli_query($connexio,$mySql); 
	$num=mysqli_num_rows($resultRecup);
	disconnect($connexio);
	
	if($num!=0){	
		$mySql="UPDATE $tbl_vila 
				SET `recContra`= '', `password`='".sha1(md5($_POST['novaContra']))."'
				WHERE `recContra`='".sha1(md5($_POST['recupera']))."'";
		$connexio=connect();
		$resultRecup=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		echo "1";
	}
	else echo "0";	
}
?>

