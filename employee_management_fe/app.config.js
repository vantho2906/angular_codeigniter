
var app = angular.module("app")

app.config(["$routeProvider", function ($routeProvider) {
  $routeProvider
    .when("/", {
        template: '<home-component></home-component>'
    })
    .when("/about", {
        template: "<about-component></about-component>",
    })
    .when("/employee", {
        template: "<employee-component></employee-component>",
    })
    .when("/employee/:id", {
        template: "<individual-component></individual-component>",
    })
    .otherwise('/')
}]);

app.value('domain', 'http://localhost:9000');