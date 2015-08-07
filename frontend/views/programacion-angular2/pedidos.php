<?php

use yii\helpers\Html;
use yii\helpers\URL;
?>
<button class="btn btn-success" ng-click="savePedidos();">Agregar Pedidos</button>
<button class="btn btn-success" ng-show="selectAll" ng-click="allSelectPedido();selectAll=false;">Marcar todos</button>
<button class="btn btn-success" ng-show="!selectAll" ng-click="deSelectPedido();selectAll=true;">Desmarcar todos</button>
<button class="btn btn-primary" ng-show="mostrarPedido" ng-click="mostrarPedido = false">Ocultar Pedidos</button>
<div id="pedidos" class="scrollable">
    <table ng-table show-filter="true" fixed-table-headers="pedidos"  class="table table-striped table-bordered table-hover">
        <thead>
            <th ng-click="orden = orden == '+OrdenCompra' ? '-OrdenCompra' : '+OrdenCompra'">Orden<br /><input class="form-control" ng-model="filtro.Orden"></th>
            <th ng-click="orden = orden == '+Identificacion' ? '-Identificacion' : '+Identificacion'">Producto<br /><input class="form-control" ng-model="filtro.Producto"></th>
            <th ng-click="orden = orden == '+ProductoCasting' ? '-ProductoCasting' : '+ProductoCasting'">Casting<br /><input class="form-control" ng-model="filtro.Casting"></th>
            <th ng-click="orden = orden == '+Producto' ? '-Producto' : '+Producto'">Descripcion<input class="form-control" ng-model="filtro.Descripcion"></th>
            <th ng-click="orden = orden == '+FechaEmbarque' ? '-FechaEmbarque' : '+FechaEmbarque'">Embarque<input class="form-control" ng-model="filtro.Embarque"></th>
            <th ng-click="orden = orden == '+Aleacion' ? '-Aleacion' : '+Aleacion'">Aleacion<input class="form-control" ng-model="filtro.Aleacion"></th>
            <th ng-click="orden = orden == '+Marca' ? '-Marca' : '+Marca'">
                Cliente
                <select class="form-control" ng-model="filtro.Cliente">
                    <option value="">Todos</option>
                    <option ng-repeat="cliente in clientes" value="{{cliente.value}}">{{cliente.text}}</option>
                </select>
            </th>
            <th ng-click="orden = orden == '+Cantidad' ? '-Cantidad' : '+Cantidad'">Cantidad<input class="form-control" ng-model="filtro.Cantidad"></th>
            <th ng-click="orden = orden == '+SaldoExistenciaPT' ? '-SaldoExistenciaPT' : '+SaldoExistenciaPT'">Saldo Exist<input class="form-control" ng-model="filtro.SaldoExistenciaPT"></th>
        </thead>
        <tbody>
            <tr style="{{pedido.EstatusEnsamble == 1 ? 'background:#90EE90' : ''}} {{pedido.EstatusEnsamble == 2 ? 'background:#F3F781' : ''}}" ng-class="{'info' : pedido.checked}" ng-repeat="pedido in pedidos | filter:{
                OrdenCompra:filtro.Orden,
                Identificacion:filtro.Producto,
                ProductoCasting:filtro.Casting,
                Producto:filtro.Descripcion,
                FechaEmbarque:filtro.Embarque,
                Aleacion:filtro.Aleacion,
                Marca:filtro.Cliente,
                Cantidad:filtro.Cantidad,
            }  | orderBy:orden" ng-click="setSelectPedido(pedido)">
                <td>{{pedido.OrdenCompra}}</td>
                <td>{{pedido.Identificacion}}</td>
                <td>{{pedido.ProductoCasting}}</td>
                <td>{{pedido.Producto}}</td>
                <td>{{pedido.FechaEmbarque}}</td>
                <td>{{pedido.Aleacion}}</td>
                <td>{{pedido.Marca}}</td>
                <td>{{pedido.Cantidad | number:0}}</td>
                <td>{{pedido.SaldoExistenciaPT}}</td>
            </tr>
        </tbody>
    </table>
</div>