//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('accountSettingsCtrl', ['$scope', '$controller', 'StoreServiceFactory', function ($scope, $controller, StoreServiceFactory) {
		$controller('entityCtrl', { $scope: $scope });

		$scope.isSingleEntity = true;
		$scope.hasUserField = true;
		$scope.canBeListed = false;
		$scope.canBeForked = false;
		$scope.hasGroupAccessInModel = false;
		$scope.hasName = false;

		$scope.message = {
			entityService: 'AccountSettings',
			entity: 'account settings',
			entityCap: 'Account settings',
			entityPlural: 'account settings',
			entityPath: 'account-settings'
		};

		$scope.hierarchy = ['Account settings'];

		$scope.knowyet = [
			{
				title: 'coming soon!',
				content: [
					'coming soon!'
				]
			}
		];

		var shared = (function(){
			var self = {
				emptyAPI: {},
			};
			return self;
		})();


		$scope.model = {};

		$scope.init();

		$scope.apiKeyService = StoreServiceFactory.create({
			getList: function(entity)	{
				return entity.apiKeys;
			},
			emptyEntry: shared.emptyAPI,
			scope: $scope,
			container: $scope.model.entity
		});
	}]);
})(angular)