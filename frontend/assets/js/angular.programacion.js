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
        return $http.get('marcas').success(function(data){
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
        
        return $http.get('save-pedidos',{
            params:{
                pedidos:JSON.stringify($scope.selectedPedido),
                IdArea:$scope.IdArea
            }
        }).success(function(data){
            $scope.loadSemanas();
        }).error(function(data){
            $scope.loadSemanas();
        });
    };
    
    $scope.loadSemanas = function(){
        return $http.get('load-semana',{params:{
                semana1:$scope.semanaActual,
                IdArea:$scope.IdArea
            }}).success(function(data){
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
    
    $scope.loadDias = function(tarimas){
        return $http.get('load-dias',{params:{semana:$scope.semanaActual}}).success(function(data){
            $scope.dias = [];
            $scope.dias = data;
            $scope.loadProgramacionDiaria(tarimas);
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
            IdArea:$scope.IdArea,
            IdProceso:$scope.IdProceso
        }}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
        });
    };
    
    $scope.saveProgramacionSemanal = function(row,semana){
        $scope.login(true);
        //row['Prioridad'+semana] = row['Prioridad'+semana] === '' ? 0 : row['Prioridad'+semana];
        //row['Programadas'+semana] = row['Programadas'+semana] === '' ? 0 : row['Programadas'+semana];

        return $http.get('save-semanal',{params:{
                IdProceso: $scope.IdProceso,
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
                IdArea:$scope.IdArea,
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
            return $http.get('resumen-diario',{params:{
                semana:$scope.semanaActual,
                turno:$scope.Turno
            }})
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

    $scope.loadProgramacionDiaria = function(tarimas){
        return $http.get('data-diaria',{params:{
                semana:$scope.semanaActual,
                IdProceso:$scope.IdProceso,
                IdArea:$scope.IdArea,
                turno:$scope.Turno
            }}).success(function(data){
            $scope.programaciones = [];
            $scope.programaciones = data.rows;
            $scope.diaActual = $scope.diaActual === undefined ? 1 : $scope.diaActual;

        if(tarimas == true){
                $scope.loadTarimas();
            }
            
            for(var x=0;x < $scope.programaciones.length;x++){
                index = $scope.aleaciones.indexOf($scope.programaciones[x].Aleacion);
                if(index === -1){
                    $scope.aleaciones.push($scope.programaciones[x].Aleacion);
                }
            }
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
            IdArea:row.IdArea,
            IdAreaProceso:row.IdAreaProceso,
            IdSubProceso:row.IdSubProceso,
            Tarimas: JSON.stringify(row.Tarimas),
            CiclosMolde: row.IdArea == 2 ? row.CiclosMoldeA : row.CiclosMolde,
            Delete:row.Delete
        }}).success(function(data){
            if(data === '1'){
                $scope.loadProgramacionDiaria(row.Tarimas == 'undefined' ? false : true);
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
            Dia:$scope.programaciones[0]['Dia1']
        }}).success(function(data){
            $scope.loops = [];
            $scope.loops = data;
            $scope.resumen();
        });
    };
    
    $scope.MostrarLoop = function(Loop){
        if($scope.reporte){
            for(var x=1;x<=9; x++){
                if(Loop['Tarima'+x] != ''){
                    return true;
                }
            }
            return false;
        }
        
        return true;
    };
    
    $scope.onDragComplete=function(data,evt){
        //console.log(data);
    };
    
    $scope.onDropComplete=function(index,evt,tarimas,data){
        data2 = $filter('filter')($scope.programaciones, $scope.filtro);
        data2 = data2[index];
        var dataDia = undefined;
        var dataNoche = undefined;
        var dia = [];
        var noche = [];
        
        
        if(data === undefined){
            data = data2;
        }
        
        if(data.TotalProgramado >= data.ProgramadasSemana){
            alert('Ya no se pueden Programar mas moldes, si se requieren mas favor de capturarlos en la programacion Semanal');
            return;
        }
            
        data.CiclosMolde = data.CiclosMoldeA;
        var ciclos = parseFloat(data.CiclosMoldeA) <= 0 ? 1 : parseFloat(data.CiclosMoldeA);
        var x;
        var y = 0;
        data.Tarimas = [];

        for(x=0;x<ciclos;x++){
            if(x > 0){
                tarima2 = prompt("En que tarima desea colocar el siguiente ciclo");
                tarima2 = tarima2 - tarimas[0].Tarima;
            }

            var tarima2 = tarima2 != null ? tarima2 : x;

            for(y=0;y<tarimas.length;y++){
                
                var tarima = tarimas[y].Tarima + tarima2;
                var loop = tarimas[y].Loop;
                var Dia = tarimas[y].Dia;

                if(loop >= 30){
                    dataNoche = data;
                    dataNoche.IdTurno = 3;
                }else{
                    dataDia = data;
                    dataDia.IdTurno = 1;
                }

                $scope.loops[Dia]['Loops'][loop]['Tarima'+tarima] = [];
                $scope.loops[Dia]['Loops'][loop]['Tarima'+tarima] = loop >= 30 ? dataNoche : dataDia;
                $scope.loops[Dia]['Loops'][loop]['Tarima'+tarima].visible = true;

                if(loop >= 30){
                    noche.push({Loop:loop,Tarima:tarima,IdTurno:3});
                }else{
                    dia.push({Loop:loop,Tarima:tarima,IdTurno:1});
                }
                Dia2 = Dia;
            }
        }

        if(dataDia != undefined){
            dataDia.Tarimas = dia;
            $scope.saveTarima(dataDia,Dia+1);
        }
        if(dataNoche != undefined){
            dataNoche.Tarimas = noche;
            $scope.saveTarima(dataNoche,Dia+1);
        }
    };
    
    $scope.saveTarima = function(data,dia){
        var cantidad = 0;

        data['Programadas'+dia] = cantidad;
        $scope.saveProgramacionDiaria(data,dia);
    };
    
    $scope.rellenar=function(dia,loop,tarima){
        var loop2 = prompt("Moldes que desea agregar");
        var data = $scope.loops[dia]['Loops'][loop]['Tarima'+tarima];
        var tarimas = [];
        var x;
        
        if(data.TotalProgramado >= data.ProgramadasSemana){
            alert('Ya no se pueden Programar mas moldes, si se requieren mas favor de capturarlos en la programacion Semanal');
            return;
        }
        
        data['Maquina'+(dia+1)] = data.Maquina;
        data['Dia'+(dia+1)] = data.Dia;
        data['Programadas'+(dia+1)] = data['Programadas'];
        
        if(loop2 !== 'null'){
            
            var ciclosMolde = data.CiclosMolde > 0 ? 1 : data.CiclosMolde;
            
            loop2 = loop2 < 60 ? loop2 : 60;
            loop2 = loop2 + data.TotalProgramado > data.ProgramadasSemana ? data.ProgramadasSemana - data.TotalProgramado: loop2;
            loop2 *= ciclosMolde;
            
            loop2 = parseInt(loop2) + (loop+1);
            
            for(x=loop + 1;x<loop2;x++){
                tarimas.push({
                    Dia:dia,
                    Loop:x,
                    Tarima:tarima
                });
            };
            $scope.onDropComplete(0,'',tarimas,data);
        }
    };
    
    $scope.Delete = function(dia,loop,tarima){
        var data = $scope.loops[dia]['Loops'][loop]['Tarima'+tarima];

        data.Tarimas = [];
        var x;
        var data = $scope.loops[dia]['Loops'][loop]['Tarima'+tarima];
        
        data.Delete = true;
        data['Maquina'+(dia+1)] = data.Maquina;
        data['Dia'+(dia+1)] = data.Dia;
        data['Programadas'+(dia+1)] = data['Programadas'];

        $scope.loops[dia]['Loops']['Tarima' + tarima] = [];
        data.Tarimas.push({
            Dia:dia,
            IdTurno: loop >= 30 ? 3 : 1,
            Loop:loop,
            Tarima:tarima
        });
        
        $scope.saveTarima(data,dia+1);
    };
    
    $scope.resumen = function(){
        angular.forEach($scope.aleaciones,function(aleacion,IndexAleacion){
            var acumulado = 0;
            angular.forEach($scope.loops,function(dia,IndexDia){
                angular.forEach(dia['Loops'],function(loop,IndexLoop){

                    $scope.loops[IndexDia]['Loops'][IndexLoop][aleacion] = acumulado;

                    for(y=1;y<=8 ;y++){
                        data = $scope.loops[IndexDia]['Loops'][IndexLoop]['Tarima'+y];
                        if(data.Aleacion === aleacion){
                            $scope.loops[IndexDia]['Loops'][IndexLoop][aleacion] += (parseFloat(data.PesoAraniaA) / parseFloat(data.CiclosMoldeA));
                            acumulado += (parseFloat(data.PesoAraniaA) / parseFloat(data.CiclosMoldeA));
                           }
                    }
                });
            });
        });
    };
    
    $scope.tolerancia = function(valor,tolerancia){
        return (parseInt((valor / 1000)+1)* 1000) + tolerancia;
    };
});