<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\produccion\PinturaControl */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
	.pintura{
			display: inline-block;
			width:300px;
			height:100%;
			vertical-align: text-top;
		}
	
	.pintura2{
			display: inline-block;
			width:200x;
			height:100%;
			vertical-align: text-top;
		}
	.pintura_main{
			width:100%;
			height:auto;
			
		}
</style>

<div class="pintura-control-form">

   
 <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'fecha')->widget(\yii\jui\DatePicker::classname(), [
			//'language' => 'ru',
			'dateFormat' => 'yyyyMMdd',
			]) ?>
			
	
	<div class = "pintura_main">
	
			<div class = "pintura2">
			<?= $form->field($model, 'nomina')->textInput() ?>
			</div>
			<div class = "pintura2">
			<?= $form->field($model, 'turno')->dropDownList(
												[
														'dia' => 'Dia',
														'noche' => 'Noche'
														] ,[]) ?> 
			</div>
			<div class = "pintura2">
			<?= $form->field($model, 'area')->dropDownList(
														[
																'kloster' => 'Kloster',
																'varel' => 'Varel',
																'Almas' => 'Almas',
																'Especial' => 'Especial',
																] ,[]) ?>
			</div>
			<div class = "pintura2">
			 <?= $form->field($model, 'Motivo')->dropDownList(
														[
														'Control Proceso' => 'Control Proceso',
														'Preparacion' => 'Preparacion'
														] ,[]) ?>
			</div>
			
	</div>
	<div class= "pintura_main">
			<div class = "pintura">

		  

			<?= $form->field($model, 'pintura')->dropDownList(
														[
														'Isomol' => 'Isomol',
														'Ceramic Shield New G 819' => 'Ceramic Shield New G 819',
														'Recobar 1010i' => 'Recobar 1010i',
														'Recobar 1017' => 'Recobar 1017',
														'Refcohol 1010' => 'Refcohol 1010',
														'Holdcote 300-85' => 'Holdcote 300-85',
														'TOP-211' => 'TOP-211',
														] ,[]) ?>

			<?= $form->field($model, 'serie')->textInput()->label("Serie/Tambor") ?>
			
			<?= $form->field($model, 'base')->textInput() ?>

			<?= $form->field($model, 'base_cant')->textInput() ?>
			
			<?= $form->field($model, 'alcohol')->textInput() ?>

			</div>
			
			<div class = "pintura">
			<?= $form->field($model, 'den_ini')->textInput() ?>
			<?= $form->field($model, 'den_fin')->textInput() ?>
			<?= $form->field($model, 'pin_nueva')->textInput() ?>
			<?= $form->field($model, 'pin_recicl')->textInput() ?>
			
			</div>	
    <?= $form->field($model, 'comentarios')->textarea(array('rows'=>3,'cols'=>1)) ?>
	</div>


   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['.'], ['class' => 'btn btn-success']) ?>
    </div>
	

    <?php ActiveForm::end(); ?>

</div>