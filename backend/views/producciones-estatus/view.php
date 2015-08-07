<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\ProduccionesEstatus */

$this->title = $model->IdProduccionEstatus;
$this->params['breadcrumbs'][] = ['label' => 'Estatus de Producciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producciones-estatus-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdProduccionEstatus], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdProduccionEstatus], [
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
            'IdProduccionEstatus',
            'Identificador',
            'Descripcion',
        ],
    ]) ?>

</div>
