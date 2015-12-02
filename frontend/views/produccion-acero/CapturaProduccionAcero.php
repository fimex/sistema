
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;
//$minFecha = date('H')< 6 ? date('Y-m-d',strtotime('-1 day',strtotime(date()))) : date('Y-m-d');
?>
<style>
    .table{
        display: fixed;
    }
    
    .table input{
        width: 100%;
    }
    
    .table .captura{
        width: 50px;
    }
    
    .div-table-content {
      height:300px;
      overflow-y:auto;
    }
    .div-table-content2 {
      height:200px;
      overflow-y:auto;
    }
    .scrollable {
        width: 100%;
        margin: auto;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    thead {
        background: white;
    }
    table {
        width: 100%;
        border-spacing:0;
        margin:0;
    }
    table th , table td  {
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
    }
    
    #detalle, #rechazo, #TMuerto, #Temperaturas{
        height:380px;
        overflow: auto;
    }
    #completo{
        width:97%;
        height:91%;
        position:absolute;
        display:block;
        background: #999999;
        z-index:99999;
        opacity:1;
        margin:0%;
        -webkit-transition: all 1s ease-in-out;
        -moz-transition: all 1s ease-in-out;
        -o-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
    }
    .centrado{
        width:50%;
        max-width: 400px;
        height:auto;
        position:relative;
        display:block;
        margin:auto;
        border:red solid 1px;
        top:30%;
        background:#ffffff;
        border:white solid 1px;
        padding:30px;
    }
     /*
     * Estilos para la captura de series de piezas OK
     * Daniel Huerta 
     * 14/10/15
     */
        .panel-heading{background:#416EB3;color:#ffffff;}
        .contenido{
            width:100%;
            /*height:auto;
            max-*/height: 280px;
            position:relative;
            display:block;
            margin:auto;
            text-align: center;
            overflow: auto;
            border:#cccccc solid 2px;
        }
        /*#contenido .form-group{display:none;}*/
        .left{text-align: left}
        .box-header{
            width:48%;
            height:auto;
            position:relative;
            display:inline-block;
            color:#000000;
            text-align: center;
            margin:5px;
            padding:5px 0;
        }
        .repetido{
            width:48%;
            height:200px;
            position:relative;
            display:inline-block;
            text-align:center;
            margin:0 5px;
            overflow:hidden;
            border:#999999 solid 1px;
            border-radius:10px;
        }
        .noScroll{
            width:100%;
            height:200px;
            position:absolute;
            display:block;
            margin:auto;
            padding-right:0;
            overflow:auto;
        }
        .con-series{
            width:95%;
            height:auto;
            position:relative;
            display:block;
            margin:3px auto;
            border-bottom:#eeeeee solid 1px;           
            cursor:pointer;
            text-align: left;
        }
        .con-series:hover{
            background:#999999;
            color:#ffffff;
        }
        .repetido.border{border:#999999 solid 1px;margin-bottom:5px;}
        #capturaAceptadas, #capturaRechazadas{
            display:block;
        }
    /*
     * Estilos para la captura de series de piezas OK
     * Daniel Huerta 
     * 14/10/15
     */


    /*
     * Estilos para la captura de evidencias, (series, motivos, comentarios e imagenes) de piezas rechazadas (reparacion y scrap)
     * Daniel Huerta 
     * 14/10/15
     */
        .repetir{
            width:98%;
            position:relative;
            display:block;
            margin:10px auto;
            text-align: center;
            border:#999999 solid 1px;
        }
        .titulo{
            width: 100%;
            height:auto;
            background: #999999;
            color:#ffffff;
            text-align: center;
        }
        .mid{
            width:50%;
            height:auto;
            position:relative;
            display:inline-block;
            vertical-align: top;
            margin:auto;           
            /*border:#eeeeee dotted 1px;*/
        }
        .imagen{
            width:100%;
            height:100px;
        }
        .imagen img{
            height:100%;
        }
        .contiene{
            width:100%;
            height:auto;
            /*border:#999999 dotted 1px;*/
        }
        .contiene select{
            width: 100%;
            height:30px;
            /*border:none;*/
        }
        .mid textarea{
            width:100%;
            height: 60px;
            /*border:none;*/
            resize:none;
        }
        .contiene .input{
            width:100%;
            height:40px;
            overflow: hidden;
            position: relative;
            border:#999999 solid 1px;
            margin:-5px 0 0 0;
            cursor: pointer;
        }
        .contiene .input .input-file {
            margin: 0;
            padding: 0;
            outline: 0;
            font-size: 10000px;
            border: 10000px solid transparent;
            opacity: 0;
            filter: alpha(opacity=0);
            position: absolute;
            right: -1000px;
            top: -1000px;
            cursor: pointer;
        }
    /*
     * Estilos para la captura de evidencias, (series, motivos, comentarios e imagenes) de piezas rechazadas (reparacion y scrap)
     * Daniel Huerta 
     * 14/10/15
     */
</style>
<!--Codigo para subir archivos por medio de ajax-->

<script>
    function sendImagen(id){
        varIdNew = id.split("_");
        var valor = document.getElementById(id).value;
        idNew = "formuploadajax_"+varIdNew[1];
        var formData = new FormData(document.getElementById(idNew));
        formData.append("name", valor);
        $.ajax({
            url: "recibe",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>
<!--Codigo para subir archivos por medio de ajax-->
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="
    IdTurno = 1;
    IdSubProceso = <?=$IdSubProceso?>;
    IdAreaAct = <?= is_null($IdAreaAct) ? 'null' : $IdAreaAct ?>;
    <?php if($IdSubProceso == 14):?>
        IdMaquina = 1;
    <?php else:?>
        IdMaquina = <?= $IdAreaAct == 1 ? 1751 : ($IdAreaAct == 2 ? 1610 : 1755) ?>;
    <?php endif?>
    <?php if( ($IdAreaAct == 2 && $IdArea == 2) || ($IdSubProceso == 7 && $IdArea == 2) ):?>
		IdCentroTrabajo = 38;
	<?php endif?>
	<?php if( ($IdAreaAct == 1 && $IdArea == 2) || ($IdSubProceso == 6 && $IdArea == 2) ):?>
		IdCentroTrabajo = 29;
	<?php endif?>
	
    
    IdArea = <?= $IdArea?>;
    IdEmpleado = <?=$IdEmpleado?>;  
    loadProgramaciones(true);
    <?php if($IdSubProceso == 14):?>
        saveProduccion();
        loadEmpleados('4-5');
        loadDefectos();        
    <?php else:?>
        loadComponentes();
        loadPartesMolde();
        loadTiempos(); 
        loadFallas();
    <?php endif?> 
    loadTurnos();
    <?php if($IdAreaAct == 2): ?>
        loadEmpleados('1-3');
    <?php endif; ?>
    <?php if($IdAreaAct == 1): ?>
        loadEmpleados('1-2');
    <?php endif; ?>
    <?php if($IdAreaAct == 3): ?>
        loadEmpleados('1-4');
    <?php endif; ?>
    <?php if($IdSubProceso == 8): ?>
        IdMaquina = 1632;
    <?php endif; ?>   
">
    {{IdCentroTrabajoDestino}}
    <!---Espacio para div que cubre toda la pantalla y pide informacion para hacer la busqueda-->
    <div id="completo" ng-model="completo" >
        <div class="centrado">
            <div class="input-group">
                <span class="input-group-addon">Fecha de captura:</span>
                <input class="form-control input-sm" type="date" ng-change="loadProgramaciones(false); loadComponentes();" ng-model="Fecha" format-date />
            </div><br />
            <input type="hidden" ng-model="FechaMoldeo2">
            <!--<div class="input-group">
                <span class="input-group-addon">Fecha de Moldeo:</span>
                <input class="form-control input-sm" type="date" ng-model="FechaMoldeo2" ng-change="capturaFecha();"/>
            </div><br />-->
            <div class="input-group">
                <span class="input-group-addon">Turno:</span>
                <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones(false); loadComponentes();" class="form-control" ng-model="IdTurno" required>
                    <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                </select>                    
            </div><br />
            <div class="input-group" ng-model="msgError" id="msgError"></div>
            <div class="input-group" >
                <button class="btn btn-info" ng-click="loadDivFlotante()">Guardar</button>
            </div>
        </div>
    </div>

    <h3><?=$title?></h3>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha de captura:</span>
                            <input class="form-control input-sm" type="date" ng-change="loadProgramaciones(false); loadComponentes();" ng-model="Fecha" format-date />
                        </div>
                        <?php if($IdSubProceso != 9):?>
                        <!--<div class="input-group">
                            <span class="input-group-addon">Fecha de Moldeo:</span>-->
                            
                            <!--<input class="form-control input-sm" type="date" ng-model="FechaMoldeo2"/>-->
                        <!--</div>-->
                        <?php endif ?>
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones(false)" class="form-control" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    
                        </div>
                        <?php if($IdSubProceso != 9):?>
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-show="mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                        </div>
                        <?php endif ?>
                    </div>
                    <?php if($IdSubProceso != 14){?>
                    <div class="col-md-2" style="margin-left:40px">
                        <div class="input-group" >
                            <button ng-click="buscar2();" class="btn btn-info">Control de Tiempos Muertos</button>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <?php if($IdSubProceso == 14){?>
        <div class="row">
            <div class="col-md-12">
                <div class="row" style="width:100%;">
                    <div class="col-md-6" style="width:100%">
                        <?= $this->render('FormProduccionDetalleAceroCalidad',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row" style="width:100%;">
                    <div class="col-md-6" style="width:100%">
                        <?= $this->render('FormCalidadAceptadas',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row" style="width:100%;">
                    <div class="col-md-6" style="width:100%">
                        <?= $this->render('FormCalidadRechazadas',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row" style="width:100%;">
                    <div class="col-md-6" style="width:100%">
                        <?= $this->render('FormCalidadRechazadas',[
                            'IdSubProceso'=>$IdSubProceso,
                            'IdAreaAct' => $IdAreaAct,
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    else{?>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php if($IdSubProceso == 7):?> 
                    <?= $this->render('FormProduccionDetalleAceroMoldeoVarel',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                <?php elseif($IdSubProceso == 6):?>
                    <?= $this->render('FormProduccionDetalleAceroMoldeoKlooster',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                <?php elseif($IdSubProceso == 9):?>
                    <?= $this->render('FormProduccionDetalleAceroCerrado',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                <?php else:?>
                    <?= $this->render('FormProduccionDetalleAcero',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php }?>
    <modal title="Control de Tiempos Muertos" visible="showModal2" width="80%">
        <?= $this->render('FormTiemposMuerto');?>
    </modal>
</div>