angular.module('vila')
.controller('IniciCtrl',function($scope,$http,$q,$rootScope,$timeout){
})
.controller('AssociCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc","favi");
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
	$scope.accion="";
	$scope.ass={};
	$scope.msj="";
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
		$scope.ass.email=$scope.vila.email;
		$scope.ass.pasMail=$scope.vila.pasMail;
		$scope.ass.logoVila=$scope.vila.logoVila;
		$scope.ass.facebook=$scope.vila.facebook;
		$scope.ass.kayApi=$scope.vila.kayApi;
		$scope.ass.password=$scope.vila.password;
		$scope.ass.logoBolsa=$scope.vila.logoBolsa;
		$scope.ass.favIcon=$scope.vila.favIcon;
		$scope.ass.telf=$scope.vila.telf;
		$scope.ass.horari=$scope.vila.horari;
		$scope.ass.nom=$scope.vila.nom;
		$scope.ass.quiSom=$scope.vila.quiSom;
		$scope.ass.equip=$scope.vila.equip;
		$scope.ass.latitud=$scope.vila.latitud;
		$scope.ass.longitud=$scope.vila.longitud;
		$scope.ass.LGPD=$scope.vila.LGPD;
		$scope.ass.URLWeb=$scope.vila.URLWeb;
		
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	$scope.submitAss=function(){
		$scope.divMsj=true;
		if($scope.ass.nom=="" || $scope.ass.telf=="" || $scope.ass.facebook=="" || $scope.ass.URLWeb=="" ||  $scope.ass.email=="" ||  $scope.ass.pasMail=="" ||  $scope.ass.horari=="" ||  $scope.ass.latitud=="" || $scope.ass.longitud=="" || $scope.ass.keyApi=="" || $scope.ass.quiSom=="" || $scope.ass.equip=="" || $scope.ass.LGPD==""){
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);
		}
		else{
			$scope.msj="Les dades s'han actualitzat correctament.";
			var data = new FormData();
				data.append("email",$scope.ass.email);
				data.append("pasMail",$scope.ass.pasMail);
				data.append("logoVila",$scope.ass.logoVila);
				data.append("facebook",$scope.ass.facebook);
				data.append("kayApi",$scope.ass.kayApi);
				data.append("password",$scope.ass.password);
				data.append("logoBolsa",$scope.ass.logoBolsa);
				data.append("favIcon",$scope.ass.favIcon);
				data.append("telf",$scope.ass.telf);
				data.append("horari",$scope.ass.horari);
				data.append("nom",$scope.ass.nom);
				data.append("quiSom",$scope.ass.quiSom);
				data.append("equip",$scope.ass.equip);
				data.append("latitud",$scope.ass.latitud);
				data.append("longitud",$scope.ass.longitud);
				data.append("LGPD",$scope.ass.LGPD);
				data.append("URLWeb",$scope.ass.URLWeb);
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
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
})	
.controller('DirectCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc","l");

	var deferred=$q.defer();
	$rootScope.cargador=true;
	$http.post("models/directori.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
})
.controller('ContactCtrl',function($scope,$http,$q,$rootScope,$timeout){
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

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
	$http.post("models/contactans.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.contactans=res.data;
		$rootScope.cargador=false;
		console.log(res.data);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
	        document.getElementById("goTop").style.display = "block";
	    } else {
	        document.getElementById("goTop").style.display = "none";
	    }
	}
 	$scope.goTop=function(){
 		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
	$scope.columnOrder=function(columna){
		$scope.order=columna;
	}
})
.controller('FiramarCtrl',function($scope, $http, $q, $timeout, $rootScope, $window) {
	var data = new FormData();
		data.append("acc", "favi");
	var deferred=$q.defer();
	
	$http.post("models/associacio.php", data,{
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

	$scope.msj="";
	$scope.firamar={};
	$scope.divMsj=false;
	$scope.firaFull=true;
	$scope.accio="";
	$scope.firaSelect=true;

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
    $scope.cargador=true;
	$http.post("models/firamar.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.edicions=res.data;
		console.log(res.data);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});

	$scope.mostraEdicio=function(fecha){
		$scope.firaFull=true;
		var data = new FormData();
		data.append("acc","listEdicion");
		data.append("dataFiramar",fecha);
	    var deferred=$q.defer();
	    $rootScope.cargador=true;
		$http.post("models/firamar.php", data,{
			headers:{
				"Content-type":undefined
			},
			transformRequest:angular.identity
		
		})
		.then(function(res){

			deferred.resolve(res);
			$scope.edicioFiramar=res.data.firamar[0];
			console.log(res.data.firamar[0].titolFiramar);
			$scope.galeriaFiramar=res.data.galeriaFiramar;
			$scope.sponsorsFiramar=res.data.sponsorsFiramar;
			$scope.participantsFiramar=res.data.participantsFiramar;
			
			$rootScope.cargador=false;
			$scope.firaSelect=false;
		})
		.catch(function(error) {
			$rootScope.cargador=false;
		});

	}
	$scope.afegeixE=function(edita=""){
		$scope.firaSelect=true;
		$scope.firaFull=false;
		if (edita!="-1") {
			$scope.accio="Editar";
			$scope.firamar.titolFiramar=$scope.edicions[edita].titolFiramar;
			$scope.firamar.fecha=$scope.edicions[edita].fecha;
			$scope.firamar.txtFiramar=$scope.edicions[edita].txtFiramar;
		}
		else{
			$scope.accio="Afegir";
			$scope.firamar.titolFiramar="";
			$scope.firamar.txtFiramar="";
			var d=new Date();
			var yyyy=d.getFullYear();
			var mm=d.getMonth()<9?"0"+(d.getMonth()+1):(d.getMonth()+1);
			var dd=d.getDate()<10?"0"+(d.getDate()):(d.getDate());
			$scope.firamar.fecha=yyyy+"-"+mm+"-"+dd;			
		}
		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	$scope.guardaEdicio=function(accio){
		if($scope.firamar.titolFiramar=="" || $scope.firamar.txtFiramar=="" || $scope.firamar.fecha==""){	
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$scope.divMsj=true;
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);		}
		else{
			var data = new FormData();
				data.append("acc",$scope.accio);
				data.append("titolFiramar",$scope.firamar.titolFiramar);
				data.append("txtFiramar",$scope.firamar.txtFiramar);
				data.append("fecha",$scope.firamar.fecha);
		    var deferred=$q.defer();
		    $rootScope.cargador=true;
			$http.post("models/firamar.php", data,{
				headers:{
					"Content-type":undefined
				},
				transformRequest:angular.identity
			})
			.then(function(res){
				console.log(res.data);
				if(res.data!="0"){
					$scope.edicions=res.data;
					$scope.msj="Les dades s'han actualitzat correctament.";
					$scope.firaFull=true;
					$scope.divMsj=true;
				}
				else{
					$scope.msj="Fallada desconegut.";
					$scope.divMsj=true;
				}
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
				$rootScope.cargador=false;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
	$scope.cancelaEdicio=function(cancel){
		$scope.firaFull=true;
	}



	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
	        document.getElementById("goTop").style.display = "block";
	    } else {
	        document.getElementById("goTop").style.display = "none";
	    }
	}
 	$scope.goTop=function(){
 		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
})
.controller('LogoutCtrl',function($scope,$http){
	$http({
		method:"GET",
		url:"models/login.php?acc=logout"
	})
	.then(function mySuccess(response){
		location.href="index.php";
	},
	function myError(response){	
	})
	.finally (function(){
	})
})
