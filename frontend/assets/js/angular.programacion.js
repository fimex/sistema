/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller('Programacion', function($scope, $filter, ngTableParams, $http){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    
    $scope.semanas = [];
    $scope.semanal = [];
    $scope.pedidos = [];
    $scope.programaciones = [];
    $scope.resumenes = [];
    $scope.maquinas = [];
    $scope.clientes = [];
    $scope.selectedPedido = [];
    $scope.aleaciones = [];
    $scope.semanaActual = new Date();
    
    $scope.selectedCerrado = [];

    $scope.mostrar = true;
    $scope.mostrarPedido = false;
    $scope.actual = '';
    
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
    
    $scope.saveEnvio = function(IdPedido,FechaEnvio){
        return $http.get('save-envio',{params:{
            IdPedido:IdPedido,
            FechaEnvio:FechaEnvio
        }}).success(function(data) {
        });
    };
    
    $scope.sumatoria = function(items,index) {
        resultado = 0;
        items.forEach(function(value, key) {
            resultado += parseFloat(value[index]);
        });
        return resultado;
    };
    
    $scope.setSelected = function(item) {
        $scope.aleacion = item.Aleacion;
        $scope.selected = item;
    };
    
    $scope.login = function (log) {
        $scope.isLoading = log;
    };
    
    $scope.setSelectPedido = function(item) {
        item.checked = !item.checked;
        $scope.selectAll = $scope.selectAll ? !$scope.selectAll : $scope.selectAll;
    };
    
    $scope.allSelectPedido = function(item) {
        $scope.pedidos.forEach(function(item){
            item.checked = !$scope.selectAll;
        });
        $scope.selectAll = !$scope.selectAll;
    };

    $scope.setDatosDux = function(){
        $scope.programaciones = [];
        return $http.get('datos-dux').success(function(data){
            $scope.loadSemanas();
        });
    };
    
    $scope.loadMaquinas = function(){
        return $http.get('/fimex/angular/maquinas',{params:{
                IdSubProceso:$scope.IdSubProceso,
                IdArea:$scope.IdArea
        }}).success(function(data) {
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
        $scope.selectedPedido = [];
        $scope.pedidos.forEach(function(item){
            if(item.checked)
                $scope.selectedPedido.push(item.IdPedido);
        });

        return $http.get('save-pedidos',{params:$scope.selectedPedido}
        ).success(function(data) {
            $scope.loadSemanas();
        }).error(function(data) {
            $scope.loadSemanas();
        });
        
        return $http.get('save-pedidos',{params:$scope.selectedPedido}).success(function(data) {
            $scope.loadSemanas();
        }).error(function(data) {
            $scope.loadSemanas();
        });
    };
    
    $scope.loadSemanas = function(){
        return $http.get('load-semana',{params:{semana1:$scope.semanaActual}}).success(function(data){
            $scope.semanas = [];
            $scope.semanas = data;
            $scope.semanaActual = $scope.semanas.semana1.val;
            $scope.loadMarcas();
            $scope.loadPedidos();
            $scope.loadProgramacionSemanal();
            $scope.loadResumen();
            $scope.loadActualizacion();
        });
    };
    
    $scope.loadDias = function(){
        return $http.get('load-dias',{params:{semana:$scope.semanaActual}}).success(function(data){
            $scope.dias = [];
            $scope.dias = data;
            $scope.loadProgramacionDiaria();
            $scope.loadResumenDiario();
            $scope.loadMaquinas();
        });
    };
    
    $scope.loadPedidos = function(){
        return $http.get('pedidos').success(function(data){
            $scope.pedidos = [];
            $scope.pedidos = data.rows;
        });
    };
    
    $scope.loadActualizacion = function(){
        return $http.get('actualizacion').success(function(data){
            $scope.actual = data;
        });
    };
    
    $scope.loadProgramacionSemanal = function(){
        return $http.get('data-semanal',{params:{
            semana1:$scope.semanaActual,
            IdAreaProceso:$scope.IdAreaProceso
        }}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
        });
    };
    
    $scope.saveProgramacionSemanal = function(row,semana){
        $scope.login(true);
        row['Prioridad'+semana] = row['Prioridad'+semana] === '' ? 0 : row['Prioridad'+semana];
        row['Programadas'+semana] = row['Programadas'+semana] === '' ? 0 : row['Programadas'+semana];

        return $http.get('save-semanal',{params:{
                IdProgramacion: row['IdProgramacion'],
                Anio: row['Anio'+semana],
                Semana: row['Semana'+semana],
                Prioridad: row['Prioridad'+semana],
                Programadas: row['Programadas'+semana]
            }}).success(function(data){
            $scope.loadResumen();
            $scope.login(false);
        }).error(function(data,status){
            $scope.login(false);
        });
    };
    
    $scope.loadResumenSemanal = function(){
        return $http.get('resumen-semanal',{params:{
                semana:$scope.semanaActual,
                filtro:$scope.filtro
            }}).success(function(data){
            $scope.resumenes = data;
        }).error(
            function(data, status, headers, config){
            }
        );
    };
    
    $scope.loadResumenDiario = function(){
        if ($scope.IdArea === 2) {
            return $http.get('resumen-diario-acero',{params:{semana:$scope.semanaActual}})
            .success(function(data){
                $scope.resumenes = data;
            }).error(function(data, status, headers, config){
                }
            );
        }else{
            return $http.get('resumen-diario',{params:{semana:$scope.semanaActual}})
            .success(function(data){
                $scope.resumenes = data;
            }).error(function(data, status, headers, config){
            });
        }
    };

    $scope.loadResumenSemanalAcero = function(){
        return $http.get('resumen-semanal-acero',{params:{semana:$scope.semanaActual}}).success(function(data){
            $scope.resumenes = data;
        }).error(
            function(data, status, headers, config){
            }
        );
    };
    
    $scope.loadResumen = function(){
        if ($scope.IdArea === 2) {
            $scope.loadResumenSemanalAcero();
        }else{
            $scope.loadResumenSemanal();
        }
    };

    $scope.loadProgramacionDiaria = function(){
        return $http.get('data-diaria',{params:{semana:$scope.semanaActual,IdSubProceso:$scope.IdSubProceso}}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
            $scope.diaActual = $scope.diaActual === undefined ? 1 : $scope.diaActual;
            $scope.loadTarimas();
            
            for(var x=0;x < $scope.programaciones.length;x++){
                index = $scope.aleaciones.indexOf($scope.programaciones[x].Aleacion);
                if(index === -1){
                    console.log(index,$scope.programaciones[x].Aleacion);
                    $scope.aleaciones.push($scope.programaciones[x].Aleacion);
                }
            }
            console.log($scope.aleaciones);
        }).error(
            function(data, status, headers, config){
            }
        );
    };
    
    $scope.saveProgramacionDiaria = function(row,dia){
        
        $scope.login(true);
        row['Programadas'+dia] = row['Programadas'+dia] === '' ? 0 : row['Programadas'+dia];
        
        return $http.get('save-diario',{params:{
            IdProgramacionSemana:row.IdProgramacionSemana,
            Dia:row['Dia'+dia],
            Prioridad:row.Prioridad,
            Programadas:row['Programadas'+dia],
            IdTurno:row.IdTurno,
            Maquina:row['Maquina'+dia],
            IdAreaProceso:row.IdAreaProceso,
            IdSubProceso:row.IdSubProceso,
            Tarimas: JSON.stringify(row.Tarimas),
            CiclosMolde:row.CiclosMolde,
            Delete:row.Delete
        }}).success(function(data){
            if(data === true){
                $scope.loadProgramacionDiaria();
                $scope.loadResumenDiario();
            }
            $scope.login(false);
        });
    };
    
    $scope.arr = [];
    
    $scope.orden = function (dato,accion){
        if(typeof dato !== 'object'){
            var palabra = "+"+dato;
            var palabra2 = "-"+dato;

            switch(accion){
                case 1:
                    palabra = "+"+dato;
                    palabra2 = "-"+dato;
                break;
                case 2:
                    palabra = "-"+dato;
                    palabra2 = "+"+dato;
                break;
            }

           for (x = 0; x <= $scope.arr.length; x++) {

                if (accion === 3 && ($scope.arr[x] === palabra || $scope.arr[x] === palabra2)) {
                    $scope.arr.splice(x,1);
                    return;
                };

                if ($scope.arr[x] === palabra2) {
                    $scope.arr[x] = palabra;
                    return;
                }else if($scope.arr[x] === palabra){return;};

            }
            $scope.arr.push(palabra);
        }
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
        
        for (x = 0; x <= $scope.arr.length; x++) {
            if (accion === 3 && ($scope.arr[x] === palabra || $scope.arr[x] === palabra2)) {
                mostrar = true;
                return mostrar;
            };
            if ($scope.arr[x] === palabra2) {
                return mostrar;
            }else if($scope.arr[x] === palabra){
                mostrar = false;
                return mostrar;
            };
        }
        return mostrar;
    };
    
    /*************************************
                    TARIMAS
    **************************************/
    
    $scope.loops = [];
    
    $scope.loadTarimas = function(){
        return $http.get('datos-tarimas',{params:{
            Dia:$scope.programaciones[0]['Dia'+$scope.diaActual],
            reporte:$scope.reporte
        }}).success(function(data){
            $scope.loops = [];
            $scope.loops = data;
        });
    };
    
    $scope.onDragComplete=function(data,evt){
    };
    
    $scope.onDropComplete=function(data,evt,tarimas){
        console.log(data);
        if(data.TotalProgramado < data.ProgramadasSemana){
            console.log(tarimas);
            var ciclos = parseInt(data.CiclosMolde);
            var x;
            var y;
            data.Tarimas = [];

            for(y=0;y<tarimas.length;y++){
                var tarima = tarimas[y].Tarima;
                var loop = tarimas[y].Loop;
                
                for(x=0;x<ciclos;x++){
                    $scope.loops[loop]['Tarima'+tarima] = [];
                    $scope.loops[loop]['Tarima'+tarima] = data;
                    $scope.loops[loop]['Tarima'+tarima].visible = true;
                    
                    console.log($scope.loops[loop]['Tarima'+tarima],$scope.loops[loop],tarima);
                    
                    data.Tarimas.push({Loop:loop,Tarima:tarima});
                    
                    tarima = x == (ciclos-1) ? '' : prompt("En que tarima desea colocar el siguiente ciclo");
                }
            }
            console.log(data);
            $scope.saveTarima(data);
        }
    };
    
    $scope.saveTarima = function(data){
        var cantidad = 0;

        data['Programadas'+$scope.diaActual] = cantidad;
        $scope.saveProgramacionDiaria(data,$scope.diaActual);
    };
    
    $scope.rellenar=function(loop,tarima){
        var loop2 = prompt("Loop Actual: "+ (loop+1) +" Hasta que loop desea rellenar");
        var data = $scope.loops[loop]['Tarima'+tarima];
        var tarimas = [];
        var x;
        
        data.TotalProgramado = parseInt(data.TotalProgramado);
        data['Maquina'+$scope.diaActual] = data.Maquina;
        data['Dia'+$scope.diaActual] = data.Dia;
        data['Programadas'+$scope.diaActual] = data['Programadas'];
        data['CiclosMolde'] = data.CiclosMolde;
        
        console.log(data);
        
        if(loop2 !== 'null'){
            loop2 = parseInt(loop2);
            for(x=loop + 1;x<loop2;x++){
                tarimas.push({
                    Loop:x,
                    Tarima:tarima
                });
            };
            console.log(tarimas);
            $scope.onDropComplete(data,'',tarimas);
        }
    };
    
    $scope.Delete = function(loop,tarima){
        var loop2 = prompt("Loop Actual: "+ (loop+1) +" Hasta que loop desea Eliminar");
        var data = $scope.loops[loop]['Tarima'+tarima];

        data.Tarimas = [];
        var x;
        
        if(loop2 !== 'null'){
            var data = $scope.loops[loop]['Tarima' + tarima];
            loop2 = parseInt(loop2);
            for(x=loop;x<loop2;x++){
                console.log(data);
                data.Delete = true;
                data['Maquina'+$scope.diaActual] = data.Maquina;
                data['Dia'+$scope.diaActual] = data.Dia;
                data['Programadas'+$scope.diaActual] = data['Programadas'];
                
                $scope.loops[x]['Tarima' + tarima] = [];
                data.Tarimas.push({
                    Loop:x,
                    Tarima:tarima
                });
            }
            $scope.saveTarima(data);
        }
    };
    
    $scope.resumen = function(loop,aleacion){
        var Toneladas = 0;
        loop = $scope.loops[loop];
        for(y=1;y<=8 ;y++){
            if(loop['Tarima'+y].Aleacion === aleacion){
                Toneladas += (loop['Tarima'+y].PesoAraniaA / loop['Tarima'+y].CiclosMolde);
            }
        }
        return Toneladas;
    };
});