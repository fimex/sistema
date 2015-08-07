<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div ng-controller="Detalle" >
    <button class="btn btn-default" ng-click="addDetalle()">Agregar</button>
    <table class="table table-hover table-condensed">
        <tr style="font-weight: bold">
            <td>Producto</td>
            <td>Inicio</td>
            <td>Fin</td>
            <td>Hechas</td>
            <td>Rechazadas</td>
            <td>Programadas</td>
            <td>Cic X Molde</td>
            <td>Pza x Molde</td>
        </tr>
        <tr ng-repeat="detalle in detalles">
            <td>
                <span editable-select="detalle.Productos" e-name="Productos" e-form="rowform" e-ng-options="s.value as s.text for s in statuses" e-required></span>
            </td>
            <td>
                <span editable-time="detalle.Inicio" e-name="Inicio" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-time="detalle.Fin" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-number="detalle.Hechas" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-number="detalle.Rechazadas" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-number="detalle.Rechazadas" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-number="detalle.Rechazadas" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td>
                <span editable-number="detalle.Rechazadas" e-name="Fin" e-form="rowform" e-ng-options="s.value as s.text for s in statuses"></span>
            </td>
            <td style="white-space: nowrap">
                <!-- form -->
                <form editable-form name="rowform" shown="true" onbeforesave="saveUser($data, detalle.id);" class="form-buttons form-inline" shown="inserted == detalle">
                    <button type="submit" ng-disabled="rowform.$waiting">
                      Guardar
                    </button>
                    <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel();rowform.\$show();">
                      Cancelar
                    </button>
                    <button ng-click="removeUser($index)">Eliminar</button>
                </form>
            </td>
        </tr>
    </table>
</div>
