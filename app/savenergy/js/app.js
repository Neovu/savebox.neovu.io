angular.module('savenergy', ['ionic'])
/**
 * The Ambiences factory handles saving and loading ambiences
 * from local storage, and also lets us save and load the
 * last active ambience index.
 */
.factory('Ambiences', function() {
  return {
    all: function() {
      var ambienceString = window.localStorage['ambiences'];
      if(ambienceString) {
        return angular.fromJson(ambienceString);
      }
      return [];
    },
    save: function(ambiences) {
      window.localStorage['ambiences'] = angular.toJson(ambiences);
    },
    newAmbience: function(ambienceTitle) {
      // Add a new ambience
      return {
        title: ambienceTitle,
        plugs: []
      };
    },
    getLastActiveIndex: function() {
      return parseInt(window.localStorage['lastActiveAmbience']) || 0;
    },
    setLastActiveIndex: function(index) {
      window.localStorage['lastActiveAmbience'] = index;
    }
  }
})

.controller('SavenergyCtrl', function($scope, $timeout, Modal, Ambiences) {

  // A utility function for creating a new ambience
  // with the given ambienceTitle
  var createAmbience = function(ambienceTitle) {
    var newAmbience = Ambiences.newAmbience(ambienceTitle);
    $scope.ambiences.push(newAmbience);
    Ambiences.save($scope.ambiences);
    $scope.selectAmbience(newAmbience, $scope.ambiences.length-1);
  }


  // Load or initialize ambiences
  $scope.ambiences = Ambiences.all();

  // Grab the last active, or the first ambience
  $scope.activeAmbience = $scope.ambiences[Ambiences.getLastActiveIndex()];

  // Called to create a new ambience
  $scope.newAmbience = function() {
    var ambienceTitle = prompt('Ambience name');
    if(ambienceTitle) {
      createAmbience(ambienceTitle);
    }
  };

  // Called to select the given ambience
  $scope.selectAmbience = function(ambience, index) {
    $scope.activeAmbience = ambience;
    Ambiences.setLastActiveIndex(index);
    $scope.sideMenuController.close();
  };

  // Create our modal
  Modal.fromTemplateUrl('new-plug.html', function(modal) {
    $scope.plugModal = modal;
  }, {
    scope: $scope
  });

  $scope.createPlug = function(plug) {
    if(!$scope.activeAmbience) {
      return;
    }
    $scope.activeAmbience.plugs.push({
      title: plug.title
    });
    $scope.plugModal.hide();

    // Inefficient, but save all the ambiences
    Ambiences.save($scope.ambiences);

    plug.title = "";
  };

  $scope.newPlug = function() {
    $scope.plugModal.show();
  };

  $scope.closeNewPlug = function() {
    $scope.plugModal.hide();
  }

  $scope.toggleAmbiences = function() {
    $scope.sideMenuController.toggleLeft();
  };

});
