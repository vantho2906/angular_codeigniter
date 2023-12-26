var employee = angular.module("employee");

employee.factory("employeeApi", ($http, domain) => {
  var factory = {};
  var employeeDomain = `${domain}/employee`

  factory.getAll = () => {
    return $http.get(employeeDomain);
  };

  factory.getById = (id) => {
    return $http.get(`${employeeDomain}/${id}`);
  };

  factory.delete = (id) => {
    return $http.delete(`${employeeDomain}/${id}`);
  };

  factory.update = (data) => {
    return $http.put(`${employeeDomain}/${data.id}`, data);
  };

  factory.create = (data) => {
    return $http.post(`${employeeDomain}`, data);
  };

  return factory;
});
