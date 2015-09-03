//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('entityCtrl', ['$scope', '$injector', '$routeParams', '$route', function ($scope, $injector, $routeParams, $route) {
		$scope.requireLogin = true;
		$scope.isDetail = $routeParams.id != null;

		$scope.ensureAccess = function()	{
			if($scope.isReadonly()){
				alert('Sorry, you don\'t have access to do that!');
				throw 'No access!';
			}
		};

		$scope.isReadonly = function()	{
			return !$scope.isLoggedIn || !$scope.model.entity.isYours;
		};

		$scope.isNew = function()	{
			return $scope.model.entity.id == 'new';
		};

		$scope.d3lete = function()	{
			if(confirm('Are you sure that you want to delete this entity?'))
				$scope.performDelete();
		};

		$scope.completeLoading = function()	{};

		$scope.init = function()	{
			var entityService = $injector.get($scope.message.entityService);

			$scope.getNewEntity = function()	{
				return _.extend({
					id: 'new',
					isYours: true,
					isListed: false
				}, $scope.getNewSpecificEntity());
			};

			$scope.save = function()	{
				$scope.pushRequest(entityService.save({}, $scope.model.entity, function(o)	{
					if($scope.isNew() && o.id != null)
						$route.updateParams({id: o.id});

				}));
			};

			$scope.performDelete = function()	{
				$scope.pushRequest(entityService.d3lete({ id: $scope.model.entity.id }, function(o)	{
					if(o.status == 'success')
						window.location.href = '#/' + $scope.message.entityPath;
				}));
			};

			$scope.fork = function()	{
				$scope.pushRequest(entityService.fork({}, $scope.model.entity, function(o)	{
					if(o.id != null)
						$route.updateParams({id: o.id});
				}));
			};

			if($scope.isDetail)
				$scope.model.entity = $routeParams.id == 'new'
					? $scope.getNewEntity()
					: $scope.pushRequest(entityService.get({ id: $routeParams.id | 0 }, $scope.completeLoading), 'init');
		};
	}]);
})(angular)