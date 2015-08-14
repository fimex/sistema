<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\produccion\PinturaControl */

$this->title = 'Update Pintura Control: ' . ' ' . $model->id_pintura;
$this->params['breadcrumbs'][] = ['label' => 'Pintura Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pintura, 'url' => ['view', 'id' => $model->id_pintura]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pintura-control-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
