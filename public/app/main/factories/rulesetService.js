//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';

	angular.module('mainApp').factory('RulesetService', ['_', function(_) {
		return function(self)	{
			self.getGroupPoints = function(shipGroup)	{
				var minPoints = null;
				var maxPoints = null;
				_.each(shipGroup.content, function(ship)	{
					if(!self.showShip(ship)) return;
					var points = self.getShipPoints(ship.id);
					if(minPoints == null || points < minPoints) minPoints = points;
					if(maxPoints == null || points > maxPoints) maxPoints = points;
				});
				if(minPoints != maxPoints) return minPoints + ' - ' + maxPoints;
				return minPoints;
			};

			self.showGroup = function(shipGroup)	{
				return _.reduce(shipGroup.content, function(memo, ship)	{
					return memo || self.showShip(ship);
				}, false);
			};

			self.showShipByPoints = function(points)	{
				return points <= self.getMaxPoints();
			};

			self.showShip = function(ship)	{
				return self.showShipByPoints(self.getShipPoints(ship.id));
			};
			return self;
		}
	}]);
})(angular)