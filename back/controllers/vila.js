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
	// $rootScope.cargador=true;
	$http.post("models/associacio.php", data,{
		headers:{
			"Content-type":undefined
		},
			transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.vila=res.data[0];
		$rootScope.cargador=false;
		$scope.ass.idVila=$scope.vila.idVila;
		$scope.ass.email=$scope.vila.email;
		$scope.ass.pasMail=$scope.vila.pasMail;
		$scope.ass.logoVila=$scope.vila.logoVila;
		$scope.ass.logoVilaOld=$scope.vila.logoVila;
		$scope.ass.logoUpdate="";
		$scope.ass.facebook=$scope.vila.facebook;
		$scope.ass.keyApi=$scope.vila.keyApi;
		$scope.ass.password=$scope.vila.password;
		$scope.ass.logoBolsa=$scope.vila.logoBolsa;
		$scope.ass.logoBolsaOld=$scope.vila.logoBolsa;
		$scope.ass.favIcon=$scope.vila.favIcon;
		$scope.ass.favIconOld=$scope.vila.favIcon;
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
		
			var data = new FormData();
				data.append("acc","updateVila");
				data.append("idVila",$scope.ass.idVila);
				data.append("email",$scope.ass.email);
				data.append("pasMail",$scope.ass.pasMail);
				data.append("logoVila",$scope.ass.logoVila);
				data.append("facebook",$scope.ass.facebook);
				data.append("keyApi",$scope.ass.keyApi);
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
				console.log(res.data);
				$rootScope.cargador=false;
				$scope.divMsj=true;
				$scope.msj="Les dades s'han actualitzat correctament.";
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.showPassAss=function(){
		if ($scope.tipe) {
			document.getElementById('txtPass').type = 'text';
		}
		else{
			document.getElementById('txtPass').type = 'password';
		}
		$('#txtPass').focus();
		$scope.tipe=!$scope.tipe;
	}
	$scope.getFileDetails = function (e,nomCamp) {
		var data = new FormData();
            data.append("acc", "updateMedia");
			data.append("nomCamp", nomCamp);
			data.append("logoUpdate", e.files[0]);
			if(nomCamp=="logoVila"){
				data.append("logoOld", $scope.ass.logoVila);
			}
			else if(nomCamp=="logoBolsa"){
				data.append("logoOld", $scope.ass.logoBolsa);
				
			}
			else if(nomCamp=="favIcon"){
				data.append("logoOld", $scope.ass.favIcon);

			}
			 var deferred=$q.defer();
			 $http.post("models/associacio.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					console.log(res.data);
					deferred.resolve(res);
					if(nomCamp=="logoVila"){
						$scope.ass.logoVila=res.data;
					}
					else if(nomCamp=="logoBolsa"){
						$scope.ass.logoBolsa=res.data;
						$rootScope.logoBolsa=res.data;
					}
					else if(nomCamp=="favIcon"){
						$scope.ass.favIcon=res.data;

					}				
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
    } 
})	
.controller('DirectCtrl',function($scope,$http,$q,$rootScope,$routeParams,$timeout,$window){
	$scope.llistatComer=true;
	var data = new FormData();
		data.append("acc","list");

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
		$scope.directoris=res.data;
		$rootScope.cargador=false;
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
.controller('DirectComerCtrl',function($scope,$http,$q,$rootScope,$routeParams,$timeout,$window){
	console.log("entra");
	$scope.llistatComer=false;
	$scope.com={};
	var data = new FormData();
		data.append("acc","l");
		data.append("idAssociat",$routeParams.idAssociat);
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
		console.log(res.data);
		$scope.com.categoriaPrinc="-1";
		$scope.com.categoriaNotPrinc="-1";
		$scope.comerc=res.data.comerc[0];
		$scope.categories=res.data.catego;
		$scope.categNotPrinc=res.data.catNotPrinc;
		$scope.listCatNotPrinc=res.data.listCatNotPrinc;
		$scope.com.categoriaPrinc=res.data.catPrinc[0].idCategoria;
		$scope.com.idAssociat=$scope.comerc.idAssociat;
		$scope.com.nomAssociat=$scope.comerc.nomAssociat;
		$scope.com.adreca=$scope.comerc.adreca;
		$scope.com.telf1=parseInt($scope.comerc.telf1);
		$scope.com.telf2=parseInt($scope.comerc.telf2);
		$scope.com.whatsapp=parseInt($scope.comerc.whatsapp);
		$scope.com.facebook=$scope.comerc.facebook;
		$scope.com.horari=$scope.comerc.horari;
		$scope.com.latitud=$scope.comerc.latitud;
		$scope.com.longitud=$scope.comerc.longitud;
		$scope.com.txtAssociat=$scope.comerc.txtAssociat;
		$scope.com.logoAssociat=$scope.comerc.logoAssociat;
		$scope.com.logoAssociatOld=$scope.comerc.logoAssociat;
		$scope.com.logoUpdate="";
		$scope.com.email=$scope.comerc.email;
		$scope.com.URLWeb=$scope.comerc.URLWeb;
		$rootScope.cargador=false;		
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
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
	$scope.columnOrder=function(columna){
		$scope.order=columna;
	}
	$scope.guardar=function(){
		$scope.divMsj=true;
		if($scope.com.nomAssociat=="" || $scope.com.adreca=="" || $scope.com.facebook=="" || $scope.com.URLWeb=="" || $scope.com.latitud==""|| $scope.com.longitud=="" || $scope.com.horari=="" || $scope.com.txtAssociat==""){
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);
		}
		else{
			$scope.msj="Les dades s'han actualitzat correctament.";
			var data = new FormData();
				data.append("idAssociat",$scope.com.idAssociat);
				data.append("nomAssociat",$scope.com.nomAssociat);
				data.append("adreca",$scope.com.adreca);
				data.append("telf1",$scope.com.telf1);
				data.append("telf2",$scope.com.telf2);
				data.append("whatsapp",$scope.com.whatsapp);
				data.append("facebook",$scope.com.facebook);
				data.append("URLWeb",$scope.com.URLWeb);
				data.append("horari",$scope.com.horari);
				data.append("txtAssociat",$scope.com.txtAssociat);
				data.append("email",$scope.com.email);
				data.append("latitud",$scope.com.latitud);
				data.append("longitud",$scope.com.longitud);
				data.append("idCategoria",$scope.com.categoriaPrinc);
				data.append("acc","up");
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
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	    var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	$scope.afegirCateg=function(){
		var data = new FormData();
		data.append("idAssociat",$scope.com.idAssociat);
		data.append("idCategoria",$scope.com.categoriaNotPrinc);
		data.append("acc","af");
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
				$scope.listCatNotPrinc=res.data;
				$scope.categNotPrinc=res.data.catNotPrinc;
				console.log(res.data);
				$rootScope.cargador=false;
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
})
.controller('ContactCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
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
.controller('SociCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
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

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
	$http.post("models/solicitutsoc.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.solicituts=res.data;
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
.controller('FiramarCtrl',function($scope, $http, $q, $timeout, $rootScope) {


})
.controller('ServeisCtrl',function($scope, $http, $q, $timeout, $rootScope) {
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
	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
	$http.post("models/serveis.php", data,{
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
	$scope.accionServ="";
	$scope.ser={};
	$scope.msj="";
	$scope.accionSer="";
	$scope.reveal=false;

	$scope.EditServei=function(){
		$scope.reveal=true;
		if (idPosServei!="-1") {
			$scope.accionSer="Editar"
			$scope.ser.idServei=$scope.serveis[idPosServei].idServeis;
			$scope.ser.nomServei=$scope.serveis[idPosServei].nomServeis;
			$scope.ser.txtServei=$scope.serveis[idPosServei].txtServeis;
		}
		else{
			$scope.accionSer="Editar"
			$scope.ser.idServei="";
			$scope.ser.nomServei="";
			$scope.ser.txtServei="";
		}
	}

})
.controller('CategCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	// var data = new FormData();
	// 	data.append("acc", "favi");
	// var deferred=$q.defer();
	
	// $http.post("models/associacio.php", data,{
	// headers:{
	// 	"Content-type":undefined
	// },
	// transformRequest:angular.identity

	// })
	// .then(function(resIcon){
	// 	deferred.resolve(resIcon);
	// 	$rootScope.favIcon=resIcon.data[0].favIcon;
	// 	$rootScope.logo=resIcon.data[0].logo;
	// 	$rootScope.cargador=false;
	// })
	// .catch(function(error){
	// 	$rootScope.cargador=false;

	// });

	$scope.dadesCateg=true;
	$scope.cat={};
	$scope.accion="";

	var data = new FormData();
		data.append("acc","list");
    var deferred=$q.defer();
	$http.post("models/categories.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.categories=res.data;
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
	$scope.muestraFormCat=function(idEdit=""){
		$scope.dadesCateg=false
		if(idEdit!="-1"){
			$scope.accion="Edita";
			$scope.cat.idCategoria=$scope.categories.idCategoria;
			$scope.cat.nomCategoria=$scope.categories.nomCategoria;
		}
		else{
			$scope.accion="Afegir";
			$scope.cat.nomCategoria="";
		}
	}
	$scope.cancel=function(listSocis){
		$scope.dadesCateg=true;		
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
