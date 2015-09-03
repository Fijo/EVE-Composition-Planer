//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, console, undefined)	{
	'use strict';

	angular.module('mainApp').factory('ItemConverter', ['$q', '_', 'Item', function($q, _, Item) {
		return $q(function(resolve, reject)	{
			Item.query(function(items)	{
				var nameById = {};
				var idByName = {};
				var dict = {};
				_.each(items, function(item)	{
					idByName[item.name] = item.id;
					nameById[item.id] = item.name;
					dict[item.id] = item;
				});
				resolve({
					getDetails: function(id)	{
						return dict[id];
					},
					getNameById: function(id)	{
						return nameById[id];
					},
					getIdByName: function(name)	{
						return idByName[name] || '[item not found]';
					}
				});
			}, reject);
		});
	}]);
})(angular, console)
