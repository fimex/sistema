<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="reporte-material">
    <table class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Cantidad</th>
            <th>Material</th>
            <th>Proceso</th>
        </tr>
        <?php foreach($model as $detail): ?>
        <tr>
            <td><?=$detail['IdMaterialVaciado']?></td>
            <td><?=$detail['Cantidad']?></td>
            <td><?=$detail['idMaterial']['Descripcion']?></td>
            <td><?=$detail['idMaterial']['idSubProceso']['Descripcion']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
