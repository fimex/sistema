app.controller('Productos', function($scope, $filter, $modal, $http, $log, $timeout){
    $scope.loadProductos = function(){
        return $http.post('/fimex/productos/data-productos',{IdPresentacion:$scope.IdPresentacion}).success(function(data){
            $scope.productos = [];
            $scope.productos = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadAlmasTipo = function(){
        return $http.post('/fimex/productos/almas-tipo').success(function(data){
            $scope.AlmasTipo = [];
            $scope.AlmasTipo = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadAlmasMaterialCaja = function(){
        return $http.post('/fimex/productos/almas-material-caja').success(function(data){
            $scope.AlmasMaterialCaja = [];
            $scope.AlmasMaterialCaja = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadAlmasRecetas = function(){
        return $http.post('/fimex/productos/almas-recetas').success(function(data){
            $scope.AlmasRecetas = [];
            $scope.AlmasRecetas = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadCamisasTipo = function(){
        return $http.post('/fimex/productos/camisas-tipo').success(function(data){
            $scope.CamisasTipo = [];
            $scope.CamisasTipo = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadFiltrosTipo = function(){
        return $http.post('/fimex/productos/filtros-tipo').success(function(data){
            $scope.FiltrosTipo = [];
            $scope.FiltrosTipo = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadCajasTipo = function(){
        return $http.post('/fimex/productos/cajas-tipo').success(function(data){
            $scope.CajasTipo = [];
            $scope.CajasTipo = data;
        }).error(function(){
            
        });
    };

    $scope.loadPartesMolde = function(){
        console.log(2);
        return $http.get('/fimex/productos/partes-molde',{params:{
            IdAreaAct:$scope.producto.IdAreaAct,
            CiclosVarel:$scope.producto.CiclosVarel,
            CiclosMolde:$scope.producto.CiclosMolde
        }})
        .success(function(data){  
            $scope.partes = data;
        });
    };
    
    $scope.selectProducto = function(datos){
        $scope.producto = datos;
        $http.post('/fimex/productos/data-almas',{IdProducto:$scope.producto.IdProducto}).success(function(data){
            $scope.almas = [];
            $scope.almas = data;
        }).error(function(){
            
        });
        
        $http.post('/fimex/productos/data-camisas',{IdProducto:$scope.producto.IdProducto}).success(function(data){
            $scope.camisas = [];
            $scope.camisas = data;
        }).error(function(){
            
        });

        $http.post('/fimex/productos/data-filtros',{IdProducto:$scope.producto.IdProducto}).success(function(data){
            $scope.filtros = [];
            $scope.filtros = data;
        }).error(function(){
            
        });
        
        $http.post('/fimex/productos/data-cajas',{IdProducto:$scope.producto.IdProducto}).success(function(data){
            $scope.cajas = [];
            $scope.cajas = data;
        }).error(function(){
            
        });

        $http.post('/fimex/productos/data-serie-cavidad',{IdProducto:$scope.producto.IdProducto}).success(function(data){
            $scope.seriecavidad = [];
            $scope.seriecavidad = data;
        }).error(function(){
            
        });

        $scope.loadPartesMolde();
        
    };
    
    $scope.saveMoldeo = function(){
        return $http.post('/fimex/productos/save-producto',$scope.producto).success(function(data){
            $scope.productos.forEach(function(value, key){
                if(value.IdProducto == data.IdProducto){
                    $scope.productos[key] = data;
                }
            });
        }).error(function(){
            
        });
    };
    
    $scope.saveDatos = function(model,index){
        return $http.post('/fimex/productos/save-' + model,$scope[model][index]).success(function(data){
            if(data != 0 ){
                $scope[model][index] = data;
            }
        }).error(function(){
            
        });
    };
    
    $scope.addDato = function(model){
        var datos = {
            IdProducto: $scope.producto.IdProducto
        };
        $scope[model].push(datos);
    };

    $scope.seriecavidad = [];
    $scope.addCavidad = function(model){
       
        $scope.datos = {
            IdProducto: $scope.producto.IdProducto
        };
        $scope.seriecavidad.push($scope.datos);

        /*for (var i = 1; i < $scope.producto.PiezasMolde; i++) {
            $scope.seriecavidad.push(datos); 
            console.log(i+" d: "+$scope.producto.PiezasMolde);
        }*/

    };
    
    $scope.addCamisa = function(){
        var datos = {
            IdProducto: $scope.producto.IdProducto
        };
        
        $scope.camisas.push(datos);
    };
    
    $scope.arr = [];
    $scope.loadAlmasTipo();
    $scope.loadAlmasMaterialCaja();
    $scope.loadAlmasRecetas();
    $scope.loadCamisasTipo();
    $scope.loadFiltrosTipo();
    $scope.loadCajasTipo();
});