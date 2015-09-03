//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('RequestManagementFactory', [function() {
		return {
			create: function()	{

				var pendingRequests = [];
				var errors = [];
				var status = {
					pendingRequests: [],
					errors: []
				};

				var hasStatus = function(name, type)	{
					 return _.indexOf(status[name], type) != -1;
				};
				var updateStatus = function(list, name) {
					var stati = [];
					_.each(list, function(entity)	{
						var type = entity.type;
						if(_.indexOf(stati, type) == -1)
							stati.push(type);
					});
					status[name] = stati;
				};
				var getPromise = function(promiseObj)	{
					if(promiseObj.$promise != null)
						return promiseObj.$promise;
					return promiseObj;
				};
				var getPendingRequest = function(promise, type)	{
					return {promise: promise, type: type || 'default'};
				};
				var updatePendingRequests = function() {
					updateStatus(pendingRequests, 'pendingRequests');
				};
				var addPendingRequest = function(pedingRequest) {
					pendingRequests.push(pedingRequest);
					updatePendingRequests();
				};
				var removePendingRequest = function(pedingRequest)	{
					var index = _.indexOf(pendingRequests, pedingRequest);
					pendingRequests.splice(index, 1);
					updatePendingRequests();
				};
				var updateErrors = function() {
					updateStatus(errors, 'errors');
				};
				var addError = function(error, type) {
					if(error.type != null)
						throw 'An Error object was expected not to have a type property.';
					errors.push(_.extend({type: type}, error));
					updateErrors();
				};
				var getWrappedError = function(message)	{
					if(typeof message == 'string')
						return {status: 'error', message: message};

					if(message.data != null)	{
						if(message.message != null)
							throw 'An Error object was expected not to have a message property if it has a data property.';
						return _.extend({status: 'error', message: message.data, advanced: true, showDetails: false}, message);
					}

					return message;					
				};

				return {
					push: function(promiseObj, type)	{
						var promise = getPromise(promiseObj);
						var pedingRequest = getPendingRequest(promise, type);
						addPendingRequest(pedingRequest);
						promise.then(function(data)	{
							if(data.status == 'error')
								addError(data, type);
							removePendingRequest(pedingRequest);
							return data;
						}, function(data)	{
							addError(getWrappedError(data), type);
							removePendingRequest(pedingRequest);
							return data;
						});
						return promiseObj;
					},
					getPendingRequests: function()	{
						return pendingRequests;
					},
					getErrors: function()	{
						return errors;
					},
					isPending: function(type)	{
						return hasStatus('pendingRequests', type);
					},
					hasError: function(type)	{
						return hasStatus('errors', type);
					}
				};
			}
		};
	}]);
})(angular)