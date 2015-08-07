<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Material de Cajas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="almas-material-caja-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Material de Caja', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdAlmaMaterialCaja',
            'Identificador',
            'Dscripcion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
