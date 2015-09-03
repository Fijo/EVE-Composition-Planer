//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(requirejs, undefined)   {
    'use strict';

    requirejs.config({
        baseUrl: '',
        paths: {
            underscore: 'bower_components/underscore/underscore',
            jquery: 'bower_components/jquery/dist/jquery',
            angular: 'bower_components/angular/angular',
            'angular-route': 'bower_components/angular-route/angular-route',
            'angular-resource': 'bower_components/angular-resource/angular-resource',
            'angular-messages': 'bower_components/angular-messages/angular-messages',
            'angular-sanitize': 'bower_components/angular-sanitize/angular-sanitize',
            'angular-cache': 'bower_components/angular-cache/dist/angular-cache',
            bootstrap: 'bower_components/bootstrap/dist/js/bootstrap',
            'angular-underscore-module': 'bower_components/angular-underscore-module/angular-underscore-module',
            'angular-strap-src': 'bower_components/angular-strap/dist/angular-strap',
            'angular-strap': 'bower_components/angular-strap/dist/angular-strap.tpl',
            'underscore-ext': 'script/underscore_ext'
        },
        shim: {
            underscore: {
                exports: '_'
            },
            angular: {
                exports: 'angular'
            },
            'angular-route': {
                deps: ['angular']
            },
            'angular-resource': {
                deps: ['angular']
            },
            'angular-messages': {
                deps: ['angular']
            },
            'angular-sanitize': {
                deps: ['angular']
            },
            'angular-cache': {
                deps: ['angular']
            },
            bootstrap: {
                deps: ['jquery']
            },
            'angular-underscore-module': {
                deps: ['underscore', 'angular']
            },
            'angular-strap': {
                deps: ['bootstrap', 'angular', 'angular-strap-src']
            },
            'angular-strap-src': {
                deps: ['bootstrap', 'angular']
            },
            'underscore-ext': {
                deps: ['underscore']
            },

        }
    });

    requirejs(['underscore',
                'jquery',
                'angular',
                'angular-route',
                'angular-resource',
                'angular-messages',
                'angular-sanitize',
                'angular-cache',
                'bootstrap',
                'angular-strap',
                'underscore-ext',
                'angular-underscore-module'], function()    {
        requirejs(['app/main/module']);
    });
})(requirejs);