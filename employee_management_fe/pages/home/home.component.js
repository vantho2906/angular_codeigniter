var app = angular.module('home');
app.component('homeComponent', {
  templateUrl: (homeConfig) => `${homeConfig.basePath}/home.html`,
  controller: ['$scope', function ($scope) {
    $scope.person = {
      name: 'Tom',
      age: 20,
      birthday: '29-06-2003',
    };

    $scope.name = 'okela';

    $scope.sayHello = () => {
      $scope.name = 'Hello ' + $scope.name;
    };
    
    $scope.languages = [
      { name: 'C#', likes: new Date(), dislikes: 1, status: false },
      { name: 'ASP.NET', likes: new Date(), dislikes: 1, status: true },
      { name: 'SQL', likes: new Date(), dislikes: 2.33, status: true },
      { name: 'AngularJS', likes: new Date(), dislikes: 0, status: false },
    ];
  },]
});

app.filter('status', function () {
  return function (status) {
    return status ? 'Good' : 'Bad';
  };
});
