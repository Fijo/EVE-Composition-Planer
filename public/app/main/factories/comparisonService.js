//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('ComparisonService', ['$q', '_', 'RuleDef', function($q, _, RuleDef) {
		return $q(function(resolve, reject)	{
			RuleDef.getComparison(function(comparisonsByType)	{
				var comparisonFunctions = {
					'Less than': function(a, b) { return a < b; },
					'Equal to': function(a, b) { return a == b; },
					'Greater than': function(a, b) { return a > b; },
					'And': function(a, b) { return a && b; },
					'Or': function(a, b) { return a || b; }
				};


				var comparisonDict = [];
				_.each(comparisonsByType, function(comparisons, type)	{
					if(type == 'int' || type == 'bool')
						_.each(comparisons, function(comparison)	{
							if(comparisonDict[comparison.id] == null)
								comparisonDict[comparison.id] = _.extend(_.dclone(comparison), {
									execute: comparisonFunctions[comparison.name]
								});
						});
				});
				resolve({
					get: function(id)	{
						return comparisonDict[id];
					}
				})
			}, reject);
		});
	}]);
})(angular)