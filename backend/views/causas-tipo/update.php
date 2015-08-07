<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\CausasTipo */

$this->title = 'Actualizar  Tipo de causa: ' . ' ' . $model->IdCausaTipo;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Causas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdCausaTipo, 'url' => ['view', 'id' => $model->IdCausaTipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="causas-tipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
