//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('fittingRuleCtrl', ['$scope', '$controller', 'RuleDef', 'StoreServiceFactory', function ($scope, $controller, RuleDef, StoreServiceFactory) {
		$controller('entityCtrl', { $scope: $scope });
		$scope.message = {
			entityService: 'FittingRule',
			entity: 'fitting rule',
			entityCap: 'Fitting rule',
			entityPlural: 'fitting rules',
			entityPath: 'fitting-rule'
		};

		$scope.hierarchy = ['Rule', 'Fitting'];

		$scope.knowyet = [
			{
				title: 'Ship tagging!',
				content: [
					'If a fitting rule for is fulfilled for a ship its gona get `tagged` with the name of that fitting rule.'
				]
			},
			{
				title: 'Is my fitting rule even used yet?',
				content: [
					'Fitting rules will only be used for validating a composition if you are using a ruleset that they are used in.'
				]
			},
			{
				title: 'Item type filter!',
				content: [
					'By specifying the rules in the white area of each of those box(es) you basicly filter the item types that gona be counted.',
					'This area is alot like the item filters you have on the left bottom of each items windows in EVE Online. If you have ever created one of those you should be familiar with how these filters work.'

				]
			},
			{
				title: 'Not only fittings!',
				content: [
					'Not only items from the fittings but also booster, implants and the ship (-item) itself are being used itself to apply the fitting rules to.'
				]
			}
		];

		$scope.filterDefs = {
			comparison: $scope.pushRequest(RuleDef.getComparison(function(comparisons)	{
				$scope.filterDefs.concatenations = comparisons.bool;
			}), 'init'),
			groups: $scope.pushRequest(RuleDef.getItemFilter(), 'init'),
			concatenations: []
		};

		var shared = (function(){
			var emptyItemFilterRule = {
				content: []
			};
			var self = {
				emptyItemFilterRule: emptyItemFilterRule,
				emptyRule: {
					itemFilterRules: [_.dclone(emptyItemFilterRule)]
				},
			};
			return self;
		})();

		$scope.model = {};

		$scope.getNewSpecificEntity = function()	{
			return {
				rules: [_.dclone(shared.emptyRule)]
			};
		};


		$scope.getGroup = function(itemFilterRule)	{
			if(itemFilterRule == null) return;
			var group = itemFilterRule.group;
			if(group == null || group.id == null) return;
			return _.findWhere($scope.filterDefs.groups, group);
		};

		$scope.getGroupType = function(itemFilterRule)	{
			var group = $scope.getGroup(itemFilterRule);
			if(group == null) return;
			return group.type;
		};

		$scope.getGroupComparison = function(itemFilterRule)	{
			var groupType = $scope.getGroupType(itemFilterRule);
			if(groupType == null) return [];
			return $scope.filterDefs.comparison[groupType];
		};

		$scope.getGroupContentDepthList = function(itemFilterRule)	{
			var group = $scope.getGroup(itemFilterRule);
			if(group == null) return [];
			var res = [];
			for(var i = 0; i < group.depth; i++)
				res.push(i);
			return res;
		};

		$scope.getGroupContents = function(itemFilterRule, subGroup)	{
			var group = $scope.getGroup(itemFilterRule);
			if(group.depth <= subGroup) return null;
			var content = group.content;
			for(var i = 0; i < subGroup; i++)	{
				var currentLevel = itemFilterRule.content[i];
				if(currentLevel == null || currentLevel.id == null) return [];
				var currentLevelData = _.findWhere(content, currentLevel);
				if(currentLevelData == null) return [];
				content = currentLevelData.content;
			}
			return content;
		};


		$scope.getIntComparison = function()	{
			return $scope.filterDefs.comparison['int'];
		};


		$scope.init();

		$scope.itemFilterRuleService = StoreServiceFactory.create({
			getList: function(rule)	{
				return rule.itemFilterRules;
			},
			emptyEntry: shared.emptyItemFilterRule,
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