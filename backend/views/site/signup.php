<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\catalogos\Empleados;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$empleados = Empleados::find()->with('users')->orderBy('ApellidoPaterno','ApellidoMaterno','Nombre')->all();
foreach($empleados as $emp){
    if(count($emp->users) == 0){
        $ListaEmpleados[$emp->IdEmpleado] = trim($emp->ApellidoPaterno)." ".trim($emp->ApellidoMaterno)." ".trim($emp->Nombre);
    }
}
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'IdEmpleado')->dropDownList($ListaEmpleados)->label('Empleado') ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>