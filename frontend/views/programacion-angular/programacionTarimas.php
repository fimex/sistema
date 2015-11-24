<style>
    *{
        -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
    }
    [ng-drag], [ng-drag-clone]{
        -moz-user-select: -moz-none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .drag-object, [ng-drag-clone], [ng-drop] [ng-drag]{
        width: 100px;
        height: 100px;
        background: rgba(255,0,0, 0.5);
        color:white;
        text-align: center;
        display: inline-block;
        margin:0 10px;
        cursor: move;
        position: relative;
        overflow: hidden;
    }
    .drag-object [ng-drag]{
        width: 100px;
        height: 100px;
        position: absolute;
        top:0; left:0;
        padding: 0;
        margin: 0;
    }
    [ng-drag-clone]{
        margin: 0;
    }
    [ng-drag].drag-over{
        border:solid 1px red;
    }
    [ng-drag].dragging{
        //opacity: 0.5;
        z-index: -1;
    }
    [ng-drop]{
        text-align: center;
        display: block;
        position: relative;
    }
    [ng-drop].drag-enter{
        border:solid 3px lightcyan;
        background-color: lightgreen;
    }
    [ng-drop] span.title{
        display: block;
        position: absolute;
        top:50%;
        left:50%;
        width: 200px;
        height: 20px;
        margin-left: -100px;
        margin-top: -10px;
    }
    [ng-drop] div{
        position: relative;
        //z-index: 2;
    }
    .dia{
        
    }
    .noche{
        background-color: lightgray;
    }
    .finalizado {
        background-color: gray;
    }
    .btn-droppable { width: 180px; height: 30px; padding-left: 4px; }
    .btn-draggable { width: 100%; }
    .scrollable {
        margin: auto;
        height: 742px;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
  </style>
<div ng-controller="Programacion" ng-init="reporte=<?=$reporte?>;loadAleaciones();loadDias(true);">
    <b style="font-size: 14pt;">Programacion Tarimas Kloster</b>  <input type="week" ng-model="semanaActual" ng-change="loadDias(true);" />
    <button class="btn btn-success" ng-click="loadProgramacionDiaria(true);">Actualizar</button>
    <button class="btn btn-success" ng-click="reporte = !reporte">Ver como <span ng-show="!reporte">Reporte</span><span ng-show="reporte">Captura</span></button>
    
    <div class="row" style="width: 100%">
        <div class="col-md-5" style="z-index: 5;">
            <table class="table table-responsive table-bordered table-hover">
            <thead>
                <tr class="active">
                    <th>Pr</th>
                    <th>
                        Producto<br/>
                        <input class="form-control" ng-model="filtro.Producto" /></th>
                    <th>Aleacion<br/>
                        <input class="form-control" ng-model="filtro.Aleacion" /></th>
                    <th>Ciclos</th>
                    <th>Prog. Sem</th>
                    <th>Prog</th>
                    <th>Faltan</th>
                    <th>Araña</th>
                    <th>Ton</th>
                </tr>
            </thead>
                <tbody>
                    <tr 
                        ng-repeat="programacion in programaciones | filter:filtro"
                        ng-class="{'finalizado':programacion.TotalProgramado >= programacion.Programadas}"
                    >
                        <th class="col-md-1">{{programacion.Prioridad}}</th>
                        <th class="col-md-2">
                            <div class="btn btn-draggable" style="opacity: .8; background-color: {{programacion.Color}}" ng-drag="!reporte && programacion.TotalProgramado < programacion.Programadas" ng-drag-data="programacion" ng-drag-success="onDragComplete($data,$event)">
                                <span style="font-size:10pt; color: #000000; font-weight: bold">{{programacion.Producto}}</span>
                            </div>
                        </th>
                        <th class="col-md-1">{{programacion.Aleacion}}</th>
                        <th class="col-md-1">{{programacion.CiclosMoldeA}}</th>
                        <th class="col-md-1">{{programacion.Programadas}}</th>
                        <th class="col-md-1">{{programacion.TotalProgramado}}</th>
                        <th class="col-md-1">{{programacion.Programadas - programacion.TotalProgramado}}</th>
                        <th class="col-md-1">{{programacion.PesoAraniaA | currency:"":2}}</th>
                        <th class="col-md-1">{{(programacion.PesoAraniaA / 1000) * programacion.Programadas | currency:"":2 }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tarimas" class="col-md-7 tarimas scrollable" style="overflow: auto;height: 850px;">
            <table class="table table-bordered table-responsive" ng-table fixed-table-headers="tarimas">
                <thead style="background-color: white">
                    <tr>
                        <th rowspan="2">Loop</th>
                        <th style="text-align: center" colspan="9">Tarimas</th>
                        <th rowspan="2">Loop</th>
                        <th style="text-align: center" colspan="{{aleaciones.length}}">Resumen x Aleacion</th>
                    </tr>
                    <tr>
                        <?php for($x=1;$x<=9;$x++):?>
                        <th style="text-align: center">T<?=$x?></th>
                        <?php endfor;?>
                        <th ng-repeat="aleacion in aleaciones"><span style="display:inline-block ;text-align: center; min-width: 60px;">{{aleacion}}</span></th>
                    </tr>
                </thead>
                <tbody ng-repeat="loop in loops" ng-init="loop.index = $index">
                    <tr class="dia">
                        <th class="text-center noche" colspan="10">{{loop.dia}}</th>
                        <th class="text-center noche" colspan="{{1 + aleaciones.length}}">{{loop.dia}}</th>
                    </tr>
                    <tr ng-class="{'dia':$index <= 29, 'noche':$index > 29}" ng-repeat="Turno in loop.Loops" ng-show="MostrarLoop(Turno);">
                        <th style="text-align: center" ng-init="Turno.index = $index">{{$index+1}}</th>
                        <?php for($x=1;$x<=9;$x++):?>
                        <td>
                            <div class="btn btn-droppable" style="background-color: {{Turno.Tarima<?=$x?>.Color}}" ng-drop="!reporte" ng-drag="!reporte" ng-drop-success="rellenar(loop.index,Turno.index,<?=$x?>,$data)">
                                <span class="glyphicon glyphicon-plus text-success" aria-hidden="true" ng-click="rellenar(loop.index,Turno.index,<?=$x?>,Turno.Tarima<?=$x?>,true);" ng-if="Turno.Tarima<?=$x?>.visible"></span>
                                <span style="font-size:10pt; color: #000000; font-weight: bold">{{Turno.Tarima<?=$x?>.Producto}}</span>
                                <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" ng-click="Delete(loop.index,Turno.index,<?=$x?>,Turno.Tarima<?=$x?>);" ng-if="Turno.Tarima<?=$x?>.visible"></span>
                            </div>
                        </td>
                        <?php endfor;?>
                        <th style="text-align: center">{{$index+1}}</th>
                        <th ng-repeat="aleacion in aleaciones" ng-class="{'success':Turno[aleacion] > {{tolerancia(Turno[aleacion],-100)}} && Turno[aleacion] < {{tolerancia(Turno[aleacion],50)}} }"><span style="display:inline-block ;text-align: center; max-width: 60px; min-width: 60px;">{{Turno[aleacion] | currency:"":2 || 0}}</span></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>