<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PinturaControlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pintura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pintura-control-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo reporte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '40'],],
            
			[
			'attribute' =>'id_pintura',
			'label' =>'ID',
			'headerOptions' => ['width' => '20'],
            ],
			
			[
			'attribute' =>'fecha',
			'label' =>'Fecha',
			 'format' =>  ['date', 'php:Y-m-d'],
			'headerOptions' => ['width' => '110'],
            ],
			
			[
			'attribute' =>'nomina',
			'label' =>'Nom',
			'headerOptions' => ['width' => '40'],
            ],
            
			[
			'attribute' =>'turno',
			'label' =>'Tur',
			'headerOptions' => ['width' => '20'],
            ],
			
			[
			'attribute' =>'Motivo',
			'label' =>'Motivo',
			'headerOptions' => ['width' => '100'],
            ],
			
           [
			'attribute' =>'pintura',
			'label' =>'Pintura',
			'headerOptions' => ['width' => '150'],
            ],
            
			 [
			'attribute' =>'den_ini',
			'label' =>'Den ini',
			'headerOptions' => ['width' => '40'],
            ],
		
			 [
			'attribute' =>'den_fin',
			'label' =>'Den fin',
			'headerOptions' => ['width' => '40'],
            ],
			
			 [
			'attribute' =>'serie',
			'label' =>'Serie',
			'headerOptions' => ['width' => '80'],
            ],
           
            [
			'attribute' =>'pin_nueva',
			'label' =>'nueva',
			'headerOptions' => ['width' => '40'],
            ],
			
			 [
			'attribute' =>'pin_recicl',
			'label' =>'Recicl',
			'headerOptions' => ['width' => '40'],
            ],
			
			 [
			'attribute' =>'pin_recicl',
			'label' =>'Recicl',
			'headerOptions' => ['width' => '40'],
            ],
           
		    [
			'attribute' =>'alcohol',
			'label' =>'Alcohol',
			'headerOptions' => ['width' => '40'],
            ],
            
			[
			'attribute' =>'area',
			'label' =>'Area',
			'headerOptions' => ['width' => '40'],
            ],
            
			[
			'attribute' =>'base',
			'label' =>'Base',
			'headerOptions' => ['width' => '40'],
            ],
            
           [
			'attribute' =>'base_cant',
			'label' =>'Base Can',
			'headerOptions' => ['width' => '40'],
            ],
            
           
            
            'comentarios',
           //'timestamp',

            
        ],
    ]); ?>

</div>
