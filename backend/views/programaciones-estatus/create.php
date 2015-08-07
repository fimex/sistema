<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProgramacionesEstatus */

$this->title = 'Crear Estatus de Programacion';
$this->params['breadcrumbs'][] = ['label' => 'Estatuses de Programaciones ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programaciones-estatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
