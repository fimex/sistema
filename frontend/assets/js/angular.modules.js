var app = angular.module("programa", ['ngTable','ui.bootstrap','ngDraggable','angularFileUpload'],function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
 
  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
      
    for(name in obj) {
      value = obj[name];
        
      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }
      
    return query.length ? query.substr(0, query.length - 1) : query;
  };
 
  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
})
    .directive('fixedTableHeaders', ['$timeout', function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                $timeout(function () {
                    container = element.parentsUntil(attrs.fixedTableHeaders);
                        element.stickyTableHeaders({ scrollableArea: container, "fixedOffset": 2 });
                }, 0);
            }
        };
    }])
    .directive('fixedHeadersFoot', ['$timeout', function($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            $timeout(function () {
                container = element.parentsUntil(attrs.fixedHeadersFoot);
                    element.fixedHeaderTable({ footer: true});
            }, 0);
        }
    }
}]).factory('method', function($http) {
    return {
        save: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        },
        del: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        },
        get: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        }
    }
}).directive("formatDate", function(){
  return {
   require: 'ngModel',
    link: function(scope, elem, attr, modelCtrl) {
      modelCtrl.$formatters.push(function(modelValue){
        return new Date(modelValue);
      });
    }
  };
}).directive('modal', function () {
    return {
        template: '<div class="modal fade">' + 
              '<div class="modal-dialog modal-lg">' + 
                '<div class="modal-content">' + 
                  '<div class="modal-header">' + 
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                    '<h4 class="modal-title">{{ title }}</h4>' + 
                  '</div>' + 
                  '<div class="modal-body" ng-transclude></div>' + 
                '</div>' + 
              '</div>' + 
            '</div>',
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:true,
        link: function postLink(scope, element, attrs) {
            scope.title = attrs.title;

            scope.$watch(attrs.visible, function(value){
              if(value == true)
                $(element).modal('show');
              else
                $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function(){
              scope.$apply(function(){
                scope.$parent[attrs.visible] = true;
              });
            });

            $(element).on('hidden.bs.modal', function(){
              scope.$apply(function(){
                scope.$parent[attrs.visible] = false;
              });
            });
            console.log(scope);
            console.log(scope.$parent);
        }
    };
}).directive('ordenamiento', function () {
    return {
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:{
            title: '@',
            element:'@',
            arreglo:'='
        },
        controller: function($scope,$element){
            $scope.orden = function (accion){
                if(typeof dato !== 'object'){
                    var palabra = "+"+$scope.element;
                    var palabra2 = "-"+$scope.element;

                    switch(accion){
                        case 1:
                            palabra = "+"+$scope.element;
                            palabra2 = "-"+$scope.element;
                        break;
                        case 2:
                            palabra = "-"+$scope.element;
                            palabra2 = "+"+$scope.element;
                        break;
                    }

                   for (x = 0; x <= $scope.arreglo.length; x++) {

                        if (accion === 3 && ($scope.arreglo[x] === palabra || $scope.arreglo[x] === palabra2)) {
                            $scope.arreglo.splice(x,1);
                            return;
                        };

                        if ($scope.arreglo[x] === palabra2) {
                            $scope.arreglo[x] = palabra;
                            return;
                        }else if($scope.arreglo[x] === palabra){return;};

                    }
                    $scope.arreglo.push(palabra);
                }
                console.log($scope.arreglo);
                console.log($scope.$parent.arr);
            };
            
            $scope.mostrarBoton = function(dato,accion) {
                var palabra = "+"+dato;
                var palabra2 = "-"+dato;
                var mostrar = false;

                switch(accion){
                    case 1:
                        palabra = "+"+dato;
                        palabra2 = "-"+dato;
                        mostrar = true;
                    break;
                    case 2:
                        palabra = "-"+dato;
                        palabra2 = "+"+dato;
                        mostrar = true;
                    break;
                }

                for (x = 0; x <= $scope.arreglo.length; x++) {
                    if (accion === 3 && ($scope.arreglo[x] === palabra || $scope.arreglo[x] === palabra2)) {
                        mostrar = true;
                        return mostrar;
                    };
                    if ($scope.arreglo[x] === palabra2) {
                        return mostrar;
                    }else if($scope.arreglo[x] === palabra){
                        mostrar = false;
                        return mostrar;
                    };
                }
                return mostrar;
            };
        },
        template: '<span>{{title}}<br />'+
            '<span ng-click="orden(1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"ng-show="mostrarBoton(\'{{element}}\',1);"></span>'+
            '<span ng-click="orden(2)" class="seleccion glyphicon glyphicon-triangle-top" aria-hidden="true" ng-show="mostrarBoton(\'{{element}}\',2);"></span>'+
            '<span ng-click="orden(3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton(\'{{element}}\',3);"></span></span>'
        
    };
});
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
    $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
}]);