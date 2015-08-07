<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AleacionesTipoFactor */

$this->title = 'Actualizar Factor: ' . ' ' . $model->IdAleacionTipoFactor;
$this->params['breadcrumbs'][] = ['label' => 'Aleaciones Tipo Factors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdAleacionTipoFactor, 'url' => ['view', 'id' => $model->IdAleacionTipoFactor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aleaciones-tipo-factor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
