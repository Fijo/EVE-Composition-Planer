//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('compositionCtrl', ['$scope', '$controller', '_', 'Ruleset', 'ShipGroup', 'FittingService', 'ItemConverter', 'CompositionValidationService', 'RulesetService', function ($scope, $controller, _, Ruleset, ShipGroup, FittingService, ItemConverter, CompositionValidationService, RulesetService) {
		$controller('entityCtrl', { $scope: $scope });
		RulesetService($scope);

		$scope.message = {
			entityService: 'Composition',
			entity: 'composition',
			entityCap: 'Composition',
			entityPlural: 'compositions',
			entityPath: 'composition'
		};

		$scope.hierarchy = ['Composition'];

		var shared = (function(){
			var self = {
				emptyShip: {
					fit: {}
				}
			};
			return self;
		})();

		$scope.model = {
			shipGroups: {
				active: -1,
				content: $scope.pushRequest(ShipGroup.query(), 'init')
			},
			ruleset: {},
			activeDetailTab: 'Additionals'
		};

		$scope.getNewSpecificEntity = function()	{
			return {
				ruleset: {},
				content: [
				]
			};
		};

		$scope.getRulesetsAutocomplete = function(value)	{
			return Ruleset.autocomplete({s: value}).$promise;
		};

		$scope.getShipPoints = function(shipId)	{
			var ruleset = $scope.model.ruleset;
			return ruleset.ships != null ? ruleset.ships[shipId] : 0;
		};

		$scope.getMaxPoints = function()	{
			return $scope.model.ruleset.maxPoints;
		};

		$scope.getShipName = function(ship, callback)	{
			ItemConverter.then(function(itemConverter)	{
				callback(itemConverter.getNameById(ship.shipId));
			});
		};

		$scope.updateGroupOverviewPoints = function(shipGroup)	{
			shipGroup.points = $scope.getGroupPoints(shipGroup);
		};

		var validateComposition = function()	{
			CompositionValidationService.then(function(compositionValidationService)	{
				$scope.model.entity.violations = compositionValidationService.validateComposition($scope.model.ruleset, $scope.model.entity);
			});
		};

		var initShip = function(ship)	{
			if(ship.destroy == null)
				ship.destroy = $scope.$on('fitUpdated-' + ship.$$hashKey, validateComposition);
		}

		var updateShips = function()	{
			var entity = $scope.model.entity;
			_.each(entity.content, function(ship)	{
				initShip(ship);
				FittingService.init($scope, ship, $scope.model.ruleset);
				$scope.getShipName(ship, function(value)	{
					ship.name = value;
				});
				ship.points = $scope.getShipPoints(ship.shipId);
			});

			entity.content = _.sortBy(entity.content, function(ship)	{
				return -ship.points;
			});

			var totalPoints = 0;
			_.each(entity.content, function(ship)	{
				totalPoints += ship.points;
			});

			entity.points = totalPoints;
		};

		$scope.getDetailShip = function()	{
			var detailShip = null;
			_.each($scope.model.entity.content, function(ship)	{
				if(ship.viewDetails)	{
					detailShip = ship;
					return false;
				}
			});
			return detailShip;
		};

		$scope.viewDetails = function(ship)	{
			_.each($scope.model.entity.content, function(ship)	{
				ship.viewDetails = false;
			});
			ship.viewDetails = true;
		};

		$scope.addShip = function(ship)	{
			$scope.ensureAccess();
			$scope.model.entity.content.push(_.extend({shipId: ship.id}, _.dclone(shared.emptyShip)));
			updateShips();
		};

		$scope.removeShip = function(shipIndex)	{
			$scope.ensureAccess();
			var ship = $scope.model.entity.content[shipIndex];
			if(ship.destroy != null) ship.destroy();
			$scope.model.entity.content.splice(shipIndex, 1);
			updateShips();			
		};

		$scope.completeLoading = function()	{
			var shipGroupsContent = $scope.model.shipGroups.content;
			shipGroupsContent.$promise.then(function()	{
				_.each(shipGroupsContent, $scope.updateGroupOverviewPoints);
			});
		};
		

		$scope.init();


		$scope.$watch('model.entity.ruleset.id', function(rulesetId)	{
			$scope.model.ruleset = rulesetId != null ? $scope.pushRequest(Ruleset.validation({cid: rulesetId}, updateShips), 'init') : {};
		});

		// preload
		$scope.pushRequest(ItemConverter.then(), 'init');
	}]);
})(angular)