<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
 <div ng-show="llistatComer" >
	<div id="divTop" class="row text-center mt-4 mb-3 titleSocis" ng-if="(socis | filter:{'activo':'S'}).length!=0">
		<h1 class="col">Llistat d'Associats actius</h1>
	</div>
	<div class="row">
		<a class=" fas fa-plus-square iconSize mb-3 col-1 offset-lg-1" title="Afegir nou comerç" ng-href="#/newComerc"></a>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-xl-10 offset-xl-1 text-center tablaSocis" ng-if="(directoris | filter:{'activo':'S'}).length!=0">
			<tr>
				<th class="cursor" ng-click="columnOrder('nomAssociat')">Nom del Comerç</th>
				<th class="cursor" ng-click="columnOrder('nomCategoria')">Categoria Principal</th>
				<th class="cursor" ng-click="columnOrder('adreca')">Adreça</th>
				<th>Telèfon 1</th>
				<th>Telèfon 2</th>
				<th>Whatsapp</th>
				<th class="cursor" ng-click="columnOrder('email')">Correu electrònic</th>
				<th>Horari</th>
				<th>Pàgina Web</th>
				<th>Accions</th>
			</tr>
			<tr ng-repeat="directori in directoris | orderBy:order | filter:{'activo':'S'}">
				
				<td>{{directori.nomAssociat}}</td>
				<td>{{directori.nomCategoria}}</td>
				<td>{{directori.adreca}}</td>
				<td>{{directori.telf1}}<span ng-if="directori.telf1=='' || directori.telf1==null">---</span></td>
				<td>{{directori.telf2}}<span ng-show="directori.telf2=='' || directori.telf2==null">---</span></td>
				<td>{{directori.whatsapp}}<span ng-show="directori.whatsapp=='' || directori.whatsapp==null">---</span><a ng-href="https://api.whatsapp.com/send?phone=34{{directori.whatsapp}}" class="fab fa-whatsapp ml-2 iconSize whats rounded" target="_blank" title="Enviar whatsapp" ng-show="directori.whatsapp!='' && directori.whatsapp!=null"></a></td>
				<td><span ng-show="directori.email=='' || directori.email==null">---</span><a class="emailTableCss" ng-href="mailto:{{soci.mail}}" target="_blank" title="Enviar correu">{{directori.email}}</a></td>
				<td>{{directori.horari}}</td>
				<td>{{directori.URLWeb}}</td>
				<td><a class="far fa-edit text-dark iconSize" ng-href="#/directori/{{directori.idAssociat}}" title="Editar les dades del comerç"></a><i class="fas fa-power-off fontAweX mx-2 mx-md-4 iconSize" ng-click="offOn(directori.idAssociat,'N')" title="Donar de baixa"></i>  </td>
			</tr>
		</table>	
	</div>
	<div class="row text-center mt-5 mb-3 titleSocis" ng-if="(directoris | filter:{'activo':'N'}).length!=0">
		<h1 class="col">Llistat d'Associats inactius</h1>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-xl-10 offset-xl-1 text-center tablaSocis" ng-if="(directoris | filter:{'activo':'N'}).length!=0">
			<tr>
				<th class="cursor" ng-click="columnOrder('nomAssociat')">Nom del Comerç</th>
				<th>Telèfon 1</th>
				<th>Telèfon 2</th>
				<th>Whatsapp</th>
				<th class="cursor" ng-click="columnOrder('email')">Correu electrònic</th>
				<th>Accions</th>
			</tr>
			<tr ng-repeat="directori in directoris | orderBy:order | filter:{'activo':'N'}">
				
				<td>{{directori.nomAssociat}}</td>
				<td>{{directori.telf1}}</td>
				<td>{{directori.telf2}}<span ng-show="directori.telf2==''">---</span></td>
				<td>{{directori.whatsapp}}<span ng-show="directori.whatsapp==''">---</span><a ng-href="https://api.whatsapp.com/send?phone=34{{directori.whatsapp}}" class="fab fa-whatsapp ml-2 iconSize whats rounded" target="_blank" title="Enviar whatsapp" ng-show="directori.whatsapp!=''"></a></td>
				<td>{{directori.email}}<span ng-show="directori.email==''">---</span></td>
				<td><i class="fas fa-power-off fontAweCheck iconSize" ng-click="offOn(directori.idAssociat,'S')" title="Donar d'alta"></i>  </td>
			</tr>
		</table>	
	</div>
 </div>


 <div ng-hide="dadesComerc">
 	<div class="row">
		<a ng-href="#/directori" class="mt-2 col-4 offset-lg-2" >
			<h5 class="fas fa-angle-double-left text-info">Tornar al directori</h5>
		</a>
	</div>
	<div id="upTop" class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Dades del associat {{com.nomAssociat}}</h1>
	</div>
	
	<div class="row">
	 	<form id="formVila" name="formVila" class="col-12">
	 		<div class="form-row">
				<div class="form-group col-md-6 col-lg-2 offset-lg-5">
				    <div class="form-row">
				        <div class="form-group col-12">
				        	<label for="inputFoto" class="col-12">Logo del comerç (mida de 155x155px)</label>
				        	<img class="img-fluid imgCssLogoDir col-10" ng-src="{{com.logoAssociat!='' ? '../img/associats/'+com.logoAssociat : '../img/noimage.png'}}" alt="">
				        </div>
				        <div class="form-group col-12">
				            <label for="btnExVila" class="cursor text-primary col-12 "><u>Examinar</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
				            <input type="file" id="btnExVila" class="align-self-end" name="btnExVila"  onchange="angular.element(this).scope().getFileDetails(this,'logoAssociat')" ng-show="false"/>
				        </div>
				    </div>    
				</div>
			</div> 
			<div class="form-row">
			    <div class="form-group col-md-6 col-lg-4 offset-lg-2">
			   		<label for="txtNom">Nom Associat</label>
			    	<input type="text" class="form-control" id="txtNom" ng-model="com.nomAssociat" maxlength="50">
			    </div>
			    <div class="form-group col-md-6 col-lg-4">
			    	<label for="inputAdre">Adreça</label>
			    	<input type="text" class="form-control" id="inputAdre" ng-model="com.adreca" maxlength="150">
			    </div>
			</div>
			<div class="form-row">
				<div class="col-lg-1 offset-lg-1"></div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputTelf1">Telèfon 1</label>
			    	<input type="number" class="form-control" id="inputTelf1" ng-model="com.telf1" maxlength="9">
			    </div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputTelf2">Telèfon 2</label>
			    	<input type="number" class="form-control" id="inputTelf2" ng-model="com.telf2" maxlength="9">
			    </div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputWhats">Whatsapp</label>
			    	<input type="number" class="form-control" id="inputWhats" ng-model="com.whatsapp" maxlength="9">
			    </div>
			    <div class="col-lg-2"></div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3 col-lg-2 offset-lg-2">
					<label for="inputMail">Correu Electronic</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text " id="inputGroupPrepend"><p class="fas fa-at mx-2 my-2"></p></span>
						</div>
						<input type="email" class="form-control" id="inputMail" ng-model="com.email" maxlength="150">
			    	</div>
			    </div>
			    <div class="form-group col-md-6 col-lg-3">
			    	<label for="inputFace">Facebook</label>
			    	<input type="text" class="form-control" id="inputFace" ng-model="com.facebook" maxlength="100">
			    </div>
			    <div class="form-group col-md-6 col-lg-3">
			    	<label for="inputURL">Enllaç pàgina Web</label>
			    	<input type="text" class="form-control" id="inputURL" ng-model="com.URLWeb" maxlength="100">
			    </div>
			</div>
			<div class="form-row">
			    <div class="form-group col-md-3 col-lg-4 offset-lg-2">
			    	<label for="inputLat">Latitud</label>
			    	<input type="text" class="form-control" id="inputLat" ng-model="com.latitud" maxlength="9">
			    </div>
			    <div class="form-group col-md-3 col-lg-4">
			    	<label for="inputLong">Longitud</label>
			    	<input type="text" class="form-control" id="inputLong" ng-model="com.longitud" maxlength="9">
			    </div>
			</div>
			<div class="form-row">
			    <div class="form-group col-12 col-lg-8 offset-lg-2">
			    	<label for="inputHorari">Horari Comerç</label>
			       	<textarea class="form-control textarea" id="inputHorari" ng-model="com.horari" ></textarea>
			    </div>
			    <div class="form-group col-12 col-lg-8 offset-lg-2">
			    	<label for="inputDesc">Descripció Comerç</label>
			       	<textarea class="form-control textarea" id="inputDesc" ng-model="com.txtAssociat" ></textarea>
			    </div>
			</div>
			<div class="form-row mb-3">
				<label class="col-12 col-lg-8 offset-lg-2">Categoria Principal</label>
				<select class="form-control col-12 col-lg-8 offset-lg-2" name="selCatPrin" id="selCatPrin" ng-model="com.categoriaPrinc" ng-change="UpdateCatPrin()">
					<option value="-1">---Selecciona categoria principal---</option>
					<option ng-repeat="categ in categories" ng-selected="com.categoriaPrinc==categ.idCategoria" ng-value="categ.idCategoria">{{categ.nomCategoria}}</option>
				</select>
			</div>
			<input type="button" id="buttonSave" class="btn btn-info offset-lg-2" ng-click="guardar()" value="Guardar canvis">
		</form>
		<div id="divMissatge" ng-show="divMsj" class="col-6 offset-3 text-center alert alert-success">{{msj}}</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 col-lg-2 offset-lg-2">
			<table>
				<tr>
					<th>Categories no principals</th>
				</tr>
			<tr ng-repeat="categoria in listCatNotPrinc | orderBy:'nomCategoria'">
				<td>
					<i class="fas fa-genderless mr-2"></i>
					{{categoria.nomCategoria}}
				</td>
				<td>
					<i class="fas fa-times text-danger iconSize ml-3 my-2" ng-click="delete(categoria.idCategoria)"></i>
				</td>
			</tr>
			
			</table>
		</div>
		<select class="form-control col-12 col-lg-6" name="selCatPrin" id="selCatPrin" ng-model="com.categoriaNotPrinc" ng-change="afegirCateg()">
			<option value="-1">---Afegeix una categoria no principal---</option>
			<option ng-repeat="categoria in categNotPrinc" ng-selected="com.categoriaNotPrinc==categoria.idCategoria" ng-value="categoria.idCategoria">{{categoria.nomCategoria}}</option>
		</select>
		<div ng-show="divMsj" class="col-6 offset-3 text-center alert alert-success">{{msj}}</div>
	</div>
	<div class="row mt-3">
		<h2 class="col-12 col-lg-8 offset-lg-2">Galeria</h2>


		<label for="insertImg" class="cursor col-12 offset-md-2">
			<i class=" fas fa-plus-square iconSize mb-3" title="Afegeix imatges"></i>
		</label>
		<input type="file" id="insertImg" class="align-self-end" name="insertImg" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().uploadGaleria(this)" ng-show="false"/>


		<div class="card-columns col-12 col-lg-8 offset-lg-2">
			<div class="card text-center" ng-repeat="galeria in galeriaAssociats">
				<img class="card-img-top img-fluid" ng-src="{{galeria.fotoGaleria!='' ? '../img/galeriaassociats/'+galeria.fotoGaleria : '../img/noimage.png'}}" alt="{{galeria.descripcio}}">
				<input type="button" class="btn btn-danger" value="Eliminar" ng-click="deleteImg(galeria.idGaleria)">
			</div>
		</div>
	</div>	
