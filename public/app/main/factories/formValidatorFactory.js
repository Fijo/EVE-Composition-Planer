//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FormValidatorFactory', [function() {
		return {
			create: function(scope, form, field)	{
				var messageGroups = [{
					name: 'error',
					content: [
						{field: 'required', message: 'You did not enter a field'},
						{field: 'idRequired', message: 'You havent chosen one of the autocomplete sugestions yet.'},
						{field: 'integer', message: 'Please enter a valid interger'},
						{field: 'number', message: 'Please enter a valid number'},
						{field: 'min', message: 'Your number is too low'},
						{field: 'max', message: 'Your number is too high'},
						{field: 'minlength', message: 'The input you made is too short'},
						{field: 'maxlength', message: 'The input you made is too long'},
						{field: 'email', message: 'Your E-Mail isn\'t valid'},
						{field: 'ecpEntityName', message: 'Name already in usage'},
						{field: 'ecpEntityNameFormat', message: 'Slashes are not allowed in names.'},
						{field: 'ecpPassword', message: 'Both passwords must match'},
						{field: 'ecpFitShipType', message: 'Your fitting isn\'t for the right ship.'},
						{field: 'ecpFitInvalidItem', message: 'At least one of the items from your fit does not exist.'},
					]
				}, {
					name: 'pending',
					content: [
						{field: 'ecpEntityName', message: 'Checking name availibility...'},
						{field: 'ecpFitShipType', message: 'Checking fitting...'},
						{field: 'ecpFitInvalidItem', message: 'Checking fitting...'}
					]
				}];

				var self = {};

				self.validateFieldYet = function()	{
					return form.$submitted || form[field].$touched;
				};

				self.getValidationState = function()	{
					return self.validateFieldYet() ? (form[field].$valid ? 'success' : 'error') : 'none';
				};

				self.watch = function(callback)	{
					scope.$watch(function()	{
						var fi = form[field];
						var getKeyStr = function(obj)	{
							if(obj == null) return '';
							return Object.keys(obj).join('_');
						};

						var validateYetPart = self.validateFieldYet() ? '*' : '';
						return validateYetPart + getKeyStr(fi.$error) + '#' + getKeyStr(fi.$pending);
					}, callback);
				};

				self.getMessages = function()	{
					if(!self.validateFieldYet()) return [];

					var messages = [];
					_.each(messageGroups, function(messageGroup)	{
						var fieldData = scope.form[scope.field];
						if(fieldData == null) return;
						var messageData = fieldData['$' + messageGroup.name];
						if(messageData == null) return;
						_.each(messageGroup.content, function(message)	{
							if(messageData[message.field] != null) 
								messages.push({message: message.message, type: messageGroup.name});
						});
					});
					return messages;
				}

				return self;
			}
		};
	}]);
})(angular)