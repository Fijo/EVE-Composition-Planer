//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').factory('pagerFactory', function() {
		return {
			create: function(options)	{
				var pageCount = Math.max(options.pageCount, 1) || 15;
				var pagerSize = options.pagerSize || 5;

				var self = {};
				self.page = options.page;

				var usedPageSize = pagerSize -1;
				var defaultPagerSize = usedPageSize / 2;

				var getPagerPosition = function()	{
					if(self.page - defaultPagerSize < 1) return 'left';
					if(self.page + defaultPagerSize > pageCount) return 'right';
					return 'middle';
				};

				switch(getPagerPosition())	{
					case 'left':
						self.startPage = 1;
						self.endPage = pagerSize;
						break;

					case 'right':
						self.startPage = pageCount - usedPageSize;
						self.endPage = pageCount;
						break;

					case 'middle':
						self.startPage = self.page - defaultPagerSize;
						self.endPage = self.page + defaultPagerSize;
						break;
				}
				self.startPage = Math.max(self.startPage, 1);
				self.endPage = Math.min(self.endPage, pageCount);

				self.hasPage = function(page)	{
					return self.startPage <= page && self.endPage >= page;
				};
				self.isActive = function(page)	{
					return page == self.page;
				};
				self.getClass = function(page)	{
					return self.isActive(page)
						? 'active'
						: self.hasPage(page)
							? ''
							: 'disabled';
				};
				self.getPages = function()	{
					var res = [];
					for(var i = self.startPage; i <= self.endPage; i++)
						res.push(i);
					return res;
				};
				return self;
			}
		};
	});
})(angular)