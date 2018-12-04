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
	if (isset($_POST['acc'])&&$_POST['acc']=='Envia'){
		$fech=date("Y-m-d H:i:s");
		$newPassword="user".date("smYiHd");
		$mySqlMail="SELECT `email`
				FROM $tbl_vila
				WHERE `email`='".$_POST['mail']."'";
				// echo $mySqlMail;
		$connexio=connect();
		$resultMail=mysqli_query($connexio,$mySqlMail); 
		$numVila=mysqli_num_rows($resultMail);
		disconnect($connexio);		
		
		if($numVila!=0){

			$mySql="UPDATE $tbl_vila SET `recContra`='".sha1(md5($newPassword))."' WHERE `email`='".$_POST['mail']."'";
			$mySqlVila="SELECT `URLWeb` FROM $tbl_vila";
			$connexio=connect();
			$resultVila=mysqli_query($connexio,$mySql);
			$resultVila=mysqli_query($connexio,$mySqlVila);
			disconnect($connexio);
			$dadesVila=mySqli_fetch_row($resultVila);
			
			$URLWeb="http://127.0.0.1/web/practGit/vila";
			//$dadesVila[0];
			$body="
					<table width='100%' style='text-align:center; color:black;'>

						<tr>
							<td width='20%'><td width='60%'>Hem rebut una sol·licitud per restablir la teva contrasenya</td><td width='20%'></td>
							</td>
						</tr>
						<tr>
							<td width='20%'><td width='60%'><p>Per canviar la teva contrasenya, <b>per favor fes clic al botó d'a baix</b>:</p></td><td width='20%'></td>
							</td>
						</tr>
						<tr>
							<td width='20%'><td width='60%'><a href='".$URLWeb."/back/reccontra.php?recupera=".$newPassword."' target='_blank'>mandar</a>"."
							<form action='".$URLWeb."/back/reccontra.php' method='post'>
							<input name='recupera' type='hidden' value='".$newPassword."'>
							<button class='estilButton'>Canviar contrasenya</button>
							</form>
							
								</td><td width='20%'></td>
							</td>
						</tr><br>
						<tr>
							<td width='20%'><td width='60%'>Si no has realitzat cap sol·licitud de restabliment de contrasenya, és probable que un altre usuari introdueixi la seva adreça de correu electrònic per error, llavors simplement pots ignorar aquest correu electrònic.</td><td width='20%'></td>
							</td>
						</tr><br>

						<tr>
							<td width='20%'><td width='60%'><hr style='border:border:1px solid #dddddd;'>
							</td><td width='20%'></td>
							</td>
						</tr>
						
					</table>
				";
		
		 	$envio=sendMail($_POST['mail'],"Recupera la teva contrasenya",donarFormat($body));	
	 	}
	 	echo $numVila;
	}
?>