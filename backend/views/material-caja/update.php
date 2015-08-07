<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AlmasMaterialCaja */

$this->title = 'Actualizar Material de Caja: ' . ' ' . $model->IdAlmaMaterialCaja;
$this->params['breadcrumbs'][] = ['label' => 'Almas Material Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdAlmaMaterialCaja, 'url' => ['view', 'id' => $model->IdAlmaMaterialCaja]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="almas-material-caja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
