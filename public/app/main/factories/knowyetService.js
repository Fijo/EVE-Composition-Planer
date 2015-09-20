//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').factory('KnowyetService', ['_', function(_) {
		return {
			getAutocompleteTip: function(name)	{
				return {
					title: 'Autocomplete box ´' + _.capitalizeFirstLetter(name) + '´',
					content: [
						'To fill out the autocomplete box for the ' + name + ' you have to start typing either a name of your ' + name + ' or if you don\'t know the exact name and you don\'t have a lot of ' + name + 's you can type a slash (´/´).',
						'Or you can pick a ' + name + ' of someone else. Therfore you have to type the full username of that person in there and then type a slash and its should start sugesting your the ' + name + ' he has while you can still keep on typing to further filter that list like always.',
						'Please don\'t be inpatient the sugestions sometimes take a couple seconds to load up.'
					]
				};
			}
		};
	}]);
})(angular)