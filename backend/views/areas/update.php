<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Areas */

$this->title = 'Actualizar Area: ' . ' ' . $model->IdArea;
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdArea, 'url' => ['view', 'id' => $model->IdArea]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="areas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
