.controller('AssociCtrl',function(){
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	$rootScope.cargador=true;
	$http.post("models/associacio.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$timeout(function() {

		}, 2000);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
})