//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	//required jquery
	angular.module('mainApp').directive('ecpSubmit', [function () {
		return {
			restrict: 'A',
			scope: {
				submit: '=ecpSubmit'
				//form: '=form'
			},
			link: function(scope, elm, attrs) {
				var form = angular.element(elm).closest('form');
				if(!form.hasClass('ecp-initialized'))	{
					form.attr("action", 'javascript:void(0)');
					form.attr("novalidate", 'novalidate');
					form.addClass('ecp-initialized');
				}
				elm.on('click', function()	{
					form.submit();
					if(form.hasClass('ng-valid'))	{
						scope.submit();
						return;
					}
					var invalidFields = form.find('.ng-invalid');
					if(invalidFields.length == 0)	{
						invalidFields = form.find('.ng-pending');
						if(invalidFields.length == 0) return;
					}

					scope.$parent.$eval('form').$submitted = true;

					angular.element(invalidFields[0]).focus();
				});
			}
		};
	}]);

})(angular)