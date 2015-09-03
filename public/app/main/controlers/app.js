//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	// requires jquery
	angular.module('mainApp').controller('appCtrl', ['$scope', 'User', 'RequestManagementFactory', 'RootValidationService', function ($scope, User, RequestManagementFactory, RootValidationService) {
		$scope.requestManagement = RequestManagementFactory.create();
		$scope.pushRequest = $scope.requestManagement.push;

		$scope.requireLogin = false;

		$scope.isLoggedIn = false;
		$scope.username = '';

		$scope.pushRequest(User.status(function(user)	{
			$scope.isLoggedIn = user.isLoggedIn;
			$scope.username = user.isLoggedIn ? user.username : '';
		}), 'init');

		$scope.isReadonly = function()	{
			return $scope.isLoggedIn;
		};

		$scope.getRepeaterHash = function(item)	{
			return item.$$hashKey.replace(/\:/g, '__');
		};

		$scope.reduceKey = function(item, customKey)	{
			if(customKey == null)
				return {id: item.id};
			var o = {};
			o[customKey] = item[customKey];
			return o;
		};

		RootValidationService.init($scope);
	}]);
})(angular)