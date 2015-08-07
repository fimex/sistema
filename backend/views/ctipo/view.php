<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\CamisasTipo */

$this->title = $model->IdCamisaTipo;
$this->params['breadcrumbs'][] = ['label' => 'Camisas Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="camisas-tipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdCamisaTipo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdCamisaTipo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdCamisaTipo',
            'Identificador',
            'Descripcion',
            'CantidadPorPaquete',
            'DUX_CodigoPesos',
            'DUX_CodigoDolares',
        ],
    ]) ?>

</div>
