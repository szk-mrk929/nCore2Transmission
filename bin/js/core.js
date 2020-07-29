'use strict';
var app = angular.module('appCore', ['ngCookies', 'ngAnimate', 'ui.router']); //,'ngFileUpload' 'ngRoute'
// var states = [];

app.run(function ($rootScope, $transitions, $state, $stateParams, $timeout, $http) {
	//UserService
	// $rootScope.$state = $state;
	// $rootScope.$stateParams = $stateParams;

	// $rootScope.bootinprogress = 'nonbooted';

	// //START
	// $rootScope.baseTitle = 'Salt & Pepper';
	// $rootScope.usrsvc = UserService;

	$rootScope.data = {};
	$rootScope.cim = '';
	$rootScope.toltes = false;
	$rootScope.ertesites = {};

	$rootScope.keresFn = (obj) => {
		$rootScope.toltes = true;
		!obj ? (obj = '*') : obj;
		return $http.post('bin/ncore.php', obj).then(
			(res) => {
				console.log('eredmeny', res.data);
				$rootScope.data = res.data;
				$rootScope.toltes = false;
				return true;
			},
			() => {
				$rootScope.toltes = false;
				return false;
			}
		);
	};
	$rootScope.letoltFn = (obj) => {
		$rootScope.ertesites = obj;
		return $http.post('bin/letolt.php', obj).then((res) => {
			console.log('letoltFn', res.data, obj);
		});
	};

	$rootScope.keresFn('*');

	// $rootScope.data.mobilemenu = true;
	// $rootScope.userData = {};

	// $timeout(function () {
	// 	$rootScope.bootinprogress = 'booted';
	// });
});

// states.push({
// 	name: 'main',
// 	url: '/',
// 	templateUrl: 'bin/template/main.php',
// 	title: 'Főoldal',
// 	// controller: 'MainCtrl',
// 	col: 'col-auto col-sm-11 col-md-11 col-lg-11 col-xl-11'
// });

app.config(function (
	$locationProvider,
	$httpProvider,
	$compileProvider,
	$cookiesProvider,
	$stateProvider,
	$urlRouterProvider
) {
	//console.log("module",$routeProvider,$locationProvider);
	// $urlRouterProvider.otherwise('/');

	// //detect last states
	// states.forEach(function (state) {
	// 	$stateProvider.state(state);
	// });

	$locationProvider.hashPrefix('');
	$locationProvider.html5Mode(true);
	$httpProvider.defaults.timeout = 10000;
	$httpProvider.defaults.headers.common.lang = 'hu';

	// $compileProvider.debugInfoEnabled(false);
	// angular.reloadWithDebugInfo = function(){ window.location.reload(); }
});

Object.prototype.isEmpty = function () {
	for (var key in this) {
		if (this.hasOwnProperty(key)) return false;
	}
	return true;
};
