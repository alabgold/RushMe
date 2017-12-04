<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>RushMe</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body
  <html lang="en" ng-app="App">
  <head>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/0.8.3/angular-material.min.css">
  </head>

  <body layout="row" ng-controller="AppCtrl" >
    <div layout="column" class="relative" layout-fill role="main" style="height: 200px;position:absolute !important">
      
      <!-- Top Toolbar -->
      <md-toolbar>
        <div class="md-toolbar-tools">
          <span flex></span>
          <h1> RushMe</h1> 
        </div>

        <!-- Top tabs for switching between pages -->
        <md-content layout="column" layout-fill>
          <md-tabs md-stretch-tabs class="md-primary" md-selected="data.selectedIndex" md-border-bottom  md-dynamic-height>
            <md-tab id="tab1" aria-controls="tab1-content">
              All Frats
            </md-tab>
            <md-tab id="tab2" aria-controls="tab2-content">
              Favorites
            </md-tab>
            <md-tab id="tab3" aria-controls="tab3-content">
              Calendar
            </md-tab>
          </md-tabs>
        </md-content>
      </md-toolbar>
    </div>

      <!-- Begins page content -->
      <div ng-controller="AppCtrl" class="md-padding dialogdemoBasicUsage" id="popupContainer" ng-cloak="" ng-app="MyApp">
        <ng-switch on="data.selectedIndex" class="tabpanel-container" >
          

          <!-- ALL FRATS tab -->
          <div role="tabpanel"
           id="tab1-content"
           aria-labelledby="tab1"
           ng-switch-when="0"
           md-swipe-left="next()"
           md-swipe-right="previous()"
           layout="row" layout-align="center center"
           style='padding: 115px 0 0 0;'>
              <md-content flex md-scroll-y>
                <ui-view layout="column" layout-fill layout-padding>
                  <div class='md-padding' layout="row" layout-wrap>
                    
                    <!-- goes through all items in the frats array and makes a card for it -->
                    <md-card style="width: 32%;" ng-repeat="product in frats track by $index">
                    <!-- get image -->
                      <img src="{{product.profile_image}}" style="height: 300px;object-fit: cover;" class="md-card-image" alt="Frat Cover Photo">
                      <md-card-content>
                        <div>
                          <h2>{{product.name}}</h2>
                          <br/>
                          <p>{{product.description}} </p>
                          <hr>

                          <!-- finds events associated with that frat -->
                          <div ng-repeat="event in filtered = ( events | filter: {house: product.name})"></div>
                          <span flex></span>
                          <div class="md-actions" layout="row" layout-align="end center">
                            <!-- button that add to favorites, passes in the current frat -->
                            <md-button ng-click="addFavorite(product)" ><ng-md-icon icon="favorite"></ng-md-icon></md-button>
                            <!-- button that shows the dialog, passes in the frat and its events -->
                            <md-button ng-click="showAdvanced($event, product, filtered)"><ng-md-icon icon="menu"></ng-md-icon></md-button>
                          </div>
                        </div>
                      </md-card-content>
                    </md-card>
                  </div>
                </ui-view>
              </md-content>
          </div>

          <!-- FAVORITES tab -->
          <div role="tabpanel"
           id="tab2-content"
           aria-labelledby="tab2"
           ng-switch-when="1"
           md-swipe-left="next()"
           md-swipe-right="previous()" 
           layout="row" layout-align="center center"
           style='padding: 115px 0 0 0;'>
            <md-content flex md-scroll-y>
              <ui-view layout="column" layout-fill layout-padding>
                <div class='md-padding' layout="row" layout-wrap>
                  
                  <!-- goes through all items in the favorites array and makes a card for it -->
                  <md-card style="width: 32%;" ng-repeat="product in favorites | filter: {favorite: true}">
                    <img src="{{product.profile_image}}" style="height: 300px;object-fit: cover;" class="md-card-image" alt="Frat Cover Photo">
                    <md-card-content>
                      <div>
                        <h2>{{product.name}}</h2>
                        <br/>
                        <p> {{product.description}} </p>
                        <hr>
                        <span flex></span>
                        <div class="md-actions" layout="row" layout-align="end center">
                          <!-- button that deletes from favorites, passes in the current frat -->
                          <md-button ng-click="unFavorite(product)"><ng-md-icon icon="favorite"></ng-md-icon></md-button>

                          <!-- button that shows dialog, passes in the current frat -->
                          <md-button ng-click="showAdvanced($event, product)"><ng-md-icon icon="menu"></ng-md-icon></md-button>
                        </div>
                      </div>
                    </md-card-content>
                  </md-card>
                </div>
              </ui-view>
            </md-content>
          </div>
              
          <!-- CALENDAR tab -->
          <div role="tabpanel"
           id="tab3-content"
           aria-labelledby="tab3"
           ng-switch-when="2"
           md-swipe-left="next()"
           md-swipe-right="previous()" 
           layout="row" layout-align="center center"
           style='padding: 115px 0 0 0;'>
            <md-content flex md-scroll-y>
              <ui-view layout="column" layout-fill layout-padding>
                <div class='md-padding' layout="row" layout-wrap style="padding: 0 0 0 30px">
                  
                  <!-- September card -->
                  <md-card class="z-depth-1" layout-fill style="width: 98%; " md-whiteframe="-1" >
                    <h1 style="text-align: center;margin: 20px 0 -40px 0;">September</h1> <span></span>
                    <div class="md-actions" layout="row" layout-align="end center">
                      <!-- button that lets you download ics -->
                      <md-button class="md-raised" style="margin: 0 20px 25px 0; padding: 10px" ng-click="ics()">Download</md-button>
                    </div>
                  </md-card>

                  <!-- Cards for days of week. Goes through daysOfWeek list and makes a card for every one -->
                  <md-card style="width: 14%;" layout-fill class="z-depth-1" ng-repeat="day in daysOfWeek">
                    <h2 style="text-align:center;">{{day.name}}</h2>
                  </md-card>

                  <!-- Cards for days of month. Goes through leadingDays list and makes a card for every one -->
                  <md-card style="width: 14%; min-height: 100px" layout-fill class="z-depth-1" ng-repeat="day in leadingDays">
                    <h2 style="color: #00add9;">{{day.number}}</h2>

                    <!-- Finds the events that are on that date -->
                    <div ng-repeat="event in filtered = ( favoriteEvents | filter: {event_date: day.date} | filter: {favorite: true}) ">
                      
                      <!-- only show one button -->
                      <div ng-show="{{filtered.length}} > 0 && $first">

                        <!-- if there is one say 'event' -->
                        <div ng-show="{{filtered.length}} == 1">
                          <!-- button that shows event dialog -->
                          <md-button ng-click="showEvent($event, day, filtered)">{{filtered.length}} Event</md-button>
                        </div>

                        <!-- if there are more than one, say 'events' -->
                        <div ng-show="{{filtered.length}} > 1">
                          <!-- button that shows event dialog -->
                          <md-button ng-click="showEvent($event, day, filtered)">{{filtered.length}} Events</md-button>
                        </div>
                      </div>
                    </div>
                  </md-card>
                  <br>
                </div>
              </ui-view>
            </md-content>
          </div>
        </ng-switch>
      </div>

      <div hide-gt-sm="" layout="row" layout-align="center center" flex="">
        <md-checkbox ng-model="customFullscreen" aria-label="Fullscreen Custom Dialog">Force Custom Dialog Fullscreen</md-checkbox>
      </div>

      <!-- Template for individual frat page dialog -->
      <script type="text/ng-template" id="orderDialog.tmpl.html">
        <md-dialog aria-label="Frat Page" ng-cloak layout="column" style="position: fixed;">
          <!-- //Toolbar -->
          <md-toolbar>
            <div class="md-toolbar-tools">
            <!-- //Use the name of the current frat -->
              <h2>{{product.name}}</h2>
              <span></span>
              <md-button class="md-icon-button" ng-click="cancel()">
                <ng-md-icon icon="close"></ng-md-icon>
              </md-button>
            </div>
          </md-toolbar>

          <!-- //Content -->
          <md-dialog-content style='overflow: auto; height:100%' width='100%'>
            <md-content flex='' style='overflow: auto; height:100%' width='100%'>

            <!-- //Card for image, name, and stats -->
              <md-card style="padding:20px;">
                <div class="row">
                  <div class="column1" >
                    <img src="{{product.profile_image}}" style="width:100%; height: 200px; object-fit: cover;"  alt="Frat Cover Photo">
                  </div>
                  <div class="column2" style="">
                    <h1>{{product.name}}: {{product.chapter}} Chapter</h1>
                    Number of Brothers: {{product.members}}<br></br>
                    House GPA: {{product.gpa}}
                  </div>
                </div>
                <p style='overflow:visable; height:100%'>{{product.description}}</p>
              </md-card>

              
              <h1 style="padding: 20px 20px 0px 20px;"> Next Events </h1>
              <!-- //Card for next events, goes though all events with for that frat and makes a card for the next 3 -->
              <div ng-repeat="event in filtered = ( currentEvents | filter: {house: product.name}) | limitTo: 3 | orderBy: event_date">
                <md-card style="padding: 20px;" style="width: 600px;" >
                  <h2>{{event.house}} : {{ event.title }} </h2>   
                  Date: {{event.event_date}} <br></br>               
                  Time: {{event.startsAt}} - {{event.endsAt}}<br></br> 
                  Location: {{event.location}} 
                </md-card>
              </div>

              <!-- //Calendar image -->
              <h1 style="padding: 20px 20px 0px 20px;"> Rush Calendar </h1>
              <img src="{{product.calendar_image}}" style="width: 800px;text-align: center;" alt="Calendar Image not available">

              
                <h1 style="padding: 20px 20px 0px 20px;"> House Location </h1>
                <md-card>
                <div ng-show="{{product.address}} ==null">
                  No Location available
                </div>
                <div ng-show="{{product.address}} !=null">
                  <!-- //Location, uses google maps iframe -->
                  <iframe
                    width="100%"
                    height="300"
                    frameborder="0" style="border:0"
                    src={{trustSrc(product.address)}} allowfullscreen>
                  </iframe>
                </div>
              </md-card>
            </md-content>
        </md-dialog-content>
      </md-dialog>
    </script>


    <!-- Date dialog -->
    <script type="text/ng-template" id="datePopup.tmpl.html">
      <md-dialog aria-label="Frat Page" ng-cloak layout="column" style="position: fixed;">
        <!-- //Toolbar -->
        <md-toolbar>
          <div class="md-toolbar-tools">
            <!-- //Display current date -->
            <h2>On this day {{day.date}}</h2>
            <span></span>
            <md-button class="md-icon-button" ng-click="cancel()">
              <ng-md-icon icon="close"></ng-md-icon>
            </md-button>
          </div>
        </md-toolbar>

        <!-- //Content -->
        <md-dialog-content style='overflow: auto; height:100%' width='100%'>
          <md-content flex='' style='overflow: auto; height:100%' width='100%'>

          <!-- //Card for events on that day, goes though all events with for that day -->
            <md-card style="padding: 20px;" style="width: 600px;" ng-repeat="event in filteredEvents | orderBy: event.startsAt">
              <h1>{{event.house}} : {{ event.title }} </h1>                  
              {{event.startsAt}} - {{event.endsAt}}<br></br> 
              {{event.location}} 
            </md-card>
          </md-content>
        </md-dialog-content>
      </md-dialog>
    </script>

    <!-- Dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.6/angular.min.js"></script>
    <scritp src="https://ajax.googleapis.com/ajax/libs/angularjs/X.Y.Z/angular-route.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.6/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.8.3/angular-material.min.js"></script>
    <script src="https://cdn.jsdelivr.net/angular-material-icons/0.4.0/angular-material-icons.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.4.7/angular-filter.js"></script>


      
  </div>
  </body>
</html>

<!-- More dependencies -->
<script src='node_modules/angular-loading-bar/src/loading-bar.js'></script>
<link href='node_modules/angular-loading-bar/src/loading-bar.css' rel='stylesheet' />
<script  src="js/index.js"></script>
<script  src="js/ics.min.js"></script>


</body>
</html>
