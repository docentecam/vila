<?php 
	require("../../inc/functions.php");
	$tbl_associacio="associats";
	$tbl_serveis="serveis";
	$tbl_subserveis="subserveis";

	function associats($tbl_associacio,$tbl_serveis){
		$mySql="SELECT `ass`.`idAssociat`, `ass`.`logoAssociat`, `ass`.`nomAssociat`, `ass`.`horari`, `ass`.`txtAssociat`, `ass`.`facebook`, `ass`.`activo`, `ass`.`adreca`, `ass`.`telf1`, `ass`.`telf2`, `ass`.`whatsapp`, `ass`.`email`
			FROM $tbl_associacio AS ass
			LEFT JOIN $tbl_serveis AS serv"
	}
?>