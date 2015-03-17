// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic', 'starter.services', 'starter.controllers'])


.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider

    // setup an abstract state for the tabs directive
    .state('tab', {
      url: '/tab',
      abstract: true,
      templateUrl: 'templates/tabs.html'
    })

    // the pet tab has its own child nav-view and history
    .state('tab.plugs', {
      url: '/plugs',
      views: {
        'plugs-tab': {
          templateUrl: 'templates/plugs.html',
          controller: 'QuestionsCtrl'
        }
      }
    }) 

    .state('tab.results', {
      url: '/results',
      views: {
        'results-tab': {
          templateUrl: 'templates/results.html',
          controller: 'ResultsCtrl'
        }
      }
    })
.state('tab.person', {
      url: '/person',
      views: {
        'person-tab': {
          templateUrl: 'templates/person.html',
          controller: 'PersonCtrl'
        }
      }
    })
    .state('tab.config', {
      url: '/config',
      views: {
        'config-tab': {
          templateUrl: 'templates/config.html',
          controller: 'ConfigCtrl'
        }
      }
    })
    .state('tab.about', {
      url: '/about',
      views: {
        'about-tab': {
          templateUrl: 'templates/about.html',
          controller: 'AboutCtrl'
        }
      }
    });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/tab/plugs');

});

