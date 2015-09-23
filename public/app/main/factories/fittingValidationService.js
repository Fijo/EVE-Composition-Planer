//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FittingValidationService', ['_', 'ValidationService', function(_, ValidationService) {
		return function(comparisonService)	{
			var self = ValidationService(comparisonService);

			self.getAffectedFittingRules =  function(fittings)	{
				throw 'Not Implemented';
			};

			self.getItems =  function(objToValidate)	{
				throw 'Not Implemented';
			};

			self.getMatchingAmount = function(ruleRow, usedItems)	{
				return _.reduce(ruleRow.itemFilterRules, function(memo, itemFilterItem)	{
					return memo + usedItems.getItemAmount(itemFilterItem);
				}, 0);
			};

			self.getRuleRows = function(ruleEntity)	{
				return ruleEntity.rules;
			};

			self.getRuleEntities =  function(ruleset)	{
				return self.getAffectedFittingRules(ruleset.fittings);
			};

			self.validateFitting = function(ruleset, objToValidate)	{
				return _.map(self.getMatchingRules(ruleset, self.getItems(objToValidate)), function(ruleEntity)	{
					return ruleEntity.name;
				});
			};
			return self;
		};
	}]);
})(angular)