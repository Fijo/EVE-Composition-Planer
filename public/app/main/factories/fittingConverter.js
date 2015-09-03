//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, console, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FittingConverter', ['$q', '_', 'ItemConverter', function($q, _, ItemConverter) {
		return $q(function(resolve, reject)	{
			ItemConverter.then(function(itemConverter)	{
				var self = {};
				
				self.convert = function(direction)	{
					return itemConverter['get' + direction];
				};

				self.convertFit = function(fit, direction)	{
					if(fit == false) return false;
					return {
						header: self.convertHeader(fit.header, direction),
						body: self.convertBody(fit.body, direction)
					};
				};

				self.convertHeader = function(header, direction)	{
					if(header == false) return false;
					return _.extendOwn(header, { shipType: self.convert(direction)(header.shipType) });
				};

				self.convertBody = function(body, direction)	{
					return _.map(body, function(row)	{
						return self.convertRow(row, direction);
					});
				};

				self.convertRow = function(row, direction)	{
					var convert = self.convert(direction);
					var result = _.clone(row);
					_.each(['item', 'ammo'], function(key)	{
						if(row[key] != null) result[key] = convert(row[key]);
					});
					return result;
				};

				resolve(self);
			}, reject);
		});
	}]);
})(angular, console)
