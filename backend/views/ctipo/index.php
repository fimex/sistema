<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ''
        . 'Tipos de Camisas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="camisas-tipo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Tipo de Camisa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdCamisaTipo',
            'Identificador',
            'Descripcion',
            'CantidadPorPaquete',
            'DUX_CodigoPesos',
            // 'DUX_CodigoDolares',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
