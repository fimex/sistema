/*app.controller('ReporteSerie', function ($scope, $http) {
    $scope.series = [
        {producto:"159", serie:"15000", estatus:{ciclo:"ok",llenado:"ok",cerrado:"ok",vaciado:"rec",comentario:"lol"}},
        {producto:"159", serie:"15001", estatus:{ciclo:"ok",llenado:"ok",cerrado:"ok",vaciado:"ok",comentario:"lole"}},
        {producto:"159", serie:"15002", estatus:{ciclo:"ok",llenado:"ok",cerrado:"rec",vaciado:"",comentario:"lole"}},
        {producto:"159", serie:"15003", estatus:{ciclo:"ok",llenado:"rec",cerrado:"",vaciado:"",comentario:"lole"}}
    ]
});
app.controller('vaciado_cont', function ($scope, $http){
    $scope.aleaciones = ['aleacion1', 'aleacion2', 'aleacion3'];
    $scope.hornos = ['horno1', 'horno2', 'horno3'];
    $scope.vaciadores = ['v1', 'v2', 'v3'];
    $scope.model_aleacion = $scope.aleaciones[0];
    $scope.model_horno = $scope.hornos[0];
    $scope.model_vaciador = $scope.vaciadores[0];
    $scope.getChange = function (val) {
        alert("value: " + val);
    }

});*/

