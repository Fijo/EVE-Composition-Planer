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
				title: 'Link your account with your EVE Characters!',
				content: [
					'Here you can link your account with your ingame characters.',
					'This can be useful if for example your ingame corperation has a group in this app that automaticly allows all corp members of that corperation to access their compositions, rulesets or more.'
				]
			},
			{
				title: 'What permissions do the app require?',
				content: [
					'We only need a zero permission api key because we only need to fetch your general character information (that are always available).',
					'You can use the folowing link to create a api key with the required permissions.',
					'https://community.eveonline.com/support/api-key/CreatePredefined?accessMask=0'
				]
			},
			{
				title: 'How long does it take to gain group access?',
				content: [
					'If there is a group that allows access to you based on your character/ corperation/ alliance it may currently take up to a little more than one day for you to actualy gain access to the group.',
					'If your API key expires access should be refused to you within the a little more than a day as well.'
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