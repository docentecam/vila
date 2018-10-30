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
		controller:'IniciCtrl',
    title: "Vilactiva"
	})
  .when('/associacio',{
    templateUrl:'views/associacio.php',
    controller:'AssociCtrl',
    title: "Manteniment Associacio"
  })
  .when('/directori',{
    templateUrl:'views/directori.php',
    controller:'DirectCtrl',
    title: "Manteniment Directori"
  })
  .when('/contactans',{
    templateUrl:'views/contactans.php',
    controller:'ContactCtrl',
    title: "Contacta'ns"
  })
<<<<<<< HEAD
  .when('/firamar',{
    templateUrl:'views/firamar.php',
    controller:'FiramarCtrl',
    title: "Firamar"
  })
=======
  .when('/solicitutsoc',{
    templateUrl:'views/contactans.php',
    controller:'SociCtrl',
    title: "Llistat Solicitud de socis"
  })

>>>>>>> d6d7c015de4469bbf1113ac464ec1540c750427a
  .when('/logout',{
    templateUrl:'index.php',
    controller:'LogoutCtrl',
  })
  .otherwise({
    redirectTo:'/'
  });
}]); 
