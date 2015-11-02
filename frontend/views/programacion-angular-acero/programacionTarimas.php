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
        opacity: 0.5;
    }
    [ng-drop]{
        text-align: center;
        display: block;
        position: relative;
    }
    [ng-drop].drag-enter{
        border:solid 5px red;
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
        z-index: 2;
    }
  </style>
<div ng-controller="Programacion" ng-init="reporte=<?=$reporte?>;loadAleaciones();loadDias();">
    <input type="color" ng-model="color" />{{color}}
    <b style="font-size: 14pt;">Programacion Tarimas</b>  <input type="week" ng-model="semanaActual" ng-change="loadDias();" />
    <button class="btn btn-success" ng-click="loadProgramacionDiaria();">Actualizar</button>
    Dia:<select ng-change="loadDias();" ng-model="diaActual"><option ng-repeat="dia in dias" value="{{$index+1}}">{{dia}}</option></select>

    <div class="row" style="width: 100%">
        <div class="col-md-4">
            <table class="table table-striped table-responsive table-bordered table-hover">
            <thead>
                <tr>
                    <th>Pr</th>
                    <th>Producto</th>
                    <th>Aleacion</th>
                    <th>Ciclos</th>
                    <th>Mold</th>
                    <th>Prog</th>
                    <th>Araña</th>
                    <th>Ton</th>
                </tr>
            </thead>
                <tbody>
                    <tr ng-repeat="programacion in programaciones">
                        <th class="col-md-1">{{programacion.Prioridad}}</th>
                        <th class="col-md-1"><div ng-drag="true" ng-drag-data="programacion" ng-drag-success="onDragComplete($data,$event)"><span class="btn btn-xs" style="background-color: {{programacion.Color}}">{{programacion.Producto}}</span></div></th>
                        <th class="col-md-1">{{programacion.Aleacion}}</th>
                        <th class="col-md-1">{{programacion.CiclosMolde}}</th>
                        <th class="col-md-1">{{programacion.Programadas}}</th>
                        <th class="col-md-1">{{programacion.TotalProgramado}}</th>
                        <th class="col-md-1">{{programacion.PesoAraniaA}}</th>
                        <th class="col-md-1">{{(programacion.PesoAraniaA / 1000) * programacion.Programadas | currency:"":2 }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-8 tarimas" style="overflow: auto;height: 850px;">
            <table class="table table-bordered table-responsive" ng-table>
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
                        <th style="text-align: center" ng-repeat="aleacion in aleaciones">{{aleacion}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="loop in loops">
                        <th style="text-align: center" ng-init="loop.index = $index">{{$index+1}}</th>
                        <?php for($x=1;$x<=9;$x++):?>
                        <td style="width: 250px;"><div ng-drop="true" ng-drop-success="rellenar({{$index}},<?=$x?>,$data,$event)">
                            <span class="btn btn-xs" style="background-color: {{loop.Tarima<?=$x?>.Color}}">{{loop.Tarima<?=$x?>.Producto}}</span>
                            <button ng-click="rellenar({{$index}},<?=$x?>,loop.Tarima<?=$x?>);" ng-if="loop.Tarima<?=$x?>.visible" class="btn btn-xs btn-success">+</button>
                            <button ng-click="Delete($index,<?=$x?>);" ng-if="loop.Tarima<?=$x?>.visible" class="btn btn-xs btn-danger">-</button>
                        </div></td>
                        <?php endfor;?>
                        <th style="text-align: center" ng-init="loop.index = $index">{{$index+1}}</th>
                        <th style="text-align: center" ng-repeat="aleacion in aleaciones">{{resumen(loop.index,aleacion)}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>