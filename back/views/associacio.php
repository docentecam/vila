<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
	?>
<div class="AssNotiAllCss" >
	
  	<h4 id="divTop" class="AssTituCss">Dades Associació:</h4>
	<form name="formAss" ng-submit="submitAss()" novalidate>
	 	<div class="form-row">
			<div class="form-group col-md-8" ng-class="{ 'has-error' : formAss.nomAss.$invalid && !formAss.nomAss.$pristine }">
	      		<label for="nomAss">Nom i Cognom</label>
	      		<input type="text" class="form-control" ng-model="ass.nom" id="nomAss" placeholder="nom" name="nomAss" required>
	    	</div>
	    	<div class="form-group col-md-4" ng-class="{ 'has-error' : formAss.telefonAss.$invalid && !formAss.telefonAss.$pristine }">
	      		<label for="telefonAss">Telèfon</label>
	      		<input type="text" class="form-control" ng-model="ass.telf" id="telefonAss" placeholder="número de telèfon" required>

	    	</div>
	    	<div class="form-group col-md-5" ng-class="{ 'has-error' : formAss.facebookAss.$invalid && !formAss.facebookAss.$pristine }">
		      	<label for="facebookAss">Facebook</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<p class="input-group-text " id="facebookAss"><i class="fab fa-facebook-square FacebookAssCss"></i></p>
	        			</div>
	        			<input type="text" class="form-control" ng-model="ass.facebook" id="facebookAss" placeholder="facebook" required>
	      			</div>
		    </div>
		    <div class="form-group col-md-7" ng-class="{ 'has-error' : formAss.URLWebAss.$invalid && !formAss.URLWebAss.$pristine }">
		      <label for="URLWebAss">URL de la Web</label>
		      <input type="text" class="form-control" id="URLWebAss" ng-model="ass.URLWeb" placeholder="URL" required>
		    </div>
		    <div class="form-group col-md-6" ng-class="{ 'has-error' : formAss.emailAss.$invalid && !formAss.emailAss.$pristine }">
		      	<label for="emailAss">Correu Electronic</label>
		      		<div class="input-group">
	        			<div class="input-group-prepend">
	          				<p class="input-group-text " id="emailAss"><i class="fas fa-at mx-2"></i></p>
	        			</div>
	        			<input type="email" class="form-control" ng-model="ass.email" id="emailAss" placeholder="correu electronic" required>
	      			</div>
		    </div>
			<div class="form-group col-md-6" ng-class="{ 'has-error' : formAss.txtPass.$invalid && !formAss.txtPass.$pristine }">
					<label for="txtPass">Password</label>
				<div class="input-group">
			      		<input type="password" class="form-control" id="txtPass" ng-model="ass.pasMail" placeholder="contrasenya" required>
			    	<div class="input-group-append">
			      		<span class="input-group-text" id="inputGroupPrepend" ng-click="showPassAss()"><i class="far fa-eye cursor" ng-hide="hidePass" title="Ocultar contrasenya"></i><i class="far fa-eye-slash cursor" ng-show="hidePass" title="Mostrar contrasenya"></i></span>
			    	</div>
				</div>
			</div> 	
		    <div class="form-group col-md-6 col-sm-12" ng-class="{ 'has-error' : formAss.horariAss.$invalid && !formAss.horariAss.$pristine }">
		      	<label for="horariAss">Horari</label>
		      	<textarea class="form-control textareaHorariAss" ng-model="ass.horari" id="horariAss" placeholder="horari" required></textarea>
		    </div>
		    <div class="form-group col-lg-2 col-md-3 col-sm-12" ng-class="{ 'has-error' : formAss.latitudAss.$invalid && !formAss.latitudAss.$pristine }">
		      <label for="latitudAss">Latitud</label>
		      <input type="text" class="form-control" ng-model="ass.latitud" id="latitudAss"  placeholder="latitud" required>
		    </div>
		    <div class="form-group col-lg-2 col-md-3 col-sm-12" ng-class="{ 'has-error' : formAss.longitudAss.$invalid && !formAss.longitudAss.$pristine }">
		      <label for="longitudAss">Longitud</label>
		      <input type="text" class="form-control" ng-model="ass.longitud" id="longitudAss" placeholder="longitud" required>
		    </div>
		    <div class="form-group col-lg-2 col-sm-12" ng-class="{ 'has-error' : formAss.keyApiAss.$invalid && !formAss.keyApiAss.$pristine }">
		      <label for="keyApiAss">API Key</label>
		      <input type="text" class="form-control" id="keyApiAss" ng-model="ass.keyApi" placeholder="key Api" required>
		    </div>
			<div class="form-group col-12" ng-class="{ 'has-error' : formAss.ExplicacioAss.$invalid && !formAss.ExplicacioAss.$pristine }">
		    	<label for="ExplicacioAss">Explicació</label>
		    	<textarea class="form-control textarea" ng-model="ass.quiSom" id="ExplicacioAss" placeholder="explicació" required></textarea>
	  		</div>	
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.equipAss.$invalid && !formAss.equipAss.$pristine }">
	    		<label for="equipAss">Equip Administratiu</label>
	    		<textarea class="form-control textarea" ng-model="ass.equip" id="equipAss" placeholder="equip" required></textarea>
	  		</div>
	  		<div class="form-group col-12" ng-class="{ 'has-error' : formAss.LGPDAss.$invalid && !formAss.LGPDAss.$pristine }">
	    		<label for="LGPDAss">LGPD</label>
	    		<textarea class="form-control textarea" ng-model="ass.LGPD" id="LGPDAss" placeholder="LGPD" required></textarea>
	  		</div>
	  		
	  	<button type="submit" class="btn btn-info" ng-disabled="formAss.$invalid" value="submit-true" formmethod="post">Guardar Canvis</button>
	</div>
	<div id="divMissatge" class="col-6 offset-3 text-center alert alert-success" ng-show="cargaMsj">
		{{msj}}
	</div>	
	</form>
	<div class="form-row">
		<div class="col-lg-1"></div>
		<div class="form-group col-md-6 col-lg text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputLogoVilaAss" class="col-12 mt-2">Logo de la Vila</label>
	          <img class="col-10 img-fluid" ng-src="{{ass.logoVila!='' ? '../img/'+ass.logoVila : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12 EspacioAgregarImgLogoVila" >
	          <label for="btnVilaLogoAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<br><i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnVilaLogoAss" name="btnVilaLogoAss" onchange="angular.element(this).scope().getFileDetails(this,'logoVila')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
	    <div class="form-group col-md-6 col-lg-2 text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputCabeceraAss" class="col-12 mt-2">Capçalera Associacio</label>
	          <img class="img-fluid col-10" ng-src="{{ass.cabeceraAssociacio!='' ? '../img/'+ass.cabeceraAssociacio : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12 AgregarImgCabeceraCssAss">
	          <label for="btnCabeceraAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<br><i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnCabeceraAss" name="btnCabeceraAss" onchange="angular.element(this).scope().getFileDetails(this,'cabeceraAssociacio')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
	    <div class="form-group col-md-6 col-lg-2 text-center">
	      <div class="form-row">
	        <div class="form-group col-12">
	          <label for="inputLogoBolsaAss" class="col-12 mt-2">Logo de la bossa</label>
	          <img class="img-fluid col-10" ng-src="{{ass.logoBolsa!='' ? '../img/'+ass.logoBolsa : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12 EspacioAgregarImgLogoYFavicon">
	          <label for="btnBolsaLogoAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<br><i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnBolsaLogoAss" name="btnBolsaLogoAss" onchange="angular.element(this).scope().getFileDetails(this,'logoBolsa')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
    	<div class="form-group col-md-6 col-lg-2 text-center">
	      <div class="form-row">
	        <div class="form-group col-12 ">
	          <label for="inputFavIconAss" class="col-12 mt-2">Imatge pestanya</label>
	          <img class="img-fluid col-10" ng-src="{{ass.favIcon!='' ? '../img/'+ass.favIcon : '../img/noimage.png'}}" alt="">
	        </div>
	        <div class="form-group col-12 EspacioAgregarImgLogoYFavicon">
	          <label for="btnFavIconAss" class="col-12 text-primary cursor align-self-end"><u>Cambiar Imatge</u>&nbsp;<br><i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
	          <input type="file" id="btnFavIconAss" name="btnFavIconAss" onchange="angular.element(this).scope().getFileDetails(this,'favIcon')" ng-show="false"/>
	        </div>
	      </div>  
	    </div>
	    <div class="col-lg-1"></div>

	</div>
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
	</button>
</div>	