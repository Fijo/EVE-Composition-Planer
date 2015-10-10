//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('compositionCtrl', ['$scope', '$controller', '_', 'Ruleset', 'ShipGroup', 'FittingService', 'ItemConverter', 'CompositionValidationService', 'GlobalFittingValidationService', 'RulesetService', 'KnowyetService', 'AutocompleteFactory', function ($scope, $controller, _, Ruleset, ShipGroup, FittingService, ItemConverter, CompositionValidationService, GlobalFittingValidationService, RulesetService, KnowyetService, AutocompleteFactory) {
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

		$scope.knowyet = [
			{
				title: 'So you wana start planing a composition for a tournerment...',
				content: [
					'Well you should start off with picking a ruleset for that particular tournerment.',
					'You should either know the name of one if its has already been created or you can always browse through the public rulesets. [...]',
					'By the way if you\'re having trouble selecting a ruleset there will be another hint like this one in two slides helping with that.'
				]
			},
			{
				title: 'So you wana start planing a composition for a tournerment... define your own rules',
				content: [
					'[...] Alternatively you could also start digging deeper into this tool by starting from scratch and start creating your own ruleset which actualy consists of multiple fitting rules that you should propobly create first. Anyhow it is not all that hard to create your own ruleset within this tool and you don\'t need any programming skills or anything like that. Its just simple logic so don\'t be afraid.'
				]
			},
			KnowyetService.getAutocompleteTip('ruleset'),
			{
				title: 'Start adding ships!',
				content: [
					'You can expand the ship groups on the left side by clicking on their names.',
					'Now you should see a list of ship you can add just click on one of their names to add one. The number on the right tells you how much points a ship needs.'
				]
			},
			{
				title: 'Detailed ship information like fittings!',
				content: [
					'After adding ships you can now click on the pen for a ship in the table in the center of your screen.',
					'Now you can start adding a fitting for that ship or take notes on how to pilot it and even specify combat boosters or implants that the pilot should use.'

				]
			},
			{
				title: 'Detailed ship information: fitting tags',
				content: [
					'On the right side of your screen might start seing tags popup below ´Fitting rules (matching)´.',
					'Those are basicly rules fitting that are matching you fit which then tag the coresponding ship configuration. The ship itself and the combat booster and implants are also being put into consideration for that.',
					'Basicly those tags are the information that is used to decide if your fit matches the rules or not. So you might end up getting some messages when you have for example too many configurations with a particular tag. An example in the alliance torunerment for a tag like this would be ´flagship´.',
					'Please note that those tags are not validation errors. They are just useful information to further understand the rule system this tool uses and to hopefully find mistakes quicker in certein scenarios.'
				]
			},
			{
				title: 'Points',
				content: [
					'You can also see the point amount check on the right side. It should be pretty self explanatory.',
					'If the bar gets red you are running out of points and the numbers mean [used amount of points] / [min points] - [max points].'
				]
			}
		];

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

		$scope.getRulesetsAutocomplete = AutocompleteFactory(Ruleset);

		$scope.getShipPoints = function(shipId)	{
			var ruleset = $scope.model.ruleset;
			return ruleset.ships != null ? ruleset.ships[shipId] || 4294967295 : 0;
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
			GlobalFittingValidationService.then(function(globalFittingValidationService)	{
				$scope.model.entity.tags = globalFittingValidationService.validateFitting($scope.model.ruleset, $scope.model.entity);
				CompositionValidationService.then(function(compositionValidationService)	{
					$scope.model.entity.violations = compositionValidationService.validateComposition($scope.model.ruleset, $scope.model.entity);
				});
			});
		};

		var initShip = function(ship)	{
			if(ship.destroy == null)	{
				var unlistenToUpdates = $scope.$on('fitUpdated-' + ship.$$hashKey, validateComposition)
				ship.destroy = (function()	{
					validateComposition();
					unlistenToUpdates();
				});
			}
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
				ship.isAllowed = $scope.showShipByPoints(ship.points);
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
			var ship = _.extend({shipId: ship.id}, _.dclone(shared.emptyShip))
			$scope.model.entity.content.push(ship);
			var unwatch = $scope.$watch(function() { return ship.$$hashKey != null; }, function(value)	{
				if(value == false) return;
				unwatch();
				updateShips();
			});
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

		$scope.reloadRuleset = function()	{
			var entity = $scope.model.entity;
			var rulesetId = entity != null && entity.ruleset ? entity.ruleset.id : null;
			$scope.model.ruleset = rulesetId != null ? $scope.pushRequest(Ruleset.validation({cid: rulesetId}, updateShips), 'init') : {};
		};

		$scope.$watch('model.entity.ruleset.id', $scope.reloadRuleset);

		// preload
		$scope.pushRequest(ItemConverter.then(), 'init');
	}]);
})(angular)