<?php
use yii\helpers\Html;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */ 

?>

<div class="reporte-ete">
    <table style="width:100%" id="ff" class="table table-striped">
        <thead>
            <tr>
                <th>IdPedido</th>
                <th>Identificacion</th>
                <th>Cliente</th>
                <th>OrdenCompra</th>
                <th>Cantidad</th>
                <th>SaldoCantidad</th>
                <th>FechaEmbarque</th>
                <th>Saldo ExistPT</th>
                <th>Falta</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach($model as $detail){ ?>
            <tr style="<?php if($detail['EstatusEnsamble'] == 1){ echo 'background:#90EE90'; }  if($detail['EstatusEnsamble'] == 2) echo 'background:#F3F781'; ?>" >
                <th><?= $detail['IdPedido'] ?> </th>
                <th><?= $detail['Identificacion'] ?></th>
                <th><?= $detail['Cliente'] ?></th>
                <th><?= $detail['OrdenCompra'] ?></th>
                <th><?= $detail['Cantidad'] ?></th>
                <th><?= $detail['SaldoCantidad'] ?></th>
                <th><?= $detail['FechaEmbarque'] ?></th>
                <th><?= $detail['SaldoExistenciaPT'] ?></th>
                <th><?php if($detail['Cantidad'] < $detail['SaldoExistenciaPT']) { echo 0; }else{ echo $detail['Cantidad'] - $detail['SaldoExistenciaPT'];  } ?></th>
            <tr>
            <?php } ?>
        </tbody>
    </table>
</div>
