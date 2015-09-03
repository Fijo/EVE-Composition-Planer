//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('loginCtrl', ['$scope', '$location', 'User', function ($scope, $location, User) {
		var section = $location.$$url.substring(1);
		$scope.hierarchy = [section == 'login' ? 'Login' : 'Register'];
		$scope.model = {
			hasName: false,
			entity: {
				username: '',
				password: ''
			}
		};
		$scope.res = {};

		$scope.isSectionActive = function(name)	{
			return section == name;
		};

		$scope.login = function()	{
			$scope.res = $scope.pushRequest(User.login($scope.model.entity, function(user)	{
				if(user.status == 'success')
					setTimeout(function()	{
						window.location.href = '#/';
						window.location.reload();
					});
			}));
		};

		$scope.register = function()	{
			$scope.res = $scope.pushRequest(User.register($scope.model.entity));
		};
	}]);
})(angular)