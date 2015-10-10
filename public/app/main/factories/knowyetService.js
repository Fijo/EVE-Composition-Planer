//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(angular, undefined)	{
	'use strict';
	
	angular.module('mainApp').factory('KnowyetService', ['_', function(_) {
		var self = {
			getSharingTips: function(name)	{
				return [
					{
						title: 'Start sharing your works!',
						content: [
							'There are two simple ways to share entities (like ' + name + 's) within this tool.',
							'One way is to make your current ' + name + ' public buy klicking on the button with the globe symbol on it. (you still have to save it afterwords)',
							'The other way is by using groups [...]'
						]
					},
					{
						title: 'Start sharing using groups!',
						content: [
							'Or you can create a group or get added to an exisiting group and share your current ' + name + ' with that group.',
							'To do so you have to click the little button below button with the globe (to start add a group) and then you have to chose the name of the group in the autocomplete box that will appear.',
							'You can share your ' + name + ' with as many groups as you would like to.'
						]
					},
					self.getAutocompleteTip('group', true),
					{
						title: 'Requirements for being able to share something',
						content: [
							'To be able to share someting all subentities you are linking to within your ' + name + ' have to be at least as visible as the ' + name + ' you are trying to share.',
							'... for sharing it with groups they have to all be shared with the same groups or more or be public.',
							'... to make it public they all have to be public as well.'
						]
					},
					{
						title: 'About sharing',
						content: [
							'It doesn\'t matter how you share your ' + name + ' it will only give people permissions to look at your ' + name + ' (and to fork (=copy) it)',
							'You will always remain the only one that has write access to your ' + name + '.',
							'If someone else wants to improve your ' + name + ' he should just fork make changes and share it as a new iteration on that ' + name + '.'
						]
					}
				]
			},
			getAutocompleteTip: function(name, noUser)	{
				if(noUser == null) noUser = false;
				return {
					title: (noUser ?  'Simple autocomplete' : 'Autocomplete') + ' box ´' + _.capitalizeFirstLetter(name) + '´',
					content: [
						'To fill out the autocomplete box for the ' + name + ' you have to start typing '
							+ (name == 'username' ? 'the username of your buddy.' : 'either a name of your ' + name + ' or if you don\'t know the exact name and you don\'t have a lot of ' + name + 's you can type a slash (´/´).'),
						(noUser ? '' : 'Or you can pick a ' + name + ' of someone else. Therefore you have to type the full username of that person in there and then type a slash and its should start sugesting your the ' + name + ' he has. Of course it only shows those that he made visible to you or the public.')
							+ 'You can keep on typing to further filter that list like always.',
						'Please don\'t be inpatient the sugestions sometimes take a couple seconds to load up. You have to actualy pick one of the sugested entries to properly fill out the field.'
					]
				};
			}
		};
		return self;
	}]);
})(angular)