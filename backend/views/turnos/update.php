<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Turnos */

$this->title = 'Actualizar Turnos: ' . ' ' . $model->IdTurno;
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdTurno, 'url' => ['view', 'id' => $model->IdTurno]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turnos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
