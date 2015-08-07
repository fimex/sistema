<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empleados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empleados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Empleados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdEmpleado',
            'Nomina',
            'ApellidoPaterno',
            'ApellidoMaterno',
            'Nombre',
            // 'IdEstatus',
            // 'RFC',
            // 'IMSS',
            // 'IdDepartamento',
            // 'IdTurno',
            // 'IdPuesto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
