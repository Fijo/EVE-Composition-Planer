//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('recoverPasswordCtrl', ['$scope', 'User', function ($scope, User) {
		$scope.sectionName = 'Recover Password';
		$scope.hierarchy = [$scope.sectionName];
		$scope.model = {
			hasName: false,
			entity: {
				email: ''
			}
		};
		$scope.res = { status: '' };

		$scope.isSectionActive = function(name)	{
			return name == 'recover-password';
		};

		$scope.recoverPassword = function()	{
			$scope.res = $scope.pushRequest(User.recoverPassword($scope.model.entity));
		};
	}]);
})(angular)