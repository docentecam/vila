var app=angular.module('vila',['ngRoute']);
app.run(['$rootScope',function($rootScope) {
  	$rootScope.cargador=false;
  	$rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
   	});
}]);
app.config(['$routeProvider',function($routeProvider){
	$routeProvider
	.when('/',{
		templateUrl:'views/inici.php',
		controller:'AssociCtrl',
    title: "Vilactiva"
	})
  .when('/associacio',{
    templateUrl:'views/associacio.php',
    controller:'AssociCtrl',
    title: "Dades Associacio"
  })
  .when('/directori',{
    templateUrl:'views/directori.php',
    controller:'DirectCtrl',
    title: "Llistat d'associats"
  })
  .when('/directori/:idAssociat',{
    templateUrl:'views/directori.php',
    controller:'DirectComerCtrl',
    title: "Manteniment de l'associat"
  })
  .when('/newComerc',{
    templateUrl:'views/directori.php',
    controller:'NewComercCtrl',
    title: "Nou Associat"
  })
  .when('/contactans',{
    templateUrl:'views/contactans.php',
    controller:'ContactCtrl',
    title: "Contacta'ns"
  })
  .when('/firamar/:dataFiramar',{
    templateUrl:'views/firamar.php',
    controller:'FiramarCtrl',
    title: "Firamar"
  })
   .when('/firamarEdit/:dataFiramar',{
    templateUrl:'views/firamar.php',
    controller:'FiramarEditCtrl',
    title: "Firamar"
  })
  .when('/solicitutsoci',{
    templateUrl:'views/solicitutsoc.php',
    controller:'SociCtrl',
    title: "Llistat solicitud de socis"
  })
  .when('/categories',{
    templateUrl:'views/categories.php',
    controller:'CategCtrl',
    title: "Manteniment de categories"
  })
  .when('/serveis',{
    templateUrl:'views/serveis.php',
    controller:'ServeisCtrl',
    title: "Serveis"
  })
  .when('/noticies',{
    templateUrl:'views/noticies.php',
    controller:'NoticiesCtrl',
    title: "Noticies"
  })
  .when('/carousel',{
    templateUrl:'views/carousel.php',
    controller:'CarCtrl',
    title: "Manteniment carousel"
  })
  .when('/banner',{
    templateUrl:'views/carousel.php',
    controller:'BannerCtrl',
    title: "Manteniment Banners"
  })
  .when('/logout',{
    templateUrl:'index.php',
    controller:'LogoutCtrl',
  })
  .otherwise({
    redirectTo:'/'
  });
}]); 