</div>


<div ng-hide="afegirComerc">
	<div class="row">
		<a ng-href="#/directori" class="col-2 offset-lg-2" >
			<h5 class="fas fa-angle-double-left text-info">Tornar al direcotri</h5>
		</a>
	</div>
 	<div id="divUpTop" class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Nou associat</h1>
	</div>
	<div class="row">
	 	<form id="formVila" name="formVila" class="col-12">
			<div class="form-row">
			    <div class="form-group col-md-6 col-lg-4 offset-lg-2">
			   		<label for="txtNom">Nom Associat</label>
			    	<input type="text" class="form-control" id="txtNom" ng-model="asso.nomAssociat" ng-init="asso.nomAssociat=''" maxlength="50" ng-blur="verificar()">
			    </div>
			    <div class="form-group col-md-6 col-lg-4">
			    	<label for="inputAdre">Adreça</label>
			    	<input type="text" class="form-control" id="inputAdre" ng-model="asso.adreca" ng-init="asso.adreca=''" maxlength="150" ng-blur="verificar()">
			    </div>
			</div>
			<div class="form-row">
				<div class="col-lg-1 offset-lg-1"></div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputTelf1">Telèfon 1</label>
			    	<input type="number" class="form-control" id="inputTelf1" ng-model="asso.telf1" ng-init="asso.telf1=''" maxlength="9" ng-blur="verificar()">
			    </div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputTelf2">Telèfon 2</label>
			    	<input type="number" class="form-control" id="inputTelf2" ng-model="asso.telf2" ng-init="asso.telf2=''" maxlength="9" ng-blur="verificar()">
			    </div>
			    <div class="form-group col-md-2 col-lg">
			   		<label for="inputWhats">Whatsapp</label>
			    	<input type="number" class="form-control" id="inputWhats" ng-model="asso.whatsapp" ng-init="asso.whatsapp=''" maxlength="9" ng-blur="verificar()">
			    </div>
			    <div class="col-lg-2"></div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3 col-lg-2 offset-lg-2">
					<label for="inputMail">Correu Electronic</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text " id="inputGroupPrepend"><p class="fas fa-at mx-2 my-2"></p></span>
						</div>
						<input type="email" class="form-control" id="inputMail" ng-model="asso.email" ng-init="asso.email=''" maxlength="150" ng-blur="verificar()">
			    	</div>
			    </div>
			    <div class="form-group col-md-6 col-lg-3">
			    	<label for="inputFace">Facebook</label>
			    	<input type="text" class="form-control" id="inputFace" ng-model="asso.facebook" ng-init="asso.facebook=''" maxlength="100" ng-blur="verificar()">
			    </div>
			    <div class="form-group col-md-6 col-lg-3">
			    	<label for="inputURL">Enllaç pàgina Web</label>
			    	<input type="text" class="form-control" id="inputURL" ng-model="asso.URLWeb" ng-init="asso.URLWeb=''" maxlength="100" ng-blur="verificar()">
			    </div>
			</div>
			<div class="form-row">
			    <div class="form-group col-md-3 col-lg-4 offset-lg-2">
			    	<label for="inputLat">Latitud</label>
			    	<input type="text" class="form-control" id="inputLat" ng-model="asso.latitud" ng-init="asso.latitud=''" maxlength="9" ng-blur="verificar()">
			    </div>
			    <div class="form-group col-md-3 col-lg-4">
			    	<label for="inputLong">Longitud</label>
			    	<input type="text" class="form-control" id="inputLong" ng-model="asso.longitud" ng-init="asso.longitud=''" maxlength="9" ng-blur="verificar()">
			    </div>
			</div>
			<div class="form-row">
			    <div class="form-group col-12 col-lg-8 offset-lg-2">
			    	<label for="inputHorari">Horari Comerç</label>
			       	<textarea class="form-control textarea" id="inputHorari" ng-model="asso.horari" ng-init="asso.horari=''" ng-blur="verificar()"></textarea>
			    </div>
			    <div class="form-group col-12 col-lg-8 offset-lg-2">
			    	<label for="inputDesc">Descripció Comerç</label>
			       	<textarea class="form-control textarea" id="inputDesc" ng-model="asso.txtAssociat" ng-init="asso.txtAssociat=''" ng-blur="verificar()"></textarea>
			    </div>
			</div>
			<div class="form-row">
				<div class="col-12 col-lg-8 offset-lg-2">
					<label>Categoria Principal</label>
					<select class="form-control" name="selCatPrin" id="selCatPrin" ng-model="asso.categPrinc" ng-change="verificar()">
						<option value="-1">---Selecciona categoria principal---</option>
						<option ng-repeat="categ in categories" ng-selected="asso.categPrinc==categ.idCategoria" ng-value="categ.idCategoria">{{categ.nomCategoria}}</option>
					</select>
				</div>
			</div>
			<input type="button" class="btn btn-info offset-lg-2 mt-3" ng-click="insert()" value="Afegir associat" ng-disabled="btnAfegir">
		</form>
	</div>
</div>
<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
	<span class="d-none d-lg-inline">Pujar</span>
	<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>

