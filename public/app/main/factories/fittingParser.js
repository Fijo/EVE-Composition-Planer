//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, console, undefined)	{
	'use strict';

	angular.module('mainApp').factory('FittingParser', ['_', function(_) {
		var self = {};
		var multibleItemRegex = /x\d+$/;

		self.parseFit = function(fit)	{
			var eftRows = fit.split('\n');
			if(eftRows.length < 6) return false;
			return {
				header: self.parseHeader(eftRows),
				body: self.parseBody(eftRows)
			};
		};

		self.parseHeader = function(eftRows)	{
			var row = eftRows[0].trim();
			var startBracketIndex = row.indexOf('[');
			if(startBracketIndex == -1) return false;
			var backetEndIndex = row.indexOf(']', startBracketIndex);
			if(backetEndIndex == -1) return false;
			var contentArray = row.substring(startBracketIndex +1, backetEndIndex).split(',');
			if(contentArray.length != 2) return false;
			return {
				shipType: contentArray[0].trim(),
				shipName: contentArray[1].trim()
			};
		};

		self.parseBody = function(eftRows)	{
			var result = [];
			_.each(eftRows, function(row, index)	{
				if(index == 0) return;
				result.push(self.parseRow(row));
			});
			return result;
		};

		self.parseRow = function(row)	{
			row = row.trim();
			if(row == '') return { type: 'empty' };
			if(row == '--') return { type: 'seperator' };
			var rowLength = row.length;
			if(rowLength > 5 && row.indexOf('[') == 0 && row.lastIndexOf(']') == rowLength -1)	{
				var words = _.filter(row.substring(1, rowLength-1).split(' '), function(word)	{
					return word != '';
				});
				if(words.length == 3 && words[0] == 'empty' && words[2] == 'slot' && ['high', 'med', 'low', 'rig'].indexOf(words[1]) != -1)
					return { type: 'empty-' + words[1] };
			}


			if(multibleItemRegex.test(row))	{
				var lastXindex = row.lastIndexOf('x');
				return {
					item: row.substring(0, lastXindex).trim(),
					amount: parseInt(row.substring(lastXindex +1).trim())
				};
			}
			var commaIndex = row.lastIndexOf(',');
			if(commaIndex == -1)	{
				return { item: row.trim() };
			}
			return {
				item: row.substring(0, commaIndex).trim(),
				ammo: row.substring(commaIndex +1).trim(),
			};
		};
		return self;
	}]);
})(angular, console)
