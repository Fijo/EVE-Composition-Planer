//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('Ruleset', ['$resource', function($resource) {
		return $resource('/rest/ruleset/:id', {}, {
			get: {
				method: 'GET',
				cache: false
			},
			save: {
				method: 'POST',
				params: { id: null }
			},
			d3lete: {
				method: 'DELETE'
			},
			fork: {
				method: 'POST',
				params: { id: 'fork' }	
			},
			check: {
				method: 'GET',
				params: { id: 'check' },
				cache: false
			},
			list: {
				method: 'GET',
				cache: false,
				params: { id: 'list' }	
			},
			autocomplete: {
				method: 'GET',
				cache: false,
				isArray: true,
				params: { id: 'autocomplete' }	
			},
			validation: {
				method: 'GET',
				cache: false,
				params: { id: 'validation' }	
			}
		});
	}]);
})(angular)