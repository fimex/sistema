<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProgramacionesEstatus */

$this->title = 'Actualizar Estatus de Programaciones : ' . ' ' . $model->IdProgramacionEstatus;
$this->params['breadcrumbs'][] = ['label' => 'Estatuses de Programaciones ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdProgramacionEstatus, 'url' => ['view', 'id' => $model->IdProgramacionEstatus]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programaciones-estatus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
