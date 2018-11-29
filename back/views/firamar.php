
	<div id="divTop" class="row text-center mt-4 mb-3">
	  <div class="col-12">

	  	<h1>Firamar</h1>
	  
	  </div>
	</div>

<div  ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>

<div class="col-lg-1 col-md-1 offset-lg-1">
	<a ng-href="#/firamarEdit/new"><i class="fas fa-plus-square afegegant text-dark cursor" ng-show="firaFull" title="Afegeix Edicio"></i></a>
</div>

	<div id="tabstid" class="row tabst">
		<table border="1" class="tabcont col-12 col-lg-4 offset-lg-4 textTabla text-center">
			<tr>
				<th colspan="3" class="my-1">Edicions</th>
			</tr>
			<tr ng-repeat="edicion in edicions | orderBy:'-fecha'">
				<td>
					<a class="cursor" ng-href="#/firamar/{{edicion.fecha}}">{{edicion.titolFiramar}}</a>
				</td>
		   		<td>
		   			<button class="btn btn-outline-dark mx-2">
		   				<a ng-href="#/firamarEdit/{{edicion.fecha}}" title="Edita aquesta edicio">Edita</a>
		   			</button>
				</td>
			</tr>
		</table>	
	</div>	


<div class="mt-lg-5" ng-hide="firaFull"> <!--  agreagar al finalizar-->

	<form id="formFiramar" name="formFiramar" class="col-12 mt-4">

	 	<div class="form-row">
		    <div class="form-group col-md-5 col-lg-3 offset-lg-2">
		      <label for="txtNom">Titol Firamar</label>
		      <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="edicioFiramar.titolFiramar" maxlength="50">
		    </div>
		    <div class="form-group col-md-2 col-lg-2">
		      <label for="txtData">Fecha</label>
		      <input type="date" class="form-control" id="txtData" name="txtData" ng-model="edicioFiramar.fecha">
		    </div>
		    <div class="form-group col-lg-7 offset-lg-2">
		      	<label for="txtParrafada">Text</label>
		       	<textarea class="form-control textarea" id="txtParrafada" name="txtParrafada" ng-model="edicioFiramar.txtFiramar"></textarea>
		   	</div>
		</div>



		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Program d'Activitats</h1></div>
		</div>

	<div ng-repeat="activitat in activitatsFiramar">
		<div class="form-row">  
			<div class="form-group col-12 col-lg-3 col-md-5 offset-lg-2 mt-3">
			      <label for="titolAct">Titol Activitat</label>
			      <input type="text" class="form-control" id="titolAct" name="titolAct" ng-model="activitat.titolActivitat" maxlength="100">
			</div>
			<div class="form-group col-md-2 col-lg-1 mt-3">
		      	<label for="horaIn">Hora Inici</label>
		      	<input type="time" class="form-control" id="horaIn" name="horaIn" ng-model="activitat.horaI">
			</div>
			<div class="form-group col-md-2 col-lg-1 mt-3">
				<label for="horaF">Hora Fi</label>
		      	<input type="time" class="form-control" id="horaF" name="horaF" ng-model="activitat.horaF">
		    </div>
			 <div class="form-group col-lg-7 offset-lg-2 mb-4">
		      	<label for="txtAct">Text</label>
		       	<textarea class="form-control textarea" id="txtAct" name="txtAct" ng-model="activitat.txtActivitat"></textarea>
		   	</div>
		</div>
		<div class="border-bottom border border-danger offset-lg-2 col-7 "></div>
	</div>

	<div class="form-row">
			<div class="form-group col-12 col-lg-3 col-md-1 offset-lg-2 mt-3">
				<div class="text-centerr">
	  			<a>	  		
	  				<input type="button" class="btn btn-primary" ng-click="guardaEdicio(accio)" value="Guardar canvis">
	  			</a>
	  			<a anchor-smooth-scroll="divTop">
	  				<input type="button" class="btn btn-danger" ng-click="cancelaEdicio()" value="Cancelar">
		  		</a>
		  		</div>
			</div>
	</div>

		<div class="row text-center mt-4 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Galeria</h1></div>
		</div>
		
		<label for="insertImgG" class="offset-md-2">
			
			<i class=" fas fa-plus-square iconSize mb-3 cursor" title="Afegeix imatges">

			<input type="file" id="insertImgG" class="align-self-end" name="insertImgG" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().getFileDetails(this,'galeria')" ng-show="false">

			</i>

		</label>

		<div class="card-columns col-12 col-lg-8 offset-lg-2">
			
			<div class="text-center" ng-repeat="galeria in galeriaFiramar">
				<img class="card-img-top img-fluid" ng-src="{{galeria.fotoFiramar!=''?'../img/galeriaFiramar/'+galeria.fotoFiramar:'../img/noimage.png'}}" id="fotoGFull">	
				<input type="button" class="btn btn-danger mt-2" value="Eliminar" ng-click="EliminaImg('galeriafiramar',galeria.fotoFiramar,galeria.idGaleriaFiramar,galeria.fotoFiramar)">
			</div> 
			
		</div>

		<div class="row text-center mt-5 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Participants</h1></div>
		</div>
		
		<label for="insertImgP" class="offset-md-2">
			<i class=" fas fa-plus-square iconSize mb-3 cursor" title="Afegeix imatges"></i>
		</label>
		<input type="file" id="insertImgP" class="align-self-end" name="insertImgP" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().getFileDetails(this,'participant')" ng-show="false">

		<div class="card-columns col-12 col-lg-8 offset-lg-2">
			
			<div class="text-center" ng-repeat="participant in participantsFiramar">
				<img class="card-img-top img-fluid" ng-src="{{participant.logoParticipant!=''?'../img/participants/'+participant.logoParticipant:'img/noimage.png'}}">
				<input type="button" class="btn btn-danger mt-2" value="Eliminar" ng-click="EliminaImg('participants',participant.nomParticipant,participant.fecha,participant.logoParticipant)">
			</div>
		
		</div>
		

		<div class="row text-center mt-5 mb-3">
	  		<div class="col-12 " ><h1 class="titleSocis">Sponsors</h1></div>
		</div>
		
		<label for="insertImgS" class="offset-md-2">
			<i class=" fas fa-plus-square iconSize mb-3 cursor" title="Afegeix imatges"></i>
		</label>
		<input type="file" id="insertImgS" class="align-self-end" name="insertImgS" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().getFileDetails(this,'sponsor')" ng-show="false">

		<div class="row mb-3">
			<div class="col-2"></div>
			<div class="col">
				<div class="row">
					<div class="col-lg-3 text-center" ng-repeat="sponsor in sponsorsFiramar">
						<img class="img-fluid rounded img-thumbnail mt-3" ng-src="{{sponsor.logoSponsor!=''?'../img/sponsors/'+sponsor.logoSponsor:'../img/noimage.png'}}">
						<input type="button" class="btn btn-danger mt-2" value="Eliminar" ng-click="EliminaImg('sponsors',sponsor.nomSponsor,sponsor.fecha,sponsor.logoSponsor)">
					</div>
				</div>
			</div>
			<div class="col-2"></div>
		</div>

 			

	</form>
