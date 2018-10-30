
<div id="divTop" class="row text-center mt-4 mb-3">
  <div class="col-12 " ><h1 class="titleSocis">Firamar</h1></div>
</div>

<div  ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>

<form id="formFiramar" name="formFiramar">
  <div class="form-row">
    <div class="form-group col-md-5 col-lg-3 offset-lg-2">
      <label for="txtNom">Titol Firamar</label>
      <input type="text" class="form-control" id="txtNom" name="txtNom" ng-model="coll.nom" maxlength="50">
    </div>
    <div class="form-group col-md-2 col-lg-1">
      <label for="txtData">Data</label>
      <input type="date" class="form-control" id="txtData" name="txtData" ng-model="coll.telf">
    </div>
    <div class="form-row">
    	<div class="form-group col-12 col-lg-8 offset-lg-2">
      		<label for="txtHistoria">Història</label>
       		<textarea class="form-control textarea" id="txtHistoria" name="txtHistoria" ng-model="coll.historiaColla"></textarea>
   		</div>
  	</div>

  	<a anchor-smooth-scroll="divTop">
  		<input type="button" class="btn btn-primary offset-lg-2" ng-click="guardar()" value="Guardar canvis">
  	</a>

</form>
  


