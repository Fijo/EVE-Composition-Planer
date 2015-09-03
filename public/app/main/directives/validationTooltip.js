//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').factory('ecpValidationTooltip', ['$popover', '$sce', '$$rAF', 'FormValidatorFactory', function ($popover, $sce, $$rAF, FormValidatorFactory) {
		return function()	{
			return {
				restrict: 'A',
				scope: {
					form: '=ecpValidationTooltip',
					field: '@name'
				},
				link: function(scope, element, attrs)	{
					var checkParent = function(parent)	{
						if(parent[0] == null) throw 'The element that a ecp-validation-tooltip is attached to has to be inside of a element with ecp-validation-container attribute';
					};
					var findValidationContainer = function(element)	{
						var parent = element.parent();
						checkParent(parent);

						while(!parent.hasClass('validation-container'))	{
							parent = parent.parent();
							checkParent(parent);
						}
						return parent;
					};

					var validationContainer = findValidationContainer(element);

					var formValidator = FormValidatorFactory.create(scope, scope.form, scope.field);
					var popover = $popover(element, {scope: scope, trigger: 'manual', placement: 'top-right', html: true});

					var show = false;

					formValidator.watch(function()	{
						var validationState = formValidator.getValidationState();
						var validationClass = validationState == 'none' ? '' : 'has-' + validationState;

						if(scope.validationState != validationState)	{
							scope.validationState = validationState;
							scope.$emit('fieldValidated', [element]);
							if(validationClass != '') validationContainer.removeClass('has-success has-error').addClass(validationClass);
						}

						var messages = formValidator.getMessages();
						var content = _.map(messages, function(message)	{
							return message.message;
						}).join('<br>');

						var oldValue = scope.content;
			            scope.content = content;

						if(show) (content == '' ? popover.hide : popover.show)();

			            angular.isDefined(oldValue) && $$rAF(function() {
			              popover && popover.$applyPlacement();
			            });
					});

					element.on('focus', function()	{
						if(scope.content != '') popover.show();
						show = true;
					});

					element.on('blur', function()	{
						show = false;
						popover.hide();
					});

			        scope.$on('$destroy', function() {
						popover.destroy();
			        });
				}
			};
		};
	}]);

	angular.module('mainApp').directive('ecpValidationTooltip', ['ecpValidationTooltip', function (ecpValidationTooltip) {
		return ecpValidationTooltip();
	}]);
	
})(angular)