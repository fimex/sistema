<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\AleacionesTipoFactor */

$this->title = $model->IdAleacionTipoFactor;
$this->params['breadcrumbs'][] = ['label' => 'Aleaciones Tipo Factors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aleaciones-tipo-factor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdAleacionTipoFactor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdAleacionTipoFactor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdAleacionTipoFactor',
            'IdAleacionTipo',
            'Fecha',
            'Factor',
        ],
    ]) ?>

</div>
