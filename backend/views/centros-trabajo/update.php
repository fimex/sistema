<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\CentrosTrabajo */

$this->title = 'Actualizar Centros Trabajo: ' . ' ' . $model->IdCentroTrabajo;
$this->params['breadcrumbs'][] = ['label' => 'Centros Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdCentroTrabajo, 'url' => ['view', 'id' => $model->IdCentroTrabajo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="centros-trabajo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
