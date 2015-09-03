//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('rulesetCtrl', ['$scope', '$controller', '$http', 'ShipGroup', 'RuleDef', 'FittingRule', 'StoreServiceFactory', 'RulesetService', function ($scope, $controller, $http, ShipGroup, RuleDef, FittingRule, StoreServiceFactory, RulesetService) {
		$controller('entityCtrl', { $scope: $scope });
		RulesetService($scope);

		$scope.message = {
			entityService: 'Ruleset',
			entity: 'ruleset',
			entityCap: 'Ruleset',
			entityPlural: 'rulesets',
			entityPath: 'ruleset'
		};

		$scope.hierarchy = ['Rule', 'Composition'];

		$scope.filterDefs = {
			comparison: $scope.pushRequest(RuleDef.getComparison(function(comparsions)	{
				$scope.filterDefs.concatenations = comparsions.bool;
			}), 'init'),
			concatenations: []
		};


		var shared = (function(){
			var emptyFittingRule = {
				tag: {}
			};
			var self = {
				emptyFittingRule: emptyFittingRule,
				emptyRule: {
					fittingRules: [_.dclone(emptyFittingRule)]
				},
			};
			return self;
		})();

		$scope.getNewSpecificEntity = function()	{
			return {
				rules: [_.dclone(shared.emptyRule)],
				ships: {}
			};
		};

		$scope.model =	{ 
			entity: {
				name: '',
				isYours: true,
				isListed: false,
				rules: [_.dclone(shared.emptyRule)]
			},
			shipGroups: {
				active: -1,
				content: $scope.pushRequest(ShipGroup.query(), 'init')
			},
			activeTab: 'GeneralInfo'
		};

		$scope.getFittingRulesAutocomplete = function(value)	{
			return FittingRule.autocomplete({s: value}).$promise;
		};

		$scope.updateGroupOverviewPoints = function(shipGroup)	{
			shipGroup.points = $scope.getGroupPoints(shipGroup);
		};

		$scope.updateGroupPoints = function(shipGroup)	{
			$scope.ensureAccess();
			var points = parseInt(shipGroup.points);
			if(isNaN(points)) return;

			console.log('update', points);
			_.each(shipGroup.content, function(ship)	{
				$scope.model.entity.ships[ship.id] = points;
			});
		};

		$scope.getIntComparison = function()	{
			return $scope.filterDefs.comparison['int'];
		};

		$scope.getShipPoints = function(shipId)	{
			var ships = $scope.model.entity.ships;
			if(ships == null) return 0;
			return ships[shipId];
		};

		$scope.getMaxPoints = function()	{
			return $scope.model.entity.maxPoints;
		};


		$scope.completeLoading = function()	{
			var shipGroupsContent = $scope.model.shipGroups.content;
			shipGroupsContent.$promise.then(function()	{
				_.each(shipGroupsContent, $scope.updateGroupOverviewPoints);
			});
		};


		$scope.init();

		$scope.fittingRuleService = StoreServiceFactory.create({
			getList: function(rule)	{
				return rule.fittingRules;
			},
			emptyEntry: shared.emptyFittingRule,
			scope: $scope
		});
		$scope.ruleService = StoreServiceFactory.create({
			getList: function(entity)	{
				return entity.rules;
			},
			emptyEntry: shared.emptyRule,
			scope: $scope,
			container: $scope.model.entity
		});
	}]);
})(angular)