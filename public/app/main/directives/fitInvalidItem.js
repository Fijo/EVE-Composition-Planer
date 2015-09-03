//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').directive('ecpFitInvalidItem', ['$q', function ($q) {
		return {
			restrict: 'A',
			require: 'ngModel',
			scope: false,
			link: function(scope, elm, attrs, ngModel) {
				ngModel.$asyncValidators.ecpFitInvalidItem = function(modelValue, viewValue) {
			  		var def = $q.defer();
			  		var shipModelKey = attrs['ecpShipModel'];
			  		if(shipModelKey == null) throw 'An element that an ecp-fit-invalid-item attribute has been attached to need to also have a ecp-ship-model attribute attached to it.';
		  			var ship = scope.$eval(shipModelKey);
		  			var seperatorGroupIndex = attrs['ecpFitInvalidItem'] | 0;

		  			if(seperatorGroupIndex == 1 && (modelValue || '').trim() == '') def.resolve();
		  			else	{
				  		var validate = function()	{
				  			var valid = false;
				  			if(ship != null && ship.fit != null && ship.fit.content != null && ship.fit.content.body != null) {
				  				var body = ship.fit.content.body;

				  				var affectedItems = [];
				  				var groupIndex = 0;
				  				_.each(body, function(row)	{
				  					if(row.type == 'seperator')	{
				  						groupIndex++;
				  					}
				  					else if(groupIndex == seperatorGroupIndex)
				  						affectedItems.push(row);
				  				});

				  				valid = _.reduce(affectedItems, function(memo, row)	{
				  					return memo && _.reduce(row, function(memo, value)	{
				  						return memo && value != '[item not found]';
				  					}, true);
				  				}, true);
				  			}

				  			if(valid) def.resolve();
							else def.reject();
				  		};
				  		var unlisten = scope.$on('fitUpdated-' + ship.$$hashKey, function()	{
				  			unlisten();
				  			validate();
				  		});
				  	}
			  		return def.promise;
				}
			}
		};
	}]);

})(angular)