<?php
	$tbl_associats="associats";
	$tbl_categoriaassociat="categoriaassociat";
	$tbl_galeriaassociats="galeriaassociats";
	$tbl_categories="categories";

	require("../inc/functions.php");

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			$dades= '{"dadesAssociats": ';
			$dades.= mostrarAssociats($tbl_associats);
			$dades.= ',"dadesCategoriaassociat":';	
			$dades.= mostrarCategoriaassociat($tbl_categoriaassociat,$tbl_categories,$tbl_associats);
			$dades.= ',"dadesGaleriaassociats":';	
			$dades.= mostrarGaleriaassociats($tbl_galeriaassociats);
			$dades.= ',"dadesCategories":';	
			$dades.= mostrarCategories($tbl_categories);

			$dades.="}";

			echo $dades;
		}

	if(isset($_POST['acc'])&&$_POST['acc']=='la'){
			$dades= '{"dadesAssociat": ';
			$dades.= mostrarAssociat($tbl_associats,$_POST['idAssociat']);
			$dades.= ',"dadesGaleriaassociat":';	
			$dades.= mostrarGaleriaassociat($tbl_galeriaassociats,$_POST['idAssociat']);

			$dades.="}";

			echo $dades;
		}

	function mostrarAssociats($tbl_associats){
			$mySql="SELECT `idAssociat`, `logoAssociat`, `nomAssociat`, `horari`, `txtAssociat`, `facebook`, `adreca`, `telf1`, `telf2`, `whatsapp`, `email`, `latitud`, `longitud`, `URLWeb`	FROM $tbl_associats WHERE `activo`='S'";
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

	function mostrarAssociat($tbl_associats,$idAssociat){
			$mySql="SELECT `idAssociat`, `logoAssociat`, `nomAssociat`, `horari`, `txtAssociat`, `facebook`, `adreca`, `telf1`, `telf2`, `whatsapp`, `email`, `latitud`, `longitud`, `URLWeb`	FROM $tbl_associats WHERE `idAssociat`=".$idAssociat;
			$connexio=connect();
			$resultAssociat=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 

			while($r = mysqli_fetch_array($resultAssociat)) 
			{
				$rows[] = $r; 
			} 
					
			return json_encode($rows);
		}
		
	function mostrarCategoriaassociat($tbl_categoriaassociat,$tbl_categories,$tbl_associats){
			$mySql="SELECT ca.`idCategoria`,ca.`idAssociat`,ca.`principal`, c.`nomCategoria`
					FROM $tbl_categories AS c
					LEFT JOIN `$tbl_categoriaassociat` AS ca 
					ON `ca`.`idCategoria` = `c`.`idCategoria` ";
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

	function mostrarGaleriaassociat($tbl_galeriaassociats,$idAssociat){
			$mySql="SELECT `idGaleria`,`fotoGaleria`,`idAssociat`	FROM $tbl_galeriaassociats WHERE `idAssociat`=".$idAssociat;
			$connexio=connect();
			$resultGaleriaassociat=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 
			$i=0;
			while($r = mysqli_fetch_array($resultGaleriaassociat)) 
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
?>