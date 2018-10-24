<!DOCTYPE html> 
<html ng-app="vilaLogin"> 
	<head>
		<title>Iniciar Sessió</title>
		<meta charset="utf-8">
		<link rel="icon" ng-href="../img/{{favIcon}}" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/angular.js"></script>
		<script src="controllers/login.js"></script>

	</head>
	<body  ng-controller="LoginCtrl"> 
		<div class="divCentro">
			<form>
				<fieldset>
					<div ng-src="">
					<legend>Iniciar Sessió</legend><br></div>
			  		<input class="form-control" type="text" name="txtHNom" id="txtHNom" size="25"  required ng-model="usuari.soci" placeholder="Introduïu el vostre correu" ng-keyup="$event.keyCode == 13 ? login() : null"><br>
			  		<div class="input-group ">
			  			<div class="input-group-append">
			  				<input class="form-control border-right-0" id="txtPass" name="txtPass" type="password" size="40" required ng-model="usuari.contra" placeholder="Contrasenya" ng-keyup="$event.keyCode == 13 ? login() : null">
				           <span class="input-group-text mr-4" id="inputGroupPrepend" ng-click="changePass()"><i class="far fa-eye cursor mx-2"></i></span>
				  		</div>	
				    </div>
			  		<small><label class="cursor mt-3" data-toggle="modal" data-target="#exampleModal">Recuperar contrasenya</label></small><br><br>
	 				<input class="btn btn-primary" type="button" value="Entrar" ng-click="login()"><br>
	 				
	 				<div ng-show="incontra" class="text-danger pt-2">
						Usuari o contransenya incorrecta
					</div>
				</fieldset>
			</form>
		</div>
		<div ng-hide="divError" class="col-6 offset-3 text-center alert alert-warning mt-3">
			{{msgError}}
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		     	<div class="modal-header">
		       		 <h5 class="modal-title" id="exampleModalLabel">Recuperar contrasenya</h5>
		      	</div>
			     	<form name="Frecontra" ng-submit="recontra()" novalidate>
			      		<div class="modal-body">
			       			Indiqueu email on restablir una nova contrasenya.<br><br>
			       	
			       			<input class="form-control" type="email" name="txtReC"  placeholder="Introduïu correu on restablir una nova contrasenya" required ng-keyup="$event.keyCode == 13 ? recontra() : null" ng-model="usuari.soci">
			       			  <p ng-show="Frecontra.txtReC.$invalid && !Frecontra.txtReC.$pristine" class="help-block text-danger">L'adreça de correu electrònic introduïda no és vàlida. {{formEmailInco}}</p>
			      		</div>
			      		<div class="modal-footer">
			      			<button ng-disabled="Frecontra.txtReC.$invalid" type="submit" data-dismiss="modal" class="btn btnColorCss" value="Enviar" ng-click="recontra()">Enviar</button> 
			        		<input type="button" class="btn btn-danger" value="Tancar" data-dismiss="modal" ng-click="close()">
		  	      	 	</div>
			  	 	</form>
		    	</div>
	  		</div>
		</div>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>

