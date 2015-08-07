<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AlmasTipo */

$this->title = 'Actualizar Tipo de Almas : ' . ' ' . $model->IdAlmaTipo;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Almas ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdAlmaTipo, 'url' => ['view', 'id' => $model->IdAlmaTipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="almas-tipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
