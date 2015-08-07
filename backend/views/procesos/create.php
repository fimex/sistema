<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\catalogos\Procesos */

$this->title = 'Crear Procesos';
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procesos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
