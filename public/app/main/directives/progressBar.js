//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	// requires jquery
	angular.module('mainApp').directive('ecpProgressBar', [function () {
		return {
			restrict: 'A',
			scope: false,
			templateUrl: 'app/main/view/directive/progressBar.html',
			link: function(scope, elm, attrs)	{
				var min = 0, max = 0, currentValue = 0;
				var progressBar = elm.find('.progress-bar');
				var progressText = elm.find('.progress-text');
				var updateState = function()	{
					progressBar.attr('style', 'width: ' + (100 * (currentValue - min) / (max - min)) + '%');
					if(currentValue >= min && currentValue <= max) progressBar.removeClass('progress-bar-danger').addClass('progress-bar-success');
					else progressBar.removeClass('progress-bar-success').addClass('progress-bar-danger');				
					progressText.text((currentValue || 0) + ' / ' + (min == 0 ? '' : (min || 0) + ' - ') + (max || 0));
				};
				scope.$watch(attrs['ecpMin'], function(value)	{
					min = value;
					progressBar.attr('aria-valuemin', min);
					updateState();
				});
				scope.$watch(attrs['ecpMax'], function(value)	{
					max = value;
					progressBar.attr('aria-valuemax', max);
					updateState();
				});
				scope.$watch(attrs['ecpValue'], function(value)	{
					currentValue = value;
					progressBar.attr('aria-valuenow', currentValue);
					updateState();
				});
			}
		};
	}]);
})(angular)