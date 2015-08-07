<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProduccionesEstatus */

$this->title = 'Crear Estatus de Produccion';
$this->params['breadcrumbs'][] = ['label' => 'Estatus de Produccion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producciones-estatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
