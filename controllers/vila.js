angular.module('vila')
.controller('IndexCtrl',function($scope,$http,$rootScope){
		// $rootScope.cargador=true;	
		// $http({
		// 	method : "GET",
		// 	url : "models/index.php?acc=l"
		// })
		// .then(function mySuccess(response) {
			
		// 	$scope.footerContent=response.data.dadesFooter;
		// 	$scope.footerContentTrans=response.data.transportFooter;
		// 	$rootScope.cargador=false;
		// }, 
		// function myError(response) {
		
		// })
		// .finally(function()
		// { 
		  
		    
		// })

})
.controller('ContactaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){

	$scope.muestraInput=false;

	$scope.muestraNom=function(tipo)
	{
		$scope.muestraInput=tipo;
	}
})

.controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("olaaaxd");
})


.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("sí, así es");
	$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","l");
		data.append("idNoticia",$routeParams.idNoticia);
	var deferred=$q.defer();
	$http.post("models/noticies.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.noticia=res.data[0];
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
})