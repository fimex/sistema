/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('Programacion', function($scope, $filter, ngTableParams, $http){
    $scope.semanas = [];
    $scope.semanal = [];
    $scope.pedidos = [];
    $scope.programaciones = [];
    $scope.resumenes = [];
    $scope.maquinas = [];
    $scope.clientes = [];
    $scope.selectedPedido = [];
    $scope.semanaActual = new Date();
    
    $scope.selectedCerrado = [];

    $scope.mostrar = true;
    $scope.mostrarPedido = false;
    $scope.actual = '';
    
    $scope.IdSubProceso = 6;
    $scope.mostrarPedidos = false;
    $scope.selected = null;

    $scope.cerrarPedido = function(){
       
        $('input[name="Cerrado[]"]:checked').each(function() {
            $scope.selectedCerrado.push($(this).val());
        });

        return $http.get('update-pedidos',{params:$scope.selectedCerrado}).success(function(data) {
           $scope.loadSemanas();
        });

    };
    
    $scope.setSelected = function(item) {
        console.log(item);
        $scope.selected = item;
    };
    
    $scope.setSelectPedido = function(item) {
        item.checked = !item.checked;
        console.log(item);
    };
    
    $scope.allSelectPedido = function(item) {
        $scope.pedidos.forEach(function(item){
            item.checked = true;
        });
    };
    
    $scope.deSelectPedido = function(item) {
        $scope.pedidos.forEach(function(item){
            item.checked = false;
        });
    };

    $scope.setDatosDux = function(){
        $scope.programaciones = [];
        return $http.get('datos-dux').success(function(data){
            $scope.loadSemanas();
        });
    };
    
    $scope.loadMaquinas = function(){
        return $http.get('/fimex/angular/maquinas',{params:{IdSubProceso:$scope.IdSubProceso}}).success(function(data) {
            $scope.maquinas = data;
        });
    };
    
    $scope.loadMarcas = function(){
        return $http.get('marcas').success(function(data) {
            $scope.clientes = [];
            $scope.clientes = data;
        });
    };
    
    $scope.savePedidos = function(){
        $scope.pedidos.forEach(function(item){
            if(item.checked)
                $scope.selectedPedido.push(item.IdPedido);
        });
        
        return $http.get('save-pedidos',{params:$scope.selectedPedido}).success(function(data) {
            $scope.loadSemanas();
        });
    };
    
    $scope.loadSemanas = function(){
        return $http.get('load-semana',{params:{semana1:$scope.semanaActual,}}).success(function(data){
            $scope.semanas = [];
            $scope.semanas = data;
            $scope.semanaActual = $scope.semanas.semana1.val;
            $scope.loadMarcas();
            $scope.loadPedidos();
            $scope.loadProgramacionSemanal();
            $scope.loadActualizacion();
        });
    }
    
    $scope.loadDias = function(){
        return $http.get('load-dias',{params:{semana:$scope.semanaActual,}}).success(function(data){
            $scope.dias = [];
            $scope.dias = data;
            $scope.loadProgramacionDiaria();
            $scope.loadMaquinas();
        });
    }
    
    $scope.loadPedidos = function(){
        return $http.get('pedidos').success(function(data){
            $scope.pedidos = [];
            $scope.pedidos = data.rows;
        });
    }
    
    $scope.loadActualizacion = function(){
        return $http.get('actualizacion').success(function(data){
            $scope.actual = data;
        });
    };
    
    $scope.loadProgramacionSemanal = function(){
        return $http.get('data-semanal',{params:{semana1:$scope.semanaActual,}}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
            $scope.resumenes = data.footer;
        });
    };
    
    $scope.saveProgramacionSemanal = function(semana){
        $scope.selected['Prioridad'+semana] = $scope.selected['Prioridad'+semana] === '' ? 0 : $scope.selected['Prioridad'+semana];
        $scope.selected['Programadas'+semana] = $scope.selected['Programadas'+semana] === '' ? 0 : $scope.selected['Programadas'+semana];

        console.log($scope.selected['Programadas'+semana]);
        return $http.get('save-semanal',{params:{
                IdProgramacion: $scope.selected['IdProgramacion'],
                Anio: $scope.selected['Anio'+semana],
                Semana: $scope.selected['Semana'+semana],
                Prioridad: $scope.selected['Prioridad'+semana],
                Programadas: $scope.selected['Programadas'+semana]
            }}).success(function(data){
            $scope.loadProgramacionSemanal();
        }).error();
    }
    
    $scope.loadProgramacionDiaria = function(){
        return $http.get('data-diaria',{params:{semana:$scope.semanaActual,}}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
            $scope.resumenes = data.footer;
            $scope.semanal = data.ResumenSem;
        }).error(
            function(data, status, headers, config){
                console.log(data);
                console.log(status);
                console.log(headers);
                console.log(config);
            }
        );
    };
    
    $scope.saveProgramacionDiaria = function(dia){
        $scope.selected['Programadas'+dia] = $scope.selected['Programadas'+dia] === '' ? 0 : $scope.selected['Programadas'+dia];
                
        return $http.get('save-diario',{params:{
            IdProgramacionSemana:$scope.selected['IdProgramacionSemana'],
            Dia:$scope.selected['Dia'+dia],
            Prioridad:$scope.selected['Prioridad'],
            Programadas:$scope.selected['Programadas'+dia],
            IdTurno:$scope.selected['IdTurno'],
            Maquina:$scope.selected['Maquina'+dia],
            IdAreaProceso:$scope.selected['IdAreaProceso'],
        }}).success(function(data){
            if(data == true){
                $scope.loadProgramacionDiaria();
            }
        });
    }
});