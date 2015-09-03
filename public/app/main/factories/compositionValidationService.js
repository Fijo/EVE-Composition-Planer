//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('CompositionValidationService', ['$q', '_', 'ComparisonService', 'ValidationService', function($q, _, ComparisonService, ValidationService) {
		return $q(function(resolve, reject)	{
			ComparisonService.then(function(comparisonService)	{
				var self = ValidationService(comparisonService);

				self.includeMatchingRule = false;

				self.getMatchingAmount = function(ruleRow, ships)	{
					var i = 0;
					_.each(ships, function(ship)	{
						if(ship.fit.tags.indexOf(ruleRow.tag.name) != -1)
							i++;
					});
					return i;
				};

				self.getRuleRows = function(ruleEntity)	{
					return ruleEntity.fittingRules;
				};

				self.getRuleEntities =  function(ruleset)	{
					return ruleset.rules;
				};

				self.validateComposition = function(ruleset, compositionEntity)	{
					return _.map(self.getMatchingRules(ruleset, compositionEntity.content), function(ruleEntity)	{
						return ruleEntity.message;
					});
				}
				resolve(self);
			}, reject);
		});
	}]);
})(angular)