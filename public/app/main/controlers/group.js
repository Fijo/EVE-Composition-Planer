//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('groupCtrl', ['$scope', '$controller', '_', 'StoreServiceFactory', 'Def', 'User', function ($scope, $controller, _, StoreServiceFactory, Def, User) {
		$controller('entityCtrl', { $scope: $scope });

		$scope.hasUserField = false;
		$scope.canBeListed = false;
		$scope.canBeForked = false;
		$scope.hasGroupAccessInModel = false;

		$scope.message = {
			entityService: 'Group',
			entity: 'group',
			entityCap: 'Group',
			entityPlural: 'groups',
			entityPath: 'group'
		};

		$scope.hierarchy = ['Group'];

		$scope.knowyet = [
			{
				title: 'Tips for this entity are coming soon.',
				content: [
					'... watch out for the next version and update your instalation of ECP ;)'
				]
			}
		];
		
		var shared = (function()	{
			var self = {
				emptyPerson: {user: {}},
				emptyEvePerson: {name: '', generatedPersons: []},
				emptySection: {
					persons: [],
					evePersons: []
				}
			};
			return self;
		})();

		$scope.model = {
			lists: $scope.pushRequest(Def.getProupPersonType(function(proupPersonType)	{
				$scope.pushRequest(User.status(function(user)	{
					$scope.getNewSpecificEntity = function()	{
						var self = {
							canEdit: true,
							lastComputed: 'none'
						};
						_.each(proupPersonType, function(proupPersonTypeObj)	{
							self[proupPersonTypeObj.name] = _.dclone(shared.emptySection);
						});
						var myAdmin = _.dclone(shared.emptyPerson);
						_.extend(myAdmin.user, {id: user.id, name: user.username});
						self.admin.persons.push(myAdmin);
						return self;
					};

					$scope.init();

					if($scope.isDetail)	{
						var baseIsReadonly = $scope.isReadonly;
						$scope.isReadonly = function()	{
							return baseIsReadonly() || !$scope.model.entity.canEdit;
						};
					}

					$scope.personService = StoreServiceFactory.create({
						getList: function(section)	{
							return section.persons;
						},
						emptyEntry: shared.emptyPerson,
						scope: $scope
					});

					$scope.evePersonService = StoreServiceFactory.create({
						getList: function(section)	{
							return section.evePersons;
						},
						emptyEntry: shared.emptyEvePerson,
						scope: $scope
					});
				}), 'init');
			}), 'init')
		};

		$scope.getUserAutocomplete = function(value)	{
			return User.autocomplete({s: value}).$promise;
		};
	}]);
})(angular)