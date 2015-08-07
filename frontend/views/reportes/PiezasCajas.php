<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$semana1 = date("Y")."-W".date("W");
$semana2 = date("Y")."-W".date("W");
 if(isset($_GET['semana_ini'])){ $semana1 = $_GET['semana_ini']; $semana2 = $_GET['semana_fin']; }

 ?>
<script>
    function filtrar(){
        var semana_ini = $('#semana_ini').val();	// get semana value
        var semana_fin = $('#semana_fin').val();	// get semana value
        document.location = '/fimex/reportes/piezascajas?semana_ini='+semana_ini+'&semana_fin='+semana_fin;
    }  
    
    function detalle(id){
      
        if(id == 1){
            $('#detalles').show("slow");
            $('#show').hide();
            $('#hide').show();
        }
        
        if(id == 2){
            $('#detalles').hide("slow");
            $('#show').show();
            $('#hide').hide();
        }
    }
</script>

<div style="margin-bottom: 10px">
  <label>Semana ini </label> <input id="semana_ini" type="week" value="<?= $semana1 ?>">
  <label>Semana fin </label> <input id="semana_fin" type="week" value="<?= $semana2 ?>">
  <!--<label>Fecha inicial</label>
  <input id="fecha-ini" class="easyui-datebox" style="width:200px" data-options="formatter:myformatter,parser:myparser" type="text" >
  <label>Fecha final</label>
  <input id="fecha-fin" class="easyui-datebox" style="width:200px" data-options="formatter:myformatter,parser:myparser" >-->
  <span style="margin-right:40px; margin-left: 10px" ><a href="#" class="easyui-linkbutton" onclick="filtrar(this);" >Aceptar</a></span> 
  <span id="show" > <a href="#" class="easyui-linkbutton" onclick="detalle(1);" >Ver detalle</a></span>
  <span style="display: none" id="hide" > <a href="#" class="easyui-linkbutton" onclick="detalle(2);" >Cerrar detalle</a></span>
</div>

<div id="detalles" style=" display: none">
     <table id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>No Parte</th>
                <th>Saldo Cant</th>
                <th>Fecha envio</th>
                <th>Caja</th>
                <th>Pz x Caja</th>
                <th>Requerido</th>
            </tr>
        </thead>
        <tbody>
            <?php         
            foreach ($detalle as $key => $value) {
                echo 
                '<tr>
                    <td>'.$value['Identificacion'].'</td>
                    <td>'.number_format($value['Programadas']).'</td>
                    <td>'.$value['Fecha'].'</td>
                    <td>'.$value['Tamano'].'</td>
                    <td>'.$value['PiezasXCaja'].'</td>
                    <td>'.number_format($value['Requiere']).'</td>
                </tr>';
            }
            ?>
        </tbody>
     </table>
</div>

<div id="reporte-cajas" style="width: 800px;" >
     <table id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>Tamaño</th>
                <th>Requerido</th>
                <th>Exist Tot</th>
                <th>Por pedir</th>
                <!--<th>ExistDlls</th>
                <th>ExistPesos</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($model as $key => $value) {
                   $xpedir = $value['Requerido']-$value['ExitTot'];
                   if($xpedir < 0) $xpedir = 0;
                    echo 
                    '<tr>
                        <td>'.$value['Tamano'].'</td>
                        <td>'.number_format($value['Requerido']).'</td>
                        <td>'.$value['ExitTot'].'</td>
                        <td>'.number_format($xpedir).'</td>
                        
                    </tr>';
                }
            ?>
        </tbody>
     </table>
</div>
