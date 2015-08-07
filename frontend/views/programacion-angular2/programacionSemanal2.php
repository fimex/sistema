  <?php

use yii\helpers\Html;
use yii\helpers\URL;

$area = Yii::$app->session->get('area');
$area = $area['IdArea'];
$fiel = 'ExitPTB'; $colspan = 'colspan="5"';
if($area == 4){ 
    $fiel = 'ExitGPT'; $colspan = 'colspan="7"'; 
}elseif($area == 3){  
    $fiel = 'ExitPTB'; $colspan = 'colspan="6"';}
?>
<input type="week" ng-model="semanaActual" ng-change="loadSemanas();" />
<button class="btn btn-success" ng-click="loadProgramacionSemanal();loadResumenSemanal();">Actualizar</button>
<button class="btn btn-primary" ng-show="!mostrar" ng-click="mostrar = true">Mostrar Datos</button>
<button class="btn btn-primary" ng-show="mostrar" ng-click="mostrar = false">Ocultar Datos</button>
<button class="btn btn-primary" ng-show="!mostrarPedido" ng-click="mostrarPedido = true">Mostrar Pedidos</button>
<?php if($area == 3){ ?>
    <button class="btn btn-success" ng-click="cerrarPedido();">Cerrar Pedido</button>
<?php } ?>
Ultima Actualizacion: {{actual}}
<div class="panel panel-default">
    <div class="panel-body">
    </div>
    <div id="semanal" class="scrollable">
    <table ng-table fixed-table-headers="semanal" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
             <?php if($area == 3){ ?>
                <th ng-show="mostrar" style="min-width: 30px" rowspan="2"></th>
            <?php } ?>
                <th ng-click="orden = '-OrdenCompra'" ng-show="mostrar" style="min-width: 100px" rowspan="2">Orden<br /><input class="form-control" ng-model="filtro.orden" /></th>
                <th ng-click="orden = '-Descripcion'" ng-show="mostrar" style="min-width: 200px" rowspan="2">Descripcion<br /><input class="form-control" ng-model="filtro.descripcion" /></th>
                <th ng-click="orden = '-FechaEmbarque'" ng-show="mostrar" style="max-width: 100px" rowspan="2">Embarque<br /><input class="form-control" ng-model="filtro.embarque" /></th>
                <th ng-click="orden = '-Aleacion'" ng-show="mostrar" style="max-width: 100px" rowspan="2">Aleacion<br /><input class="form-control" ng-model="filtro.aleacion" /></th>
                <th ng-click="orden = '-Marca'" ng-show="mostrar" style="max-width: 100px" rowspan="2">Cliente<br /><input class="form-control" ng-model="filtro.cliente" /></th>
                <th ng-click="orden = '-Producto'" style="max-width: 100px" rowspan="2">Producto<br /><input class="form-control" ng-model="filtro.producto" /></th>
                <th ng-click="orden = '-ProductoCasting'" style="max-width: 100px" rowspan="2">Casting<br /><input class="form-control" ng-model="filtro.casting" /></th>
            <?php if($area == 2){ ?>
                <th style="max-width: 100px" rowspan="2">AreaAct</th>
                <th style="max-width: 100px" rowspan="2">C Moldes</th>
            <?php } ?>
                <th colspan="2">Pedido</th>
                <th <?= $colspan; ?>>Existencias Almacenes</th>
                <th colspan="2">Maquinado</th>
                <th colspan="2">Casting</th>
                <th colspan="2">Programacion</th>
                <th style="max-width: 100px" style="max-width: 100px" rowspan="2">Prog</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <th style="max-width: 50px">Pzas</th>
                <th style="max-width: 50px">Mol</th>
            <?php if($area == 2){ ?>
                <th style="max-width: 50px" >PLA</th>
                <th style="max-width: 50px" >CTA</th>
                <th style="max-width: 50px" >PMA</th>
                <th style="max-width: 50px" >PTA</th>
                <th style="max-width: 50px" >TRA</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
            <?php } ?>
            <?php if($area == 3){ ?>
                <th style="max-width: 50px" >PLB</th>
                <th style="max-width: 50px" >CTB</th>
                <th style="max-width: 50px" >PCC</th>
                <th style="max-width: 50px" >PMB</th>
                <th style="max-width: 50px" >PTB</th>
                <th style="max-width: 50px" >TRB</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
            <?php } ?>
            <?php if($area == 4){ ?>
                <th style="max-width: 50px" >Term.</th>
                <th style="max-width: 50px" >Cast.</th>
                <th style="max-width: 50px" >Maq.</th>
                <th style="max-width: 50px" >GPT1</th>
                <th style="max-width: 50px" >GPP</th>
                <th style="max-width: 50px" >GPTA</th> 
                <th style="max-width: 50px" >GPC</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
                <th style="max-width: 50px" >Exist</th>
                <th style="max-width: 50px" >Falta</th>
            <?php } ?>
                <th valign="middle">Pzas</th>
                <th>Mol</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" ng-click="orden = '-Prioridad<?=$x?>'">Pr</th>
                <th class="<?=$class?>" ng-click="orden = '-Programadas<?=$x?>'">Prg</th>
                <th class="<?=$class?>2" ng-click="orden = '-Hechas<?=$x?>'">H</th>
                <th class="<?=$class?>2" ng-click="orden = '-Programadas<?=$x?>'">Hrs</th>
                <?php endfor;?>
            </tr>
        </thead>
        <tbody style="font-size: 10pt">
            <tr style="{{programacion.class}}" ng-repeat="programacion in programaciones | filter:{
                OrdenCompra:filtro.orden,
                Producto:filtro.producto,
                ProductoCasting:filtro.casting,
                Descripcion:filtro.descripcion,
                FechaEmbarque:filtro.embarque,
                Aleacion:filtro.aleacion,
                Marca:filtro.cliente,
            } | orderBy:orden" ng-click="setSelected(programacion);" ng-class="{info:selected.IdProgramacion == programacion.IdProgramacion}">
            <?php if($area == 3){ ?>
                <td ng-show="mostrar" > <input type="checkbox" class="form-control" name="Cerrado[]" value="{{programacion.IdProgramacion}}"  /></td>
            <?php } ?>
                <td ng-show="mostrar" >{{programacion.OrdenCompra}}</td>
                <td title="{{programacion.Descripcion}}" ng-show="mostrar" >{{programacion.Descripcion | uppercase | limitTo : 15}}</td>
                <td ng-show="mostrar" style="min-width: 150px">{{programacion.FechaEmbarque | date:'dd-MMM-yyyy'}}</td>
                <td ng-show="mostrar" style="max-width: 100px">{{programacion.Aleacion}}</td>
                <td ng-show="mostrar" style="max-width: 100px">{{programacion.Marca}}</td>
                <td style="mix-width: 100px">{{programacion.Producto}}</td>
                <td style="max-width: 100px">{{programacion.ProductoCasting}}</td>
            <?php if($area == 2){ ?>
                <td style="max-width: 100px">{{programacion.AreaAct}}</td>
                <td style="max-width: 100px">{{programacion.CiclosMolde}}</td>
                <td style="max-width: 50px">{{programacion.Cantidad}}</td>
                <td style="max-width: 50px">{{programacion.Moldes}}</td>
            <?php }else{ ?>
                <td style="max-width: 50px">{{programacion.Ensamble == 2 ? programacion.Cantidad : programacion.SaldoCantidad}}</td>
                <td style="max-width: 50px">{{programacion.MoldesSaldo}}</td>
            <?php } if($area == 2){ ?>
                <td style="max-width: 50px" class="info">{{programacion.PLA == 0 ? '' : programacion.PLA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.CTA == 0 ? '' : programacion.CTA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.PMA == 0 ? '' : programacion.PMA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.PTA == 0 ? '' : programacion.PTA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.TRA == 0 ? '' : programacion.TRA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitPTA == 0 ? '' : programacion.ExitPTA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaPTA == 0 ? '' : programacion.FaltaPTA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitCast == 0 ? '' : programacion.ExitCast}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaCast == 0 ? '' : programacion.FaltaCast}}</td>
            <?php } ?>
            <?php if($area == 3){ ?>
                <td style="max-width: 50px" class="info">{{programacion.PLB == 0 ? '' : programacion.PLB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.CTB == 0 ? '' : programacion.CTB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.PCC  == 0 ? '' :  programacion.PCC}}</td>
                <td style="max-width: 50px" class="info">{{programacion.PMB == 0 ? '' : programacion.PMB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.PTB == 0 ? '' : programacion.PTB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.TRB == 0 ? '' : programacion.TRB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitPTB == 0 ? '' : programacion.ExitPTB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaPTB == 0 ? '' : programacion.FaltaPTB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitCast == 0 ? '' : programacion.ExitCast}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaCast == 0 ? '' : programacion.FaltaCast}}</td>
            <?php } ?>
            <?php if($area == 4){ ?>
                <td style="max-width: 50px" class="info">{{programacion.GPT}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPCB}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPM}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPT1}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPP}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPTA}}</td>
                <td style="max-width: 50px" class="info">{{programacion.GPC}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitGPT}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaGPT}}</td>
                <td style="max-width: 50px" class="info">{{programacion.ExitGPT}}</td>
                <td style="max-width: 50px" class="info">{{programacion.FaltaGPT}}</td>
            <?php } ?>
                <td class="active"><input style="width: 50px;" ng-model="programado"></td>
                <td class="active">{{programado / programacion.PiezasMolde | number:0}}</td>
                <td class="active">{{programacion.Programadas == 0 ? '' : programacion.Programadas * programacion.PiezasMolde}}</td>
            <?php for($x=1;$x<=4;$x++): ?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <td class="<?=$class?>"><input disabled="" style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionSemanal(<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}"></td>
                <td class="<?=$class?>"><input disabled="" style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-change="saveProgramacionSemanal(<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></td>
                <td class="<?=$class?>2">{{programacion.Llenadas<?=$x?>}}</td>
                <td class="<?=$class?>2">{{(programacion.Programadas<?=$x?> / programacion.MoldesHora) | number : 1}}</td>
            <?php endfor; ?>
            </tr>
        </tbody>
    </table>
    </div>
