<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Empleados */

$this->title = 'Crear Empleado';
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empleados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
