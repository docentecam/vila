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
  .when('/logout',{
    templateUrl:'index.php',
    controller:'LogoutCtrl',
  })
}]); 
