<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\datos\Causas */

$this->title = 'Update Causas: ' . ' ' . $model->IdCausa;
$this->params['breadcrumbs'][] = ['label' => 'Causas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdCausa, 'url' => ['view', 'id' => $model->IdCausa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="causas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
