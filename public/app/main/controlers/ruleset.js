//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('rulesetCtrl', ['$scope', '$controller', '$http', 'ShipGroup', 'RuleDef', 'FittingRule', 'StoreServiceFactory', 'RulesetService', 'KnowyetService', function ($scope, $controller, $http, ShipGroup, RuleDef, FittingRule, StoreServiceFactory, RulesetService, KnowyetService) {
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

		$scope.knowyet = [
			{
				title: 'Ship points: point amount for the whole category!',
				content: [
					'Under the tab ´Ship points´ you can simply type into the textboxes to specify a certain amount of points for the whole category quickly.'
				]
			},
			{
				title: 'Ship points: setting points for individual ships!',
				content: [
					'Under the tab ´Ship points´ you can expand each ship category by clicking on the blue text on the left side of each greay box.',
					'You can then specify a point amount for each ship individualy.'
				]
			},
			{
				title: 'Ship points: forbidding ships or ship groups entirely',
				content: [
					'You can forbid individual ships or whole ship groups entirely just by giving them a point requirement that exceeds the maximum amount of points that you have specified on the ´General information´ tab.',
					'In both cases the according corresponding containers will become half transperent to indicate that they have been entirely forbidden.'

				]
			},
			{
				title: 'Rules: what are those?',
				content: [
					'On the ´Rules´ tab you can basicly specify rules that your composition has to fulfill.',
					'Each of those grey and white boxes can be used to define a single rule.'
				]
			},
			{
				title: 'Rules: rule violations!',
				content: [
					'When your ruleset is used in a composition you rules are gona be applied to that composition.',
					'If the rule reqirements aren´t meet for a rule a message will pop up telling the message you entered in the bottom of the corresponding rule box.'
				]
			},
			KnowyetService.getAutocompleteTip('fitting rule'),
			{
				title: 'Rules: fitting tags!',
				content: [
					'If you don\' know what fitting tags are you should propobly create a fitting rule first. Also you can look at a existing example composition with a ruleset. Just check out some of the public ones.',
					'Basicly the short version is there are fitting rules that are used to validate the fits in the composition. if any of those fits violates a fitting rule the fits is then being tagged with the name of that corresponding fitting rule.',
					'Now you are basicly using those information in tag form to start validating the entire composition using your ruleset.'
				]
			}
		];

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

		$scope.getNewSpecificEntity = function()	{
			var entity = {
				rules: [_.dclone(shared.emptyRule)],
				ships: {}
			};

			$scope.model.shipGroups.content.$promise.then(function(shipGroups)	{
				_.each(shipGroups, function(shipGroup)	{
					_.each(shipGroup.content, function(ship)	{
						entity.ships[ship.id] = 9999;
					});
				});
			});
			return entity;
		};

		$scope.getFittingRulesAutocomplete = function(value)	{
			return FittingRule.autocomplete({s: value}).$promise;
		};

		$scope.updateGroupOverviewPoints = function(shipGroup)	{
			shipGroup.points = $scope.getGroupPoints(shipGroup);
		};

		$scope.updateGroupsOverviewsPoints = function()	{
			var shipGroupsContent = $scope.model.shipGroups.content;
			shipGroupsContent.$promise.then(function()	{
				_.each(shipGroupsContent, $scope.updateGroupOverviewPoints);
			});
		};

		$scope.updateGroupPoints = function(shipGroup)	{
			$scope.ensureAccess();
			var points = parseInt(shipGroup.points);
			if(isNaN(points)) return;

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
			$scope.updateGroupsOverviewsPoints();
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