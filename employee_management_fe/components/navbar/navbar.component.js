angular.module('navbar').component('navbarComponent', {
  templateUrl: (config) =>`${config.basePath}/navbar.html`,
  bindings: {
    active: '<'
  },
});