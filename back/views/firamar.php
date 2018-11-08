
<div id="divTop" class="row text-center mt-4 mb-3">
  <div class="col-12 " ><h1 class="titleSocis">Firamar</h1></div>
</div>

<div  ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>

<div class="col-lg-1 col-md-1 offset-lg-1">
	<i class="fas fa-plus-square afegegant text-dark cursor" ng-click="afegeixE(-1)" ng-show="firaFull" title="Afegeix Edicio"></i>
</div>

	<div id="tabstid" class="row tabst">
		<table border="1" class="tabcont col-12 col-lg-5 offset-lg-2 offset-lg-1 textTabla text-center">
			<tr>
				<th colspan="3" class="my-1">Edicions</th>
			</tr>
			<tr ng-repeat="edicion in edicions | orderBy:'-fecha'">
				<td><a class="cursor" ng-click="mostraEdicio(edicion.fecha)">{{edicion.titolFiramar}}</a></td>
				<td>
					<button id="BuAlFinal" type="button" class="btn btn-outline-success my-1">
		   				<span ng-click="afegeixE()" title="Edita Gegant">Principal</span>
		   			</button>
		   			<button id="BuAlFinal" type="button" class="btn btn-outline-primary" ng-show="$index==1">
		   				<span ng-click="afegeixE()" title="Edita Gegant">Hacer Principal</span>
		   			</button>
		   		</td>
		   		<td>
		   			<button id="BuAlFinal" type="button" class="btn btn-outline-dark mx-2">
		   				<span ng-click="afegeixE($index)" title="Edita Gegant">Edita</span>
		   			</button>
				</td>
			</tr>
		</table>	
	</div>	


