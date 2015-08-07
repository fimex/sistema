<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Defectos */

$this->title = 'Actualizar Defectos: ' . ' ' . $model->IdDefecto;
$this->params['breadcrumbs'][] = ['label' => 'Defectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdDefecto, 'url' => ['view', 'id' => $model->IdDefecto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="defectos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
