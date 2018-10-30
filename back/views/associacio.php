<div class="AssAllCss">
	<div class="AssTituCss">Dades Associació:</div>
	<!-- <div>{{msj}}</div> -->
	<form ng-submit="submitAss()">
	 	<div class="form-row">
			<div class="form-group col-md-8">
	      		<label for="nomAss">Nom i Cognom</label>
	      		<input type="text" class="form-control" ng-model="ass.nom" id="nomAss" placeholder="nom">
	    	</div>
	    	<div class="form-group col-md-4">
	      		<label for="telefonAss">Telèfon</label>
	      		<input type="number" class="form-control" ng-model="telf.nom" id="telefonAss" placeholder="número de telèfon">
	    	</div>
	    	<div class="form-group col-md-5">
		      	<label for="facebookAss">Facebook</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<span class="input-group-text " id="facebookAss"><i class="fab fa-facebook-square FacebookAssCss"></i></span>
	        			</div>
	        			<input type="text" class="form-control" ng-model="telf.facebook" id="facebookAss" placeholder="facebook">
	      			</div>
		    </div>
		    <div class="form-group col-md-7">
		      <label for="URLWebAss">URL de la Web</label>
		      <input type="text" class="form-control" id="URLWebAss" ng-model="telf.URLWeb" placeholder="URL">
		    </div>
		    <div class="form-group col-md-6">
		      	<label for="emailAss">Correu Electronic</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<span class="input-group-text " id="emailAss"><i class="fas fa-at mx-2"></i></span>
	        			</div>
	        			<input type="email" class="form-control" ng-model="telf.email" id="emailAss" placeholder="correu electronic">
	      			</div>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="passwordAss">Password</label>
		      <input type="password" class="form-control" id="passwordAss" ng-model="telf.password" placeholder="contrasenya">
		    </div>
		    <div class="form-group col-6">
		      	<label for="horariAss">Horari</label>
		      	<textarea class="form-control textareaHorariAss" ng-model="telf.horari" id="horariAss" placeholder="horari"></textarea>
		    </div>
		    <div class="form-group col-2">
		      <label for="latitudAss">Latitud</label>
		      <input type="number" class="form-control" ng-model="telf.latitud" id="latitudAss"  placeholder="latitud">
		    </div>
		    <div class="form-group col-2">
		      <label for="longitudAss">Longitud</label>
		      <input type="number" class="form-control" ng-model="telf.longitud" id="longitudAss" placeholder="longitud">
		    </div>
		    <div class="form-group col-2">
		      <label for="keyApiAss">API Key</label>
		      <input type="text" class="form-control" id="keyApiAss" ng-model="telf.keyApi" placeholder="key Api">
		    </div>
			<div class="form-group col-12">
		    	<label for="ExplicacioAss">Explicació</label>
		    	<textarea class="form-control textareaQuiSomAss" ng-model="telf.quiSom" id="ExplicacioAss" placeholder="explicació"></textarea>
	  		</div>	
	  		<div class="form-group col-12">
	    		<label for="equipAss">Equip Administratiu</label>
	    		<textarea class="form-control textareaLGPDAss" ng-model="telf.equip" id="equipAss" placeholder="equip"></textarea>
	  		</div>
	  		<div class="form-group col-12">
	    		<label for="LGPDAss">LGPD</label>
	    		<textarea class="form-control textareaLGPDAss" ng-model="telf.LGPD" id="LGPDAss" placeholder="LGPD"></textarea>
	  		</div>
	<!-- 	</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-lg-2 offset-lg-2">
		      <div class="form-row">
		        <div class="form-group col-12">
		          <label for="inputLogo" class="col-12">Logo de la Vila</label>
		          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.logoVila!='' ? '../img/'+ass.logoVila : '../img/noimage.png'}}" alt="">
		        </div>
		        <div class="form-group col-12">
		          <label for="btnExLogo" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
		          <input type="file" id="btnExLogo" name="btnExLogo" onchange="angular.element(this).scope().getFileDetails(this,'logoVila')" ng-show="false"/>
		        </div>
		      </div>  
		    </div>
		    <div class="form-group col-md-6 col-lg-2">
		      <div class="form-row">
		        <div class="form-group col-12">
		          <label for="inputLogo" class="col-12">Logo de la Bolsa</label>
		          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.logoBolsa!='' ? '../img/'+ass.logoBolsa : '../img/noimage.png'}}" alt="">
		        </div>
		        <div class="form-group">
		          <label for="btnExLogo" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
		          <input type="file" id="btnExLogo" name="btnExLogo" onchange="angular.element(this).scope().getFileDetails(this,'logoBolsa')" ng-show="false"/>
		        </div>
		      </div>  
		    </div>
	    	<div class="form-group col-md-6 col-lg-2">
		      <div class="form-row">
		        <div class="form-group col-12">
		          <label for="inputFavIcon" class="col-12">Imatge pestanya de la pàgina</label>
		          <img class="img-fluid imgCssColla col-10" ng-src="{{ass.favIcon!='' ? '../img/'+ass.favIcon : '../img/noimage.png'}}" alt="">
		        </div>
		        <div class="form-group col-12">
		          <label for="btnExFavIcon" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
		          <input type="file" id="btnExFavIcon" name="btnExFavIcon" onchange="angular.element(this).scope().getFileDetails(this,'favIcon')" ng-show="false"/>
		        </div>
		      </div>  
		    </div>
		</div>
		<input type="button" class="btn btn-primary" ng-click="submit()" value="Guardar canvis"> -->
	</form>
</div>	