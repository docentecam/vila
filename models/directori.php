<?php
		$tbl_associats="associats";
		$tbl_categoriaassociat="categoriaassociat";
		$tbl_galeriaassociats="galeriaassociats";
		$tbl_categories="categories";

		require("../inc/functions.php");

		if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			$mySqlAssociats="SELECT `idAssociat`, `logoAssociat`, `nomAssociat`, `horari`, `txtAssociat`, `facebook`, `activo`, `adreca`, `telf1`, `telf2`, `whatsapp`, `email`, `latitud`, `longitud`, `URLWeb` FROM $tbl_associats";
			
			$connexio=connect();
			$resultAssociats=mysqli_query($connexio,$mySqlAssociats);
			disconnect($connexio);
			//echo json_encode(mysqli_fetch_row($resultAssociats));
			 $rows = array(); 
			while($r = mysqli_fetch_array($resultAssociats)) 
			{
				$rows[] = $r; 
			} 
			echo json_encode($rows);

	}
?>