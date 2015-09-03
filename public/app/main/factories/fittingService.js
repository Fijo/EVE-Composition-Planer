//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').factory('FittingService', ['_', 'FittingParser', 'FittingWriter', 'FittingConverter', 'ItemCounter', 'ItemConverter', 'FittingValidationService', function(_, FittingParser, FittingWriter, FittingConverter, ItemCounter, ItemConverter, FittingValidationService) {

		var self = {};
		self.setFit = function(model, fittingContent)	{
			var parts = fittingContent.split('\n--\n');
			model.eft = parts[0];
			model.additionals = parts[1];
		};
		self.getFit = function(model)	{
			return (model.eft != null ? model.eft : '') + '\n--\n' + (model.additionals != null ? model.additionals : '');
		};
		self.getItems = function(itemConverter, fit)	{
			var items = new ItemCounter();
			if(fit == null) return items;
			if(fit.header != null && fit.header != false)
				items.addItem(fit.header.shipType, 1);

			_.each(fit.body, function(row)	{
				if(row.item == null) return;
				if(row.amount != null) items.addItem(row.item, row.amount);
				else	{
					items.addItem(row.item, 1);
					if(row.ammo != null) items.addItem(row.ammo, self.getAmountOfAmmoInItem(itemConverter, row.item, row.ammo))
				}
			});
			return items;
		};
		self.getAmountOfAmmoInItem = function(itemConverter, item, ammo)	{
			var itemDetails = itemConverter.getDetails(item);
			var ammoDetails = itemConverter.getDetails(ammo);
			return itemDetails && ammoDetails != null ? Math.floor(itemDetails.capacity / ammoDetails.volume) : 0;
		};
		self.init = function($scope, ship, ruleset)	{
			var fit = ship.fit;
			if(fit.init == null)	{
				if(fit.content != null)	{
					FittingConverter.then(function(fittingConverter)	{
						self.setFit(fit, FittingWriter.writeFit(fittingConverter.convertFit(fit.content, 'NameById')));
					});
				}
				$scope.$watchGroup([function() { return fit.eft; }, function() { return fit.additionals; }], function()	{
					ItemConverter.then(function(itemConverter)	{
						FittingConverter.then(function(fittingConverter)	{
							var content = fittingConverter.convertFit(FittingParser.parseFit(self.getFit(fit)), 'IdByName');
							fit.content = content;
							fit.items = self.getItems(itemConverter, content);
							FittingValidationService.then(function(fittingValidationService)	{
								fit.tags = fittingValidationService.validateFitting(ruleset, fit.items);
							});
							$scope.$broadcast('fitUpdated-' + ship.$$hashKey, []);
						});
					});
				});
				fit.init = true;
			}					
		}
		return self;
	}]);
})(angular)