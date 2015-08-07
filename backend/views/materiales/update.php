<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Materiales */

$this->title = 'Actualizar Material: ' . ' ' . $model->IdMaterial;
$this->params['breadcrumbs'][] = ['label' => 'Materiales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdMaterial, 'url' => ['view', 'id' => $model->IdMaterial]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="materiales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
