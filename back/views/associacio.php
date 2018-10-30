<div class="AssAllCss">
  	<div class="AssTituCss">Dades Associació:</div>
	<!-- <div>{{msj}}</div> -->
	<form name="formAss" ng-submit="submitAss()">
	 	<div class="form-row">
			<div class="form-group col-md-8" ng-class="{ 'has-error' : formAss.nomAss.$invalid && !formAss.nomAss.$pristine }">
	      		<label for="nomAss">Nom i Cognom</label>
	      		<input type="text" class="form-control" ng-model="ass.nom" id="nomAss" placeholder="nom" name="nomAss">
	    	</div>
	    	<div class="form-group col-md-4" ng-class="{ 'has-error' : formAss.telefonAss.$invalid && !formAss.telefonAss.$pristine }">
	      		<label for="telefonAss">Telèfon</label>
	      		<input type="number" class="form-control" ng-model="ass.telf" id="telefonAss" placeholder="número de telèfon">
	    	</div>
	    	<div class="form-group col-md-5" ng-class="{ 'has-error' : formAss.facebookAss.$invalid && !formAss.facebookAss.$pristine }">
		      	<label for="facebookAss">Facebook</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<span class="input-group-text " id="facebookAss"><i class="fab fa-facebook-square FacebookAssCss"></i></span>
	        			</div>
	        			<input type="text" class="form-control" ng-model="ass.facebook" id="facebookAss" placeholder="facebook">
	      			</div>
		    </div>
		    <div class="form-group col-md-7" ng-class="{ 'has-error' : formAss.URLWebAss.$invalid && !formAss.URLWebAss.$pristine }">
		      <label for="URLWebAss">URL de la Web</label>
		      <input type="text" class="form-control" id="URLWebAss" ng-model="ass.URLWeb" placeholder="URL">
		    </div>
		    <div class="form-group col-md-6" ng-class="{ 'has-error' : formAss.emailAss.$invalid && !formAss.emailAss.$pristine }">
		      	<label for="emailAss">Correu Electronic</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<span class="input-group-text " id="emailAss"><i class="fas fa-at mx-2"></i></span>
	        			</div>
	        			<input type="email" class="form-control" ng-model="ass.email" id="emailAss" placeholder="correu electronic">
	      			</div>
		    </div>
		    <div class="form-group col-md-6" ng-class="{ 'has-error' : formAss.passwordAss.$invalid && !formAss.passwordAss.$pristine }">
		      <label for="passwordAss">Password</label>
		      <input type="password" class="form-control" id="passwordAss" ng-model="ass.password" placeholder="contrasenya">
		    </div>
		    <div class="form-group col-6" ng-class="{ 'has-error' : formAss.horariAss.$invalid && !formAss.horariAss.$pristine }">
		      	<label for="horariAss">Horari</label>
		      	<textarea class="form-control textareaHorariAss" ng-model="ass.horari" id="horariAss" placeholder="horari"></textarea>
		    </div>
		    <div class="form-group col-2" ng-class="{ 'has-error' : formAss.latitudAss.$invalid && !formAss.latitudAss.$pristine }">
		      <label for="latitudAss">Latitud</label>
		      <input type="number" class="form-control" ng-model="ass.latitud" id="latitudAss"  placeholder="latitud">
		    </div>
		    <div class="form-group col-2" ng-class="{ 'has-error' : formAss.longitudAss.$invalid && !formAss.longitudAss.$pristine }">
		      <label for="longitudAss">Longitud</label>
		      <input type="number" class="form-control" ng-model="ass.longitud" id="longitudAss" placeholder="longitud">
		    </div>
		    <div class="form-group col-2" ng-class="{ 'has-error' : formAss.keyApiAss.$invalid && !formAss.keyApiAss.$pristine }">
		      <label for="keyApiAss">API Key</label>
		      <input type="text" class="form-control" id="keyApiAss" ng-model="ass.keyApi" placeholder="key Api">
		    </div>
			<div class="form-group col-12" ng-class="{ 'has-error' : formAss.ExplicacioAss.$invalid && !formAss.ExplicacioAss.$pristine }">
		    	<label for="ExplicacioAss">Explicació</label>
		    	<textarea class="form-control textareaQuiSomAss" ng-model="ass.quiSom" id="ExplicacioAss" placeholder="explicació"></textarea>
	  		</div>	
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.equipAss.$invalid && !formAss.equipAss.$pristine }">
	    		<label for="equipAss">Equip Administratiu</label>
	    		<textarea class="form-control textareaLGPDAss" ng-model="ass.equip" id="equipAss" placeholder="equip"></textarea>
	  		</div>
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.LGPDAss.$invalid && !formAss.LGPDAss.$pristine }">
	    		<label for="LGPDAss">LGPD</label>
	    		<textarea class="form-control textareaLGPDAss" ng-model="ass.LGPD" id="LGPDAss" placeholder="LGPD"></textarea>
	  		</div>
	  	<button type="submit" class="btn btn-info" ng-disabled="formAss.$invalid">Guardar Canvis</button>
	</form>
<!-- 	</div>
	<div class="form-row">
		<div class="form-group col-md-6 col-lg-2 offset-lg-2">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputLogo" class="col-12">Logo de la Vila</label>
	          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.logoVila!='' ? '../img/'+ass.logoVila : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12" >
	          <label for="btnExLogo" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnVilaLogo" name="btnExLogo" onchange="angular.element(this).scope().getFileDetails(this,'logoVila')" ng-show="false"/>
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
	</div>-->
</div>	