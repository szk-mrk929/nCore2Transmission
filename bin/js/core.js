'use strict';
var app = angular.module('appCore', ['ngCookies', 'ngAnimate']); //,'ngFileUpload' 'ngRoute', 'ui.router'

app.run(function ($rootScope, $http) {
	// declares
	$rootScope.data = {};
	$rootScope.cim = '';
	$rootScope.toltes = false;
	$rootScope.ertesites = {};

	$rootScope.keresFn = (obj) => {
		$rootScope.toltes = true;
		!obj ? (obj = '*') : obj;
		return $http.post('bin/ncore.php', obj).then(
			(res) => {
				$rootScope.data = res.data;
				$rootScope.toltes = false;
				console.log('keresFn', res.data);
				return true;
			},
			() => {
				$rootScope.toltes = false;
				return false;
			}
		);
	};
	$rootScope.letoltFn = (obj) => {
		return $http.post('bin/letolt.php', obj).then((res) => {
			console.log('letoltFn', res.data, obj, this);
			if (res.data == 'true') {
				$rootScope.ertesites = obj;
			} else {
				alert('Sajnos nem sikerült, szólj Dávidkának!');
			}
		});
	};

	// init
	$rootScope.keresFn('*');
});

app.config(function ($locationProvider, $httpProvider, $compileProvider, $cookiesProvider) {
	$locationProvider.hashPrefix('');
	$locationProvider.html5Mode(true);
	$httpProvider.defaults.timeout = 10000;
	// $httpProvider.defaults.headers.common.lang = 'hu';

	$compileProvider.debugInfoEnabled(false);
	angular.reloadWithDebugInfo = function () {
		window.location.reload();
	};
});

Object.prototype.isEmpty = function () {
	for (var key in this) {
		if (this.hasOwnProperty(key)) return false;
	}
	return true;
};
