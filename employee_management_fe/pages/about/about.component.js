var app = angular.module('about')
app.component('aboutComponent', {
    templateUrl: (aboutConfig) => `${aboutConfig.basePath}/about.template.html`,
    controller: function($scope) {
        $scope.name = 'TOM'
    }
})
