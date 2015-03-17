angular.module('starter.controllers', [])

        .controller('QuestionsCtrl', function ($scope, PetService, SettingsService) {

            $scope.navTitle = "Savebox";
            $scope.navCount = 0;
            if (SettingsService.get('pets')) {
                $scope.pets = SettingsService.get('pets');
            } else {
                $scope.pets = PetService.all();
            }

            angular.forEach($scope.pets, function (value, key) {
                var localData = JSON.parse(JSON.stringify(value));
                if (localData.state > 0) {
                    $scope.navCount++;
                }
            });

            
            $scope.changeResults = function (id) {
                $scope.navCount = 0;
                var newpet = [];
                angular.forEach($scope.pets, function (value, key) {
                    var localData = JSON.parse(JSON.stringify(value));
                    if (localData.id === id) {
                        localData.state++;
                        localData.color = '#00AADB';
                    }
                    if (localData.state > 0) {
                        $scope.navCount++;
                    }
                    newpet.push(localData);
                });

                $scope.pets = newpet;
                SettingsService.set('pets', newpet);
            };

        })

        .controller('ResultsCtrl', function ($scope, SettingsService) {
            sessionStorage.logObject = "";
            $scope.navTitle = "Consumo";
            $scope.navCount = 0;
            $scope.navPoints = 0;
            $scope.pets = SettingsService.get('pets');
            ;

            var logObject = {};
            logObject.R = 0;
            logObject.C = 0;
            logObject.D = 0; 

            angular.forEach($scope.pets, function (value, key) {
                var localData = JSON.parse(JSON.stringify(value));
                if (localData.state > 0) {
                    if (localData.id == 1) {
                        logObject.R += parseInt(localData.value) * Math.random() *10;
                        $scope.navCount++;
                    }
                    if (localData.id == 2) {
                        logObject.C += parseInt(localData.value) * Math.random()*10;
                        $scope.navCount++;
                    }
                    if (localData.id == 3) {
                        logObject.D += parseInt(localData.value) * Math.random()*10;
                        $scope.navCount++;
                    }
                     
                }
            });
            $scope.navPoints =  parseInt( logObject.R) + parseInt(logObject.C) + parseInt(logObject.D)  ;
            sessionStorage.logObject = JSON.stringify(logObject);
            
            document.getElementById("results").innerHTML = "<iframe src=\"templates/amcharts.html\"  ></iframe>";

        })

        .controller('AboutCtrl', function ($scope, PetService) {
            $scope.navTitle = "Sobre";
            $scope.navCount = 0;
        })
         .controller('PersonCtrl', function ($scope, PetService) {
            $scope.navTitle = "Perfil";
            $scope.navCount = 0;
            document.getElementById("profile").innerHTML = "<iframe src=\"http://www.savenergies.com\"  ></iframe>";
             
        })
         .controller('ConfigCtrl', function ($scope, PetService) {
            $scope.navTitle = "Configurações";
            $scope.navCount = 0;
            document.getElementById("config").innerHTML = "<iframe src=\"templates/config/savenergy.html\"  ></iframe>";
             
        })
        ;
