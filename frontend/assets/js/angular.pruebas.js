app.controller('Pruebas', function($scope, $filter, $http){
    $scope.FechaIni = new Date();
    $scope.FechaFin = new Date();
    $scope.IdTurno = 1;
    $scope.semanaActual = new Date();
        
    // Disable weekend selection
    $scope.disabled = function(date, mode) {
        return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 7 ) );
    };

    $scope.sumatoria = function(index) {
        resultado = 0;
        $scope.data.forEach(function(value, key) {
            resultado += parseFloat(value[index]);
        });
        return resultado;
    };
    
    $scope.openFechaFin = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.openedFechaFin = true;
    };
    
    $scope.openFechaIni = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.openedFechaIni = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];

    $scope.getDayClass = function(date, mode) {
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i=0;i<$scope.events.length;i++){
                var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    };

    $scope.data = [];
    
    $scope.load = function(url,params){
        return $http.get(url,{params:params}).success(function(data){
            $scope.data = data;
            console.log($scope.data);
        });
    };
    
    $scope.delete = function(url,params){
        return $http.get(url,{params:params}).success(function(data){
            $scope.data.splice(params.index,1);
        });
    };

    $scope.getSemana = function(item,index) {
        return item['semana' + index];
    };
    
    $scope.suma = function(item,val) {
        item.total = item.total + vla; 
    };

    $scope.cerrarPedido = function(){
        var checkboxValues = new Array();
        //recorremos todos los checkbox seleccionados con .each
        $('input[name="Cerrado[]"]:checked').each(function() {
            //$(this).val() es el valor del checkbox correspondiente
            checkboxValues.push($(this).val());
            alert(checkboxValues);
        });
    };

    $scope.loadProductosSeries = function(){
        return $http.get('productos-series').success(function(data){
            $scope.series = data;
        });
    };
    
    $scope.totalFiltro = function(campo){
        var res = 0;
        var datos = $filter('filter')( $scope.data, $scope.filter);
        for(var j=0;j<datos.length;j++){
            res += datos[j][campo];
        };
        return res;
    };
    
    $scope.Resumen = function(index,index2){
        var res = 0;
        var datos = $filter('filter')( $scope.data, $scope.filter);
        console.log(datos);
        for(var x=0;x<datos.length;x++){
            for(var y=0;y<datos[x][index].length;y++){
                res += datos[x][index][y][index2];
            }
        };
        return res;
    };
});