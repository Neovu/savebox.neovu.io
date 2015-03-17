angular.module('starter.services', [])

        .factory('PetService', function () {

            var pets = [
                {id: 1, color: "#f3f3f3", state: 0, value: 0, title: 'Plug 1', description: 'Escala: 0 = nada, 1 = um pouco, 2 = moderadamente, 3 = bastante, 4 = extremamente'},
                {id: 2, color: "#f3f3f3", state: 0, value: 0, title: 'Plug 2', description: 'Escala: 0 = nada, 1 = um pouco, 2 = moderadamente, 3 = bastante, 4 = extremamente'},
                {id: 3, color: "#f3f3f3", state: 0, value: 0, title: 'Plug 3', description: 'Escala: 0 = nada, 1 = um pouco, 2 = moderadamente, 3 = bastante, 4 = extremamente'},
             ];


            return {
                all: function () {
                    return pets;
                },
                get: function (petId) {
                    return pets[petId];
                }
            }
        })
        .filter('to_trusted', ['$sce', function ($sce) {
                return function (text) {
                    return $sce.trustAsHtml(text);
                };
            }])
        .service('SettingsService', function () {
            var _variables = {};

            return {
                get: function (varname) {
                    return (typeof _variables[varname] !== 'undefined') ? _variables[varname] : false;
                },
                set: function (varname, value) {
                    _variables[varname] = value;
                }
            };
        })
        ;
