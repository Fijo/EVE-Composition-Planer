//EVE Composition Planer - a little helper for theorycrafting compositions in EVE Online
//Copyright (C) 2015 Jonas Fischer
//
//This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License.
//This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA

(function(define, undefined)   {
    'use strict';

    define('app/main/module', ['require', 'angular'], function(require, angular) {
        require(['./init'], function()  {
            require([
                './factories/formValidatorFactory',
                './factories/pagerFactory',
                './factories/user',
                './factories/shipGroup',
                './factories/ruleDef',
                './factories/item',
                './factories/def',
                './factories/itemConverter',
                './factories/itemCounter',
                './factories/fittingRule',
                './factories/ruleset',
                './factories/composition',
                './factories/group',
                './factories/requestManagementFactory',
                './factories/storeServiceFactory',
                './factories/fittingService',
                './factories/fittingParser',
                './factories/fittingWriter',
                './factories/fittingConverter',
                './factories/comparisonService',
                './factories/validationService',
                './factories/fittingValidationService',
                './factories/globalFittingValidationService',
                './factories/perConfigFittingValidationService',
                './factories/compositionValidationService',
                './factories/rulesetService',
                './factories/rootValidationService',
                './factories/knowyetService',
                './directives/integer',
                './directives/entityName',
                './directives/entityNameFormat',
                './directives/fitInvalidItem',
                './directives/fitShipType',
                './directives/password',
                './directives/validationContainer',
                './directives/validationTooltip',
                './directives/passwordValidationTooltip',
                './directives/submit',
                './directives/idRequired',
                './directives/progressBar',
                './directives/tooltip',
                './controlers/entity',
                './controlers/nav',
                './controlers/breadcrumb',
                './controlers/about',
                './controlers/feedback',
                './controlers/composition',
                './controlers/fittingRule',
                './controlers/ruleset',
                './controlers/group',
                './controlers/login',
                './controlers/confirmRegistration',
                './controlers/recoverPassword',
                './controlers/resetPassword',
                './controlers/list',
                './controlers/app',
                './controlers/specificApps',
                './controlers/specificLists'], function(){
                require(['./self'], function()  {
                    angular.element(document).ready(function() {
                        angular.bootstrap(document, ['mainApp']);
                    });
                });
            })
        });
    });
})(define);