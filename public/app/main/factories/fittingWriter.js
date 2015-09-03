//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, console, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FittingWriter', ['_', function(_) {
		var self = {};

		self.writeFit = function(fit)	{
			return self.writeHeader(fit.header) + '\n'
				+ self.writeBody(fit.body);
		};

		self.writeHeader = function(header)	{
			return '[' + header.shipType + ', ' + header.shipName + ']';
		};

		self.writeBody = function(body)	{
			return _.map(body, self.writeRow).join('\n');
		};

		self.writeRow = function(row)	{
			if(row.type == 'empty') return '';
			if(row.type == 'seperator') return '--';
			if(row.type != null && row.type.indexOf('empty-') == 0)	{
				var parts = row.type.split('-');
				if(parts[0] == 'empty' && ['high', 'med', 'low', 'rig'].indexOf(parts[1]) != -1)
					return '[empty ' + parts[1] + ' slot]';
			}
			if(row.amount != null) return row.item + ' x' + row.amount;
			if(row.ammo == null) return row.item;
			return row.item + ', ' + row.ammo;
		};
		return self;
	}]);
})(angular, console)
