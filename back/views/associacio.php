<div class="row">
	<div ng-repeat="vi in vila">
		<div>Qui Som?</div>
		<span>{{vi.quiSom}}</span>
	</div>
</div>
<div class="row">
	<div>Serveis:</div>
	<ul class="ServeisLista" ng-repeat="servei in serveis">
		<li>{{servei.nomServei}}</li>
	</ul>
	<div>-Subserveis:</div>
	<ul ng-repeat="subservei in subserveis">
		<li>{{subservei.nomSubservei}}</li>
	</ul>
</div>
<div>
	<div>Equip:</div>
	<div ng-repeat=""></div>
		<span>{{vi.equip}}</span>
</div>