<div class="mt-lg-5" ng-hide="firaFull"> <!--  agreagar al finalizar-->
	<form id="formFiramar" name="formFiramar">
	 	<div class="form-row">
		    <div class="form-group col-md-5 col-lg-3 offset-lg-2">
		      <label for="txtNom">Titol Firamar</label>
		      <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
		    </div>
		    <div class="form-group col-md-2 col-lg-2">
		      <label for="txtData">Fecha</label>
		      <input type="date" class="form-control" id="txtData" name="txtData" ng-model="firamar.fecha">
		    </div>
		    <div class="form-group col-lg-7 offset-lg-2">
		      	<label for="txtParrafada">Text</label>
		       	<textarea class="form-control textarea" id="txtParrafada" name="txtParrafada" ng-model="firamar.txtFiramar"></textarea>
		   	</div>
		</div>
		<div class="form-row">
			<div class="form-group col-12 col-lg-3 col-md-1 offset-lg-2">
				<div class="modal-footer">
	  			<a anchor-smooth-scroll="divTop">	  		
	  				<input type="button" class="btn btn-primary" ng-click="guardaEdicio(accio)" value="Guardar canvis">
	  			</a>
	  			<a anchor-smooth-scroll="divTop">
	  				<input type="button" class="btn btn-danger" ng-click="cancelaEdicio()" value="Cancelar">
		  		</a>
		  		</div>
			</div>
		</div>

		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Program d'Activitats</h1></div>
		</div>

		<div class="form-row">  
			<div class="form-group col-12 col-lg-4 col-md-5 offset-lg-2">
			      <label for="titolAct">Titol Activitat</label>
			      <input type="text" class="form-control" id="titolAct" name="titolAct" ng-model="firamar.titolActivitat" maxlength="100">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-2 col-lg-2 offset-lg-2">
		      	<label for="horaIn">Hora inici</label>
		      	<input type="date" class="form-control" id="horaIn" name="horaIn" ng-model="firamar.horaInici">
			</div>
			<div class="form-group col-md-2 col-lg-2">
				<label for="horaF">Hora Fi</label>
		      	<input type="date" class="form-control" id="horaF" name="horaF" ng-model="firamar.holaFi">
		    </div>
	  	</div>
	  	<div class="form-row">
			 <div class="form-group col-lg-7 offset-lg-2">
		      	<label for="txtAct">Text</label>
		       	<textarea class="form-control textarea" id="txtAct" name="txtAct" ng-model="firamar.txtActivitat"></textarea>
		   	</div>
		</div>
		
		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Galeria</h1></div>
		</div>
		
		
		<div class="card-columns" data-spy="scroll">
				<div class="card" ng-repeat="galeria in galerias">
					<img class="card-img-top img-fluid d-md-none" ng-src="{{galeria.fotoFiramar!=''?'../../img/galeriaFiramar/'+galeria.fotoFiramar:'img/noimage.png'}}" ng-if="soci.idSoci==sociUser" id="fotoFull" >
					<img class="card-img-top img-fluid d-none d-md-inline" ng-src="{{galeria.fotoFiramar!=''?'../../img/galeriaFiramar/'+galeria.fotoFiramar:'img/noimage.png'}}" ng-if="soci.idSoci==sociUser" data-toggle="modal" data-target="#modalFoto" id="fotoFull" ng-click="modalFoto(galeria.fotoFiramar)">
				</div>
		</div>

		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Participants</h1></div>
		</div>

		<div class="card-group" ng-repeat="parti in partis">
			<div class="card">
			    	<img class="card-img-top img-fluid d-md-none" ng-src="{{parti.logoParticipant!=''?'../../img/galeriaFiramar/'+parti.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	     			<h5 class="card-title">Card title</h5>
		     			<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Participant</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	     		</div>
			</div>
			<div class="card">
					<img class="card-img-top img-fluid d-md-none" ng-src="{{parti.logoParticipant!=''?'../../img/galeriaFiramar/'+parti.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	 				<h5 class="card-title">Card title</h5>
	 					<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Participant</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	 			</div>
			</div>
			<div class="card">
					<img class="card-img-top img-fluid d-md-none" ng-src="{{parti.logoParticipant!=''?'../../img/galeriaFiramar/'+parti.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	 				<h5 class="card-title">Card title</h5>
	 					<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Participant</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	 			</div>
			</div>
			<div class="card">
					<img class="card-img-top img-fluid d-md-none" ng-src="{{parti.logoParticipant!=''?'../../img/galeriaFiramar/'+parti.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	 				<h5 class="card-title">Card title</h5>
	 					<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Participant</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	 			</div>
			</div>
		</div>

		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Sponsors</h1></div>
		</div>

		<div class="card-group" ng-repeat="sponsor in sponsors">
			<div class="card">
			    	<img class="card-img-top img-fluid d-md-none" ng-src="{{sponsor.logoParticipant!=''?'../../img/galeriaFiramar/'+sponsor.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	     			<h5 class="card-title">Card title</h5>
		     			<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Sponsor</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	     		</div>
			</div>
			<div class="card">
			    	<img class="card-img-top img-fluid d-md-none" ng-src="{{sponsor.logoParticipant!=''?'../../img/galeriaFiramar/'+sponsor.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	     			<h5 class="card-title">Card title</h5>
		     			<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Sponsor</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	     		</div>
			</div>
			<div class="card">
			    	<img class="card-img-top img-fluid d-md-none" ng-src="{{sponsor.logoParticipant!=''?'../../img/galeriaFiramar/'+sponsor.logoParticipant:'img/noimage.png'}}">
				<div class="card-body">
	     			<h5 class="card-title">Card title</h5>
		     			<div class="form-group col-md-5 col-lg-3 offset-lg-2">
			     		 	<label for="txtNom">Nom Sponsor</label>
			     			 <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="firamar.titolFiramar" maxlength="50">
			    		</div>
	     		</div>
			</div>
		</div>
	</form>
	</div>
	
<div class="mt-lg-5" ng-hide="firaSelect">
	
	<div class="row">
		<h1>{{edicioFiramar.titolFiramar}}</h1>

	</div>




</div>


<button id="goTop" class="goToTop" value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline ">Pujar</span>
		<img ng-src="img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>
  


