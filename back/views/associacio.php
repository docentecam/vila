<div class="AssNotiAllCss" id="divTop">
  	<div class="AssTituCss">Dades Associació:</div>
	<div>{{msj}}</div>
	<form name="formAss" ng-submit="submitAss()">
	 	<div class="form-row">
			<div class="form-group col-md-8" ng-class="{ 'has-error' : formAss.nomAss.$invalid && !formAss.nomAss.$pristine }">
	      		<label for="nomAss">Nom i Cognom</label>
	      		<input type="text" class="form-control" ng-model="ass.nom" id="nomAss" placeholder="nom" name="nomAss">
	    	</div>
	    	<div class="form-group col-md-4" ng-class="{ 'has-error' : formAss.telefonAss.$invalid && !formAss.telefonAss.$pristine }">
	      		<label for="telefonAss">Telèfon</label>
	      		<input type="text" class="form-control" ng-model="ass.telf" id="telefonAss" placeholder="número de telèfon">

	    	</div>
	    	<div class="form-group col-md-5" ng-class="{ 'has-error' : formAss.facebookAss.$invalid && !formAss.facebookAss.$pristine }">
		      	<label for="facebookAss">Facebook</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<p class="input-group-text " id="facebookAss"><i class="fab fa-facebook-square FacebookAssCss"></i></p>
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
	          				<p class="input-group-text " id="emailAss"><i class="fas fa-at mx-2"></i></p>
	        			</div>
	        			<input type="email" class="form-control" ng-model="ass.email" id="emailAss" placeholder="correu electronic">
	      			</div>
		    </div>
			<div class="form-group col-md-6" ng-class="{ 'has-error' : formAss.txtPass.$invalid && !formAss.txtPass.$pristine }">
					<label for="txtPass">Password</label>
				<div class="input-group">
			      		<input type="password" class="form-control" id="txtPass" ng-model="ass.pasMail" placeholder="contrasenya">
			    	<div class="input-group-append">
			      		<span class="input-group-text" id="inputGroupPrepend" ng-click="showPassAss()"><i class="far fa-eye cursor"></i></span>
			    	</div>
				</div>
			</div> 	
		    <div class="form-group col-6" ng-class="{ 'has-error' : formAss.horariAss.$invalid && !formAss.horariAss.$pristine }">
		      	<label for="horariAss">Horari</label>
		      	<textarea class="form-control textareaHorariAss" ng-model="ass.horari" id="horariAss" placeholder="horari"></textarea>
		    </div>
		    <div class="form-group col-2" ng-class="{ 'has-error' : formAss.latitudAss.$invalid && !formAss.latitudAss.$pristine }">
		      <label for="latitudAss">Latitud</label>
		      <input type="text" class="form-control" ng-model="ass.latitud" id="latitudAss"  placeholder="latitud">
		    </div>
		    <div class="form-group col-2" ng-class="{ 'has-error' : formAss.longitudAss.$invalid && !formAss.longitudAss.$pristine }">
		      <label for="longitudAss">Longitud</label>
		      <input type="text" class="form-control" ng-model="ass.longitud" id="longitudAss" placeholder="longitud">
		    </div>
		    <div class="form-group col-lg-2 col-sm-12" ng-class="{ 'has-error' : formAss.keyApiAss.$invalid && !formAss.keyApiAss.$pristine }">
		      <label for="keyApiAss">API Key</label>
		      <input type="text" class="form-control" id="keyApiAss" ng-model="ass.keyApi" placeholder="key Api">
		    </div>
			<div class="form-group col-12" ng-class="{ 'has-error' : formAss.ExplicacioAss.$invalid && !formAss.ExplicacioAss.$pristine }">
		    	<label for="ExplicacioAss">Explicació</label>
		    	<textarea class="form-control textarea" ng-model="ass.quiSom" id="ExplicacioAss" placeholder="explicació"></textarea>
	  		</div>	
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.equipAss.$invalid && !formAss.equipAss.$pristine }">
	    		<label for="equipAss">Equip Administratiu</label>
	    		<textarea class="form-control textarea" ng-model="ass.equip" id="equipAss" placeholder="equip"></textarea>
	  		</div>
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.LGPDAss.$invalid && !formAss.LGPDAss.$pristine }">
	    		<label for="LGPDAss">LGPD</label>
	    		<textarea class="form-control textarea" ng-model="ass.LGPD" id="LGPDAss" placeholder="LGPD"></textarea>
	  		</div>
	  	<button type="submit" class="btn btn-info" ng-disabled="formAss.$invalid" value="submit-true" formmethod="post">Guardar Canvis</button>
	</div>	
	</form>
	<div class="form-row">
		<div class="form-group col-md-6 col-lg-3 offset-lg-1 text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputLogoVilaAss" class="col-12 mt-2">Logo de la Vila</label>
	          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.logoVila!='' ? '../img/'+ass.logoVila : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12" >
	          <label for="btnVilaLogoAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnVilaLogoAss" name="btnVilaLogoAss" onchange="angular.element(this).scope().getFileDetails(this,'logoVila')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
	    <div class="form-group col-md-6 col-lg-3 text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputLogoBolsaAss" class="col-12 mt-2">Logo de la Bolsa</label>
	          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.logoBolsa!='' ? '../img/'+ass.logoBolsa : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12">
	          <label for="btnBolsaLogoAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnBolsaLogoAss" name="btnBolsaLogoAss" onchange="angular.element(this).scope().getFileDetails(this,'logoBolsa')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
    	<div class="form-group col-md-6 col-lg-3 text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputFavIconAss" class="col-12 mt-2">Imatge pestanya</label>
	          <img class="img-fluid imgCssAss col-10" ng-src="{{ass.favIcon!='' ? '../img/'+ass.favIcon : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12">
	          <label for="btnFavIconAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnFavIconAss" name="btnFavIconAss" onchange="angular.element(this).scope().getFileDetails(this,'favIcon')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
	</div>
	<!-- <button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button> -->
</div>	