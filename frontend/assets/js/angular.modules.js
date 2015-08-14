var app = angular.module("programa", ['ngTable','ui.bootstrap','ngDraggable'])
    .directive('fixedTableHeaders', ['$timeout', function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                $timeout(function () {
                    container = element.parentsUntil(attrs.fixedTableHeaders);
                        element.stickyTableHeaders({ scrollableArea: container, "fixedOffset": 2 });
                }, 0);
            }
        }
    }])
    .directive('cellFixed', ['$timeout', function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                $timeout(function () {
                    container = element.parentsUntil(attrs.cellFixed);
                        element.stickyTableColumn({ scrollableArea: container, "fixedOffset": 2 });
                }, 0);
            }
        }
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