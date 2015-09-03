//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('ValidationService', ['_', function(_) {
		return function(comparisonService)	{
			var self = {};

			self.includeMatchingRule = true;
			
			self.getMatchingAmount = function(ruleRow, objToValidate)	{
				throw 'Not Implemented';
			};

			self.getRuleRows = function(ruleEntity)	{
				throw 'Not Implemented';
			};

			self.getRuleEntities =  function(ruleset)	{
				throw 'Not Implemented';
			};

			self.matchRule = function(ruleEntity, objToValidate)	{
				return _.reduce(self.getRuleRows(ruleEntity), function(memo, ruleRow)	{
					var matchingAmount = self.getMatchingAmount(ruleRow, objToValidate);
					var newValue = comparisonService.get(ruleRow.comparison.id).execute(matchingAmount, ruleRow.value);
					if(ruleRow.concatenation.id != 0) newValue = comparisonService.get(ruleRow.concatenation.id).execute(memo, newValue);
					return newValue;
				}, true);
			};

			self.getMatchingRules = function(ruleset, objToValidate)	{
				var matchingRules = [];
				var ruleEntities = self.getRuleEntities(ruleset);
				if(ruleEntities == null) return matchingRules;
				_.each(ruleEntities, function(ruleEntity)	{
					if(self.matchRule(ruleEntity, objToValidate) == self.includeMatchingRule)
						matchingRules.push(ruleEntity);
				});
				return matchingRules;
			};
			return self;
		}
	}]);
})(angular)