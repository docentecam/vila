angular.module('vila')
.controller('IniciCtrl',function($scope,$http,$q,$rootScope,$timeout){
})
.controller('AssociCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});
	$scope.accion="";
	$scope.ass={};
	$scope.msj="";
	$scope.hidePass=true;
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
				$rootScope.cargador=false;
				$scope.cargaMsj=true;
				$scope.msj="Les dades s'han actualitzat correctament.";
				$timeout(function() {
					$scope.cargaMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.showPassAss=function(){
		if ($scope.tipe) {
			document.getElementById('txtPass').type = 'text';
			$scope.hidePass=false;
		}
		else{
			document.getElementById('txtPass').type = 'password';
			$scope.hidePass=true;
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
})	
.controller('DirectCtrl',function($scope,$http,$q,$rootScope,$window){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});
	$scope.llistatComer=true;
	$scope.afegirComerc=true;
	$scope.dadesComerc=true;
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
	$scope.offOn=function (directori, active) {
		var data = new FormData();
			data.append("idAssociat",directori);
			data.append("activo",active);
			data.append("acc","U");	
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
	}
})
.controller('DirectComerCtrl',function($scope,$http,$q,$rootScope,$routeParams,$timeout,$window, $document){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});
	$scope.llistatComer=false;
	$scope.afegirComerc=true;
	$scope.dadesComerc=false;
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
		$scope.galeriaAssociats=res.data.galeriaAssociats;
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
 		var element = document.getElementById("upTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
	$scope.getFileDetails = function (e,nomCamp) {
		var data = new FormData();
            data.append("acc", "updateMedia");
            data.append("idAssociat",$scope.com.idAssociat);
			data.append("nomCamp", nomCamp);
			data.append("logoUpdate", e.files[0]);
			data.append("logoAssociatOld", $scope.com.logoAssociatOld);
			console.log($scope.com.logoAssociatOld);
				//data.append("logoDelete", $scope.com.logoAssociatOld);
			 var deferred=$q.defer();
			 $http.post("models/directori.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					deferred.resolve(res);
					$scope.com.logoAssociat=res.data;
					$scope.com.logoAssociatOld=res.data;					
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
		
    } 
	$scope.guardar=function(){
		$scope.divMsj=true;
		if(isNaN($scope.com.telf2)){
			$scope.com.telf2=null;
		}
		if(isNaN($scope.com.whatsapp)){
			$scope.com.whatsapp=null;
		}
		else if($scope.com.nomAssociat=="" || $scope.com.adreca=="" 
			|| $scope.com.facebook=="" || $scope.com.URLWeb=="" 
			|| $scope.com.latitud==""|| $scope.com.longitud=="" 
			|| $scope.com.horari=="" || $scope.com.txtAssociat==""
			|| $scope.com.telf1==""){
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
				console.log(res.data);
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
				$scope.listCatNotPrinc=res.data['listCatNotPrinc'];
				$scope.categNotPrinc=res.data['catNotPrinc'];
				$rootScope.cargador=false;
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.delete=function(idCategoria){
		console.log(idCategoria);
		var segur=confirm("Segur que vols suprimir aquesta categoria?");
		if (segur) {
			var data = new FormData();
			data.append("idAssociat",$scope.com.idAssociat);
			data.append("idCategoria",idCategoria);
			data.append("acc","del");
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
					$scope.listCatNotPrinc=res.data['listCatNotPrinc'];
					$scope.categNotPrinc=res.data['catNotPrinc'];
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
	$scope.uploadGaleria=function(e){
			$scope.filesImages = [];
			$scope.$apply(function () {
			// Guardamos los ficheros en un array.
				for (var i = 0; i < e.files.length; i++) {
				    $scope.filesImages.push(e.files[i]);
					$scope.message=e.files[i]['name'];
					console.log($scope.filesImages.length+$scope.message);
				}
            });  
            var data = new FormData();

            data.append("acc", "uploadImg");
            data.append("idAssociat",$scope.com.idAssociat);
			for (var i in $scope.filesImages) {
			        data.append("uploadedFile"+i, $scope.filesImages[i]);
			        //console.log("uploadedFile"+i, $scope.filesImages[i]);
			}

			data.append("cantImatge", i);
			 var deferred=$q.defer();
			 $http.post("models/directori.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					deferred.resolve(res);
					$scope.galeriaAssociats=res.data;
					console.log(res.data);
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
	}
	$scope.deleteImg=function(idGaleria){
		var segur=confirm("Segur que vols eliminar aquesta imatge?");
		if (segur) {
			var data = new FormData();
			data.append("idAssociat",$scope.com.idAssociat);
			data.append("idGaleria",idGaleria);
			data.append("acc","delImg");
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
					$scope.galeriaAssociats=res.data.galeriaAssociats;
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
.controller('NewComercCtrl',function($scope,$http,$q,$rootScope,$timeout,$window, $document){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});

	$scope.afegirComerc=false;
	$scope.llistatComer=false;
	$scope.dadesComerc=true;
	$scope.btnAfegir=true;
	$scope.asso={};
	$scope.asso.logoAssociat="";
	$scope.asso.categPrinc="-1";
	var data = new FormData();
	data.append("acc", "selCat");
		var deferred=$q.defer();
		$http.post("models/directori.php", data,{
			headers:{
				"Content-type":undefined
			},
				transformRequest:angular.identity
			})
			.then(function(res)
			{
				deferred.resolve(res);
				$scope.categories=res.data;
				console.log(res.data);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
	        document.getElementById("goTop").style.display = "block";
	    } else {
	        document.getElementById("goTop").style.display = "none";
	    }
	}
 	$scope.goTop=function(){
 		var element = document.getElementById("divUpTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
 	$scope.verificar=function(){
 		if($scope.asso.nomAssociat=="" || $scope.asso.adreca=="" 
 			|| $scope.asso.facebook=="" || $scope.asso.URLWeb=="" 
 			|| $scope.asso.latitud=="" || $scope.asso.longitud=="" 
 			|| $scope.asso.horari=="" || $scope.asso.txtAssociat=="" 
 			|| $scope.asso.telf1=="" || $scope.asso.categPrinc=="-1"
 			){
 			$scope.btnAfegir=true;
		}
		else{
			$scope.btnAfegir=false;
		}	
 	}
 	$scope.insert=function(){
		var data = new FormData();
			data.append("idAssociat",$scope.asso.idAssociat);
			data.append("nomAssociat",$scope.asso.nomAssociat);
			data.append("adreca",$scope.asso.adreca);
			data.append("telf1",$scope.asso.telf1);
			data.append("telf2",$scope.asso.telf2);
			data.append("whatsapp",$scope.asso.whatsapp);
			data.append("facebook",$scope.asso.facebook);
			data.append("URLWeb",$scope.asso.URLWeb);
			data.append("horari",$scope.asso.horari);
			data.append("txtAssociat",$scope.asso.txtAssociat);
			data.append("email",$scope.asso.email);
			data.append("latitud",$scope.asso.latitud);
			data.append("longitud",$scope.asso.longitud);
			data.append("idCategoria",$scope.asso.categPrinc);
			data.append("acc","afeg");
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
			window.location.href="#/directori/"+res.data;
			console.log(res.data);
		})
		.catch(function(error) {
			$rootScope.cargador=false;
		});
		
 	}
})
.controller('ContactCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
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
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
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
.controller('FiramarCtrl',function($scope, $http, $q, $timeout, $rootScope, $routeParams) {
	
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;
	});

	$scope.msj="";
	$scope.divMsj=false;
	$scope.firaSelect=true;
	$scope.firaFull=true;

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();

	$http.post("models/firamar.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.edicions=res.data;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});



	if($routeParams.dataFiramar!='all')
{


		$scope.firaFull=true;
		
		var data = new FormData();
		data.append("acc","listEdicion");
		data.append("dataFiramar",$routeParams.dataFiramar);
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
			console.log(res.data.activitatsFiramar);
			$scope.edicioFiramar=res.data.edicioFiramar[0];
			$scope.galeriaFiramar=res.data.galeriaFiramar;
			$scope.sponsorsFiramar=res.data.sponsorsFiramar;
			$scope.participantsFiramar=res.data.participantsFiramar;
			$scope.activitatsFiramar=res.data.activitatsFiramar;
			$rootScope.cargador=false;
			$scope.firaSelect=false;
		})
		.catch(function(error) {
			$rootScope.cargador=false;
		});
		}
})	

	
.controller('FiramarEditCtrl',function($scope, $http, $q, $timeout, $rootScope,$routeParams){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;
	});

	$scope.msj="";
	$scope.firamar={};
	$scope.divMsj=false;
	$scope.accio="";
	$scope.firaSelect=true;
	$scope.firaFull=true;

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();

	$http.post("models/firamar.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.edicions=res.data;
		$scope.firaFull=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;

});

		if ($routeParams.dataFiramar!="new") {

			$scope.accio="Editar";

			$scope.firaFull=false;
			$scope.firaSelect=true;
			var data = new FormData();
			data.append("acc","listEdicion");
			data.append("dataFiramar",$routeParams.dataFiramar);
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
				$scope.edicioFiramar=res.data.edicioFiramar[0];
				$scope.galeriaFiramar=res.data.galeriaFiramar;
				$scope.sponsorsFiramar=res.data.sponsorsFiramar;
				$scope.participantsFiramar=res.data.participantsFiramar;
				$scope.activitatsFiramar=res.data.activitatsFiramar;
				$rootScope.cargador=false;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
			
		}
		else{
			$scope.firaFull=false;
			$scope.firaSelect=true;
			$scope.accio="Afegir";
			$scope.firamar.titolFiramar="";
			$scope.firamar.txtFiramar="";
			$scope.firamar.titolActivitat="";
			$scope.firamar.horaI="";
			$scope.firamar.horaF="";
			$scope.firamar.txtActivitat="";
			$scope.firamar.fotoFiramar="";
			$scope.firamar.logoParticipant="";
			$scope.firamar.nomSponsor="";

			var d=new Date();
			var yyyy=d.getFullYear();
			var mm=d.getMonth()<9?"0"+(d.getMonth()+1):(d.getMonth()+1);
			var dd=d.getDate()<10?"0"+(d.getDate()):(d.getDate());
			$scope.firamar.fecha=yyyy+"-"+mm+"-"+dd;			
		}
		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});


	$scope.editActivitat=function(idActivitat,tipo){
		
	}

	$scope.getFileDetails=function(e,tabla){
			$scope.filesImages = [];
			$scope.$apply(function () {
			// Guardamos los ficheros en un array.
				for (var i = 0; i < e.files.length; i++) {
				    $scope.filesImages.push(e.files[i]);
					$scope.message=e.files[i]['name'];
					console.log($scope.filesImages.length+$scope.message);
				}
            });
              
            var data = new FormData();

            data.append("acc", "uploadImg");
            data.append("dataFiramar",$scope.firamar.dataFiramar);
			for (var i in $scope.filesImages) {
			        data.append("getFileDetails"+i, $scope.filesImages[i]);
			}

			data.append("cantImatge", i);
			 var deferred=$q.defer();
			 $http.post("models/firamar.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					deferred.resolve(res);
					$scope.galeriaFiramar=res.data;
					console.log(res.data);
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
	}
	$scope.guardaEdicio=function(accio){
		if($scope.firamar.titolFiramar=="" || $scope.firamar.txtFiramar=="" || $scope.firamar.fecha==""){	
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$scope.divMsj=true;
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);		
		}
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
		}
	}

	$scope.cancelaEdicio=function(cancel){
		$scope.firaFull=true;
	}

	$scope.EliminaImg=function(nomtaula,nomImatge,dataFiramar,logo,){
		var segur=confirm("Segur que vols eliminar aquesta imatge?");
		if (segur) {
			var data = new FormData();
			data.append("nomtaula",nomtaula);
			data.append("nomImatge",nomImatge);
			data.append("dataFiramar",dataFiramar);
			data.append("acc","Volatilizado");
			data.append("logo",logo)
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
				$scope.galeriaFiramar=res.data.galeriaFiramar;
				$scope.sponsorsFiramar=res.data.sponsorsFiramar;
				$scope.participantsFiramar=res.data.participantsFiramar;
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
.controller('ServeisCtrl',function($scope, $http, $q, $timeout, $rootScope) {
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
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
		$scope.serveis=res.data;
		$rootScope.cargador=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	$scope.accionServ="";
	$scope.ser={};
	$scope.subSer={};
	$scope.msj="";
	$scope.accionSer="";
	$scope.accionSubser="";
	$scope.reveal=true;
	$scope.revealSub=true;

	$scope.EditServei=function(PosServei){
		$scope.revealSub=true;
		$scope.reveal=false;
		if (PosServei!="-1") {
			$scope.accionSer="Editar"
			$scope.ser.idServei=$scope.serveis[PosServei].idServei;
			$scope.ser.nomServei=$scope.serveis[PosServei].nomServei;
			$scope.ser.txtServei=$scope.serveis[PosServei].txtServei;
		}
		else{
			$scope.accionSer="Afegir"
			$scope.ser.idServei="";
			$scope.ser.nomServei="";
			$scope.ser.txtServei="";
		}
		var element = document.getElementById("SerEditTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	$scope.EditSubservei=function(indexSubservei,idServei){
		$scope.reveal=true;
		$scope.revealSub=false;
		$scope.subSer.idServei=idServei;
		if (indexSubservei!="-1") {
			$scope.accionSubser="Editar";
			for(i=0;i<$scope.serveis.length;i++)
			{
				if($scope.serveis[i].idServei==idServei){
					$scope.subSer.idServei=idServei;
					$scope.subSer.idSubservei=$scope.serveis[i][3][indexSubservei].idSubservei;
					$scope.subSer.nomSubservei=$scope.serveis[i][3][indexSubservei].nomSubservei;
					$scope.subSer.txtSubservei=$scope.serveis[i][3][indexSubservei].txtSubservei;
				}
				
			}
		}
		else{
			$scope.accionSubser="Afegir";
			$scope.subSer.idSubservei="";
			$scope.subSer.nomSubservei="";
			$scope.subSer.txtSubservei="";
		}
		var element = document.getElementById("SubserEditTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	$scope.submitServei=function(){
			var data = new FormData();
				data.append("acc",$scope.accionSer);
				data.append("idServei",$scope.ser.idServei);
				data.append("nomServei",$scope.ser.nomServei);
				data.append("txtServei",$scope.ser.txtServei);
				var deferred=$q.defer();
			$rootScope.cargador=true;
			$http.post("models/serveis.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				$rootScope.cargador=false;
				$scope.reveal=true;
				$scope.cargaMsj=true;
				$scope.msj="Les dades s'han actualitzat correctament.";
				$timeout(function() {
					$scope.cargaMsj=false;
				}, 2000);
				$scope.serveis=res.data;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.submitSubservei=function(){
			var data = new FormData();
				data.append("acc",$scope.accionSubser);
				data.append("idSubservei",$scope.subSer.idSubservei);
				data.append("nomSubservei",$scope.subSer.nomSubservei);
				data.append("txtSubservei",$scope.subSer.txtSubservei);
				data.append("idServei",$scope.subSer.idServei);
				var deferred=$q.defer();
			$rootScope.cargador=true;
			$http.post("models/serveis.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				$rootScope.cargador=false;
				$scope.revealSub=true;
				$scope.cargaMsj=true;
				$scope.msj="Les dades s'han actualitzat correctament.";
				$timeout(function() {
					$scope.cargaMsj=false;
				}, 2000);
				$scope.serveis=res.data;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.eliminarServei=function(idServei,nomServei){
		var respuesta= confirm ("Desitja eliminar el servei "+nomServei+"?")
		if (respuesta) 
		{
			var data = new FormData();
				data.append("acc","delSer");
				data.append("idServei",idServei);
				var deferred=$q.defer();
				$rootScope.cargador=true;
				$http.post("models/serveis.php", data,{
				headers:{
					"Content-type":undefined
				},
				transformRequest:angular.identity
			
			})
			.then(function(res){
				deferred.resolve(res);
				$scope.serveis=res.data;
				$scope.msj="Les dades han estat eliminades correctament";
				$scope.cargaMsj=true;
				$timeout(function(){
					$scope.cargaMsj=false;
				},2000);
				$rootScope.cargador=false;
				$scope.serveis=res.data;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});	
		}	
	}
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
	$scope.eliminarSubservei=function(idSubservei,nomSubservei){
		var respuesta= confirm ("Desitja eliminar el Subservei "+nomSubservei+"?")
		if (respuesta) 
		{
			var data = new FormData();
				data.append("acc","delSubser");
				data.append("idSubservei",idSubservei);
				var deferred=$q.defer();
				$rootScope.cargador=true;
				$http.post("models/serveis.php", data,{
				headers:{
					"Content-type":undefined
				},
				transformRequest:angular.identity
			
			})
			.then(function(res){
					deferred.resolve(res);
					$scope.serveis=res.data;
					$scope.msj="Les dades han estat eliminades correctament";
					$scope.cargaMsj=true;
					$timeout(function(){
						$scope.cargaMsj=false;
					},2000);
					$rootScope.cargador=false;
					$scope.serveis=res.data;
					
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}		
	$scope.cancelSer=function(){
		$scope.reveal=true;
		$scope.revealSub=true;
	}

})
.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	var data = new FormData();
		data.append("acc", "l");
	var deferred=$q.defer();
	
	$rootScope.cargador=true;
	$http.post("models/associacio.php", data,{
	headers:{
		"Content-type":undefined
	},
	transformRequest:angular.identity

	})
	.then(function(resIcon){
		deferred.resolve(resIcon);
		$rootScope.favIcon=resIcon.data[0].favIcon;
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});

	$scope.not={};
	$scope.msj="";
	$scope.reveal=true;
	$scope.accionNot="";
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	$rootScope.cargador=true;
	$http.post("models/noticies.php", data,{
		headers:{
			"Content-type":undefined
		},
			transformRequest:angular.identity
	})

	.then(function(res){
		deferred.resolve(res);
		$scope.noticies=res.data.dadesNoticies;
		$scope.totalPrincipal=res.data.cantNoticiesPrincipal;
		$rootScope.cargador=false;
	})
	.catch(function(error){
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
 		var element = document.getElementById("NotiEditTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
	$scope.EditNoticia=function(PosNoti){
		$scope.reveal=false;
		$scope.not.fotoNoticia="";
		if(PosNoti!="-1"){
			$scope.accionNot="Editar";
			$scope.not.idNoticia=$scope.noticies[PosNoti].idNoticia;
			$scope.not.titolNoticia=$scope.noticies[PosNoti].titolNoticia;
			$scope.not.dataNoticia=$scope.noticies[PosNoti].dataNoticia;
			$scope.not.txtNoticia=$scope.noticies[PosNoti].txtNoticia;
			$scope.not.fotoNoticia=$scope.noticies[PosNoti].fotoNoticia;
			$scope.not.fotoNoticiaOld=$scope.noticies[PosNoti].fotoNoticia;
			$scope.not.principal=$scope.noticies[PosNoti].principal;		
		}
		else{

			$scope.accionNot="Afegir";
			$scope.not.idNoticia="";
			$scope.not.titolNoticia="";
			var d=new Date();
			var yyyy=d.getFullYear();
			var mm=d.getMonth()<9?"0"+(d.getMonth()+1):(d.getMonth()+1);
			var dd=d.getDate()<10?"0"+(d.getDate()):(d.getDate());
			$scope.not.dataNoticia=yyyy+"-"+mm+"-"+dd;
			$scope.not.txtNoticia="";
			$scope.not.fotoNoticia="";
			$scope.not.fotoNoticiaOld="";
			$scope.not.principal="N";
			}
		var element = document.getElementById("NotiEditTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	$scope.accioNoticies=function(){
		var data = new FormData();
			data.append("acc", $scope.accionNot);
			data.append("idNoticia", $scope.not.idNoticia);
			data.append("titolNoticia", $scope.not.titolNoticia);
			data.append("dataNoticia", $scope.not.dataNoticia);
			data.append("txtNoticia", $scope.not.txtNoticia);
			data.append("fotoNoticia", $scope.not.fotoNoticia);
			data.append("principal", $scope.not.principal);
			data.append("fotoNoticiaOld", $scope.not.fotoNoticiaOld);
		var deferred=$q.defer();
	    $rootScope.cargador=true;
		$http.post("models/noticies.php", data,{
			headers:{
				"Content-type":undefined
			},
			transformRequest:angular.identity
		
		})
		.then(function(res){
			deferred.resolve(res);
			$scope.noticies=res.data;			 	
			console.log(res.data);
			$scope.reveal=true;
			$scope.msj="Les dades han estat actualitzades correctament";
			$scope.cargaMsj=true;
			$timeout(function(){
				$scope.cargaMsj=false;
			},2000);
			$rootScope.cargador=false;
		})
		.catch(function(error){
			$rootScope.cargador=false;
		});
	}

	$scope.eliminarNoticies=function(idNoticia,titolNoticia, fotoNoticia){
		var respuesta= confirm ("Desitja eliminar l'esdeveniment "+titolNoticia+"?")
		if (respuesta) 
		{
			var data = new FormData();
				data.append("acc","delNot");
				data.append("idNoticia",idNoticia);
				data.append("fotoNoticia",fotoNoticia);
				var deferred=$q.defer();
				$rootScope.cargador=true;
				$http.post("models/noticies.php", data,{
				headers:{
					"Content-type":undefined
				},
				transformRequest:angular.identity
			
			})
			.then(function(res){
					deferred.resolve(res);
					$scope.noticies=res.data;
					$scope.reveal=true;
					$scope.msj="Les dades han estat eliminades correctament";
					$scope.cargaMsj=true;
					$timeout(function(){
						$scope.cargaMsj=false;
					},2000);
					$rootScope.cargador=false;
					
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}	
	$scope.cancelNot=function(){
		$scope.reveal=true;
	}
	$scope.cambiaPrinc=function(principal,idNoticia){
		console.log(principal+" "+$scope.totalPrincipal+" "+idNoticia);
		if(principal=='S' && $scope.totalPrincipal==2)
		{
			alert("Només pot triar 2 notícies favorites");
		}
		else{


		var deferred=$q.defer();
		var data = new FormData();
		data.append("acc","updatePrincipal");
		data.append("principal",principal);
		data.append("idNoticia",idNoticia);	
		$rootScope.cargador=true;
		$http.post("models/noticies.php", data,{
		headers:{
			"Content-type":undefined
		},
			transformRequest:angular.identity
		})
		.then(function(res){
					deferred.resolve(res);
					$scope.noticies=res.data.dadesNoticies;
					$scope.totalPrincipal=res.data.cantNoticiesPrincipal;
					$rootScope.cargador=false;					
				})
		.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
	$scope.getFileDetails=function(e){
		$scope.not.fotoNoticia=e.files[0];
	}		
})
.controller('CategCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});

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
	$scope.muestraFormCat=function(idEdit=""){
		$scope.dadesCateg=false;
		if(idEdit!="-1"){
			$scope.accion="Edita";
			$scope.cat.idCategoria=$scope.categories[idEdit].idCategoria;
			$scope.cat.nomCategoria=$scope.categories[idEdit].nomCategoria;
			$scope.cat.pictograma=$scope.categories[idEdit].pictograma;
			$scope.cat.pictogramaOld=$scope.categories[idEdit].pictograma;
		}
		else{
			$scope.accion="Afegir";
			$scope.cat.nomCategoria="";
			$scope.cat.pictograma="";

		}
	}
	$scope.cancel=function(listSocis){
		$scope.dadesCateg=true;		
	}
	$scope.edit=function(accion){
		console.log(accion);
		if($scope.cat.nomCategoria==""){
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$scope.divMsj=true;
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);}
		else{
			$scope.msj="Les dades s'han actualitzat correctament.";
			var data = new FormData();
				data.append("acc",$scope.accion);
				data.append("idCategoria",$scope.cat.idCategoria);
				data.append("nomCategoria",$scope.cat.nomCategoria);
				data.append("logoUpdate", $scope.cat.logoUpdate);
				data.append("pictogramaOld", $scope.cat.pictograma);
				var deferred=$q.defer();
			$rootScope.cargador=true;
			$http.post("models/categories.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})

			.then(function(res){
				deferred.resolve(res);
				$scope.categories=res.data;
				$scope.msj="Les dades s'han actualitzat correctament.";
				$scope.dadesCateg=true;
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
				$rootScope.cargador=false;
				console.log(res.data);				
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
	$scope.getFileDetailss = function (e) {
		console.log(e.files[0].name);
		$("#inputPictograma").val(e.files[0].name);
		$scope.cat.logoUpdate=e.files[0];		
    } 
	$scope.elimina=function(idCategoria){
		console.log(idCategoria);
		var confirmar=confirm("Segur que vol eliminar aquesta categoria?")
		if(confirmar){
	    	var data = new FormData();
				data.append("idCategoria",idCategoria);
				data.append("acc","elim");
				
			$scope.cargador=true;
			$http.post("models/categories.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})

			.then(function(res){
				deferred.resolve(res);
				$scope.categories=res.data;
				$scope.cargador=false;
				console.log(res.data);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	}
})
.controller('CarCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	$scope.imatgesCarBan=true;
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;
	});

	$scope.car={};
	var data = new FormData();
		data.append("acc","c");
    var deferred=$q.defer();

	$http.post("models/carousel.php", data,{

		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.imatgesCar=res.data;
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
	$scope.uploadGaleria=function(e){
			$scope.filesImages = [];
			$scope.$apply(function () {
			// Guardamos los ficheros en un array.
				for (var i = 0; i < e.files.length; i++) {
				    $scope.filesImages.push(e.files[i]);
					$scope.message=e.files[i]['name'];
					console.log($scope.filesImages.length+$scope.message);
				}
            });  
            var data = new FormData();

            data.append("acc", "uploadImg");
            data.append("idCarousel",$scope.car.idCarousel);
			for (var i in $scope.filesImages) {
			        data.append("uploadedFile"+i, $scope.filesImages[i]);
			        console.log("uploadedFile"+i, $scope.filesImages[i]);
			}

			data.append("cantImatge", i);
			 var deferred=$q.defer();
			 $http.post("models/carousel.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					deferred.resolve(res);
					$scope.imatgesCar=res.data;
					console.log(res.data);
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
	}
	$scope.deleteImg=function(idCarousel,logo){
		var segur=confirm("Segur que vols eliminar aquesta imatge?");
		if (segur) {
			var data = new FormData();
			data.append("acc","delImg");
			data.append("idCarousel",idCarousel);
			data.append("logo",logo);
			var deferred=$q.defer();
			$rootScope.cargador=true;
				$http.post("models/carousel.php", data,{
					headers:{
						"Content-type":undefined
					},
						transformRequest:angular.identity
				})
				.then(function(res){
					deferred.resolve(res);
					$scope.imatgesCar=res.data;
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
.controller('BannerCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
	$scope.imatgesCarBan=false;
	var data = new FormData();
		data.append("acc", "l");
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
		$rootScope.logo=resIcon.data[0].logoBolsa;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;
	});

	$scope.ban={};
	$scope.dadesBanner=true;
	$scope.muestraInput="directori";
	$scope.associatSel="-1";
	$scope.ban.fotoBanner="";
	var data = new FormData();
		data.append("acc","b");
    var deferred=$q.defer();

	$http.post("models/carousel.php", data,{

		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.imatgesBanner=res.data.banner;
		$scope.associats=res.data.associats;
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
	$scope.insertBanner=function(){
		$scope.dadesBanner=false;
		$scope.associatSel="-1";
		$scope.ban.fotoBanner="";	
	}
	$scope.muestraURL=function(tipo)
	{
		$scope.muestraInput=tipo;
		if (tipo=="directori") {
			$scope.associatSel="-1";
		}
		else{
			$scope.associatSel="";
		}
		console.log(tipo);
	}
	// $scope.uploadGaleria=function(e){
	// 	console.log(e);
	// 	$scope.divMsj=true;
	// 	if ($scope.associatSel=="" || $scope.associatSel=="-1") {
	// 		$timeout(function() {
	// 			$scope.divMsj=false;
	// 		}, 2000);
	// 	}
	// 	else{
	// 		if ($scope.muestraInput=="directori") {
	// 			$scope.associatSel="#/directori/"+$scope.associatSel;
	// 		}
	// 		var data = new FormData();
 //            data.append("acc", "upImg");
 //            data.append("fotoBanner", $scope.ban.fotoBanner);
 //            data.append("idBanner",$scope.ban.idBanner);
	// 			//data.append("logoDelete", $scope.com.bannerOld);
	// 		var deferred=$q.defer();
	// 		$http.post("models/carousel.php", data,{
	// 			headers:{
	// 				"Content-type":undefined
	// 			},
	// 				transformRequest:angular.identity
	// 			})
	// 			.then(function(res)
	// 			{
	// 				deferred.resolve(res);
	// 				$rootScope.cargador=false;
	// 				$scope.imatgesBanner=res.data.banner;

	// 			})
	// 			.catch(function(error) {
	// 				$rootScope.cargador=false;
	// 			});
	// 	}
	// }
	$scope.nowBanner=function(){
		$scope.divMsj=true;
		if ($scope.associatSel=="" || $scope.associatSel=="-1") {
			$timeout(function() {
				$scope.divMsj=false;
			}, 2000);
		}
		else{
			if ($scope.muestraInput=="directori") {
				$scope.associatSel="#/directori/"+$scope.associatSel;
			}
			var data = new FormData();
            data.append("acc", "newBanner");
            data.append("URLWeb", $scope.associatSel);
            data.append("fotoBanner", $scope.ban.logoUpdate);
			 var deferred=$q.defer();
			 $http.post("models/carousel.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					deferred.resolve(res);
					$rootScope.cargador=false;
					$scope.imatgesBanner=res.data.banner;
					$scope.dadesBanner=true;
					$scope.muestraInput="directori";
					$scope.associatSel="-1";
					$("#inputBanner").val("");				
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
		}
	}
	$scope.uploadGaleria = function (e) {
		console.log(e.files[0].name);
		$("#inputBanner").val(e.files[0].name);
		$scope.ban.logoUpdate=e.files[0];		
    } 
	$scope.deleteImg=function(idBanner,logo){
		console.log("hola");
		var segur=confirm("Segur que vols eliminar aquest Banner?");
		if (segur) {
			var data = new FormData();
			data.append("acc","dImg");
			data.append("idBanner",idBanner);
			data.append("logo",logo);
			var deferred=$q.defer();
			$rootScope.cargador=true;
				$http.post("models/carousel.php", data,{
					headers:{
						"Content-type":undefined
					},
						transformRequest:angular.identity
				})
				.then(function(res){
					deferred.resolve(res);
					$scope.imatgesBanner=res.data.banner;
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
	$scope.cancel=function(banners){
		$scope.dadesBanner=true;
		$scope.associatSel="-1";
		$("#inputBanner").val("");	
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
