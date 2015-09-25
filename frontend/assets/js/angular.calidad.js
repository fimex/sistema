app.controller('Calidad', function($scope, $filter, $modal, $http, $log, $timeout){
    //$scope.Fecha = new Date();
    $scope.catalogos = [];
    $scope.medidas = [];
    
    $scope.getCatalogos = function(){
        return $http.post('/fimex/data-calidad/catalogos')
        .success(function(data){$scope.catalogos = data;});
    };
    
    $scope.getMediciones = function(){
        return $http.post('/fimex/data-calidad/mediciones')
        .success(function(data){$scope.medidas = data;});
    };
    
    $scope.getCapturas = function(index, idFolio){
        var value
        $http.post('/fimex/data-calidad/capturas',{
            FechaIni:$scope.FechaIni,
            FechaFin:$scope.FechaFin,
            idFolio:idFolio
        })
        .success(function(data){
            console.log(data);
            $scope.medidas[index].capturas = data;
        });
    };
});