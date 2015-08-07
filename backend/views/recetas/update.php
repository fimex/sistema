<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AlmasRecetas */

$this->title = 'Actualizar Almas Recetas: ' . ' ' . $model->IdAlmaReceta;
$this->params['breadcrumbs'][] = ['label' => 'Almas Recetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdAlmaReceta, 'url' => ['view', 'id' => $model->IdAlmaReceta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="almas-recetas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
