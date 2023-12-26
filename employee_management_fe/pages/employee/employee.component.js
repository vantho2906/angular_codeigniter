var employee = angular.module("employee");

employee.component("employeeComponent", {
  templateUrl: (employeeConfig) => `${employeeConfig.basePath}/templates/employee.html` ,
  controller: [
    "$scope",
    "employeeApi",
    function ($scope, employeeApi) {
      $scope.id = "";
      $scope.employees = [];

      $scope.getAll = () => {
        employeeApi.getAll().then((res) => {
          $scope.employees = res.data.data;
        });
      };

      $scope.getById = (id) => {
        employeeApi.getById(id).then((res) => {
          $scope.employee = res.data;
        });
      };

      $scope.delete = (id) => {
        employeeApi.delete(id).then(() => {
          $scope.employees = $scope.employees.filter(
            (person) => person.id != id
          );
          createToast("Delete success!!", "success");
        });
      };

      $scope.update = (data) => {
        employeeApi.update(data).then((res) => {
          $scope.getAll();
          createToast("Update success!!", "success");
        });
      };

      $scope.create = (data) => {
        employeeApi.create(data).then(() => {
          $scope.getAll();
          $scope.createEmployee = {};
          createToast("Create success!!", "success");
        });
      };

      $scope.getAll();

      $scope.openUpdateModal = (employee) => {
        $scope.updateEmployee = { ...employee };
      };

      $scope.openDeleteModal = (employee) => {
        $scope.deleteEmployee = { ...employee };
      };

      $scope.isReverse = false;
      $scope.sort = (column) => {
        if ($scope.sortColumn == column) $scope.isReverse = !$scope.isReverse;
        else {
          $scope.sortColumn = column;
          $scope.isReverse = false;
        }
      };
      $scope.reset = () => {
        $scope.sortColumn = '';
        $scope.isReverse = false;
        $scope.filterColumn = '';
        $scope.filterValue = '';
      }

      $scope.customFilter = (item) => {
        if (!$scope.filterValue) {
          return true; 
        }

        if (!$scope.filterColumn) {
          var filterValue = $scope.filterValue.toLowerCase();
          var itemProperties = Object.values(item).join(' ').toLowerCase();
          return itemProperties.includes(filterValue);
        }
        
        var filterValue = $scope.filterValue.toLowerCase();
        var itemPropertyValue = item[$scope.filterColumn];
        if (itemPropertyValue) {
          return itemPropertyValue.toString().toLowerCase().includes(filterValue);
        }
        
        return false;
      }

      $scope.calculateAge = (dob) => {
        let bitrh = new Date(dob);
        let today = new Date();
        return today.getFullYear() - bitrh.getFullYear();
      }
    },
  ],
});

employee.component("updateModalComponent", {
  templateUrl: (employeeConfig) => `${employeeConfig.basePath}/templates/updateModal.html`,
  bindings: {
    employee: "<",
    update: "=",
  },
});

employee.component("createModalComponent", {
  templateUrl: (employeeConfig) => `${employeeConfig.basePath}/templates/createModal.html`,
  bindings: {
    employee: "=",
    create: "=",
  },
});

employee.component("deleteModalComponent", {
  templateUrl: (employeeConfig) => `${employeeConfig.basePath}/templates/deleteModal.html`,
  bindings: {
    delete: "=",
    employee: "<",
  },
});

employee.component("individualComponent", {
  templateUrl: (employeeConfig) => `${employeeConfig.basePath}/templates/individual.html`,
  controller: function(employeeApi, $scope, $routeParams ) {
    $scope.id = $routeParams.id;
    $scope.getById = (id) => {
      employeeApi.getById(id).then((res) => {
        $scope.employee = res.data;
      });
    };
    $scope.getById($scope.id);
  }
});
