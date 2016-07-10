//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 - 2016 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('StoreServiceFactory', [function() {
		var createWithDynamicContainer = function(options)	{
			return (function()	{
				var self = {
					minEntryCount: options.minEntryCount != null ? options.minEntryCount : 1,
					canRemove: function(container)	{
						return options.getList(container).length > self.minEntryCount;
					},
					add: function(container)	{
						options.scope.ensureAccess();
						options.getList(container).push(_.dclone(options.emptyEntry));
					},
					remove: function(container, index)	{
						options.scope.ensureAccess();
						if(self.canRemove(container)) options.getList(container).splice(index, 1);
					}
				};
				return self;
			})();
		};
		var createWithFixedContainer = function(options)	{
			var service = createWithDynamicContainer(options);
			var self = _.clone(service);
			_.each(['canRemove', 'add', 'remove'], function(fnKey)	{
				self[fnKey] = function()	{
					var argArray = [options.container];
					_.each(arguments, function(value)	{
						argArray.push(value);
					});
					return service[fnKey].apply(this, argArray);
				};
			});
			return self;
		};


		return {
			create: function(options)	{
				if(options.container != null)
					return createWithFixedContainer(options);
				return createWithDynamicContainer(options);
			}
		};
	}]);
})(angular)