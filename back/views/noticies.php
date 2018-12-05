<?php
	session_start();
	?>
	<div class="col-8 offset-2 text-center alert alert-warning" ng-show="cargaMsj">
		{{msj}}
	</div>
	<br>	
	<div class="AssNotiAllCss" id="NotiEditTop">
		<form id="formNot" name="formNot" ng-submit="accioNoticies()" novalidate ng-hide="reveal">
			<br>
			<div class="row">
				<div class="col" ng-class="{ 'has-error' : formNot.nomNot.$invalid && !formNot.nomNot.$pristine }">
					<label for="nomNot">Titular:</label>
					<input type="text" class="form-control" ng-model="not.titolNoticia" id="nomNot" placeholder="Nom" name="nomNot" required>
				</div>
				<div class="col" ng-class="{ 'has-error' : formNot.descNot.$invalid && !formNot.descNot.$pristine }">
					<label for="descNot">Descripció:</label>
					<textarea type="text" class="form-control" ng-model="not.txtNoticia" id="descNot" placeholder="Descripció" name="descNot" required>{{not.txtNoticia}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<label>Data:</label>
					<input type="date" class="form-control" name="dataNot" ng-model="not.dataNoticia">
				</div>
			</div>
			<div class="row">
				<label class="cursor text-primary col mt-1" for="btnExaminar">{{accionNot}} imatge <i class="fas fa-camera add-examinar text-primary cursor" aria-hidden="true"></i></label>
				<input type="file" id="btnExaminar" name="btnExaminar" accept="image/jpg, image/jpeg, image/png"  multiple onchange="angular.element(this).scope().getFileDetails(this)" ng-show="false"/>
			</div>
			<div>
			<input class="btn btn-danger" type="button" value="Cancelar" ng-click="cancelNot()">
			<button type="submit"  ng-disabled="formNot.$invalid" class="btn btn-info"  >{{accionNot}}</button>
			</div>
		</form>
	</div>

	<div class="row text-center">
		<h2 class="col my-3"> Noticies </h2>
	</div>
	<i class="offset-md-1 fas fa-plus-square iconSize" ng-click="EditNoticia('-1')" ng-show="reveal" title="Afegeix una Noticia"></i>
	<br>
	<br>
	<div class="row justify-content-center">
		<div class="card mx-xl-3 my-2 mr-md-3 col-md-5 col-xl-3 media"  ng-repeat="noticia in noticies">
			<div class="row text-center">
				<div class="col-12 imgNotCss d-flex justify-content-center">				
						<img class="card-img-top imgNotCss-img" ng-src="{{noticia.fotoNoticia!='' ? '../img/noticies/'+noticia.fotoNoticia : '../img/noimage.png'}}" alt="">
				</div>
				<div class="col-12 card-body d-flex flex-column align-self-end">
					<div class="row">
						<span class="col-12 card-subtitle text-muted">{{noticia.dataNoticia}}</span>
						<h4 class="col-12 card-title">{{noticia.titolNoticia}}</h4>
						<span class="col-12 mb-3">{{noticia.txtNoticia}}</span>
					</div>
					<div class="col-12 col-sm-12">
						<i class="far fa-star iconSize " ng-if="noticia.principal=='N'" ng-click="cambiaPrinc('S', noticia.idNoticia)" title="Afegir com a favorit"></i>
						<i class="fas fa-star iconSize"  ng-if="noticia.principal=='S'" ng-click="cambiaPrinc('N', noticia.idNoticia)" title="Quitar com a favorit"></i>
						<i class="far fa-edit iconSize" ng-click="EditNoticia($index)" title="Editar"></i>
						<i class="far fa-times-circle iconSize fontAweX" ng-click="eliminarNoticies(noticia.idNoticia, noticia.titolNoticia, noticia.fotoNoticia)" title="Eliminar"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
	<span class="d-none d-lg-inline">Pujar</span>
	<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>