app.controller('ProduccionAceros', function ($scope, $filter, $modal, $http, $log, $timeout, $window, $upload){
    $scope.Fecha = new Date();
    $scope.IdProduccion = null;
    $scope.IdProduccionEstatus = 1;
    $scope.indexSerie = null;
   
    $scope.produccion = [];
    $scope.turnos = [];

    $scope.maquinas = [];
    $scope.fallas = [];
    $scope.TiemposMuertos = [];
    $scope.turno = [];
    $scope.tiempos = [];
    $scope.lenghtPartes = [];
	$scope.mostrar = true;
    $scope.uploadResult = [];
	
	$scope.countProduccionesAceros = function(IdSubProceso,IdArea){

        return $http.get('count-produccion',{params:{
                IdSubProceso:IdSubProceso, 
                IdArea:IdArea
            }}).success(function(data){
                $scope.producciones = [];
                $scope.producciones = data;

                if ($scope.producciones == '') {
                    $scope.producciones.IdProduccion = '';
                };
               
                if($scope.index === undefined){
                   
                    $scope.index = $scope.producciones.length - 1;
                    $scope.loadProduccion();
    				//$scope.loadDetallett();   
                }
        });
        
    };

    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.index -= 1;
        }
        $scope.show();
        console.log($scope.index);
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.producciones.length-1  ){
            $scope.index += 1;
        }
        $scope.show();
    };
    
    $scope.First = function(){
        $scope.index = 0;
        $scope.show();
    };
    
    $scope.Last = function(){
        console.log($scope.producciones);
        $scope.index = $scope.producciones.length - 1;
        $scope.show();
    };
    
    $scope.show = function(){
        $scope.loadProduccion();
        if($scope.produccion.IdProduccionEstatus != 1){
            $scope.mostrar = false;
        }else{
            $scope.mostrar = true;
        }
        $scope.indexDetalle = null;
		 
        //$scope.loadData();
    }
	
    $scope.loadProduccion = function(){
        if ($scope.IdSubProceso == 18 || $scope.IdSubProceso == 14 ){
            idproduccion =  $scope.producciones[$scope.index].IdProduccion;
        }

        return $http.get('data-produccion',{params:{
            IdArea: $scope.IdArea,
            Fecha: $scope.Fecha,
            //IdMaquina: $scope.IdMaquina,
            //IdEmpleado: $scope.IdEmpleado,
            IdTurno: $scope.IdTurno,
            IdProduccion: $scope.producciones[$scope.index].IdProduccion
        }}).success(function(data){       
            $scope.IdProduccion = data.IdProduccion;
            $scope.IdProduccionEstatus = data.IdProduccionEstatus;
            $scope.produccion = data;
            $scope.loadDetallett();
            $scope.loadProbetas();
        }).error(function(){
            
        });
    };

    $scope.UpdateProduccion = function(){
        console.log($scope.produccion);

        return $http.get('data-produccion',{params:{
            IdArea: $scope.produccion,
        }}).success(function(data){       
            $scope.IdProduccion = data.IdProduccion;
            $scope.IdProduccionEstatus = data.IdProduccionEstatus;
            $scope.produccion = data;
            $scope.loadDetallett();
            $scope.loadProbetas();
        }).error(function(){
            
        });
    };

    $scope.loadProgramaciones = function(){

        $scope.programacionAceros = [];
        return $http.get('data-programaciones',{params:{
            IdArea: $scope.IdArea,
            IdAreaAct: $scope.IdAreaAct,
            Dia: $scope.Fecha
           
        }}).success(function(data){
            $scope.programacionAceros = data;
            /************************************************************************
            Solucion Apocrifa (REVISAR CONSULTA v_ProduccionCiclos)
            ************************************************************************/
            for(x=0;x<$scope.programacionAceros.length;x++){
                if($scope.programacionAceros[x].CiclosMolde == 1)
                    $scope.programacionAceros[x].OKMoldeo = $scope.programacionAceros[x].OKMoldeo/2;
            }
            /************************************************************************
            Solucion Apocrifa (REVISAR CONSULTA v_ProduccionCiclos)
            ************************************************************************/
            $scope.loadProduccion();
            $scope.getDatos();
            $scope.loadPartesMolde();
        }).error(function(){
        });
    };
    
    $scope.loadPartesMolde = function(){
        return $http.get('partes-molde',{params:{
            IdArea: $scope.IdArea,
            IdAreaAct:$scope.IdAreaAct
        }})
        .success(function(data){  
            $scope.partes = data;
        });
    };
    
    $scope.selectParte = function(IdParteMolde){
        $scope.IdParteMolde = IdParteMolde;
    };
    
    $scope.selectReposicion = function(Reposicion){
        $scope.Reposicion = Reposicion;
    };
    
    $scope.selectSerie = function(indexSerie){
        $scope.indexSerie = indexSerie;
        //alert($scope.indexSerie);
    };
    
    $scope.ModelMoldeo = function(index,tipo){
        $scope.index = index;
        $scope.estatus = tipo;
        ciclo = $scope.programacionAceros[index].CiclosMolde;
        //if($scope.programacionAceros[index].LlevaSerie == 'Si' && ($scope.IdSubProceso != 6 || $scope.IdSubProceso != 7)){
        if($scope.programacionAceros[index].LlevaSerie == 'Si'){
            $scope.MostrarSeries($scope.programacionAceros[index].IdProducto,$scope.IdSubProceso); 
        }
        
        $scope.title = $scope.estatus == 3 ? 'Ciclos Rechazados' : 'Captura de Ciclos';
        $scope.estatus == 3 ? $scope.showModalR = !$scope.showModalR : ($scope.estatus == 4 ? $scope.showModalCRK = !$scope.showModalCRK : $scope.showModal = !$scope.showModal);
    };
    
    $scope.MostrarSeries = function(IdProducto,IdSubProceso){
        if(IdSubProceso == 9 && $scope.IdAreaAct == 1)
            subProceso = 6;
        else if(IdSubProceso == 9 && $scope.IdAreaAct == 2)
            subProceso = 7;
        else
            subProceso = IdSubProceso;

        
        return $http.get('mostrar-series',{params:{
                IdProducto: IdProducto,
                Estatus:'B',
                IdSubProceso:subProceso
            }}).success(function(data) {
            $scope.listadoseries = data;
        });
    };

    
    $scope.saveDetalleAcero = function(index,tipo){
        $scope.index = index;
        $scope.estatus = tipo;
        $scope.programacionAceros[$scope.index].SerieInicio = $scope.IdSubProceso == 6 || $scope.IdSubProceso ==7 || $scope.IdSubProceso == 17 ? $scope.programacionAceros[$scope.index].SerieInicio : null;
        if ($scope.IdSubProceso != 9) {
            if ($scope.programacionAceros[$scope.index].FechaMoldeo == 1 && !$scope.FechaMoldeo2) {
                return alert("Debes de ingresar la fecha del moldeo");
            };
        };
        i = 0;
        console.log('hola');
        $scope.IdParteMolde = [];
        if($scope.programacionAceros[$scope.index].CiclosMoldeA <= 1 && ($scope.estatus == 1 && $scope.Reposicion != 'SI')){
            $scope.IdParteMolde = $scope.programacionAceros[$scope.index].CiclosMoldeA == (.5) ? [1,2,1,2] : [1,2];
        }else{           
            $('input[name="Parte"]:checked').each(function() {
                $scope.IdParteMolde[i] = $(this).val();
                i++;
            });
        }
        console.log($scope.IdParteMolde);

        if($scope.estatus == 3){
            $scope.IdParteMolde = [];
            $('input[name="ParteR"]:checked').each(function() {
                $scope.IdParteMolde[1] = $(this).val();
            });
        }
            
        var CiclosMoldeA = 0;
        switch ($scope.estatus){
            case 1: CiclosMoldeA = $scope.Reposicion == 'SI' ? (.5) : (1 / $scope.programacionAceros[$scope.index].CiclosMoldeA); break;
            case 3: CiclosMoldeA = $scope.IdSubProceso == 6 || $scope.IdSubProceso == 7 ? 0 : (-.5); break;
        }
        
        $scope.programacionAceros[$scope.index].FechaMoldeo2 = $scope.FechaMoldeo2;
        $scope.programacionAceros[$scope.index].IdEstatus = $scope.Reposicion == 'SI' ? 2 : $scope.estatus;
        $scope.programacionAceros[$scope.index].Linea = $scope.Linea || null;
        $scope.programacionAceros[$scope.index].IdPartesMoldes = $scope.IdParteMolde;
        $scope.programacionAceros[$scope.index].SerieInicio = $scope.indexSerie == null ? $scope.programacionAceros[$scope.index].SerieInicio : $scope.listadoseries[$scope.indexSerie].Serie;
        $scope.indexSerie = null;
        
        if ($scope.programacionAceros[$scope.index].FechaMoldeo == null) {
            $scope.programacionAceros[$scope.index].FechaMoldeo = 0;
        };
        if($scope.programacionAceros[$scope.index].LlevaSerie != 'Si' || ($scope.programacionAceros[$scope.index].LlevaSerie == 'Si' && $scope.programacionAceros[$scope.index].SerieInicio != null))
        return $http.get('save-detalle-acero',{params:{
            Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha,
                IdEmpleado: $scope.IdEmpleado,
                IdMaquina: $scope.IdMaquina,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno
            },
            ProduccionesDetalleMoldeo:$scope.programacionAceros[$scope.index]
        }}).success(function(data) {
            $scope.loadProgramaciones();
            $scope.listadoSeries = [];
            $scope.indexSerie = null;
            $scope.loadPartesMolde();
            $scope.showModal = false;
            window.name = 'NG_ENABLE_DEBUG_INFO!' + window.name;
        });
    };

    $scope.getSerie = function(IdParte,IdProducto,estatus,IdSubProceso){
        $scope.ModelParte = IdParte;
        if (IdSubProceso == 9) { IdSubProceso = 6; };
        return $http.get('get-serie',{params:{
        IdParteMolde:IdParte,
        IdProducto:IdProducto
        }})
        .success(function(data){
            if (data != 0) {
                $scope.serieproducto = data;
                $scope.MostrarSeries(IdProducto,IdSubProceso);
                $('#showseries').removeAttr("disabled", 'false');
            }
            if(data == 0){
                $('#showseries').attr("disabled", 'true');
            }
        });
    };
    
    $scope.loadProductosSeries = function(){
        return $http.get('productos-series')
        .success(function(data) {
            $scope.ProductosSeries = [];
            $scope.ProductosSeries = data;
        });
    };

    $scope.loadProductos = function(){
        return $http.get('productos')
        .success(function(data){
            $scope.productos = data;
        });
    };

    $scope.addSerie = function() {
        $scope.inserted = {
            IdConfiguracionSerie: null,
            IdProducto: $scope.ProductosSeries.IdProducto,
            Identificacion:'',
        };
        $scope.ProductosSeries.push($scope.inserted); 
    };

    $scope.saveSerie = function(index){
        if($scope.ProductosSeries[index].SerieInicio != ''){
            return $http.get('save-serie',{params:$scope.ProductosSeries[index]})
            .success(function(data) {
                $scope.errores = [];
                $scope.errores = data;
                if($scope.errores.Error == 1){
                    alert("El No de Parte "+$scope.errores.IdProducto+" o la Serie "+$scope.errores.Serie+" ya estan configuradas ");
                }
                $scope.loadProductosSeries();
            });
        }
    };

    $scope.buscar2 = function(){
        $scope.showModal2 = !$scope.showModal2;
    };
  
    $scope.loadTurnos = function(){
        return $http.get('turnos',{}).success(function(data) {
            $scope.turnos = data;
        });
    };
	
	$scope.loadEmpleados = function(depto){
        return $http.get('empleados',{params:{depto:depto}})
        .success(function(data){
            $scope.empleados = data;
        });
    };

    /********************************************************************
    *                        CONTROL DE FALLAS
    *******************************************************************/
    $scope.countTiemposMuertos = function(){
        return $http.get('count-tiempos',{params:{
            IdEmpleado: 977
        }}).success(function(data){
            $scope.tiempos = [];
            $scope.tiempos = data;
            if ($scope.tiempos == '') {
                $scope.tiempos.IdTiempoMuerto = '';
            };
           
            if($scope.index == undefined){
                $scope.index = $scope.tiempos.length - 1;
                $scope.getDatos();
            }
        });
    };

    $scope.loadFallas = function(){
        return $http.get('fallas',{params:{
                IdSubProceso: 6,
                IdArea: 2
            }}).success(function(data) {
            $scope.fallas = [];
            $scope.fallas = data;
        });
    };
    
    $scope.loadTiempos = function(){
        return $http.get('tiempos',{params:{
                Fecha: $scope.Fecha,
                IdMaquina: $scope.IdMaquina,
                IdEmpleado: $scope.IdEmpleado,
                IdTurno: $scope.IdTurno
            }}).success(function(data) {
            $scope.TiemposMuertos = [];
            $scope.TiemposMuertos = data;
        });
    };
    
    $scope.deleteTiempo = function(index){
        var dat = $scope.TiemposMuertos[index];
        return $http.get('delete-tiempo',{params:dat}).success(function(data) {
            $scope.TiemposMuertos.splice(index,1);
        });
    };
    
    $scope.addTiempo = function() {
        $scope.inserted = {
            IdTiempoMuerto: null,
            IdCausa: $scope.IdCausa,
            Inicio:'00:00',
            Fin:'00:00',
            Descripcion:'',
            IdTurno: $scope.IdTurno,
            Fecha: $scope.Fecha,
            IdMaquina: $scope.IdMaquina,
            IdEmpleado: $scope.IdEmpleado
        };
        $scope.TiemposMuertos.push($scope.inserted);
    };
    
    $scope.saveTiempo = function(index){
        if(($scope.TiemposMuertos[index].Incio != '00:00' && $scope.TiemposMuertos[index].Fin != '00:00') || $scope.TiemposMuertos[index].IdCausa != null){
            return $http.get('save-tiempo',{params:$scope.TiemposMuertos[index]}).success(function(data) {
                $scope.TiemposMuertos[index] = data;
                $scope.loadTiempos();
            });
        }
    };


    /********************************************************************
    *                        OBTENER DATOS
    *******************************************************************/

    $scope.loadEmpleados = function(depto){
        return $http.get('/fimex/angular/empleados',{params:{depto:depto}})
        .success(function(data){
            $scope.empleados = data;
        });
    };
    
    $scope.openTiemposMuertos = function(){
      
    };

    $scope.loadTurnos = function(){
        return $http.get('turnos',{}).success(function(data) {
            $scope.turnos = data;
        });
    };

    $scope.getDatos = function(){
        $scope.loadFallas();
        $scope.loadTiempos();
    };

	//***************************TratamientosJS***************************
	
	$scope.loadMaquinas = function(){
        return $http.get('/fimex/angular/maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea,
            IdCentroTrabajo:$scope.IdCentroTrabajo
        }}).success(function(data){
            $scope.maquinas = data;
        });
    };

    $scope.selectMaquina = function(index){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                return $scope.indexMaquina = key;
            }
        });
    };
	
	$scope.showcampostt = function(){
		if(  $scope.IdCentroTrabajo == 1036 ||  $scope.IdCentroTrabajo== 1041){
		  $scope.campostt= true;
		}else
			$scope.campostt= false;
	}
	
	$scope.loadCentros = function(){
        return $http.get('/fimex/angular/centros-trabajo',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.centros = data;
        });
    };
	
	$scope.loadenfriamientos = function(){
        return $http.get('ttenfriamientos',{params:{
                
            }}).success(function(data) {
            $scope.enfriamientos = [];
            $scope.enfriamientos = data;
        });
    };	
	
	$scope.SaveTratamientos = function(){
        var imagen = document.getElementById('imagen').value;
        console.log($scope.produccion.idTratamientosTermicos.NoTT);
        //console.log($scope.tratamientos[index]);
        
        return $http.get('save-tratamientos', {params:{
           Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha, 
                IdEmpleado: $scope.IdEmpleado,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
				Observaciones: $scope.Observaciones,
				IdMaquina: $scope.IdMaquina,
            },
            tratamientos:{
				HoraInicio: $scope.produccion.idTratamientosTermicos.HoraInicio,
				HoraFin: $scope.produccion.idTratamientosTermicos.HoraFin,
				NoTT:$scope.produccion.idTratamientosTermicos.NoTT,
				NoGraficaTT: null,
				KWIni: $scope.produccion.idTratamientosTermicos.KWIni,
				KWFin: $scope.produccion.idTratamientosTermicos.KWFin,
				Temp1: $scope.produccion.idTratamientosTermicos.Temp1, 
				Temp2: $scope.produccion.idTratamientosTermicos.Temp2,
				TempEntradaDeposito: $scope.produccion.idTratamientosTermicos.TempEntradaDeposito,
				TempSalidaDeposito: $scope.produccion.idTratamientosTermicos.TempSalidaDeposito,
				TempPzDepositoIn: $scope.produccion.idTratamientosTermicos.TempPzDepositoIn,
				TempPzDepositoOut: $scope.produccion.idTratamientosTermicos.TempPzDepositoOut,
				IdTipoEnfriamiento: $scope.produccion.idTratamientosTermicos.IdTipoEnfriamiento,
				TiempoEnfriamiento: $scope.produccion.idTratamientosTermicos.TiempoEnfriamiento,
				TotalKG: $scope.produccion.idTratamientosTermicos.TotalKG,
				Ecofuel: $scope.produccion.idTratamientosTermicos.Ecofuel,
				idOperador: $scope.produccion.idTratamientosTermicos.idOperador,
				idAprobo: $scope.produccion.idTratamientosTermicos.idAprobo,
				idSuperviso: $scope.produccion.idTratamientosTermicos.idSuperviso,
                Imagen: imagen
			}
        }}).success(function(data){
			$scope.produccion = data;
            $scope.index = undefined;
            $scope.countProduccionesAceros($scope.IdSubProceso,$scope.IdArea);
            //alert('Guardado');
        })
    };

    $scope.updateTratamientos = function (){
        var imagen = document.getElementById('imagen').value;
        return $http.get('save-tratamientos',{params:{
             Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha, 
                IdEmpleado: $scope.IdEmpleado,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
                Observaciones: $scope.Observaciones,
                IdMaquina: $scope.IdMaquina,
                IdProduccion: $scope.produccion.IdProduccion
            },
            tratamientos:{
                IdTratamientoTermico: $scope.produccion.idTratamientosTermicos.IdTratamientoTermico,
                HoraInicio: $scope.produccion.idTratamientosTermicos.HoraInicio,
                HoraFin: $scope.produccion.idTratamientosTermicos.HoraFin,
                NoTT:$scope.produccion.idTratamientosTermicos.NoTT,
                NoGraficaTT: null,
                KWIni: $scope.produccion.idTratamientosTermicos.KWIni,
                KWFin: $scope.produccion.idTratamientosTermicos.KWFin,
                Temp1: $scope.produccion.idTratamientosTermicos.Temp1, 
                Temp2: $scope.produccion.idTratamientosTermicos.Temp2,
                TempEntradaDeposito: $scope.produccion.idTratamientosTermicos.TempEntradaDeposito,
                TempSalidaDeposito: $scope.produccion.idTratamientosTermicos.TempSalidaDeposito,
                TempPzDepositoIn: $scope.produccion.idTratamientosTermicos.TempPzDepositoIn,
                TempPzDepositoOut: $scope.produccion.idTratamientosTermicos.TempPzDepositoOut,
                IdTipoEnfriamiento: $scope.produccion.idTratamientosTermicos.IdTipoEnfriamiento,
                TiempoEnfriamiento: $scope.produccion.idTratamientosTermicos.TiempoEnfriamiento,
                TotalKG: $scope.produccion.idTratamientosTermicos.TotalKG,
                Ecofuel: $scope.produccion.idTratamientosTermicos.Ecofuel,
                idOperador: $scope.produccion.idTratamientosTermicos.idOperador.IdEmpleado,
                idAprobo: $scope.produccion.idTratamientosTermicos.idAprobo.IdEmpleado,
                idSuperviso: $scope.produccion.idTratamientosTermicos.idSuperviso.IdEmpleado,
                Imagen: imagen
            }

        }}).success(function(data){
            $scope.produccion = data;
            $scope.index = undefined;
            $scope.countProduccionesAceros($scope.IdSubProceso,$scope.IdArea);
        });
    };

    $scope.addTratamientos = function(){
        var defaultForm = {
            HoraInicio: null,
            HoraFin: null,
            NoTT: null,
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
            idOperador: null,
            idAprobo: null,
            idSuperviso: null,
          };

        $scope.editableForm.$setPristine();
        $scope.produccion.idTratamientosTermicos = defaultForm;
      
    };
	//*************tratamientos DETALLE*********************************
	
	    $scope.detalles = [];
		$scope.IdProgramacion = null;
	    $scope.programadosTT = [];
		
		$scope.encuentra = function(term){
			
			var items = [];
			devices = $scope.programadosTT
			for (var i=0;i<devices.length;i++) {
				var item = devices[i];
				for (var prop in item) {
					var detail = item[prop].toString().toLowerCase();
					if (detail.indexOf(term)>-1) {
						items.push(item);
						break;               
					}
				}
			}
			return items;
		}

	
		$scope.SetIdProgramacion = function(item){
			
			res = $scope.encuentra(item);
			
			 $scope.IdProgramacion = res[0].IdProgramacion;
			
		}
		
		$scope.loadprogramadostt = function(){
			return $http.get('productosprogramadostt',{params:{
                fecha: '2015-07-01'
            }}).success(function(data){
            $scope.programadosTT = [];
            $scope.programadosTT = data;
			});
			
		}
		
    $scope.loadDetallett = function(){
        return $http.get('detallett',{params:{
                IdProduccion: $scope.produccion.IdProduccion
            }}).success(function(data){
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };
    
    $scope.addDetalle = function(){
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                Fecha: null,
                IdProduccionDetalle: null,
                IdProduccion:$scope.produccion.IdProduccion,
                IdProgramacion:$scope.IdProgramacion,
				Eficiencia:1,
                FechaMoldeo:null,
				IdProductos:null,
				Hechas: null
                
            };
            $scope.detalles.push($scope.inserted);
            //$scope.saveDetalle($scope.detalles.length - 1);
        }
    };
    
    $scope.saveDetalle = function(index){
        console.log($scope.detalles[index].IdProgramacion);
        if($scope.controlClick('detalles',index)){
            if($scope.detalles[index].IdProgramacion == null)
                $scope.detalles[index].IdProgramacion  =$scope.IdProgramacion;
				
            return $http.get('save-detallett',{
                params:$scope.detalles[index]
            }).success(function(data) {
                $scope.detalles[index] = data;
                $scope.loadDetallett();
            });
        }
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
    
	$scope.confirm = function(){
        var r = confirm("¿Realmente desas eliminar el registro?");
        return r;
    };
	
    $scope.deleteDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.detalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-detallett',{params:dat}).success(function(data) {
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
		$scope.loadSeriestt();
		$scope.loadLseries($scope.detalles[$scope.indexDetalle].IdProductos);
        //$scope.loadRechazos();
        //$scope.loadAlmasRechazos();
    };
	
	//series tratamientos *************************
	$scope.series = [];
	$scope.lseries = [];
	
		
	
	$scope.loadSeriestt = function(){
        return $http.get('seriestt',{params:{
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle
            }}).success(function(data){
            $scope.series = [];
            $scope.series = data;
        });
    };
	
	
	$scope.addSerie= function(){
		
		if ($scope.indexDetalle == null){
			alert("selecciones un prooducto "); return; 
			
		}
		
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
				IdSeriesDetalle: null,
                Comentarios: null,
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle,
                IdSerie:null,
				Estatus:'B',
            };
            $scope.series.push($scope.inserted);
			$scope.loadLseries($scope.detalles[$scope.indexDetalle].IdProductos);
            //$scope.saveDetalle($scope.detalles.length - 1);
        }
    };
	
	
	$scope.loadLseries = function(Producto){

		return $http.get('lseriestt',{params:{
                IdProducto: Producto,
            }}).success(function(data){
            $scope.lseries = [];
            $scope.lseries = data;
        });
		
	}
	
	 $scope.saveSeriett = function(index){
        if($scope.controlClick('series',index)){
		 
            //$scope.detalles[index].IdProgramacion  =$scope.IdProgramacion;
            return $http.get('saveseriestt',{
				params:$scope.series[index]
				}).success(
				function(data) {
					$scope.series[index] = data;
					 $scope.loadSeriestt();
					});
        }
    };
	
	$scope.deleteseriesDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.series[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('deleteseriestt',{params:dat}).success(function(data) {
                //$scope.loadDetalle();
               $scope.loadSeriestt();
            }).error(function(){
            return $scope.addAlert('Error al intentar guardar la captura de producto','danger');
        });
        }
    };
	//probetas ******************************************************+
    $scope.probetadetalles = [];
	$scope.loadProbetas = function(){
        //console.log($scope.produccion.IdProduccion+ ' 22');
        return $http.get('probetastt',{params:{
              IdProduccion: $scope.produccion.IdProduccion
        }}).success(function(data){
			 $scope.probetadetalles =[];
            $scope.probetadetalles = data;
        });
    };
	
	 $scope.loadLances = function(){
        return $http.get('lances',{params:{
            IdArea: $scope.IdArea
        }}).success(function(data){
            $scope.lances = data;
        });
    };
		
	$scope.addProbetaDetalle = function(){
        $scope.inserted = {
			idTratamientoProbetas: null,
            IdLance: null,
			idProduccion: $scope.produccion.IdProduccion,
            Cantidad:null,
           };			
        $scope.probetadetalles.push($scope.inserted);
    };
	
	$scope.saveProbetaDetalle = function(index){
        console.log($scope.probetadetalles[index]);
        if($scope.controlClick('probetadetalles',index)){
            $scope.probetadetalles[index].IdProgramacion  =$scope.IdProgramacion;
            return $http.get('saveprobetadetalle',{
				params:$scope.probetadetalles[index]
				}).success(
				function(data) {
					$scope.probetadetalles[index] = data;
					 $scope.loadProbetas();
					});
        }
    };
	
	$scope.deleteProbetaDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.probetadetalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('deleteprobetasdetallett',{params:dat}).success(function(data) {
                //$scope.loadDetalle();
               $scope.loadProbetas();
            }).error(function(){
            return $scope.addAlert('Error al intentar guardar la captura de producto','danger');
        });
        }
    };
	
	//subir imagentt
	$scope.onFileSelect = function(files) {
    //$files: an array of files selected, each file has name, size, and type.
		for (var i = 0; i < files.length; i++) {
		    var file = files;
            console.log(file);
            $upload.upload({
                url: 'uploadtt',
                file: file,
                progress: function(e){}
            }).then(function(response) {
            // file is uploaded successfully
                $timeout(function() {
                    $scope.uploadResult.push(response.data);
                    console.log($scope.uploadResult);
                });
            });
		}
	}
	

});// ****************************************** FIN controlador ProduccionAceros

