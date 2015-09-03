//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FittingValidationService', ['$q', '_', 'ComparisonService', 'ValidationService', function($q, _, ComparisonService, ValidationService) {
		return $q(function(resolve, reject)	{
			ComparisonService.then(function(comparisonService)	{
				var self = ValidationService(comparisonService);

				self.getMatchingAmount = function(ruleRow, usedItems)	{
					return _.reduce(ruleRow.itemFilterRules, function(memo, itemFilterItem)	{
						return memo + usedItems.getItemAmount(itemFilterItem);
					}, 0);
				};

				self.getRuleRows = function(ruleEntity)	{
					return ruleEntity.rules;
				};

				self.getRuleEntities =  function(ruleset)	{
					return ruleset.fittings;
				};

				self.validateFitting = function(ruleset, items)	{
					return _.map(self.getMatchingRules(ruleset, items), function(ruleEntity)	{
						return ruleEntity.name;
					});
				}
				resolve(self);
			}, reject);
		});
	}]);
})(angular)