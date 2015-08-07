app.controller('ReporteSerie', function ($scope, $http) {
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

});

app.controller('ProduccionAceros', function ($scope, $filter, $http){
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

    $scope.countProduccionesAceros = function(IdSubProceso){
        return $http.get('count-produccion',{params:{IdSubProceso:IdSubProceso}}).success(function(data){
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
       // $scope.loadData();
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
        $scope.loadDetalleAcero();
    }

    $scope.loadEmpleados = function(depto){
        return $http.get('empleados',{params:{depto:depto}})
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

    $scope.loadMaquinas = function(){
        return $http.get('maquinas',{params:{IdSubProceso:$scope.IdSubProceso}})
        .success(function(data){
            $scope.maquinas = data;
        });
    };

    $scope.loadPartesMolde = function(){
        return $http.get('partes-molde')
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
                IdMaquina: $scope.produccion.IdMaquina,
        }})
        .success(function(data){
            $scope.detalles[index]=data;
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

        return $http.get('save-produccion',{params:{
            Fecha: $scope.Fecha,
            IdMaquina:$scope.maquinas[$scope.indexMaquina].IdMaquina,
            IdCentroTrabajo:$scope.maquinas[$scope.indexMaquina].IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdSubProceso:$scope.IdSubProceso,
            Observaciones:$scope.produccion.Observaciones,
            IdAleacion:$scope.IdAleacion,
        }})
        .success(function(data) {
            $scope.produccion = data[0];
            $scope.erroresP = data[1];
            if ($scope.erroresP == 1) {
                $scope.IdProduccion2 = $scope.produccion.IdProduccion;
            }
            $scope.FechaProduccion = $scope.produccion.Fecha;
            console.log($scope.produccion.Fecha);
            $scope.index = undefined;
            $scope.countProduccionesAceros($scope.IdSubProceso);
        });
    };

    /********************************************************************
     *                     DETALLE DE PRODUCCION MOLDEO
    ********************************************************************/


    $scope.loadDetalleAcero = function(){
        if ($scope.FechaProduccion == null ) {
            $scope.FechaProduccion = new Date();
            $scope.produccion.IdArea = '';
            $scope.produccion.IdSubProceso = '';
            $scope.produccion.IdProduccion = '';
            //$scope.IdAreaAct = '';
            //alert($scope.FechaProduccion);
        };

        return $http.get('detalle',{params:{
               // Dia: $scope.produccion.Fecha,
                Dia: $scope.FechaProduccion,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                IdProduccion: $scope.produccion.IdProduccion,
                IdAreaAct: $scope.IdAreaAct,
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

    $scope.saveDetalleAcero = function(index,idproducto,SerieInicio,IdConfSerie,IdParteMolde,estatus,FechaMoldeo2,Reposicion,SubProceso,SerieR ,Comentarios){
        if ($scope.detalles[index].FechaMoldeo == 1 && !FechaMoldeo2) {
            return alert("Debes de ingresar la fehca del moldeo");
        };

        if (Reposicion == 'SI') { estatus = 2 };
        if (SerieR == null) { SerieR = ''; };
        $scope.detalles[index].FechaMoldeo2 = FechaMoldeo2;
        $scope.detalles[index].Fecha = $scope.produccion.Fecha;
        $scope.detalles[index].IdProduccion = $scope.produccion.IdProduccion;
        $scope.detalles[index].IdProducto = idproducto;
        $scope.detalles[index].IdProductos = idproducto;
        $scope.detalles[index].SerieInicio = SerieInicio;
        $scope.detalles[index].IdParteMoldeCap = $scope.ModelParte;
        $scope.detalles[index].IdConfiguracionSerie = IdConfSerie;
        $scope.detalles[index].IdSubProceso = $scope.produccion.IdSubProceso;
        $scope.detalles[index].IdCicloTipo = estatus;
        $scope.detalles[index].SerieR = SerieR;
        $scope.detalles[index].SubProceso = SubProceso;
        $scope.detalles[index].Comentarios = Comentarios;
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

    $scope.ModelMoldeo = function(Producto,IdProducto,index,model){  
        switch (model){
            case 1:{$scope.showModal = !$scope.showModal;}break;
            case 2:{$scope.showModalR = !$scope.showModalR;}break;
            case 3:{$scope.showModalCK = !$scope.showModalCK;}break;
            //case 4:{$scope.showModalCR = !$scope.showModalCR;}break;
            //case 5:{$scope.showModalClR = !$scope.showModalClR;}break;
        }
        $scope.producto = Producto;
        $scope.idproducto = IdProducto;
        $scope.index = index;
    };

    $scope.CerradosOk = function (Producto,IdProducto,index,model) {
       // alert($scope.detalles[index].LlevaSerie);

        if ($scope.detalles[index].LlevaSerie == "Si"){
            $scope.MostrarSeries(IdProducto);
            $scope.ModelMoldeo(Producto,IdProducto,index,model);
        }else{
            return $http.get('cerrado-ok',{params:{id:$scope.detalles[index].IdProgramacionDia}})
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

    $scope.getSerie = function(IdParte,IdProducto,estatus){
        $scope.ModelParte = IdParte;
        return $http.get('get-serie',{params:{
            IdParteMolde:IdParte,
            IdProducto:IdProducto,
            }})
            .success(function(data){
                if (data != 0) {
                    $scope.serieproducto = data;
                    $scope.MostrarSeries(IdProducto);
                    $('#showseries').removeAttr("disabled", 'false');
                    $('#showseriesR').removeAttr("disabled", 'false');
                    $('#btn-rechazo').attr("disabled", 'true');
                }
                if(data == 0){
                    $('#showseries').attr("disabled", 'true');
                    $('#showseriesR').attr("disabled", 'true');
                    $scope.activaBtnCerrado(2);
                }
            });
    };


    $scope.activaBtnCerrado = function(op){
        switch (op){
            case 1: $('#btn-ciclo').removeAttr("disabled", 'false'); break;
            case 2: $('#btn-rechazo').removeAttr("disabled", 'false'); break;
            case 3: $('#btn-cerrado').removeAttr("disabled", 'false'); break;
        }                        
    };


    $scope.MostrarSeries = function(IdProducto){     
        return $http.get('mostrar-series',{params:{
                IdProducto: IdProducto,
                Estatus:'B',
                IdSubProceso:6,
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
                IdMaquina: $scope.produccion.IdMaquina,
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
    
      
});