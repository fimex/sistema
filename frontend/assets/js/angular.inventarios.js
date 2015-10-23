/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('Inventarios', function($scope, $filter, ngTableParams, $http){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    
    $scope.loadExistencias = function(){
        $http.get('/fimex/inventario/inventario',{params:{
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.Existencias = data;
        }).error(function(){
            
        });
    };
});