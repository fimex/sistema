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
        }
    };
});
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
    $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
}]);