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
        //border:solid 5px red;
        background-color: lightcyan
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
    tr.active {
        background-color: lightgray !important;
    }
  </style>
<div ng-controller="Programacion" ng-init="reporte=<?=$reporte?>;loadAleaciones();loadDias(true);">
    <input type="color" ng-model="color" />{{color}}
    <b style="font-size: 14pt;">Programacion Tarimas</b>  <input type="week" ng-model="semanaActual" ng-change="loadDias(true);" />
    <button class="btn btn-success" ng-click="loadProgramacionDiaria(true);">Actualizar</button>
    <button class="btn btn-success" ng-click="reporte = !reporte">Ver como <span ng-show="!reporte">Reporte</span><span ng-show="reporte">Captura</span></button>
    Dia:<select ng-change="loadDias();" ng-model="diaActual"><option ng-repeat="dia in dias" value="{{$index+1}}">{{dia}}</option></select>

    <div class="row" style="width: 100%">
        <div class="col-md-4" style="overflow: auto;height: 850px;">
            <table class="table table-striped table-responsive table-bordered table-hover">
            <thead>
                <tr>
                    <th>Pr</th>
                    <th>
                        Producto<br/>
                        <input class="form-control" ng-model="filtro.Producto" /></th>
                    <th>Aleacion<br/>
                        <input class="form-control" ng-model="filtro.Aleacion" /></th>
                    <th>Ciclos</th>
                    <th>Mold</th>
                    <th>Prog</th>
                    <th>Araña</th>
                    <th>Ton</th>
                </tr>
            </thead>
                <tbody>
                    <tr 
                        ng-repeat="programacion in programaciones | filter:filtro"
                        ng-class="{'active':programacion.TotalProgramado >= programacion.Programadas}"
                    >
                        <th class="col-md-1">{{programacion.Prioridad}}</th>
                        <th class="col-md-1"><div ng-drag="!reporte" ng-drag-data="programaciones[$index]" ng-drag-success="onDragComplete($data,$event)"><span class="btn btn-xs" style="background-color: {{programacion.Color}}">{{programacion.Producto}}</span></div></th>
                        <th class="col-md-1">{{programacion.Aleacion}}</th>
                        <th class="col-md-1">{{programacion.CiclosMolde}}</th>
                        <th class="col-md-1">{{programacion.Programadas}}</th>
                        <th class="col-md-1">{{programacion.TotalProgramado}}</th>
                        <th class="col-md-1">{{programacion.PesoAraniaA | currency:"":2}}</th>
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
                <tbody ng-repeat="loop in loops" ng-init="loop.index = $index">
                    <tr class="dia">
                        <th colspan="{{11 + aleaciones.length}}">{{loop.dia}}</th>
                    </tr>
                    <?php for($y=1;$y<=3;$y++):?>
                    <tr class="<?= $y == 1 ? 'dia' : ($y == 1 ? 'tarde' : 'noche') ?>" ng-repeat="Turno in loop.Turno<?=$y?>" ng-show="MostrarLoop(Turno);">
                        <th style="text-align: center" ng-init="Turno.index = $index">{{$index+1}}</th>
                        <?php for($x=1;$x<=9;$x++):?>
                        <td style="width: 250px;"><div ng-drop="!reporte" ng-drop-success="onDropComplete($data,$event,[{Dia:loop.index,Turno:'Turno<?=$y?>',Loop:{{Turno.index}},Tarima:<?=$x?>}])">
                            <span class="btn btn-xs" style="background-color: {{Turno.Tarima<?=$x?>.Color}}">{{Turno.Tarima<?=$x?>.Producto}}</span>
                            <button ng-click="rellenar(loop.index,'Turno<?=$y?>',$index,<?=$x?>);" ng-if="Turno.Tarima<?=$x?>.visible" class="btn btn-xs btn-success">+</button>
                            <button ng-click="Delete(loop.index,'Turno<?=$y?>',$index,<?=$x?>);" ng-if="Turno.Tarima<?=$x?>.visible" class="btn btn-xs btn-danger">-</button>
                        </div></td>
                        <?php endfor;?>
                        <!--<th style="text-align: center" ng-init="loop.index = $index">{{$index+1}}</th>
                        <th style="text-align: center" ng-repeat="aleacion in aleaciones">{{resumen(loop.index,aleacion)}}</th>-->
                    </tr>
                    <?php endfor;?>
                </tbody>
            </table>
        </div>
    </div>
</div>