<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Maquinas */

$this->title = 'Actualizar Maquinas: ' . ' ' . $model->IdMaquina;
$this->params['breadcrumbs'][] = ['label' => 'Maquinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdMaquina, 'url' => ['view', 'id' => $model->IdMaquina]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="maquinas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
