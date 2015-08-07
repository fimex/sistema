<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Centros Trabajos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centros-trabajo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Centros de Trabajo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdCentroTrabajo',
            'Identificador',
            'Descripcion',
            'IdSubProceso',
            'IdArea',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
