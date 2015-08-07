<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Empleados */

$this->title = 'Actualizar Empleado: ' . ' ' . $model->IdEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdEmpleado, 'url' => ['view', 'id' => $model->IdEmpleado]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empleados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