</div>
<div>
<?php if($area == 2){ ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="2">Resumen</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">K</th>
                <th class="<?=$class?>">V</th>
                <th class="<?=$class?>">E</th>
                <th class="<?=$class?>"></th>
                <?php endfor;?>
                
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="resumen in resumenes">
                <th>{{resumen.Programadas}}</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <td class="<?=$class?>">{{resumen.Prioridad<?=$x?> | currency:'':0}}</td>
                <td class="<?=$class?>">{{resumen.Programadas<?=$x?>}}</td>
                <td class="<?=$class?>">{{resumen.Hechas<?=$x?> | currency:'':2}}</td>
                <td class="<?=$class?>"></td>
                <?php endfor;?>
            </tr>
        </tbody>
    </table>
     <?php }else{ ?>
    
        <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="2">Resumen</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="4">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>">Mol</th>
                <th class="<?=$class?>">Ton</th>
                <th class="<?=$class?>">Ton P</th>
                <th class="<?=$class?>">Hrs</th>
                <?php endfor;?>
                
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="resumen in resumenes">
                <th>{{resumen.Programadas}}</th>
                <?php for($x=1;$x<=4;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <td class="<?=$class?>">{{resumen.Prioridad<?=$x?> | currency:'':0}}{{resumen.Programadas == '% PROD' ? '%' : ''}}</td>
                <td class="<?=$class?>">{{resumen.Programadas<?=$x?> | currency:'':2}}</td>
                <td class="<?=$class?>">{{resumen.Hechas<?=$x?> | currency:'':2}}</td>
                <td class="<?=$class?>">{{resumen.Horas<?=$x?> | currency:'':2}}</td>
                <?php endfor;?>
            </tr>
        </tbody>
    </table>
<?php } ?>
</div>
