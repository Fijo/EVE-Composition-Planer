//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('User', ['$resource', function($resource) {
		return $resource('/rest/user/:action', {}, {
			login: {
				method: 'POST',
				params: { action: 'login' }
			},
			register: {
				method: 'POST',
				params: { action: 'register' }
			},
			logout: {
				method: 'POST',
				params: { action: 'logout' }
			},
			status: {
				method: 'GET',
				params: { action: 'status' },
				cache: false
			},
			autocomplete: {
				method: 'GET',
				cache: false,
				isArray: true,
				params: { action: 'autocomplete' }	
			},
			check: {
				method: 'GET',
				params: { action: 'check' },
				cache: false
			},
			confirmRegistration: {
				method: 'POST',
				params: { action: 'confirm-registration' }
			},
			recoverPassword: {
				method: 'POST',
				params: { action: 'recover-password' }
			},
			resetPassword: {
				method: 'POST',
				params: { action: 'reset-password' }
			},
			resetPasswordCheck: {
				method: 'GET',
				params: { action: 'reset-password-check' },
				cache: false
			}
		});
	}]);
})(angular)