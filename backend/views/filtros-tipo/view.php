<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\FiltrosTipo */

$this->title = $model->IdFiltroTipo;
$this->params['breadcrumbs'][] = ['label' => 'Filtros Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filtros-tipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdFiltroTipo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdFiltroTipo], [
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
            'IdFiltroTipo',
            'Identificador',
            'Descripcion',
            'CantidadPorPaquete',
            'DUX_CodigoPesos',
            'DUX_CodigoDolares',
        ],
    ]) ?>

</div>
