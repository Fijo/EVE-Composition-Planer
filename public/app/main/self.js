//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').config(['$routeProvider', function($routeProvider) {
		$routeProvider.when('/', {
			templateUrl: 'app/main/view/page/home.html'
		})
		.when('/register', {
			templateUrl: 'app/main/view/page/login.html',
			controller: 'loginAppCtrl'
		})
		.when('/recover-password', {
			templateUrl: 'app/main/view/page/auth-steps.html',
			controller: 'recoverPasswordAppCtrl'
		})
		.when('/reset-password/:code', {
			templateUrl: 'app/main/view/page/auth-steps.html',
			controller: 'resetPasswordAppCtrl'
		})
		.when('/confirm-registration/:code', {
			templateUrl: 'app/main/view/page/auth-steps.html',
			controller: 'confirmRegistrationAppCtrl'
		})
		.otherwise({
			redirectTo: '/'
		});

		_.each([
			'about', 'feedback', 'login'
		], function(name)	{
			$routeProvider.when('/' + name, {
				templateUrl: 'app/main/view/page/' + name + '.html',
				controller: name + 'AppCtrl'
			});
		});

		_.each([
			{ ctrl: 'composition', name: 'composition'  },
			{ ctrl: 'ruleset', name: 'ruleset' },
			{ ctrl: 'fittingRule', name: 'fitting-rule' }
		], function(config)	{
			$routeProvider.when('/' + config.name + '/', {
				redirectTo: '/' + config.name + '/my/page/1'
			})
			.when('/' + config.name + '/:visibility/page/:page', {
				templateUrl: 'app/main/view/page/list.html',
				controller: config.ctrl + 'ListAppCtrl'
			})
			.when('/' + config.name + '/detail/:id', {
				templateUrl: 'app/main/view/page/' + config.name + '.html',
				controller: config.ctrl + 'AppCtrl'
			});
		});
	}]).config(['CacheFactoryProvider', function (CacheFactoryProvider) {
		angular.extend(CacheFactoryProvider.defaults, { maxAge: 15 * 60 * 1000, storageMode: 'localStorage' });
	}]);
})(angular)