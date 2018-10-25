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
	console.log("llegaa");
})

.controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("olaaaxd");
})


.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("sí, así es");
})