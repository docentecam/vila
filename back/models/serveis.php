<?php 
	require("../../inc/functions.php");
	$tbl_serveis="serveis";
	$tbl_subserveis="subserveis"

	function serveis($tbl_serveis){
		$mySql="SELECT `idServei`,`nomServei`,`txtServei`
				FROM $tbl_serveis"
	}
	function subserveis($tbl_subserveis){
		$mySql="SELECT `idSubservei`,`nomSubservei`,`txtSubservei`,`idServei`
				FROM $tbl_subserveis"
	}
?>