app.controller('tratamientos', function($scope, $filter, $modal, $http, $log, $timeout){
    //$scope.Fecha = new Date();
    $scope.control = false;
    $scope.produccion = [{
        Fecha: new Date(),
        IdArea: null,
        IdCentroTrabajo:null,
        IdEmpleado:null,
        IdTurno:null,
        IdMaquina:null,
        IdProduccion:null,
        IdProduccionEstatus:null,
        IdSubProceso:null,
    }];

    $scope.arr = [];
    $scope.aleaciones = [];
    $scope.changes = [];
    $scope.busquedas = [];
    $scope.maquinas = [];
    $scope.centrosTrabajo = [];
    $scope.empleados = [];
    $scope.defectos = [];
    $scope.fallas = [];
    $scope.materiales = [];
    $scope.turnos = [];
    $scope.tratamientos = [
	{
				Idproduccion: null,
				HoraInicio: null,
				Horafin: null,
				NoGraficaTT: null,
				KWIni: null,
				KWFin: null,
				Temp1: null, 
				Temp2: null,
				TempEntradaDeposito: null,
				TempSalidaDeposito: null,
				TempPzDepositoIn: null,
				TempPzDepositoOut: null,
				IdTipoEnfriamiento: null,
				TiempoEnfriamiento: null,
				TotalKG: null,
				Ecofuel: null,
				archivoGrafica: null,
				idOperador: null,
				idAprobo: null,
				idSuperviso: null
	}
	];
    $scope.enfriamientos = [];
    
    //Catalogos para las Capturas
    
    $scope.programaciones = [];
    $scope.programacionEmpaque = [];
    $scope.detalles = [];
    $scope.rechazos = [];
    $scope.almasRechazos = [];
    $scope.consumos = [];
    $scope.TiemposMuertos = [];
    $scope.temperaturas = [];
    
    $scope.mostrar = false;
    $scope.showModal = false;
    $scope.delete = false;
    $scope.newLance = true;
    
    $scope.index = undefined;
    $scope.indexProgramacion = null;
    $scope.indexDetalle = null;
    $scope.indexMaquina = null;
    
    $scope.aleacionSelect = null;
    $scope.maquinaSelect = null;

    $scope.maintenance = function(){
        alert("test");
    };

    $scope.confirm = function(){
        var r = confirm("¿Realmente desas eliminar el registro?");
        return r;
    };
    
    $scope.alerts = [];
    
    $scope.addAlert = function(msg,type) {
        $scope.alerts.push({
            msg: msg,
            type: type
        });
        $timeout(function() {$scope.alerts.splice($scope.alerts.length-1, 1);}, 5000);
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    
    $scope.countProducciones = function(IdSubProceso,IdArea){
        return $http.post('count-produccion',{
            IdSubProceso:IdSubProceso,
            IdArea:IdArea
        }).success(function(data){
            $scope.producciones = [];
            $scope.producciones = data;
            if($scope.index === undefined){
                $scope.index = $scope.producciones.length - 1;
                $scope.loadProduccion();
            }
        });
    };
    
    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.show($scope.index - 1);
        }
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.producciones.length-1  ){
            $scope.show($scope.index + 1);
        }
    };
    
    $scope.First = function(){
        $scope.show(0);
    };
    
    $scope.Last = function(){
        $scope.show($scope.producciones.length - 1);
    };
    
    $scope.show = function(index){
        $scope.getChanges();
        if($scope.changes.length > 0){
            respuesta = confirm("¿Deseas guardar los cambios en el reporte?");
            if(respuesta){
                var res = $scope.saveChanges();
                
                if(!res)
                    return $scope.addAlert('Error al intentar guardar la produccion','danger');
            }
            $scope.changes = [];
        }
        
        $scope.index = index;
        $scope.loadProduccion();
        if($scope.produccion.IdProduccionEstatus != 1){
            $scope.mostrar = false;
        }else{
            $scope.mostrar = true;
        }
        $scope.almasRechazos = [];
        $scope.rechazos = [];
        $scope.indexDetalle = null;
        $timeout(function() {$scope.loadProgramacion();}, 1000);
        //$scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
    };
    
    $scope.buscar = function(){
        $scope.showModal = !$scope.showModal;
        $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        return $http.post('produccion',{
                busqueda: true,
                IdSubProceso:$scope.IdSubProceso,
                IdArea:$scope.IdArea,
            }).success(function(data){
            $scope.busquedas = data;
        });
    };
    
    $scope.buscar2 = function(){
        $scope.showModal2 = !$scope.showModal2;
    };
    
    $scope.getChanges = function(){
        $scope.changes = [];
        
        for(x=0;x < $scope.detalles.length; x++){
            console.log($scope.detalles[x]);
            if($scope.detalles[x].change == true){
                if($scope.IdSubProceso == 2 || $scope.IdSubProceso == 3){
                    save = 'saveAlmasDetalle('+x+')';
                }else{
                    save = 'saveDetalle('+x+')';
                }
                $scope.changes.push(save);
            }
        }
        
        for(x=0;x < $scope.almasRechazos.length; x++){
            console.log($scope.almasRechazos[x]);
            if($scope.almasRechazos[x].change == true){
                $scope.changes.push('saveAlmaRechazo('+x+')');
            }
        }
        
        for(x=0;x < $scope.rechazos.length; x++){
            console.log($scope.rechazos[x]);
            if($scope.rechazos[x].change == true){
                $scope.changes.push('saveRechazo('+x+')');
            }
        }
        
        for(x=0;x < $scope.temperaturas.length; x++){
            console.log($scope.temperaturas[x]);
            if($scope.temperaturas[x].change == true){
                $scope.changes.push('saveTemperatura('+x+')');
            }
        }
        
        for(x=0;x < $scope.TiemposMuertos.length; x++){
            if($scope.TiemposMuertos[x].change == true){
                $scope.changes.push('saveTiempo('+x+')');
            }
        }

        console.log($scope.changes);
    };
    
    $scope.saveChanges = function(){
        for(x=0;x < $scope.changes.length; x++){
            $scope.$eval($scope.changes[x]);
        }
        return true;
    };
    
    $scope.loadData = function(){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                $scope.indexMaquina = key;
            }
        });
        $scope.produccion.IdSubProceso == 2 || $scope.produccion.IdSubProceso == 3 || $scope.produccion.IdSubProceso == 4 ? $scope.loadAlmasDetalle() : $scope.loadDetalle();
        $scope.loadConsumo();
        $scope.loadTemperaturas();
        $scope.loadTiempos();
    }

    $scope.loadEmpleados = function(depto){
        return $http.get('empleados',{params:{depto:depto}}).success(function(data){
            $scope.empleados = data;
        });
    };
    
    $scope.loadMaquinas = function(){
        return $http.get('maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.maquinas = data;
        });
    };
    
    $scope.loadTurnos = function(){
        return $http.get('turnos',{}).success(function(data) {
            $scope.turnos = data;
        });
    };
    
    $scope.loadAleaciones = function(){
        return $http.get('aleaciones',{params:$scope.produccion}).success(function(data) {
            $scope.aleaciones = data;
        });
    };
    
    $scope.selectMaquina = function(index){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                return $scope.indexMaquina = key;
            }
        });
    };

    $scope.selectTurnos = function(){
        $scope.turnos.forEach(function(value, key) {
            if(value.IdTurno == $scope.produccion.IdTurno){
                return $scope.indexTurno = key;
            }
        });
    };
    
    
    
    
    /********************************************************************
     *                        ENCABEZADO DE PRODUCCION
     *******************************************************************/

    $scope.loadProduccion = function(){
        return $http.post('produccion',{IdProduccion:$scope.producciones[$scope.index].IdProduccion}).success(function(data){
            $scope.mostrar = true;
            $scope.produccion = data;
            $scope.control = true
            $scope.loadData();
        }).error(function(){$scope.control = true});
    };

    $scope.deleteProducciones = function(){
        return $http.get('delete-producciones',{params:{
            IdProduccion:$scope.produccion.IdProduccion
        }}).success(function(data){
            $scope.producciones.splice($scope.index,1);
            $scope.Prev();
        });
    };
    
    $scope.findProduccion = function(data){
        var guardar = true;
        $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        return $http.get('find-produccion',{params:{
            Fecha: $scope.Fecha,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdTurno:$scope.IdTurno,
            IdSubProceso:$scope.IdSubProceso
        }}).success(function(data){
            if(data != 'null' && $scope.IdSubProceso != 10){
                for(x = 0;x < $scope.producciones.length;x++){
                    if(data.IdProduccion == $scope.producciones[x].IdProduccion){
                        console.log('entro');
                        $scope.index = x;
                        $scope.loadProduccion();
                        $scope.loadProgramacion();
                        guardar = false;
                    }
                }
            }
            if(guardar == true) $scope.saveProduccion();
        });
    };
    
    $scope.addProduccion = function(){
        $scope.detalles = [];
        $scope.rechazos = [];
        $scope.almasRechazos = [];
        $scope.consumos = [];
        $scope.TiemposMuertos = [];
        $scope.temperaturas = [];
        $scope.inserted = {
            IdProduccion:null,
            Fecha: $scope.produccion.Fecha,
            IdArea: $scope.IdArea,
            IdCentroTrabajo:null,
            IdEmpleado:null,
            IdMaquina:null,
            IdTurno:$scope.IdTurno,
            IdProduccionEstatus:1,
            IdSubProceso:$scope.IdSubProceso,
            lances:{IdAleacion:$scope.IdAleacion}
        };
        $scope.produccion = $scope.inserted;
        console.log($scope.produccion);
    };
    
    $scope.saveProduccion = function (){
        console.log($scope.produccion,$scope.IdMaquina);
        return $http.get('save-produccion',{params:{
            Fecha: $scope.Fecha,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdTurno:$scope.IdTurno,
            IdSubProceso:$scope.IdSubProceso,
            IdAleacion:$scope.IdAleacion,
			Idproduccion: $scope.IdAleacion,
			
			HoraInicio: $scope.IdAleacion,
			Horafin: $scope.IdAleacion,
			
			NoGraficaTT: $scope.IdAleacion,
			KWIni: $scope.KWIni,
			KWFin: $scope.KWFin,
			Temp1: $scope.Temp1, 
			Temp2: $scope.Temp2,
			TempEntradaDeposito: $scope.TempEntradaDeposito,
			TempSalidaDeposito: $scope.TempSalidaDeposito,
			TempPzDepositoIn: $scope.TempPzDepositoIn,
			TempPzDepositoOut: $scope.TempPzDepositoOut,
			IdTipoEnfriamiento: $scope.IdTipoEnfriamiento,
			TiempoEnfriamiento: $scope.TiempoEnfriamiento,
			TotalKG: $scope.TotalKG,
			Ecofuel: $scope.Ecofuel,
			archivoGrafica: $scope.archivoGrafica,
			idOperador: $scope.idOperador,
			idAprobo: $scope.idAprobo,
			idSuperviso: $scope.idSuperviso
        }}).success(function(data) {
            $scope.produccion = data;
            $scope.index = undefined;
            $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        }).error(function(){
            $scope.addAlert('Error al intentar guardar la produccion','danger');
        });
    };
    
    $scope.updateProduccion = function (){
        return $http.get('save-produccion',{params:$scope.produccion}).success(function(data){
            $scope.produccion = data;
            $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        });
    };
    
    /********************************************************************
     *                        DETALLE DE PRODUCCION
     *******************************************************************/
    
    $scope.loadDetalle = function(){
        return $http.get('detalle',{params:{
                IdProduccion: $scope.produccion.IdProduccion
            }}).success(function(data){
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };
    
    $scope.addDetalle = function(){
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                Fecha: $scope.produccion.Fecha,
                IdProduccionDetalle: null,
                IdProduccion:$scope.produccion.IdProduccion,
                IdProgramacion:$scope.programaciones[$scope.indexProgramacion].IdProgramacion,
                IdProductos:$scope.programaciones[$scope.indexProgramacion].IdProductoCasting,
                Inicio:null,
                Fin:null,
                CiclosMolde: $scope.programaciones[$scope.indexProgramacion].CiclosMolde,
                PiezasMolde: $scope.programaciones[$scope.indexProgramacion].PiezasMolde,
                Programadas: $scope.programaciones[$scope.indexProgramacion].Programadas,
                Hechas: 0,
                Rechazadas: 0,
                Eficiencia: $scope.produccion.IdMaquina.Eficiencia,
                idProductos: {Identificacion:$scope.programaciones[$scope.indexProgramacion].ProductoCasting}
            };
            $scope.detalles.push($scope.inserted);
            $scope.saveDetalle($scope.detalles.length - 1);
        }
    };
    
    $scope.saveDetalle = function(index){
        if($scope.controlClick('detalles',index)){
            $scope.detalles[index].Fecha = $scope.produccion.Fecha;
            return $http.get('save-detalle',{params:$scope.detalles[index]}).success(function(data) {
                $scope.detalles[index] = data;
                $scope.loadProgramacion();
            });
        }
    };
    
    $scope.deleteDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.detalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-detalle',{params:dat}).success(function(data) {
                //$scope.loadDetalle();
                $scope.detalles.splice(index,1);
            }).error(function(){
            return $scope.addAlert('Error al intentar guardar la captura de producto','danger');
        });
        }
    };
    
    $scope.selectDetalle = function(index){
        if($scope.indexDetalle != null){
            $scope.detalles[$scope.indexDetalle].Class = "";
            $scope.indexDetalle = null;
        }
        $scope.indexDetalle = index;
        $scope.detalles[$scope.indexDetalle].Class = "info";
        $scope.loadRechazos();
        $scope.loadAlmasRechazos();
    }

   
    
    /********************************************************************
     *                        CONTROL DE RECHAZO
     *******************************************************************/
    
    $scope.loadDefectos = function(){
        return $http.get('defectos',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea,
            }}).success(function(data){
            $scope.defectos = [];
            $scope.defectos = data;
        });
    };
    
    $scope.loadRechazos = function(){
        return $http.get('rechazos',{params:{
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle,
            }}).success(function(data) {
            $scope.rechazos = [];
            $scope.rechazos = data;
        });
    };
    
    $scope.addRechazo = function(){
        if($scope.indexDetalle != null){
            $scope.inserted = {
                IdProduccionDefecto: null,
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle,
                IdDefectoTipo:null,
                Rechazadas:0
            };
            $scope.rechazos.push($scope.inserted);
        }else{
            $scope.addAlert('Primero debe guardar la produccion para poder generar rechazos','warning');
        }
    };
    
    $scope.delRechazo = function(index){
        return $http.get('del-rechazo',{params:{IdProduccionDefecto:$scope.rechazos[index].IdProduccionDefecto}}).success(function(data) {
            $scope.rechazos.splice(index,1);
        });
    };
    
    $scope.saveRechazo = function(index){
        if($scope.controlClick('rechazos',index)){
            return $http.get('save-rechazo',{params:$scope.rechazos[index]}).success(function(data) {
                $scope.rechazos[index] = data;
                $scope.loadDetalle();
            });
        }
    };
    /********************************************************************
     *                        CONTROL DE FALLAS
     *******************************************************************/
    
    $scope.loadFallas = function(){
        return $http.get('fallas',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea
            }}).success(function(data) {
            $scope.fallas = [];
            $scope.fallas = data;
        });
    };
    
    $scope.loadTiempos = function(){
        return $http.get('tiempos',{params:{
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: $scope.produccion.Fecha,
                IdEmpleado: $scope.produccion.IdEmpleado,
                IdTurno: $scope.produccion.IdTurno,
            }}).success(function(data) {
            $scope.TiemposMuertos = [];
            $scope.TiemposMuertos = data;
        });
    };
    
    $scope.deleteTiempo = function(index){
        if($scope.confirm()){
            var dat = $scope.TiemposMuertos[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-tiempo',{params:dat}).success(function(data) {
                $scope.TiemposMuertos.splice(index,1);
            });
        }
    };
    
    $scope.addTiempo = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdTiempoMuerto: null,
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: $scope.produccion.Fecha,
                IdCausa: null,
                Inicio:'00:00',
                Fin:'00:00',
                Descripcion:'',
                IdTurno: $scope.produccion.IdTurno,
                IdEmpleado: $scope.produccion.IdEmpleado
            };
            $scope.TiemposMuertos.push($scope.inserted);
            //$scope.TiemposMuertos($scope.TiemposMuertos.length - 1);
        }
    };
    
    $scope.saveTiempo = function(index){
        if($scope.controlClick('TiemposMuertos',index)){
            if(($scope.TiemposMuertos[index].Incio != '00:00' && $scope.TiemposMuertos[index].Fin != '00:00') || $scope.TiemposMuertos[index].IdCausa != null){
                return $http.get('save-tiempo',{params:$scope.TiemposMuertos[index]}).success(function(data) {
                    $scope.TiemposMuertos[index] = data;
                });
            }
        }
    };
	
	/********************************************************************
     *                        tratamientos
     *******************************************************************/
	
	$scope.loadTratamientos = function(){
        return $http.get('tratamientos',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.tratamientos = [];
            $scope.tratamientos = data;
        });
    };
    

	
	
	$scope.loadenfriamientos = function(){
        return $http.get('ttenfriamientos',{params:{
                
            }}).success(function(data) {
            $scope.enfriamientos = [];
            $scope.enfriamientos = data;
        });
    };
	
	/********************************************************************
     *                        utilitarios
     *******************************************************************/
    
     
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

                if (accion == 3 && ($scope.arr[x] == palabra || $scope.arr[x] == palabra2)) {
                    $scope.arr.splice(x,1);
                    return;
                };

                if ($scope.arr[x] == palabra2) {
                    $scope.arr[x] = palabra;
                    return;
                }else if($scope.arr[x] == palabra){return;};

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
            if (accion == 3 && ($scope.arr[x] == palabra || $scope.arr[x] == palabra2)) {
                mostrar = true;
                return mostrar;
            };
            if ($scope.arr[x] == palabra2) {
                return mostrar;
            }else if($scope.arr[x] == palabra){
                mostrar = false;
                return mostrar;
            };
        }
        return mostrar;
    };
    
    $scope.controlClick = function(arr,index){
        $scope[arr][index]['active'] = $scope[arr][index]['active'] == undefined ? true : $scope[arr][index]['active'];

        if($scope[arr][index]['active'] == false){
            console.log('entro y no hizo nada');
            return false;
        }
        
        $scope[arr][index]['active'] = false;
        return true;
    };
});