</div>


										<!-- <<< ONLY LOOK >>> -->


<div class="mt-lg-5" ng-hide="firaSelect">

	<div class="row text-center mt-4 mb-3">
  		<div class="col-12">
  			
  			<h1>{{edicioFiramar.titolFiramar}}</h1>
  		
  		</div>
  		<div class="col-12">
  			
  			<p>{{edicioFiramar.txtFiramar}}</p>
  		
  		</div>
	</div>

<div class="row text-center mt-4 mb-3">
	<div class="col-12 " ><h1 class="titleSocis">Programa d'activitats</h1></div>
</div>
<div class="row">
	<div class="card border-secondary mb-3 CardMw col-lg-10 offset-lg-1" ng-repeat="activitats in activitatsFiramar">

	  <div class="card-header bg-transparent border-secondary">
	  			<span class="far fa-clock fa-lg"></span>&nbsp;{{activitats.horaIni}} - {{activitats.horaFF}}
	  </div>

	  <div class="card-body text-secondary">

	    <h5 class="card-title">{{activitats.titolActivitat}}</h5>
	    <p class="card-text">{{activitats.txtActivitat}}</p>

	  </div>
	</div>
</div>

<div class="row text-center mt-4 mb-3">
	<div class="col-12 " ><h1 class="titleSocis">Galeria</h1></div>
</div>	
	
	<div class="card-columns col-12 col-lg-8 offset-lg-2">
			
			<div class="text-center" ng-repeat="galeria in galeriaFiramar">
				<img class="card-img-top img-fluid rounded" ng-src="{{galeria.fotoFiramar!=''?'../img/galeriaFiramar/'+galeria.fotoFiramar:'../img/noimage.png'}}">
			</div> 
			
		</div>


<div class="row text-center mt-4 mb-3">
	<div class="col-12 " ><h1 class="titleSocis">Participants</h1></div>
</div>
	
    <div class="card-columns col-12 col-lg-8 offset-lg-2">
      	<div class="text-center" ng-repeat="participant in participantsFiramar">
      	
        	<img class="rounded card-img-top img-fluid" 
       		 ng-src="{{participant.logoParticipant!=''?'../img/participants/'+participant.logoParticipant:'img/noimage.png'}}">
    	
      	</div>
 	</div>


<div class="row text-center mt-4 mb-3">
	<div class="col-12 " ><h1 class="titleSocis">Sponsors</h1></div>
</div>
	<div class="row mb-3">
			<div class="col-2"></div>
			<div class="col">
				<div class="row">
					<div class="col-lg-3 text-center" ng-repeat="sponsor in sponsorsFiramar">
						<img class="img-fluid rounded img-thumbnail mt-3" ng-src="{{sponsor.logoSponsor!=''?'../img/sponsors/'+sponsor.logoSponsor:'../img/noimage.png'}}">
					</div>
				</div>
			</div>
			<div class="col-2"></div>
		</div>

	<!-- <div class="row justify-content-center offset-2">
		<div class="col-lg-2 " ng-repeat="sponsor in sponsorsFiramar">
		
			<img class="rounded img-thumbnail img-fluid" ng-src="{{sponsor.logoSponsor!=''?'../img/sponsors/'+sponsor.logoSponsor:'../img/noimage.png'}}">
		
		</div>
	</div> -->

</div>


<button id="goTop" class="goToTop" value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline ">Pujar</span>
		<img ng-src="img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>
  


