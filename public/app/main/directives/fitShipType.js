//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').directive('ecpFitShipType', ['$q', function ($q) {
		return {
			restrict: 'A',
			require: 'ngModel',
			scope: false,
			link: function(scope, elm, attrs, ngModel) {
				ngModel.$asyncValidators.ecpFitShipType = function(modelValue, viewValue) {
			  		var def = $q.defer();
			  		var shipModelKey = attrs['ecpShipModel'];
			  		if(shipModelKey == null) throw 'An element that an ecp-fit-ship-type attribute has been attached to need to also have a ecp-ship-model attribute attached to it.';
		  			var ship = scope.$eval(shipModelKey);

			  		var validate = function()	{
			  			if(ship != null && ship.fit != null && ship.fit.content != null && ship.fit.content.header != null && ship.fit.content.header != false
			  				&& ship.shipId == ship.fit.content.header.shipType) def.resolve();
						else def.reject();
			  		};
			  		var unlisten = scope.$on('fitUpdated-' + ship.$$hashKey, function()	{
			  			unlisten();
			  			validate();
			  		});
			  		return def.promise;
				}
			}
		};
	}]);

})(angular)