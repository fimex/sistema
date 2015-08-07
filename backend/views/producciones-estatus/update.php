<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProduccionesEstatus */

$this->title = 'Actualizar Estatus de Produccion: ' . ' ' . $model->IdProduccionEstatus;
$this->params['breadcrumbs'][] = ['label' => 'Estatus de Producciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdProduccionEstatus, 'url' => ['view', 'id' => $model->IdProduccionEstatus]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="producciones-estatus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
