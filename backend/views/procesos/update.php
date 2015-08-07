<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Procesos */

$this->title = 'Actualizar Procesos: ' . ' ' . $model->IdProceso;
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdProceso, 'url' => ['view', 'id' => $model->IdProceso]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procesos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
