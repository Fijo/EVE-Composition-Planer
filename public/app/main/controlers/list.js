//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').controller('listCtrl', ['$scope', '$routeParams', '$route', '$injector', 'pagerFactory', function ($scope, $routeParams, $route, $injector, pagerFactory) {
		$scope.model.hasName = false;

		$scope.listVisibility = $routeParams.visibility;
		$scope.requireLogin = $scope.listVisibility != 'public';
		$scope.list = [];
		$scope.pager = {};

		var page = ($routeParams.page | 0) || 1;
		var entityService = $injector.get($scope.message.entityService);
		$scope.pushRequest(entityService.list({ type: $scope.listVisibility, page: page }, function(data)	{
			$scope.pager = pagerFactory.create({ page: page, pageCount: data.pageCount });
			$scope.list = data.content;
		}), 'init');
		

		$scope.changePage = function(page)	{
			if(!$scope.pager.hasPage(page)) return;
			$route.updateParams({page: page});
		};

		$scope.changeListVisibility = function(value)	{
			$route.updateParams({visibility: value, page: 1});
		};

		$scope.new = function()	{
			$scope.detail('new');
		}

		$scope.detail = function(id)	{
			window.location.href = '#/' + $scope.message.entityPath + '/detail/' + id;
		};

		$scope.isReadonly = function()	{
			return !$scope.isLoggedIn;
		};
	}]);
})(angular)