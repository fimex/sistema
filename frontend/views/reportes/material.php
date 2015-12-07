<?php
use yii\helpers\Html;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */ 

$cantidad = isset($_GET['cantidad']) ? $_GET['cantidad'] : 4;
?>

<div style="margin-bottom: 10px">
    <input id="semana" type="week" value="<?= $semanas['semana1']['year'].'-W'.$semanas['semana1']['week']?>">
    <label>Semanas</label>
    <input id="cantidadS" class="easyui-textbox" style="width:80px" value="<?= $cantidad?>">
    
    <a href="#" class="easyui-linkbutton" onclick="filtrar(this);" >Filtrar</a>
</div>

<div class="reporte-ete">
    <h2>Totales Araña</h2>
    <table style="width:100%" id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>Aleacion</th>
                <?php foreach($semanas as $semana): ?>
                    <th>Sem <?=$semana['week']?></th>
                <?php endforeach; ?>
                <th>Total Araña</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model as $detail): ?>
            <tr>
                <th><?= $detail['Aleacion'] ?> </th>
            <?php foreach($semanas as $semana): ?>
                <th><?= $detail[$semana['year'].'-S'.($semana['week']*1)] == null ? 0 : $detail[$semana['year'].'-S'.($semana['week']*1)] ?> </th>
                <?php 
                    $sum[$semana['year'].'-S'.($semana['week']*1)] = isset($sum[$semana['year'].'-S'.($semana['week']*1)]) ? $sum[$semana['year'].'-S'.($semana['week']*1)] : 0;
                    $sum[$semana['year'].'-S'.($semana['week']*1)] += $detail[$semana['year'].'-S'.($semana['week']*1)];
                ?>
            <?php endforeach; ?>
                <th><?= $detail['PesoTot'] ?> </th>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php $total= 0; ?>
                <?php foreach($semanas as $semana): ?>
                    <?php $total += $sum[$semana['year'].'-S'.($semana['week']*1)]?>
                    <th><?= $sum[$semana['year'].'-S'.($semana['week']*1)]?></th>
                <?php endforeach; ?>
                <th><?=$total?></th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="reporte-ete">
    <h2>Totales Casting</h2>
    <table style="width:100%" id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>Aleacion</th>
                <?php foreach($semanas as $semana): ?>
                    <th>Sem <?=$semana['week']?></th>
                <?php endforeach; ?>
                <th>Total Casting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model2 as $detail): ?>
            <tr>
                <th><?= $detail['Aleacion'] ?> </th>
            <?php foreach($semanas as $semana): ?>
                <th><?= $detail[$semana['year'].'-S'.($semana['week']*1)] == null ? 0 : $detail[$semana['year'].'-S'.($semana['week']*1)] ?> </th>
                <?php 
                    $sum[$semana['year'].'-S'.($semana['week']*1)] = isset($sum[$semana['year'].'-S'.($semana['week']*1)]) ? $sum[$semana['year'].'-S'.($semana['week']*1)] : 0;
                    $sum[$semana['year'].'-S'.($semana['week']*1)] += $detail[$semana['year'].'-S'.($semana['week']*1)];
                ?>
            <?php endforeach; ?>
                <th><?= $detail['PesoTot'] ?> </th>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php $total= 0; ?>
                <?php foreach($semanas as $semana): ?>
                    <?php $total += $sum[$semana['year'].'-S'.($semana['week']*1)]?>
                    <th><?= $sum[$semana['year'].'-S'.($semana['week']*1)]?></th>
                <?php endforeach; ?>
                <th><?=$total?></th>
        </tfoot>
    </table>

</div>

<script>
    function filtrar(){
        var cantidad = $('#cantidadS').textbox('getValue');	// get datebox value
        var semana = $('#semana').val();	// get datebox value
        //var anio = $('#anio').val();    
        document.location = '/fimex/reportes/material?cantidad='+cantidad+'&semana='+semana;
    }   
</script>

<script type="text/javascript">
    function myformatter(date){
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate();
        return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
    }
    function myparser(s){
        if (!s) return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0],10);
        var m = parseInt(ss[1],10);
        var d = parseInt(ss[2],10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
            return new Date(y,m-1,d);
        } else {
            return new Date();
        }
    }
</script>