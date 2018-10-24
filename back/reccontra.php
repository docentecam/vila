<!-- Raul recuerda vigilar todo, vista controller y model!! es Vila, no Colla!!-->
	<!-- ^^
		^^
		^^ -->
<!DOCTYPE html> 
<html ng-app="collaLogin"> 
	<head>	
		<title>Recuperar contrasenya</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/angular.js"></script>
		<script src="controllers/login.js"></script>
		<style type="text/css">
					.activCent{
						display: inline-block;
				 }
				.activContainer{
					text-align: center;
				}
		</style>
	</head>
	<body ng-controller="RecContraCtrl"> 
		<?php
			if(isset($_POST['recupera'])){
		?>
		<div class="row text-center mt-5">
			<form class="col">
				<div class="row">
					<div class="form-group col-12 col-md-4 offset-md-4">
						<label for="txtNovContra">Nova Contrasenya</label>
						<div class="input-group">
							<input type="password" class="form-control" id="txtNovContra" ng-model="novaContra">
							<div class="input-group-append">
					           <span class="input-group-text far fa-eye cursor" id="inputGroupPrepend" ng-click="changePass()"></span>
					        </div>
					    </div>
					</div>
					<div class="form-group col-12 col-md-4 offset-md-4">
						<label for="inputRepitContra">Repetir nova Contrasenya</label>
						<input type="password" class="form-control" id="inputRepitContra" ng-model="repetirNovaContra">	
					</div>
					<div class="form-group col-12 col-md-4 offset-md-4 ">
						<button type="button" value="guardar" ng-click="save('<?php if(isset($_POST['recupera'])) echo $_POST['recupera'];?>')" class=" btn btnColorCss">Guardar</button>
						<input  type="button" id="btnLogin" value="Anar al login" class=" btn btn-primary" ng-disabled="actBtnIrLogin" ng-click="redirectLogin()"></input>
					</div>
				</div>
			</form>
		</div>
		<div ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>
		<?php
			}
		?>
		<?php
			if(isset($_GET['ta'])){
				if($_GET['ta']=="OK")
				{
					?>
					<br>
					<br>
					<br>
					<div class="activContainer">
						<div class="alert alert-success activCent mt-5" role="alert">

							Perfecte! L'activació s'ha realitzat amb èxit.

						</div>
					</div>
					<?php
				}
				if($_GET['ta']=="KO")
				{
					?>
					<br>
					<br>
					<br>
					<div class="activContainer">
						<div class="alert alert-danger activCent" role="alert">
							Hi ha hagut algun problema amb l'activació. Si us plau, posa't en contacte amb nosaltres.
						</div>
					</div>
					<?php
				}
			}
					?>
			

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>
