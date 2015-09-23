//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('GlobalFittingValidationService', ['$q', '_', 'ComparisonService', 'FittingValidationService', 'ItemCounter', function($q, _, ComparisonService, FittingValidationService, ItemCounter) {
		return $q(function(resolve, reject)	{
			ComparisonService.then(function(comparisonService)	{
				var self = FittingValidationService(comparisonService);

				self.getAffectedFittingRules =  function(fittings)	{
					return fittings.global;
				};

				self.getItems = function(composition)	{
					var compositionItems = new ItemCounter();
					_.each(composition.content, function(ship)	{
						var fit = ship.fit;
						if(fit.items == null)	{
							compositionItems.addItem(ship.shipId, 1);
							return;
						}
						compositionItems.add(fit.items);
						if(fit.items.getItemAmount(ship.shipId) == 0)
							compositionItems.addItem(ship.shipId, 1);
					});
					return compositionItems;
				};
				resolve(self);
			}, reject);
		});
	}]);
})(angular)