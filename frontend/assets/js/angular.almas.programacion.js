/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('ProgramacionAlmas', function($scope, $filter, ngTableParams, $http){
    
    $scope.semanas = [];
    $scope.semanal = [];
    $scope.pedidos = [];
    $scope.programaciones = [];
    $scope.resumenes = [];
    $scope.maquinas = [];
    $scope.clientes = [];
    $scope.selectedPedido = [];
    $scope.semanaActual = new Date();
    
    $scope.mostrar = true;
    $scope.mostrarPedido = false;
    $scope.actual = '';
    
    $scope.IdSubProceso = 2;
    $scope.mostrarPedidos = false;
    $scope.selected = null;
    
    $scope.setSelected = function(item) {
        $scope.selected = item;
    };
    
    $scope.loadMaquinas = function(){
        console.log($scope.IdSubProceso);
        return $http.get('/fimex/angular/maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data) {
            $scope.maquinas = data;
        });
    };
    
    $scope.loadCentros = function(){
        console.log($scope.IdSubProceso);
        return $http.get('/fimex/angular/centros-trabajo',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data) {
            $scope.centros = data;
        });
    };
    
    $scope.loadMarcas = function(){
        return $http.get('marcas').success(function(data) {
            $scope.clientes = [];
            $scope.clientes = data;
        });
    };
    
    $scope.loadSemanas = function(){
        return $http.get('load-semana',{params:{semana1:$scope.semanaActual,}}).success(function(data){
            $scope.semanas = [];
            $scope.semanas = data;
            $scope.semanaActual = $scope.semanas.semana1.val;
            $scope.loadProgramacionSemanal();
        });
    }
    
    $scope.loadDias = function(){
        return $http.get('load-dias',{params:{semana:$scope.semanaActual,}}).success(function(data){
            $scope.dias = [];
            $scope.dias = data;
            $scope.loadProgramacionDiaria();
            $scope.loadMaquinas();
            $scope.loadCentros();
        });
    }
    
    $scope.loadPedidos = function(){
        return $http.get('pedidos').success(function(data){
            $scope.pedidos = [];
            $scope.pedidos = data.rows;
        });
    }
    
    $scope.loadProgramacionSemanal = function(){
        return $http.get('data-semanal',{params:{semana1:$scope.semanaActual,}}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
            $scope.resumenes = data.footer;

        });
    };
    
    $scope.saveProgramacionSemanal = function(semana){
        return $http.get('save-semanal',{params:{
                IdProgramacionAlma: $scope.selected['IdProgramacionAlma'],
                Anio: $scope.selected['Anio'+semana],
                Semana: $scope.selected['Semana'+semana],
                Prioridad: $scope.selected['Prioridad'+semana],
                Programadas: $scope.selected['Programadas'+semana]
            }}).success(function(data){
                $scope.loadProgramacionSemanal();
        });
    }
    
    $scope.loadProgramacionDiaria = function(){
        return $http.get('data-diaria',{params:{semana:$scope.semanaActual,}}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
        });
    };
    
    $scope.saveProgramacionDiaria = function(dia){
        console.log($scope.selected);
        return $http.get('save-diario',{params:{
            IdProgramacionAlmaSemana: $scope.selected['IdProgramacionAlmaSemana'],
            Prioridad: $scope.selected['Prioridad'],
            Dia: $scope.selected['Dia'+dia],
            Programadas: $scope.selected['Programadas'+dia],
            Maquina: $scope.selected['Maquina'+dia],
            Centro: $scope.selected['Centro'+dia]
        }}).success(function(data){
            if(data == true){
                $scope.loadProgramacionDiaria();
            }
        });
    }
});