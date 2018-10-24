var appLogin= angular.module('vilaLogin', []);
appLogin.controller ('LoginCtrl', function($scope, $http, $q, $timeout, $rootScope) {
	
	var data = new FormData();
		data.append("acc", "favi");
	var deferred=$q.defer();
	
	$http.post("models/home.php", data,{
	headers:{
		"Content-type":undefined
	},
	transformRequest:angular.identity

	})
	.then(function(resIcon){
		deferred.resolve(resIcon);
		$rootScope.favIcon=resIcon.data[0].favIcon;
		$rootScope.logo=resIcon.data[0].logo;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});
			$scope.usuari={};
			$scope.usuari.soci="";
			$scope.usuari.contra="";
			$scope.message="";
			$scope.incontra=false;
			$scope.usuari.recon="";
			$scope.divError=true;
			$scope.msgError="";
			$scope.tipe=true;
	$scope.changePass=function(){
		if ($scope.tipe) {
			document.getElementById('txtPass').type = 'text';
		}
		else{
			document.getElementById('txtPass').type = 'password';
		}
		$('#txtPass').focus();
		$scope.tipe=!$scope.tipe;
	}
	$scope.login=function(){
		var data = new FormData();
			data.append("acc","log");
			data.append("soci",$scope.usuari.soci);
			data.append("contra",$scope.usuari.contra);
		var deferred=$q.defer();
		$http.post("models/home.php",data,{
			headers:{
				"Content-type":undefined
		},
		transformRequest:angular.identity
		})
		.then(function (res) {
			deferred.resolve(res);
			$scope.message=res.data[0].message;					
		}, function (res) {
			$scope.usuari.soci=res.statusText;
		})
		.finally(function() 
		{ 			
		    if($scope.message=="OK") window.location.href="home.php";

		    else {
		    	$scope.usuari.soci="";
				$scope.usuari.contra="";
				$scope.incontra=true;
				$timeout(function(){
						$scope.incontra=false;
						},3000);	
			}
			
		});
	}
	$scope.recontra=function(){
		$scope.divError=false;
		var data = new FormData();
			data.append("acc","Envia");
			data.append("mail",$scope.usuari.soci);
			
		var deferred=$q.defer();

		$rootScope.cargador=true;
		$http.post("models/home.php",data,{
			headers:{
				"Content-type":undefined
			},
				transformRequest:angular.identity
		})
		.then(function (res) {
			deferred.resolve(res);
			console.log(res.data);
			$scope.usuari.soci="";
			$scope.usuari.contra="";
			if(res.data==0){
				$scope.msgError="Verifica adreça";
				$timeout(function(){
					$scope.divError=true;
				},3000);
			}
			else{
				$scope.msgError="Correu enviat";
				$timeout(function(){
					$scope.divError=true;
				},3000);
			}
			
		})
		.catch(function(){
			$rootScope.cargador=false;

		});
	}

	$scope.close=function(){
		$scope.usuari.soci="";
		$scope.usuari.contra="";
	}	
})
.controller('RecContraCtrl', function($scope, $http, $q, $timeout, $rootScope){
	$scope.actBtnIrLogin=true;
	var recupera="";
	$scope.recupera=recupera;
	$scope.novaContra="";
	$scope.tipe=true;
	$scope.save=function(recupera){
		$scope.divMsj=true;
		if($scope.novaContra=="" || $scope.novaContra!=$scope.repetirNovaContra){
			$scope.msj="No s'ha modificat la contrasenya. Comprova que estigui tot correcte.";
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);
		}
		else{
			var data = new FormData();
				data.append("novaContra",$scope.novaContra);
				data.append("acc","rec");
				data.append("recupera",recupera);
			var deferred=$q.defer();
			$rootScope.cargador=true;
			$http.post("models/reccontra.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				$scope.actBtnIrLogin=false;
				$scope.msj="S'ha modificat la contrasenya correctament.";
				$timeout(function() {
					$scope.divMsj=false;
				}, 3000);
				$scope.novaContra="";
				$scope.repetirNovaContra="";
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
	$scope.changePass=function(){
		if ($scope.tipe) {
			document.getElementById('txtNovContra').type = 'text';
		}
		else{
			document.getElementById('txtNovContra').type = 'password';
		}
		$('#txtNovContra').focus();
		$scope.tipe=!$scope.tipe;
	}
	$scope.redirectLogin=function(){
		document.location.href = "index.php";
	}
})

