<?php
		$tbl_associats="associats";
		$tbl_categoriaassociat="categoriaassociat";
		$tbl_galeriaassociats="galeriaassociats";
		$tbl_categories="categories";

		require("../inc/functions.php");

		if(isset($_POST['acc'])&&$_POST['acc']=='l'){
				echo mostrarAssociats($tbl_associats);
			}

		function mostrarAssociats($tbl_associats){
				$mySql="SELECT `idAssociat`, `logoAssociat`, `nomAssociat`, `horari`, `txtAssociat`, `facebook`, `adreca`, `telf1`, `telf2`, `whatsapp`, `email`, `latitud`, `longitud`, `URLWeb`	FROM $tbl_associats";
				$connexio=connect();
				$resultAssociats=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultAssociats)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}
		function mostrarCategoriaassociat($tbl_categoriaassociat){
				$mySql="SELECT `idCategoria`,`idAssociat`,`principal`	FROM $tbl_categoriaassociat";
				$connexio=connect();
				$resultCategoriaassociat=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 
				$i=0;
				while($r = mysqli_fetch_array($resultCategoriaassociat)) 
				{
					$rows[] = $r; 
					 $i++;
				} 
						
				return json_encode($rows);
			}

		function mostrarGaleriaassociats($tbl_galeriaassociats){
				$mySql="SELECT `idGaleria`,`fotoGaleria`,`idAssociat`	FROM $tbl_galeriaassociats";
				$connexio=connect();
				$resultGaleriaassociats=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 
				$i=0;
				while($r = mysqli_fetch_array($resultGaleriaassociats)) 
				{
					$rows[] = $r; 
					 $i++;
				} 
						
				return json_encode($rows);
			}

		function mostrarCategories($tbl_categories){
				$mySql="SELECT `idCategoria`,`pictograma`,`nomCategoria`	FROM $tbl_categories";
				$connexio=connect();
				$resultCategories=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 
				$i=0;
				while($r = mysqli_fetch_array($resultCategories)) 
				{
					$rows[] = $r; 
					 $i++;
				} 
						
				return json_encode($rows);
			}