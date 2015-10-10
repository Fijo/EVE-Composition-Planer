//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').controller('groupCtrl', ['$scope', '$controller', '_', 'StoreServiceFactory', 'Def', 'User', 'KnowyetService', 'AutocompleteFactory', function ($scope, $controller, _, StoreServiceFactory, Def, User, KnowyetService, AutocompleteFactory) {
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
				title: 'What are groups useful for?',
				content: [
					'Groups are pretty much used to share entities (like Compositions) with your friends without making them public.',
					'Once you created a group or once someone else added you to one you can start sharing entities with that group.',
					'All groups you are part of are also gona be listed under the groups list.'
				]
			},
			KnowyetService.getAutocompleteTip('username', true),
			{
				title: 'What can admins do more than members?',
				content: [
					'Every admin can change and save the group.',
					'Members can only use the group view stuff that has been shared with it and look at it.'
				]
			},
			{
				title: 'Anything else I should be aware of when trying to create a group?',
				content: [
					'There\'s only one thing you cannot remove yourself from the admins. If you do so you wount be able to save the group.'
				]
			},
			{
				title: 'So this is kinda anoying now I have to add every single person in my alliance to the members list ...',
				content: [
					'Well I already started to implement a feature that allows you to add ingame entities as well but I haven\'t finished that yet.' ,
					'So for now you cant just add like an alliance to the members list but that will be possible soon.'
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

		$scope.getUserAutocomplete = AutocompleteFactory(User);
	}]);
})(angular)