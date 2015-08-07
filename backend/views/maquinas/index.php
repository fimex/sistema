<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maquinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maquinas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Maquinas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdMaquina',
            'IdCentroTrabajo',
            'Identificador',
            'Descripcion',
            'Consecutivo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