app.controller('ProduccionAceros2', function ($scope, $filter, $modal, $http, $log, $timeout){
	
	    $scope.campostt= false;
    $scope.Fecha = new Date();
    $scope.produccion = [{
        Fecha: new Date(),
        IdArea: null,
        IdCentroTrabajo:null,
        IdEmpleado:null,
        IdMaquina:null,
        IdProduccion:null,
        IdProduccionEstatus:null,
        IdSubProceso:null,
        Observaciones:null,
        IdAreaAct:null,
        Proceso:null,
        lances:{IdAleacion:$scope.IdAleacion},
        lances:{Kellblocks:$scope.Kellblocks},
        lances:{Lingotes:$scope.Lingotes},
        lances:{Probetas:$scope.Probetas}
    }];

    $scope.Series = [];
    $scope.ProductosSeries = [];
    $scope.productos = [];
    $scope.errores = [];
    $scope.detalles = [];
    $scope.producciones = [];
    $scope.empleados = [];
    $scope.maquinas = [];
    $scope.programaciones = [];
    $scope.serieproducto = [];
    $scope.listadoseries = [];
    $scope.productosdia = [];
    $scope.productosdiadetalle = [];
    $scope.erroresP = [];
    $scope.Partes = [];
    $scope.selectedPartes = [];
    $scope.consumos = [];
    $scope.temperaturas = [];
    $scope.tiempoanalisis = [];
    $scope.selectedSeries = [];
    $scope.Series = [];

    $scope.parte = [];

    $scope.index = undefined;
    $scope.indexMaquina = null;
    $scope.indexProgramacion = null;

    $scope.showModal = false;   
    $scope.showModalR = false;
    $scope.showModalRM = false;
    $scope.Producto = '';
    $scope.producto = '';
    $scope.idproducto = '';
    $scope.ModelParte = '';
    $scope.FechaProduccion = '';
    $scope.IdProduccion2 = '';
    $scope.IdProduccion3 = '';
    $scope.DatosPartes = '';
    $scope.linea = '';
    $scope.DatosSeries = '';
    Kellblocks = 0;
    Probetas = 0;
    Lingotes = 0;
    count = 0;
    Vaciar = 0;


    $scope.countProduccionesAceros = function(IdSubProceso,IdArea){
        return $http.get('count-produccion',{params:{IdSubProceso:IdSubProceso, IdArea:IdArea,}}).success(function(data){
            $scope.producciones = [];
            $scope.producciones = data;
            if ($scope.producciones == '') {
                $scope.producciones.IdProduccion = '';
            };
           
            if($scope.index == undefined){
                $scope.index = $scope.producciones.length - 1;
                $scope.loadProduccion();
            }
        });
    };

    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.index -= 1;
        }
        $scope.show();
        console.log($scope.index);
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.producciones.length-1  ){
            $scope.index += 1;
        }
        $scope.show();
    };
    
    $scope.First = function(){
        $scope.index = 0;
        $scope.show();
    };
    
    $scope.Last = function(){
        console.log($scope.producciones);
        $scope.index = $scope.producciones.length - 1;
        $scope.show();
    };
    
    $scope.show = function(){
        $scope.loadProduccion();
        if($scope.produccion.IdProduccionEstatus != 1){
            $scope.mostrar = false;
        }else{
            $scope.mostrar = true;
        }
        $scope.indexDetalle = null;
        //$scope.loadData();
    }

    $scope.loadProduccion = function(){

        if ($scope.erroresP == 1) {
            $scope.IdProduccion3 = $scope.IdProduccion2;
        }else{
            if ($scope.producciones.IdProduccion != '') {
                $scope.IdProduccion3 = $scope.producciones[$scope.index].IdProduccion;
            }else{  $scope.IdProduccion3  = '';  }

        }

        return $http.get('produccion',{params:{
            IdProduccion:$scope.IdProduccion3
            
        }}).success(function(data){
            $scope.mostrar = true;
            $scope.produccion = data;
            
            if ($scope.erroresP == '') {
                $scope.FechaProduccion = $scope.produccion.Fecha
            };
            console.log($scope.FechaProduccion);
            console.log($scope.erroresP);
            $scope.loadData();
        });
    };

    $scope.loadData = function(){
       
        $scope.loadProgramacion();
        $scope.loadProductosDia();
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                $scope.indexMaquina = key;
            }
        });

        if ($scope.IdSubProceso != 10) {
            $scope.loadDetalleAcero();
        }else{
            $scope.loadDetalleVaciado();
        }
        $scope.loadConsumo();
        $scope.loadTemperaturas();
        $scope.loadTiempoAnalisis();
    }

    $scope.loadEmpleados = function(depto){
        return $http.get('/fimex/angular/empleados',{params:{depto:depto}})
        .success(function(data){
            $scope.empleados = data;
        });
    };

    $scope.loadMaquinas = function(){
        return $http.get('maquinas',{params:{IdSubProceso:$scope.IdSubProceso}})
        .success(function(data){
            $scope.maquinas = data;
        });
    };

    $scope.selectMaquina = function(index){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                return $scope.indexMaquina = key;
            }
        });
    };


    $scope.loadPartesMolde = function(){
        return $http.get('partes-molde',{params:{IdAreaAct:$scope.IdAreaAct}})
        .success(function(data){

            $scope.partes = data;
        });
    };

    $scope.loadProductosDia=function(){
        return $http.get('productos-dia',{params:{
                Dia: $scope.mostrar ? $scope.produccion.Fecha : $scope.Fecha,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                IdMaquina: $scope.produccion.IdMaquina,
        }})
        .success(function(data){
            $scope.productosdia = data;
        });
    };

    $scope.DetallesDia = function(IdProducto,index){  
        return $http.get('detalles-dia',{params:{
                IdProducto: IdProducto,
                Dia: $scope.mostrar ? $scope.produccion.Fecha : $scope.Fecha,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                IdMaquina: $scope.produccion.IdMaquina
        }})
        .success(function(data){
            $scope.detalles[index]=data;
        });
    };

    $scope.loadAleaciones = function(){
        return $http.get('aleaciones',{params:$scope.produccion}).success(function(data) {
            $scope.aleaciones = data;
        });
    };
	
    $scope.addProduccion = function(){
            produccion = null;
    };


    /********************************************************************
     *                       TIEMPO ANALISIS
     *******************************************************************/

    $scope.loadTiempoAnalisis = function(){
        return $http.get('tiempo-analisis',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.tiempoanalisis = [];
            $scope.tiempoanalisis = data;
        });
    };

    $scope.SaveTiempoAnalisis = function(index){
        return $http.get('save-tiempo-analisis',{params:$scope.tiempoanalisis[index]}).success(function(data) {
            $scope.tiempoanalisis[index] = data;
            $scope.loadTiempoAnalisis();
        });

    };

    $scope.addTiempoAnalisis = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdTiempoAnalisis: null,
                IdProduccion: $scope.produccion.IdProduccion,
                Tiempo: null,
                Tipo: null,
                Fecha: $scope.produccion.Fecha,
            };
            $scope.tiempoanalisis.push($scope.inserted);
        }
    };

    /********************************************************************
     *                       CONTROL DE MATERIAL
     *******************************************************************/
  
    $scope.loadMaterial = function(){
        return $http.get('material',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea,
            }}).success(function(data) {
            $scope.materiales = [];
            $scope.materiales = data;
        });
    };

    $scope.loadConsumo = function(){
        return $http.get('consumo',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.consumos = [];
            $scope.consumos = data;
        });
    };

    $scope.addConsumo = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdMaterialVaciado: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdMaterial: null,
                Cantidad: 0,
            };
            $scope.consumos.push($scope.inserted);
        }
    };

    $scope.saveConsumo = function(index){
        //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
        return $http.get('save-consumo',{params:$scope.consumos[index]}).success(function(data) {
            $scope.consumos[index] = data;
        });
    };


    $scope.deleteConsumo = function(index){
        if($scope.confirm()){
            var dat = $scope.consumos[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-consumo',{params:dat}).success(function(data) {
                $scope.consumos.splice(index,1);
            });
        }
    };


    /********************************************************************
     *                        CONTROL DE TEMPERATURAS
     *******************************************************************/
    
    $scope.loadTemperaturas = function(){
        return $http.get('temperaturas',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.temperaturas = [];
            $scope.temperaturas = data;
        });
    };
    
    $scope.deleteTemperatura = function(index){
        if($scope.confirm()){
            var dat = $scope.temperaturas[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-temperatura',{params:dat}).success(function(data) {
                $scope.temperaturas.splice(index,1);
            });
        }
    };
    
    $scope.addTemperatura = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdTemperatura: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: null,
                Fecha2: $scope.produccion.Fecha,
                Temperatura: 0,
                Temperatura2: 0,
                IdEmpleado: $scope.produccion.IdEmpleado,
                Moldes: 0,
            };
            $scope.temperaturas.push($scope.inserted);
        }
    };
    
    $scope.saveTemperatura = function(index){
        return $http.get('save-temperatura',{params:$scope.temperaturas[index]}).success(function(data) {
            if(data != false){
                $scope.temperaturas[index] = data;
            }
        });
    };
    
    
    /********************************************************************
     *                     CONTROL DE SERIES
    ********************************************************************/

    $scope.loadProductosSeries = function(){
        return $http.get('productos-series')
        .success(function(data) {
            $scope.ProductosSeries = [];
            $scope.ProductosSeries = data;
        });
    };

    $scope.loadProductos = function(){
        return $http.get('productos')
        .success(function(data){
            $scope.productos = data;
        });
    };

    $scope.addSerie = function() {
        $scope.inserted = {
            IdConfiguracionSerie: null,
            IdProducto: $scope.ProductosSeries.IdProducto,
            Identificacion:'',
        };
        $scope.ProductosSeries.push($scope.inserted); 
    };

    $scope.saveSerie = function(index){
        if($scope.ProductosSeries[index].SerieInicio != ''){
            return $http.get('save-serie',{params:$scope.ProductosSeries[index]})
            .success(function(data) {
                $scope.errores = [];
                $scope.errores = data;
                if($scope.errores.Error == 1){
                    alert("El No de Parte "+$scope.errores.IdProducto+" o la Serie "+$scope.errores.Serie+" ya estan configuradas ");
                }
                $scope.loadProductosSeries();
            });
        }   
    };

    $scope.saveProduccion = function (){
        if ($scope.IdSubProceso == 10) {
            Kellblocks = $scope.produccion.lances.Kellblocks;
            Lingotes = $scope.produccion.lances.Lingotes;
            Probetas = $scope.produccion.lances.Probetas;
        }
        return $http.get('save-produccion',{params:{
            Fecha: $scope.Fecha,
            //IdMaquina:$scope.maquinas[$scope.indexMaquina].IdMaquina,
            //IdCentroTrabajo:$scope.maquinas[$scope.indexMaquina].IdCentroTrabajo,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdSubProceso:$scope.IdSubProceso,
            Observaciones:$scope.produccion.Observaciones,
            IdAleacion:$scope.IdAleacion,
            IdTurno:$scope.IdTurno,
            Kellblocks:Kellblocks,
            Lingotes:Lingotes,
            Probetas:Probetas,
        }})
        .success(function(data) {
            $scope.produccion = data[0];
            $scope.erroresP = data[1];
            if ($scope.erroresP == 1) {
                $scope.IdProduccion2 = $scope.produccion.IdProduccion;
                alert("Error ese registro ya fue capturado.");
            }
            $scope.FechaProduccion = $scope.produccion.Fecha;
            console.log($scope.erroresP);
            $scope.index = undefined;
            $scope.countProduccionesAceros($scope.IdSubProceso);
        });
    };


    /********************************************************************
     *                     DETALLE DE PRODUCCION VACIADO
    ********************************************************************/

    $scope.loadDetalleVaciado = function(){

        if ($scope.FechaProduccion == null ) {
            $scope.FechaProduccion = new Date();
        };

        return $http.get('detalle-vaciado',{params:{
            Dia: $scope.FechaProduccion,
            IdArea: $scope.produccion.IdArea,
            IdSubProceso: $scope.IdSubProceso,
            IdProduccion: $scope.produccion.IdProduccion
        }}).success(function(data) {
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };

    $scope.saveDetalleVaciado = function(index,Vaciar, operacion){
        $scope.selectedSeries = [];
        count = 0;
        $('input[name="Series[]"]:checked').each(function() {
            $scope.selectedSeries.push($(this).val());
            $scope.DatosSeries =  $scope.selectedSeries+",";
            count++;
        });

        $scope.detalles[index].Fecha = $scope.produccion.Fecha;
        $scope.detalles[index].IdProduccion = $scope.produccion.IdProduccion;
        $scope.detalles[index].Series = $scope.DatosSeries;
        $scope.detalles[index].Vaciar = Vaciar;
        $scope.detalles[index].op = operacion;
        $scope.detalles[index].Count = count;

        return $http.get('save-vaciado',{params:$scope.detalles[index]}).success(function(data) {
            $scope.detalles[index] = data;
            $scope.loadDetalleVaciado();
        });
        
    };
    
    /********************************************************************
     *                     DETALLE DE PRODUCCION MOLDEO
    ********************************************************************/


    $scope.loadDetalleAcero = function(){

        if ($scope.FechaProduccion == null ) {
            $scope.FechaProduccion = new Date();
        };

        return $http.get('detalle',{params:{
               // Dia: $scope.produccion.Fecha,
                Dia: $scope.FechaProduccion,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                IdProduccion: $scope.produccion.IdProduccion,
                IdAreaAct: $scope.IdAreaAct,
                IdEmpleado: $scope.produccion.IdEmpleado,
                IdProduccionEstatus: $scope.produccion.IdProduccionEstatus,
                IdMaquina:$scope.produccion.IdMaquina,
                IdCentroTrabajo:$scope.produccion.IdCentroTrabajo,
        }})
        .success(function(data){
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };

    $scope.setSelectPedido = function(item) {
        item.checked = !item.checked;
        //$scope.selectAll = $scope.selectAll ? !$scope.selectAll : $scope.selectAll;
        alert(item);
    };

    $scope.saveDetalleAcero = function(index,idproducto,SerieInicio,IdConfSerie,IdParteMolde,estatus,FechaMoldeo2,Reposicion,SubProceso,SerieR ,Comentarios, linea){
        $scope.selectedPartes = [];
        IdParteMoldeCapK=[];
        if ($scope.produccion.IdSubProceso != 9) {
            if ($scope.detalles[index].FechaMoldeo == 1 && !FechaMoldeo2) {
                return alert("Debes de ingresar la fehca del moldeo");
            };
        };
        $('input[name="Partes[]"]:checked').each(function() {
            $scope.selectedPartes.push($(this).val());
            $scope.DatosPartes =  $scope.selectedPartes+",";
        });

        if (Reposicion == 'SI') { estatus = 2 };
        if (SerieR == null) { SerieR = ''; };
        $scope.detalles[index].IdEmpleado = $scope.produccion.IdEmpleado,
        $scope.detalles[index].IdMaquina = $scope.produccion.IdMaquina,
        $scope.detalles[index].IdCentroTrabajo = $scope.produccion.IdCentroTrabajo,
        $scope.detalles[index].IdProduccionEstatus = $scope.produccion.IdProduccionEstatus,
        $scope.detalles[index].FechaMoldeo2 = FechaMoldeo2;
        $scope.detalles[index].Fecha = $scope.produccion.Fecha;
        $scope.detalles[index].IdProduccion = $scope.produccion.IdProduccion;
        $scope.detalles[index].IdProducto = idproducto;
        $scope.detalles[index].IdProductos = idproducto;
        $scope.detalles[index].SerieInicio = SerieInicio;
        $scope.detalles[index].IdParteMoldeCap = $scope.ModelParte;
        $scope.detalles[index].IdParteMoldeCapK = $scope.DatosPartes;
        $scope.detalles[index].IdConfiguracionSerie = IdConfSerie;
        $scope.detalles[index].IdSubProceso = $scope.produccion.IdSubProceso;
        $scope.detalles[index].IdCicloTipo = estatus;
        $scope.detalles[index].SerieR = SerieR;
        $scope.detalles[index].SubProceso = SubProceso;
        $scope.detalles[index].Comentarios = Comentarios;
        $scope.detalles[index].Linea = linea;
        if ($scope.detalles[index].FechaMoldeo == null) {
            $scope.detalles[index].FechaMoldeo = 0;
        };
        if(($scope.detalles[index].Incio != '00:00' && $scope.detalles[index].Fin != '00:00') || $scope.IdSubProceso == 10){
            return $http.get('save-detalle-acero',{params:$scope.detalles[index]}).success(function(data) {
                $scope.detalles[index] = data;
                $scope.loadProgramacion();
                $scope.loadDetalleAcero();
                $scope.serieproducto = "";
                $scope.loadPartesMolde();
                window.name = 'NG_ENABLE_DEBUG_INFO!' + window.name;
              
            });
        }
    };

    $scope.ModelMoldeo = function(Producto,IdProducto,index,model,cicloMolde,operacion){  
        switch (model){
            case 1:{$scope.showModal = !$scope.showModal;}break;
            case 2:{$scope.showModalR = !$scope.showModalR;}break;
            case 3:{$scope.showModalCK = !$scope.showModalCK;}break;
            case 4:{$scope.showModalCRK = !$scope.showModalCRK;}break;
            case 5:{$scope.showModalK = !$scope.showModalK;}break;
            case 6:{$scope.showModalV = !$scope.showModalV;}break;
            case 7:{$scope.showModalRV = !$scope.showModalRV;}break;
            case 8:{$scope.showModalSeries = !$scope.showModalSeries;}break;
        }
        $scope.producto = Producto;
        $scope.idproducto = IdProducto;
        $scope.cicloMolde = cicloMolde;
        $scope.index = index;
        $scope.operacion = operacion;
    };

    $scope.CerradosOk = function (Producto,IdProducto,index,model) {
        if ($scope.detalles[index].LlevaSerie == "Si"){
            $scope.MostrarSeries(IdProducto);
            $scope.ModelMoldeo(Producto,IdProducto,index,model);
        }else{
                $scope.saveDetalleAcero(index, IdProducto);
        }
    }

    $scope.MoldeVaciado = function (Producto,IdProducto,index,model) {
        if ($scope.detalles[index].LlevaSerie == "Si"){
            $scope.MostrarSeries(IdProducto);
            $scope.ModelMoldeo(Producto,IdProducto,index,model);
        }else{
            return $http.get('save-detalle-acero',{params:{id:$scope.detalles[index].IdProgramacionDia}})
            .success(function (data) {
                $scope.loadDetalleAcero();
            });
        }
    }

    $scope.getSerieCR = function (IdProducto) {
        // $scope.ModelParte = IdParte;
        return $http.get('get-serie',{params:{
            IdProducto:IdProducto,
            }})
            .success(function(data){
                if (data != 0) {
                    $scope.serieproducto = data;
                }
            });
    }

    $scope.getSerie = function(IdParte,IdProducto,estatus,IdSubProceso){
        $scope.ModelParte = IdParte;
        return $http.get('get-serie',{params:{
            IdParteMolde:IdParte,
            IdProducto:IdProducto
            }})
            .success(function(data){
                if (data != 0) {
                    $scope.serieproducto = data;
                    $scope.MostrarSeries(IdProducto,IdSubProceso);
                    $('#showseries').removeAttr("disabled", 'false');
                    $('#showseriesR').removeAttr("disabled", 'false');
                    $('#btn-rechazoV').attr("disabled", 'true');
                }
                if(data == 0){
                    $('#showseries').attr("disabled", 'true');
                    $('#showseriesR').attr("disabled", 'true');
                    //$('#lb-serie').attr("disabled",'true');
                    $scope.activaBtnCerrado(2);
                }
            });
    };


    $scope.activaBtnCerrado = function(op){
        switch (op){
            case 1: $('#btn-ciclo').removeAttr("disabled", 'false'); break;
            case 2: $('#btn-rechazoV').removeAttr("disabled", 'false'); break;
            case 3: $('#btn-cerrado').removeAttr("disabled", 'false'); break;
            case 4: $('#btn-rechazoK').removeAttr("disabled", 'false'); break;
            case 5: $('#btn-cicloK').removeAttr("disabled", 'false'); break;
        }                        
    };


    $scope.MostrarSeries = function(IdProducto,id){   
        return $http.get('mostrar-series',{params:{
                IdProducto: IdProducto,
                Estatus:'B',
                IdSubProceso:id,
            }}).success(function(data) {
            $scope.listadoseries = data;
        });
    };


    /********************************************************************
     *                        PROGRAMACION
     *******************************************************************/
    $scope.loadProgramacion = function(){
        
        return $http.get('programacion',{params:{
                Dia: $scope.mostrar ? $scope.produccion.Fecha : $scope.Fecha,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
            }}).success(function(data) {
            $scope.programaciones = [];
            $scope.programaciones = data;
            //console.log($scope.produccion.Fecha);
            /*if(timeout == true){
                console.log('Automatico');
                $timeout(function() {$scope.loadProgramacion(true);}, 50000);
            }*/
        });

    };
    
       
    $scope.actualizarProgramacion = function(){
        return $http.get('save-programacion',{
            params:$scope.programaciones[$scope.indexProgramacion]
        }).success(function(data) {
            $scope.loadProgramacion();
        });
    }
    
    /*$scope.selectProgramacion = function(index){
        if($scope.indexProgramacion != null){
            $scope.indexProgramacion = null;
        }
        $scope.indexProgramacion = index;
    }*/
    

    $scope.buscar2 = function(){
        $scope.showModal2 = !$scope.showModal2;
    };

      /********************************************************************
     *                        MATTO HORNOS
     *******************************************************************/
    
    $scope.getData = function() {
        $http.get('mant-hornos').success(function(data){
            $scope.datos = [];
            $scope.datos = data;
        });
   };
    
    $scope.addMtto = function(mtto){
        console.log(mtto);  
        $http.get('save-hornos',{params:mtto}).success(function(data){
            $scope.getData();
            $scope.mtto = [];
        });
    };
});


app.controller('PruebasDestructivas', function ($scope, $filter, $modal, $http, $log, $window){

    $scope.Fecha= new Date();
    $scope.turnos = [];
    $scope.producciones = [];
    $scope.aleaciones = [];
    $scope.datoscharpy = [];
    $scope.probetas = [];
    $scope.datosdureza = [];
    $scope.datostension = [];

    $scope.mostrar = true;
   


    $scope.countProduccionesAceros = function(IdSubProceso,IdArea,IdMaquina,IdCentroTrabajo){
        return $http.get('count-produccion-pruebas',{params:{  
            IdSubProceso:IdSubProceso, 
            IdArea:IdArea,
            IdCentroTrabajo:IdCentroTrabajo,
            IdMaquina:IdMaquina
        }}).success(function(data){
            $scope.producciones = [];
            $scope.producciones = data;
            if ($scope.producciones == '') {
                $scope.producciones.IdProduccion = '';
            };
           
            if($scope.index == undefined){
                $scope.index = $scope.producciones.length - 1;
                $scope.loadProduccion();
                $scope.loadAleaciones();
            }
        });
    };     

    $scope.saveProduccion = function (){
        return $http.get('save-produccion',{params:{
            Fecha: $scope.Fecha,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdSubProceso:$scope.IdSubProceso,
            IdAleacion:$scope.IdAleacion,
            IdTurno:$scope.IdTurno,
        }})
        .success(function(data) {
            $scope.produccion = data[0];
            $scope.erroresP = data[1];
            if ($scope.erroresP == 1) {
                $scope.IdProduccion2 = $scope.produccion.IdProduccion;
                alert("Error ese registro ya fue capturado.");
            }
            //$scope.FechaProduccion = $scope.produccion.Fecha;
            //console.log($scope.erroresP);
            $scope.index = undefined;
            $scope.countProduccionesAceros($scope.IdSubProceso,$scope.IdArea,$scope.IdMaquina,$scope.IdCentroTrabajo);
            $scope.loadDetalleVaciado();
        });
    };

    $scope.loadProduccion = function(){
        return $http.get('produccion',{params:{
            IdArea: $scope.IdArea,
            Fecha: $scope.Fecha,
            IdProduccion: $scope.producciones[$scope.index].IdProduccion,
            IdSubProceso: $scope.IdSubProceso
        }}).success(function(data){
            $scope.mostrar = true;
            $scope.IdProduccion = data.IdProduccion;
            $scope.produccion = data;
            if (true) {};
            $scope.loadData();
        }).error(function(){
            
        });
    };

    $scope.loadProbetas = function(prueba){
        return $http.get('probetas',{params:{
            Tipo:prueba
        }}).success(function(data){
            $scope.probetas = data;
        });
    };

    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.index -= 1;
        }
        $scope.show();
        console.log($scope.index);
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.producciones.length-1  ){
            $scope.index += 1;
        }
        $scope.show();
    };
    
    $scope.First = function(){
        $scope.index = 0;
        $scope.show();
    };
    
    $scope.Last = function(){
        console.log($scope.producciones);
        $scope.index = $scope.producciones.length - 1;
        $scope.show();
    };
    
    $scope.show = function(){
        $scope.loadProduccion();
        if($scope.produccion.IdProduccionEstatus != 1){
            $scope.mostrar = false;
        }else{
            $scope.mostrar = true;
        }
        $scope.indexDetalle = null;
        //$scope.loadData();
    }

    
    $scope.loadTurnos = function(){
        $http.get('turnos').success(function(data){
            $scope.turnos = [];
            $scope.turnos = data;
        });
    };


    $scope.loadAleaciones = function(){
        $http.get('aleaciones').success(function(data){
            $scope.aleaciones = [];
            $scope.aleaciones = data;
        });
    };
	
	
	
	

    /*******************************************************************
    ***************************Pruebas Charpy***************************
    ********************************************************************/

    $scope.loadCharpy = function(){
        return $http.get('data-charpy',{params:{
            IdProduccion: $scope.produccion.IdProduccion
        }}).success(function(data){
            $scope.datoscharpy = data;
        });
    };

    $scope.addPruebas = function(){
        //console.log($scope.probetas.IdPruebaDestructiva);
        $scope.inserted = {
            IdCharpy: null,
            //IdPruebaDestructiva: $scope.probetas.IdPruebaDestructiva,
            Espesor: null,
            Ancho: null,
            Largo:null,
            Profundo:null,
            Angulo:null,
            ResultadoLBFT:null,
            Temperatura:null,
            SpecimenStandard: 'ASTM-E23',
            Tipo: 'Charpy',
            IdProbeta: null, // $scope.IdProbeta,
            IdProduccion: $scope.produccion.IdProduccion
        };
        $scope.datoscharpy.push($scope.inserted);
    };

    $scope.SavePruebas = function(index){
        //console.log($scope.probetas.IdPruebaDestructiva);
        return $http.get('save-pruebas', {params:{
           Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha, 
                IdEmpleado: $scope.IdEmpleado,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdMaquina:$scope.IdMaquina,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
                IdProduccion: $scope.produccion.IdProduccion,
                //IdAleacion:$scope.produccion.lances.IdAleacion,
            },
            PruebasDestructivas:$scope.datoscharpy[index]  
        }}).success(function(data){
            //console.log(data);
                $scope.datoscharpy[index] = data;
            
            $scope.loadData();
        })
    };

    $scope.SavePruebasTension = function(index){
        //console.log($scope.probetas.IdPruebaDestructiva);
        return $http.get('save-pruebas', {params:{
           Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha, 
                IdEmpleado: $scope.IdEmpleado,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdMaquina:$scope.IdMaquina,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
                IdProduccion: $scope.produccion.IdProduccion,
                //IdAleacion:$scope.produccion.lances.IdAleacion,
            },
            PruebasDestructivas:$scope.datostension[index]  
        }}).success(function(data){
            //console.log(data);
            $scope.datostension[index] = data;
            $scope.loadData();
        })
    };

    $scope.SavePruebasDureza = function(index){
        //console.log($scope.probetas.IdPruebaDestructiva);
        return $http.get('save-pruebas', {params:{
           Produccion:{
                IdArea: $scope.IdArea,
                Fecha: $scope.Fecha, 
                IdEmpleado: $scope.IdEmpleado,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdMaquina:$scope.IdMaquina,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
                IdProduccion: $scope.produccion.IdProduccion,
                //IdAleacion:$scope.produccion.lances.IdAleacion,
            },
            PruebasDestructivas:$scope.datosdureza[index]  
        }}).success(function(data){
            //console.log(data);
            $scope.datosdureza[index] = data;
            $scope.loadData();
        })
    };


    /*******************************************************************
    ***************************Pruebas Mecanicas************************
    ********************************************************************/

    $scope.loadPruebasMecanicas = function(){
        return $http.get('data-pruebas-mecanicas',{params:{
            IdProduccion: $scope.produccion.IdProduccion
        }}).success(function(data){
            $scope.datostension = data;
        });
    };

    $scope.loadDureza = function(){
        return $http.get('data-dureza',{params:{
            IdProduccion: $scope.produccion.IdProduccion
        }}).success(function(data){
            $scope.datosdureza = data;
        });
    };
 
    $scope.addTension = function(){
        //console.log($scope.probetas.IdPruebaDestructiva);
        $scope.inserted = {
            IdTension: null,
            PsiTensileStrength: null,
            PsiYieldStrength: null,
            Elongacin:null,
            ReduccionArea:null,
            IdProbeta: null,
            Tipo: 'Tension',
            IdDureza: null,
            DiametroHuella: null,
            IdProbeta: null,
            IdProduccion: $scope.produccion.IdProduccion
        };
        $scope.datostension.push($scope.inserted);
    };

    $scope.addDureza = function(){
        //console.log($scope.probetas.IdPruebaDestructiva);
        $scope.inserted = {
            IdDureza: null,
            DiametroHuella: null,
            IdProbeta: null,
            Tipo: 'Dureza',
            IdProduccion: $scope.produccion.IdProduccion
        };
        $scope.datosdureza.push($scope.inserted);
    };

    $scope.loadData = function(){
        if ($scope.IdMaquina == 2242) {
            $scope.loadCharpy();
        };
        if ($scope.IdMaquina == 2243) {
            $scope.loadPruebasMecanicas();
            $scope.loadDureza();
        };

    };



});