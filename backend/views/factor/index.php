<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Factor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aleaciones-tipo-factor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Factor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdAleacionTipoFactor',
            'IdAleacionTipo',
            'Fecha',
            'Factor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
