var app = angular.module('App', ['ngMaterial', 'ngMdIcons', 'angular.filter', 'angular-loading-bar']);

app.controller('AppCtrl', ['$scope', '$mdDialog', '$mdMedia', '$http', '$sce', function ($scope, $mdDialog, $mdMedia, $http, $sce) {
    "use strict";
    // pull the frat data
    $http.get('fratpull.php').success(function (data) {
        $scope.frats = data;
    });

    // pull the event data
    $http.get('eventpull.php').success(function (data) {
        $scope.events = data;
    });

    // function that allows page to trust google iframe
    $scope.trustSrc = function (src) {
        return $sce.trustAsResourceUrl(src);
    };

    // days in calendar
    $scope.leadingDays = [{
        "date": "08/27/2017",
        number: 27
    }, {
        "date": "08/28/2017",
        number: 28
    }, {
        "date": "08/29/2017",
        number: 29
    }, {
        "date": "08/30/2017",
        number: 30
    }, {
        "date": "08/31/2017",
        number: 31
    }, {
        "date": "09/01/2017",
        number: 1
    }, {
        "date": "09/02/2017",
        number: 2
    }, {
        "date": "09/03/2017",
        number: 3
    }, {
        "date": "09/04/2017",
        number: 4
    }, {
        "date": "09/05/2017",
        number: 5
    }, {
        "date": "09/06/2017",
        number: 6
    }, {
        "date": "09/07/2017",
        number: 7
    }, {
        "date": "09/08/2017",
        number: 8
    }, {
        "date": "09/09/2017",
        number: 9
    }, {
        "date": "09/10/2017",
        number: 10
    }, {
        "date": "09/11/2017",
        number: 11
    }, {
        "date": "09/12/2017",
        number: 12
    }, {
        "date": "09/13/2017",
        number: 13
    }, {
        "date": "09/14/2017",
        number: 14
    }, {
        "date": "09/15/2017",
        number: 15
    }, {
        "date": "09/16/2017",
        number: 16
    }, {
        "date": "09/17/2017",
        number: 17
    }, {
        "date": "09/18/2017",
        number: 18
    }, {
        "date": "09/19/2017",
        number: 19
    }, {
        "date": "09/20/2017",
        number: 20
    }, {
        "date": "09/21/2017",
        number: 21
    }, {
        "date": "09/22/2017",
        number: 22
    }, {
        "date": "09/23/2017",
        number: 23
    }, {
        "date": "09/24/2017",
        number: 24
    }, {
        "date": "09/25/2017",
        number: 25
    }, {
        "date": "09/26/2017",
        number: 26
    }, {
        "date": "09/27/2017",
        number: 27
    }, {
        "date": "09/28/2017",
        number: 28
    }, {
        "date": "09/29/2017",
        number: 29
    }, {
        "date": "09/30/2017",
        number: 30
    }];

    // names of days of week
    $scope.daysOfWeek = [{
        name: "Sunday"
    }, {
        name: "Monday"
    }, {
        name: "Tuesday"
    }, {
        name: "Wednesday"
    }, {
        name: "Thursday"
    }, {
        name: "Friday"
    }, {
        name: "Saturday"
    }];

    // initialize an empty list for favorites
    $scope.favorites = [];

    // initialize an empty list for events of favorites
    $scope.favoriteEvents = [];

    // favoriting function
    $scope.addFavorite = function (product) {
        var i = 0;
      // if not there already, add fav to favorites list
        if ($scope.favorites.indexOf(product) < 0) {
            $scope.favorites.push(product);
            product.favorite = true;

            $scope.clicked = true;

            // at the same time, add the associated events to
        // the favorite event list
            for (var i = 0; i < $scope.events.length; i += 1) {
                if ($scope.events[i].house === product.name) {
                    $scope.events[i].favorite = true;
                    $scope.favoriteEvents.push($scope.events[i]);
                }
            }
        } else {
        // if its already favorited, unfavorite
            $scope.favorites.splice($scope.favorites.indexOf(product), 1);
            product.favorite = false;

            $scope.clicked = false;

            for (var i = 0; i < $scope.favoriteEvents.length; i += 1) {
                if ($scope.favoriteEvents[i].house === product.name) {
                    // $scope.favoriteEvents[i].favorite = false;
                    // $scope.favoriteEvents.splice(i, 1);
                    delete $scope.favoriteEvents[i];
                }
            }
        }
    };

    $scope.unFavorite = function (product) {
        $scope.favorites.splice($scope.favorites.indexOf(product), 1);
        $scope.clicked = false;
        var i = 0;
        for (var i = 0; i < $scope.favoriteEvents.length; i += 1) {
            if ($scope.favoriteEvents[i].house === product.name) {
              // $scope.favoriteEvents[i].favorite = false;
              // $scope.favoriteEvents.splice(i, 1);
                delete $scope.favoriteEvents[i];
            }
        }
        $scope.favoriteEvents.filter(x => x);
    };

    // function that creates a ics file out of the events in favoriteEvents
    // then exports it
    $scope.ics = function (){
        var cal = ics();
        var i = 0;
        for ( var i = 0; i < $scope.favoriteEvents.length; i += 1) {
            if ($scope.favoriteEvents[i] != null) {
                cal.addEvent($scope.favoriteEvents[i].title, $scope.favoriteEvents[i].house, $scope.favoriteEvents[i].location, $scope.favoriteEvents[i].event_date, $scope.favoriteEvents[i].event_date );
            }
        }
        cal.download('favorites');
    };

    $scope.alert = '';

    $scope.status = $scope.items;

    $scope.customFullscreen = $mdMedia('xs') || $mdMedia('sm');

    // Controller that handles the frat page dialog box
    function DialogController($scope, $mdDialog, dataToPass) {
        $scope.hide = function () {
            $mdDialog.hide();
        };

        $scope.cancel = function () {
            $mdDialog.cancel();
        };

        $scope.product = dataToPass;

        $scope.trustSrc = function (src) {
            return $sce.trustAsResourceUrl(src);
        };

        $http.get('eventpull.php').success(function (data) {
            $scope.currentEvents = data;
        });

        $scope.answer = function (answer) {
            $mdDialog.hide(answer);
        };
    }

    // show dialog for individual frat pages
    $scope.showAdvanced = function (ev, product) {
        var useFullScreen = ($mdMedia('sm') || $mdMedia('xs')) && $scope.customFullscreen;

        $mdDialog.show({
            controller: DialogController,
            templateUrl: 'orderDialog.tmpl.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true,
            fullscreen: useFullScreen,
            locals: {dataToPass: product}
        })
            .then(function (answer) {
                $scope.status = 'Here goes the http request to REST with loading icon while in progress "' + answer + '".';
            });

        $scope.watch(function () {
            return $mdMedia('xs') || $mdMedia('sm');
        }, function (wantsFullScreen) {
            $scope.customFullscreen = (wantsFullScreen === true);
        });
    };


    // Controller that handles the calendar day dialog box
    function EventDialogController($scope, $mdDialog, dataToPass, today) {
        $scope.hide = function () {
            $mdDialog.hide();
        };

        $scope.cancel = function () {
            $mdDialog.cancel();
        };

        $scope.day = dataToPass;

        $scope.filteredEvents = today;

        $scope.answer = function (answer) {
            $mdDialog.hide(answer);
        };
    }

    // show dialog for individual day on calendar
    $scope.showEvent = function (ev, day, t) {
        var useFullScreen = ($mdMedia('sm') || $mdMedia('xs')) && $scope.customFullscreen;

        $mdDialog.show({
            controller: EventDialogController,
            templateUrl: 'datePopup.tmpl.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true,
            fullscreen: useFullScreen,
            locals: {dataToPass: day, today: t}
        })
            .then(function (answer) {
                $scope.status = 'Here goes the http request to REST with loading icon while in progress "' + answer + '".';
            });

        $scope.watch(function () {
            return $mdMedia('xs') || $mdMedia('sm');
        }, function (wantsFullScreen) {
            $scope.customFullscreen = (wantsFullScreen === true);
        });
    };

    //change button color
    $scope.clicked = false;
}]);


// configures color scheme
app.config(function ($mdThemingProvider) {
    'use strict';
    var customBlueMap = $mdThemingProvider.extendPalette('light-blue', {
        'contrastDefaultColor': 'light',
        'contrastDarkColors': ['50'],
        '50': 'ffffff'
    });
    $mdThemingProvider.definePalette('customBlue', customBlueMap);
    $mdThemingProvider.theme('default')
        .primaryPalette('customBlue', {
            'default': '500',
            'hue-1': '50'
        })
        .accentPalette('grey');
    $mdThemingProvider.theme('input', 'default')
        .primaryPalette('grey');
});
