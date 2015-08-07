<?php
	use yii\helpers\Html;
	use yii\helpers\URL;
	$this->title = $title;
?>

<div ng-controller="vaciado_cont">
	<div class="row">
		<label>Fecha: </label>  <input type="text" ng-model="fecha" > <br> <br>
		<label>Colada: </label> <input type="text" ng-model="colada"> <br> <br>
		<label>Lance: </label>  <input type="text" ng-model="lance"> <br> <br>
		<label>Inicio Lance: </label>  <input type="text" ng-model="inicio_lance"> <br> <br>
		<label>Hora Vaciado: </label>  <input type="text" ng-model="hora_vaciado"> <br> <br>
	</div>
	<div class="col">
		<label>Aleacion: </label><select ng-model="model_aleacion" ng-options='aleacion for aleacion in aleaciones'></select><br>
		<label>Horno: </label><select ng-model="model_horno" ng-options="horno for horno in hornos"></select><br>
		<label>Vaciador: </label><select ng-model="model_vaciador" ng-options="vaciador for vaciador in vaciadores" ng-change="getChange(model_vaciador)"></select><br><br>
	</div>
		<button>Nueva Colada</button>
		<button>Mantenimiento Hornos</button>
		<button>Obtener Moldes Vaciados</button>
		<button>Generar Transaccion</button>
	</div>
</div>
	
		