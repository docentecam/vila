
<div id="divTop" class="row text-center mt-4 mb-3">
  <div class="col-12 " ><h1 class="titleSocis">Firamar</h1></div>
</div>

<div  ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>

<div class="col-lg-1 col-md-1 offset-lg-1">
	    <i class="fas fa-plus-square afegegant text-dark cursor" ng-click="editGegant(-1)" ng-show="cartaGegant" title="Afegeix Edicio"></i>
</div>

<form id="formFiramar" name="formFiramar">
	<div class="cursor col-12 col-lg-1 col-md-1 offset-lg-2">
		<li>Firamar 2016</li>
		<li>Firamar 2017</li>
		<li>Firamar 2018</li>
	</div>
	</br>
 	<div class="form-row">
	    <div class="form-group col-md-5 col-lg-3 offset-lg-2">
	      <label for="txtNom">Titol Firamar</label>
	      <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="coll.nom" maxlength="50">
	    </div>
	    <div class="form-group col-md-2 col-lg-2">
	      <label for="txtData">Fecha</label>
	      <input type="date" class="form-control" id="txtData" name="txtData" ng-model="coll.telf">
	    </div>
	    <div class="form-group col-12 col-lg-8 offset-lg-2">
	      	<label for="txtHistoria">Història</label>
	       	<textarea class="form-control textarea" id="txtHistoria" name="txtHistoria" ng-model="coll.historiaColla"></textarea>
	   	</div>
	</div>
	<div class="form-row">
		<div class="form-group col-12 col-lg-1 col-md-1 offset-lg-2">
  			<a anchor-smooth-scroll="divTop">	  		
  				<input type="button" class="btn btn-primary" ng-click="guardar()" value="Guardar canvis">
	  		</a>
		</div>
	</div>
	
</form>
  


