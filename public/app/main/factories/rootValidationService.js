//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('RootValidationService', ['_', function(_) {
		return {
			init: function($scope)	{

				var getAllValidationContainerRoots = function(element)	{
					var result = angular.element(element).closest('.validation-container-root');
					if(result.length == 0) return [];
					_.each(result, function(entry)	{
						_.each(getAllValidationContainerRoots(angular.element(entry).parent()), function(e)	{
							result.push(e);
						});						
					});
					return result;
				}
				var getValidationContainers = function(element)	{
					var validationContainers = getAllValidationContainerRoots(element); // check
					if(validationContainers.length == 0) return [];

					return _.map(validationContainers, function(validationContainer)	{
						validationContainer = angular.element(validationContainer);
						var redirectValidation = validationContainer.attr('ecp-redirect-validation');
						if(redirectValidation != null)	{
							validationContainer = angular.element(redirectValidation);
							if(validationContainer.length == 0) throw 'ecp-redirect-validation element with the selector ´' + redirectValidation + '´ could not be found';
						}
						return validationContainer;
					});
					
				};

				var currentElementId = 0;
				var getUniqueId = function(element)	{
					var id = element.attr('id');
					if(id != null) return id;
					var newId = 'validation-root-' + currentElementId++;
					element.attr('id', newId);
					return id;
				};

				var getRootValidation = function(fieldScope, element)	{
					if(fieldScope.rootValidation != null) return fieldScope.rootValidation;
					var rootValidation = fieldScope.rootValidation = {};
					var validationContainers = getValidationContainers(element);
					if(validationContainers.length == 0) return rootValidation;

					rootValidation.containers = _.map(validationContainers, function(validationContainer)	{
						var result = { element: validationContainer };
						var containerId = getUniqueId(validationContainer);
						var containerContext = result.context = containerRoots[containerId] == null
							? containerRoots[containerId] = {content: [], hasError: false}
							: containerRoots[containerId];

						containerContext.content.push(fieldScope);
						return result;
					});


			        fieldScope.$on('$destroy', function() {
			        	var containerContexts = _.map(rootValidation.containers, function(container)	{
			        		return containerRoots[getUniqueId(container.element)];
			        	});
			        	
						_.each(containerContexts, function(containerContext)	{
							containerContext.content = _.reject(containerContext.content, function(sc) { return sc.field == fieldScope.field; });
						});

						// revalidate closest container
						var firstContainerContextWithOthers = _.find(containerContexts, function(containerContext)	{
							return containerContext.content.length != 0;
						});
						if(firstContainerContextWithOthers != null) firstContainerContextWithOthers.content[0].$emit('fieldValidated', [element]);
			        });

					return rootValidation;
				};
				var scopeHasError = function(scope)	{
					return scope.validationState == 'error';
				};

				var containerRoots = {};

				$scope.$on('fieldValidated', function(e, args)	{
					var fieldScope = e.targetScope;
					var rootValidation = getRootValidation(fieldScope, args[0]);
					if(rootValidation.containers == null)	{
						return;
					}

					var currentScopeHasError = scopeHasError(fieldScope);
					_.each(rootValidation.containers, function(container)	{
						if(currentScopeHasError != container.context.hasError)	{
							var hasError = currentScopeHasError || _.reduce(container.context.content, function(memo, scope)	{
								return memo || scopeHasError(scope);
							}, false);

							if(hasError) container.element.addClass('root-error');
							else container.element.removeClass('root-error');

							container.context.hasError = hasError
						};
					})
				});
			}
		};
	}]);
})(angular)