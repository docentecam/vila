<?php  
	require("../inc/functions.php");
	$tbl_contactans="contactans";
	$tbl_vila="vila";
	$tbl_solicitutssocis="solicitutssocis";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$mySql="SELECT `logoVila`,`facebook`, `nom`, `horari`, `telf`, `email`,`LGPD` FROM $tbl_vila";
		$connexio=connect();
		$resultVila=mysqli_query($connexio,$mySql);
		disconnect($connexio);
			
		$rows = array(); 
		while($r = mysqli_fetch_array($resultVila)) 
		{
			$rows[] = $r; 
		}
		echo json_encode($rows);	
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='i'){
		$mySql="INSERT INTO $tbl_contactans (`nomContacte`,`cognomContacte`,`tipus`,`email`, `telefon`, `nomEmpresa`,`txtContacte`, `data`) 
				VALUES  ('".$_POST['nomContacte']."','".$_POST['cognomContacte']."','".$_POST['tipus']."','".$_POST['email']."','".$_POST['telefon']."','".$_POST['nomEmpresa']."','".replaceFromHtml($_POST['txtContacte'])."','".date("Y-m-d H:i:s")."')";
		$connexio=connect();
		$resultContactans=mysqli_query($connexio,$mySql);

		disconnect($connexio);
//TODO VERIFICAR QUE LO INSERTA. $idContactans=mysqli_insert_id
		

		// $numContac=1;
		// if($numContac!=0){

		// 	$envio=sendMail($_POST['email'],"Missatge rebut per la Colla.",donarFormat("Hola, acabem de rebre el teu missatge on deia el següent:<br><br>".$_POST['txtContacte']."<br><br>Moltes gràcies per escriure'ns, et respondrem el més aviat possible així que estigues atent de la teva safata d'entrada.<br><br>Salutacions!"),"si");
		// 	$estat="ok";
		// }
		// else{
		// 	$estat="ko";
		// }
		

		// echo $estat;

}

	if(isset($_POST['acc'])&&$_POST['acc']=='insertSolicitutssocis'){
		$dataActual=date("Y-m-d H:i:s");
		$newToken="tok".date("smyiHDW");

		$mySql="SELECT `email`,`nom`,`URLWeb` FROM $tbl_vila ";
				
		$connexio=connect();
		$resultSolicitutVila=mysqli_query($connexio,$mySql); 
		$numSolicitutssocis=mysqli_num_rows($resultSolicitutVila);
		disconnect($connexio);		
		$dadesVila=mySqli_fetch_row($resultSolicitutVila);

		if($numSolicitutssocis==0){
		$mySql="INSERT INTO $tbl_Solicitutssocis (`nomComercial`,`sectorComercial`,`adreca`,`telf`,`email`,`data`,`personaContacte`,`horari`)
				VALUES ('".$_POST['nomComercial']."','".$_POST['sectorComercial']."','".$_POST['adreca']."','".$_POST['telf']."','".$_POST['email']."','".$_POST['data']."','".$_POST['personaContacte']."','".$_POST['horari']."','".$dataActual."','N','".sha1(md5($newToken))."')";

			$connexio=connect();
		$resultContactans=mysqli_query($connexio,$mySql);

		disconnect($connexio);
		
		$envio=sendMail($_POST['email'],"Benvinguts!",donarFormat("Hola <b>".$_POST['nom']."</b>!<br>Ara que ets un afiliat més a la nostra associació, gaudiràs d'estar al dia de totes les novetats i esdeveniments.<br>No oblidis que qualsevol dubte que puguis tenir, pots contactar amb nosaltres sempre que vulguis.<br>Et convidem a donar-li una ullada a la <a href='".$dadesVila[2]."' target='_blank'>pàgina web</a> i a les nostres xarxes socials on trobaràs molta més informació.<br>Dit això, ens veiem aviat! <br>
			<form action='".$dadesVila[2]."/cpanel/models/reccontra.php' method='post'>
			<input name='acc' type='hidden' value='ta'>
			<input name='afiliat' type='hidden' value='".$newToken."'>
				<button class='estilButton'>Activació Afiliat</button>
			</form>	
			"),"simpat");
		echo "ok";
		}
		else{
			echo "0";
		}
		
}

?>